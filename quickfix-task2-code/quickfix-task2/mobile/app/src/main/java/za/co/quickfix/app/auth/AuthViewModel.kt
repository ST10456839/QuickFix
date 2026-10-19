package za.co.quickfix.app.auth

import android.content.Context
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import za.co.quickfix.app.util.Validator

data class AuthUiState(
    val email: String = "",
    val password: String = "",
    val confirmPassword: String = "",
    val fullName: String = "",
    val emailError: String? = null,
    val passwordError: String? = null,
    val confirmError: String? = null,
    val nameError: String? = null,
    val formError: String? = null,
    val isBusy: Boolean = false,
    val isSignedIn: Boolean = false,
    val displayName: String? = null
)

class AuthViewModel(
    private val repo: AuthRepository = AuthRepository()
) : ViewModel() {

    private val _state = MutableStateFlow(
        AuthUiState(isSignedIn = repo.isSignedIn, displayName = repo.currentName)
    )
    val state: StateFlow<AuthUiState> = _state.asStateFlow()

    fun onEmailChange(v: String) = _state.update { it.copy(email = v, emailError = null, formError = null) }
    fun onPasswordChange(v: String) = _state.update { it.copy(password = v, passwordError = null, formError = null) }
    fun onConfirmChange(v: String) = _state.update { it.copy(confirmPassword = v, confirmError = null) }
    fun onNameChange(v: String) = _state.update { it.copy(fullName = v, nameError = null) }

    fun signIn() {
        val s = _state.value
        val email = Validator.email(s.email)
        val password = Validator.required(s.password, "password")
        _state.update { it.copy(emailError = email.message, passwordError = password.message) }
        if (!Validator.allValid(email, password)) return

        viewModelScope.launch {
            _state.update { it.copy(isBusy = true, formError = null) }
            when (val result = repo.signIn(s.email, s.password)) {
                is AuthResult.Success ->
                    _state.update {
                        it.copy(isBusy = false, isSignedIn = true, displayName = result.displayName)
                    }
                is AuthResult.Failure ->
                    _state.update { it.copy(isBusy = false, formError = result.message) }
            }
        }
    }

    fun register() {
        val s = _state.value
        val name = Validator.fullName(s.fullName)
        val email = Validator.email(s.email)
        val password = Validator.password(s.password)
        val confirm = Validator.passwordsMatch(s.password, s.confirmPassword)
        _state.update {
            it.copy(
                nameError = name.message,
                emailError = email.message,
                passwordError = password.message,
                confirmError = confirm.message
            )
        }
        if (!Validator.allValid(name, email, password, confirm)) return

        viewModelScope.launch {
            _state.update { it.copy(isBusy = true, formError = null) }
            when (val result = repo.register(s.fullName, s.email, s.password)) {
                is AuthResult.Success ->
                    _state.update {
                        it.copy(isBusy = false, isSignedIn = true, displayName = result.displayName)
                    }
                is AuthResult.Failure ->
                    _state.update { it.copy(isBusy = false, formError = result.message) }
            }
        }
    }

    fun signInWithGoogle(context: Context) {
        viewModelScope.launch {
            _state.update { it.copy(isBusy = true, formError = null) }
            when (val result = repo.signInWithGoogle(context)) {
                is AuthResult.Success ->
                    _state.update {
                        it.copy(isBusy = false, isSignedIn = true, displayName = result.displayName)
                    }
                is AuthResult.Failure ->
                    _state.update { it.copy(isBusy = false, formError = result.message) }
            }
        }
    }

    fun signOut() {
        repo.signOut()
        _state.value = AuthUiState()
    }

    private inline fun MutableStateFlow<AuthUiState>.update(block: (AuthUiState) -> AuthUiState) {
        value = block(value)
    }
}
