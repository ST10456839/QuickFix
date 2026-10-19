package za.co.quickfix.app.ui.screen

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.ExperimentalLayoutApi
import androidx.compose.foundation.layout.FlowRow
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material3.Card
import androidx.compose.material3.FilterChip
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import androidx.lifecycle.viewmodel.compose.viewModel
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import za.co.quickfix.app.QuickFixApp
import za.co.quickfix.app.data.model.RepairPrice
import za.co.quickfix.app.data.repo.BookingRepository
import za.co.quickfix.app.data.repo.DataResult

val PRICE_CATEGORIES = listOf(
    "Screen Replacement", "Battery & Power", "SSD & RAM Upgrades", "Motherboard & Logic"
)

data class PricingUiState(
    val category: String = PRICE_CATEGORIES.first(),
    val prices: List<RepairPrice> = emptyList(),
    val error: String? = null,
    val isBusy: Boolean = false
)

class PricingViewModel(
    private val repo: BookingRepository = QuickFixApp.instance.bookingRepository
) : ViewModel() {

    private val _state = MutableStateFlow(PricingUiState())
    val state: StateFlow<PricingUiState> = _state.asStateFlow()

    fun select(category: String) {
        _state.value = _state.value.copy(category = category)
        load()
    }

    fun load() {
        viewModelScope.launch {
            _state.value = _state.value.copy(isBusy = true, error = null)
            when (val result = repo.pricing(_state.value.category)) {
                is DataResult.Success ->
                    _state.value = _state.value.copy(isBusy = false, prices = result.data)
                is DataResult.Failure ->
                    _state.value = _state.value.copy(
                        isBusy = false, prices = emptyList(), error = result.message
                    )
            }
        }
    }
}

@OptIn(ExperimentalLayoutApi::class)
@Composable
fun PricingScreen(viewModel: PricingViewModel = viewModel()) {
    val state by viewModel.state.collectAsState()
    LaunchedEffect(Unit) { viewModel.load() }

    Column(
        modifier = Modifier
            .fillMaxSize()
            .padding(20.dp),
        verticalArrangement = Arrangement.spacedBy(12.dp)
    ) {
        Text("Transparent pricing", style = MaterialTheme.typography.headlineSmall)
        Text(
            "Prices include VAT and standard labour. Exact costs vary by make and model.",
            style = MaterialTheme.typography.bodySmall
        )

        FlowRow(horizontalArrangement = Arrangement.spacedBy(8.dp)) {
            PRICE_CATEGORIES.forEach { category ->
                FilterChip(
                    selected = state.category == category,
                    onClick = { viewModel.select(category) },
                    label = { Text(category) }
                )
            }
        }

        when {
            state.isBusy -> Text("Loading prices...")
            state.error != null -> Text(state.error!!, color = MaterialTheme.colorScheme.error)
            state.prices.isEmpty() -> Text("No pricing available for this category - please contact us.")
            else -> LazyColumn(verticalArrangement = Arrangement.spacedBy(8.dp)) {
                items(state.prices) { price ->
                    Card(modifier = Modifier.fillMaxWidth()) {
                        Row(
                            Modifier
                                .fillMaxWidth()
                                .padding(14.dp),
                            horizontalArrangement = Arrangement.SpaceBetween
                        ) {
                            Column(Modifier.padding(end = 12.dp)) {
                                Text(price.servicePartName,
                                    style = MaterialTheme.typography.titleSmall)
                                price.description?.let {
                                    Text(it, style = MaterialTheme.typography.bodySmall)
                                }
                            }
                            Text(
                                price.estimatedPrice,
                                style = MaterialTheme.typography.titleSmall,
                                color = MaterialTheme.colorScheme.primary
                            )
                        }
                    }
                }
            }
        }
    }
}
