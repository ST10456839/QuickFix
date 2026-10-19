package za.co.quickfix.app.ui.screen

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.Button
import androidx.compose.material3.Card
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.testTag
import androidx.compose.ui.unit.dp
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import androidx.lifecycle.viewmodel.compose.viewModel
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import za.co.quickfix.app.QuickFixApp
import za.co.quickfix.app.data.model.TrackingResult
import za.co.quickfix.app.data.repo.BookingRepository
import za.co.quickfix.app.data.repo.DataResult
import za.co.quickfix.app.util.Validator

data class TrackUiState(
    val reference: String = "",
    val referenceError: String? = null,
    val formError: String? = null,
    val result: TrackingResult? = null,
    val isBusy: Boolean = false
)

class TrackViewModel(
    private val repo: BookingRepository = QuickFixApp.instance.bookingRepository
) : ViewModel() {

    private val _state = MutableStateFlow(TrackUiState())
    val state: StateFlow<TrackUiState> = _state.asStateFlow()

    fun onReferenceChange(v: String) {
        _state.value = _state.value.copy(reference = v, referenceError = null, formError = null)
    }

    fun track() {
        val reference = Validator.bookingReference(_state.value.reference)
        _state.value = _state.value.copy(referenceError = reference.message)
        if (!reference.isValid) return

        viewModelScope.launch {
            _state.value = _state.value.copy(isBusy = true, result = null, formError = null)
            when (val result = repo.track(_state.value.reference)) {
                is DataResult.Success ->
                    _state.value = _state.value.copy(isBusy = false, result = result.data)
                is DataResult.Failure ->
                    _state.value = _state.value.copy(isBusy = false, formError = result.message)
            }
        }
    }
}

@Composable
fun TrackRepairScreen(viewModel: TrackViewModel = viewModel()) {
    val state by viewModel.state.collectAsState()

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(20.dp),
        verticalArrangement = Arrangement.spacedBy(12.dp)
    ) {
        Text("Track your repair", style = MaterialTheme.typography.headlineSmall)
        Text(
            "Enter the reference from your booking confirmation, or the phone number you booked with.",
            style = MaterialTheme.typography.bodyMedium
        )

        ValidatedField(
            label = "Reference or phone number",
            value = state.reference,
            onValueChange = viewModel::onReferenceChange,
            error = state.referenceError,
            testTag = "track_reference"
        )

        Button(
            onClick = viewModel::track,
            enabled = !state.isBusy,
            modifier = Modifier
                .fillMaxWidth()
                .testTag("track_submit")
        ) { Text(if (state.isBusy) "Checking..." else "Track") }

        state.formError?.let { Text(it, color = MaterialTheme.colorScheme.error) }

        state.result?.let { result ->
            Card(modifier = Modifier.fillMaxWidth()) {
                Column(Modifier.padding(16.dp), verticalArrangement = Arrangement.spacedBy(6.dp)) {
                    Text(result.reference, style = MaterialTheme.typography.titleMedium)
                    Text(result.device)
                    Text("Status: ${result.status}", style = MaterialTheme.typography.titleSmall)
                    Text("Booked: ${result.submittedDate}",
                        style = MaterialTheme.typography.bodySmall)
                    result.history.forEach { event ->
                        Text("${event.changedAt} - ${event.status}" +
                            (event.note?.let { ": $it" } ?: ""),
                            style = MaterialTheme.typography.bodySmall)
                    }
                }
            }
        }
    }
}
