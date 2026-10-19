package za.co.quickfix.app.auth

import android.content.Context
import androidx.credentials.CredentialManager
import androidx.credentials.CustomCredential
import androidx.credentials.GetCredentialRequest
import androidx.credentials.exceptions.GetCredentialException
import com.google.android.libraries.identity.googleid.GetGoogleIdOption
import com.google.android.libraries.identity.googleid.GoogleIdTokenCredential
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.auth.FirebaseAuthInvalidCredentialsException
import com.google.firebase.auth.FirebaseAuthInvalidUserException
import com.google.firebase.auth.FirebaseAuthUserCollisionException
import com.google.firebase.auth.FirebaseAuthWeakPasswordException
import com.google.firebase.auth.GoogleAuthProvider
import com.google.firebase.auth.UserProfileChangeRequest
import kotlinx.coroutines.tasks.await
import za.co.quickfix.app.BuildConfig
import za.co.quickfix.app.data.api.ApiClient
import java.io.IOException

sealed class AuthResult {
    data class Success(val uid: String, val email: String?, val displayName: String?) : AuthResult()
    data class Failure(val message: String) : AuthResult()
}

/**
 * Wraps Firebase Authentication - the online-hosted authentication service used
 * by QuickFix.
 *
 * Passwords are never stored by the app or by the QuickFix database. They are
 * sent over TLS to Firebase, which stores them as a salted hash using a modified
 * scrypt algorithm; only the resulting UID and a short-lived ID token ever reach
 * the QuickFix API.
 */
class AuthRepository(
    private val auth: FirebaseAuth = FirebaseAuth.getInstance()
) {

    val currentUid: String? get() = auth.currentUser?.uid
    val currentEmail: String? get() = auth.currentUser?.email
    val currentName: String? get() = auth.currentUser?.displayName
    val isSignedIn: Boolean get() = auth.currentUser != null

    suspend fun register(fullName: String, email: String, password: String): AuthResult = try {
        val result = auth.createUserWithEmailAndPassword(email.trim(), password).await()
        result.user?.updateProfile(
            UserProfileChangeRequest.Builder().setDisplayName(fullName.trim()).build()
        )?.await()
        result.user?.sendEmailVerification()?.await()
        refreshToken()
        val user = result.user!!
        AuthResult.Success(user.uid, user.email, fullName.trim())
    } catch (e: FirebaseAuthWeakPasswordException) {
        AuthResult.Failure("That password is too weak. Use at least 8 characters with a number and a capital letter.")
    } catch (e: FirebaseAuthUserCollisionException) {
        AuthResult.Failure("An account already exists for that email address. Try signing in instead.")
    } catch (e: FirebaseAuthInvalidCredentialsException) {
        AuthResult.Failure("That email address is not valid.")
    } catch (e: IOException) {
        AuthResult.Failure("No connection. Check your data or Wi-Fi and try again.")
    } catch (e: Exception) {
        AuthResult.Failure("We could not create your account. Please try again.")
    }

    suspend fun signIn(email: String, password: String): AuthResult = try {
        val result = auth.signInWithEmailAndPassword(email.trim(), password).await()
        refreshToken()
        val user = result.user!!
        AuthResult.Success(user.uid, user.email, user.displayName)
    } catch (e: FirebaseAuthInvalidUserException) {
        AuthResult.Failure("Incorrect email or password.")
    } catch (e: FirebaseAuthInvalidCredentialsException) {
        AuthResult.Failure("Incorrect email or password.")
    } catch (e: IOException) {
        AuthResult.Failure("No connection. Check your data or Wi-Fi and try again.")
    } catch (e: Exception) {
        AuthResult.Failure("We could not sign you in. Please try again.")
    }

    /**
     * Single sign-on with a Google account, via Credential Manager.
     *
     * The Google ID token returned by Credential Manager is exchanged for a
     * Firebase credential, so an SSO user and an email/password user end up as
     * the same kind of Firebase account downstream.
     */
    suspend fun signInWithGoogle(context: Context): AuthResult = try {
        val googleIdOption = GetGoogleIdOption.Builder()
            .setFilterByAuthorizedAccounts(false)
            .setServerClientId(BuildConfig.GOOGLE_WEB_CLIENT_ID)
            .setAutoSelectEnabled(true)
            .build()

        val request = GetCredentialRequest.Builder()
            .addCredentialOption(googleIdOption)
            .build()

        val response = CredentialManager.create(context).getCredential(context, request)
        val credential = response.credential

        if (credential is CustomCredential &&
            credential.type == GoogleIdTokenCredential.TYPE_GOOGLE_ID_TOKEN_CREDENTIAL
        ) {
            val googleCredential = GoogleIdTokenCredential.createFrom(credential.data)
            val firebaseCredential =
                GoogleAuthProvider.getCredential(googleCredential.idToken, null)
            val result = auth.signInWithCredential(firebaseCredential).await()
            refreshToken()
            val user = result.user!!
            AuthResult.Success(user.uid, user.email, user.displayName)
        } else {
            AuthResult.Failure("Google sign-in returned an unexpected credential type.")
        }
    } catch (e: GetCredentialException) {
        AuthResult.Failure("Google sign-in was cancelled or no Google account is available on this device.")
    } catch (e: Exception) {
        AuthResult.Failure("We could not sign you in with Google. Please try again.")
    }

    suspend fun sendPasswordReset(email: String): AuthResult = try {
        auth.sendPasswordResetEmail(email.trim()).await()
        AuthResult.Success(uid = "", email = email.trim(), displayName = null)
    } catch (e: Exception) {
        AuthResult.Failure("We could not send the reset email. Check the address and try again.")
    }

    /** Fetches a fresh ID token and hands it to the API client. */
    suspend fun refreshToken(): String? = try {
        val token = auth.currentUser?.getIdToken(false)?.await()?.token
        ApiClient.updateToken(token)
        token
    } catch (e: Exception) {
        ApiClient.updateToken(null)
        null
    }

    fun signOut() {
        auth.signOut()
        ApiClient.updateToken(null)
    }
}
