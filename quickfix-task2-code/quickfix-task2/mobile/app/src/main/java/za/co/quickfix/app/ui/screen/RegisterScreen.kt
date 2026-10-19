package za.co.quickfix.app.ui.screen

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.Button
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.testTag
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import za.co.quickfix.app.auth.AuthViewModel

@Composable
fun RegisterScreen(
    viewModel: AuthViewModel,
    onSignedIn: () -> Unit,
    onBack: () -> Unit
) {
    val state by viewModel.state.collectAsState()
    LaunchedEffect(state.isSignedIn) { if (state.isSignedIn) onSignedIn() }

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(24.dp),
        verticalArrangement = Arrangement.spacedBy(12.dp)
    ) {
        Text("Create your account", style = MaterialTheme.typography.headlineSmall)
        Text(
            "Your password is stored by Google Firebase Authentication as a salted hash. " +
                "QuickFix never sees or stores it.",
            style = MaterialTheme.typography.bodySmall
        )

        ValidatedField(
            label = "Full name",
            value = state.fullName,
            onValueChange = viewModel::onNameChange,
            error = state.nameError,
            testTag = "register_name"
        )
        ValidatedField(
            label = "Email address",
            value = state.email,
            onValueChange = viewModel::onEmailChange,
            error = state.emailError,
            keyboardType = KeyboardType.Email,
            testTag = "register_email"
        )
        ValidatedField(
            label = "Password",
            value = state.password,
            onValueChange = viewModel::onPasswordChange,
            error = state.passwordError,
            isPassword = true,
            testTag = "register_password"
        )
        ValidatedField(
            label = "Confirm password",
            value = state.confirmPassword,
            onValueChange = viewModel::onConfirmChange,
            error = state.confirmError,
            isPassword = true,
            imeAction = ImeAction.Done,
            testTag = "register_confirm"
        )

        if (state.formError != null) {
            Text(state.formError!!, color = MaterialTheme.colorScheme.error)
        }

        Button(
            onClick = viewModel::register,
            enabled = !state.isBusy,
            modifier = Modifier
                .fillMaxWidth()
                .testTag("register_submit")
        ) { Text("Create account") }

        TextButton(onClick = onBack) { Text("Back to sign in") }
    }
}
