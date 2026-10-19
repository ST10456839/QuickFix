package za.co.quickfix.app.ui.screen

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.Button
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.platform.testTag
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import za.co.quickfix.app.auth.AuthViewModel

@Composable
fun LoginScreen(
    viewModel: AuthViewModel,
    onSignedIn: () -> Unit,
    onRegister: () -> Unit
) {
    val state by viewModel.state.collectAsState()
    val context = LocalContext.current

    LaunchedEffect(state.isSignedIn) { if (state.isSignedIn) onSignedIn() }

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(24.dp),
        verticalArrangement = Arrangement.spacedBy(12.dp)
    ) {
        Text("QuickFix", style = MaterialTheme.typography.headlineMedium)
        Text(
            "Sign in to book a repair, track your device and see your history.",
            style = MaterialTheme.typography.bodyMedium
        )

        ValidatedField(
            label = "Email address",
            value = state.email,
            onValueChange = viewModel::onEmailChange,
            error = state.emailError,
            keyboardType = KeyboardType.Email,
            testTag = "login_email"
        )

        ValidatedField(
            label = "Password",
            value = state.password,
            onValueChange = viewModel::onPasswordChange,
            error = state.passwordError,
            isPassword = true,
            imeAction = ImeAction.Done,
            testTag = "login_password"
        )

        if (state.formError != null) {
            Text(
                state.formError!!,
                color = MaterialTheme.colorScheme.error,
                style = MaterialTheme.typography.bodyMedium,
                modifier = Modifier.testTag("login_form_error")
            )
        }

        Button(
            onClick = viewModel::signIn,
            enabled = !state.isBusy,
            modifier = Modifier
                .fillMaxWidth()
                .testTag("login_submit")
        ) {
            if (state.isBusy) {
                CircularProgressIndicator(modifier = Modifier.padding(end = 8.dp))
            }
            Text("Sign in")
        }

        OutlinedButton(
            onClick = { viewModel.signInWithGoogle(context) },
            enabled = !state.isBusy,
            modifier = Modifier
                .fillMaxWidth()
                .testTag("login_google")
        ) {
            Text("Continue with Google")
        }

        TextButton(
            onClick = onRegister,
            modifier = Modifier.align(Alignment.CenterHorizontally)
        ) {
            Text("New to QuickFix? Create an account")
        }
    }
}
