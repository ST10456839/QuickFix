package za.co.quickfix.app.ui.screen

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.ExperimentalLayoutApi
import androidx.compose.foundation.layout.FlowRow
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.Button
import androidx.compose.material3.FilterChip
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.testTag
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel

/** Dropdown options for the "primary issue" input control. */
val PRIMARY_ISSUES = listOf(
    "Screen Damage", "Battery Issues", "Slow Performance", "Water Damage",
    "Data Recovery", "Motherboard Fault", "Other"
)

@OptIn(ExperimentalLayoutApi::class)
@Composable
fun BookRepairScreen(viewModel: BookingViewModel = viewModel()) {
    val state by viewModel.state.collectAsState()

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(20.dp),
        verticalArrangement = Arrangement.spacedBy(12.dp)
    ) {
        Text("Book a repair", style = MaterialTheme.typography.headlineSmall)

        ValidatedField("Full name", state.fullName, viewModel::onNameChange,
            error = state.nameError, testTag = "book_name")
        ValidatedField("Phone number", state.phone, viewModel::onPhoneChange,
            error = state.phoneError, keyboardType = KeyboardType.Phone, testTag = "book_phone")
        ValidatedField("Email address", state.email, viewModel::onEmailChange,
            error = state.emailError, keyboardType = KeyboardType.Email, testTag = "book_email")
        ValidatedField("Device brand", state.deviceBrand, viewModel::onBrandChange,
            error = state.brandError, testTag = "book_brand")
        ValidatedField("Device model or serial", state.deviceModel, viewModel::onModelChange,
            error = state.modelError, testTag = "book_model")

        Text("Primary issue", style = MaterialTheme.typography.labelLarge)
        FlowRow(horizontalArrangement = Arrangement.spacedBy(8.dp)) {
            PRIMARY_ISSUES.forEach { issue ->
                FilterChip(
                    selected = state.primaryIssue == issue,
                    onClick = { viewModel.onIssueChange(issue) },
                    label = { Text(issue) },
                    modifier = Modifier.testTag("book_issue_$issue")
                )
            }
        }
        state.issueError?.let {
            Text(it, color = MaterialTheme.colorScheme.error,
                style = MaterialTheme.typography.bodySmall)
        }

        ValidatedField(
            "Describe the problem", state.description, viewModel::onDescriptionChange,
            error = state.descriptionError, singleLine = false, minLines = 4,
            testTag = "book_description"
        )

        state.formError?.let { Text(it, color = MaterialTheme.colorScheme.error) }
        state.successMessage?.let { Text(it, color = MaterialTheme.colorScheme.primary) }

        Button(
            onClick = viewModel::submit,
            enabled = !state.isBusy,
            modifier = Modifier
                .fillMaxWidth()
                .testTag("book_submit")
        ) { Text(if (state.isBusy) "Submitting..." else "Submit booking request") }
    }
}
