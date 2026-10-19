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
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp

@Composable
fun HomeScreen(
    displayName: String?,
    onBook: () -> Unit,
    onTrack: () -> Unit,
    onPricing: () -> Unit
) {
    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(20.dp),
        verticalArrangement = Arrangement.spacedBy(16.dp)
    ) {
        Text(
            "Hello${if (!displayName.isNullOrBlank()) ", $displayName" else ""}",
            style = MaterialTheme.typography.headlineSmall
        )
        Text(
            "Repair, upgrade, buy back and revive your tech.",
            style = MaterialTheme.typography.bodyLarge
        )

        Button(onClick = onBook, modifier = Modifier.fillMaxWidth()) { Text("Book a repair") }
        OutlinedButton(onClick = onTrack, modifier = Modifier.fillMaxWidth()) { Text("Track my repair") }
        OutlinedButton(onClick = onPricing, modifier = Modifier.fillMaxWidth()) { Text("See pricing") }

        Card(modifier = Modifier.fillMaxWidth()) {
            Column(Modifier.padding(16.dp), verticalArrangement = Arrangement.spacedBy(4.dp)) {
                Text("Visit us", style = MaterialTheme.typography.titleMedium)
                Text("296 Pretorius Street, Pretoria Central")
                Text("Mon to Fri 08:00-18:00, Sat 09:00-13:00")
                Text("+27 62 161 4699")
            }
        }

        Card(modifier = Modifier.fillMaxWidth()) {
            Column(Modifier.padding(16.dp), verticalArrangement = Arrangement.spacedBy(4.dp)) {
                Text("Why QuickFix", style = MaterialTheme.typography.titleMedium)
                Text("Clear upfront quotes")
                Text("Premium A-grade parts")
                Text("Same-day turnaround on common repairs")
            }
        }
    }
}
