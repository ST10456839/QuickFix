package za.co.quickfix.app.ui.screen

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.ExperimentalLayoutApi
import androidx.compose.foundation.layout.FlowRow
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.Card
import androidx.compose.material3.FilterChip
import androidx.compose.material3.HorizontalDivider
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.Switch
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.testTag
import androidx.compose.ui.unit.dp
import kotlinx.coroutines.launch
import za.co.quickfix.app.QuickFixApp
import za.co.quickfix.app.data.prefs.UserSettings

@OptIn(ExperimentalLayoutApi::class)
@Composable
fun SettingsScreen(onSignOut: () -> Unit) {
    val store = QuickFixApp.instance.settingsStore
    val settings by store.settings.collectAsState(initial = UserSettings())
    val scope = rememberCoroutineScope()

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(20.dp),
        verticalArrangement = Arrangement.spacedBy(12.dp)
    ) {
        Text("Settings", style = MaterialTheme.typography.headlineSmall)

        SettingToggle(
            title = "Dark theme",
            subtitle = "Use the dark colour scheme throughout the app",
            checked = settings.darkTheme,
            testTag = "settings_dark"
        ) { scope.launch { store.setDarkTheme(it) } }

        SettingToggle(
            title = "Email notifications",
            subtitle = "Receive booking confirmations and status updates by email",
            checked = settings.emailNotifications,
            testTag = "settings_email"
        ) { scope.launch { store.setEmailNotifications(it) } }

        SettingToggle(
            title = "SMS notifications",
            subtitle = "Receive a text message when your device is ready",
            checked = settings.smsNotifications,
            testTag = "settings_sms"
        ) { scope.launch { store.setSmsNotifications(it) } }

        HorizontalDivider()

        Text("Preferred contact method", style = MaterialTheme.typography.titleSmall)
        FlowRow(horizontalArrangement = Arrangement.spacedBy(8.dp)) {
            listOf("Email", "Phone call", "WhatsApp").forEach { option ->
                FilterChip(
                    selected = settings.preferredContact == option,
                    onClick = { scope.launch { store.setPreferredContact(option) } },
                    label = { Text(option) }
                )
            }
        }

        ValidatedField(
            label = "Default device brand",
            value = settings.defaultDeviceBrand,
            onValueChange = { scope.launch { store.setDefaultDeviceBrand(it) } },
            testTag = "settings_brand"
        )

        HorizontalDivider()

        OutlinedButton(
            onClick = onSignOut,
            modifier = Modifier
                .fillMaxWidth()
                .testTag("settings_sign_out")
        ) { Text("Sign out") }

        Text(
            "QuickFix for Android - version 1.0.0",
            style = MaterialTheme.typography.bodySmall
        )
    }
}

@Composable
private fun SettingToggle(
    title: String,
    subtitle: String,
    checked: Boolean,
    testTag: String,
    onCheckedChange: (Boolean) -> Unit
) {
    Card(modifier = Modifier.fillMaxWidth()) {
        Row(
            modifier = Modifier
                .fillMaxWidth()
                .padding(14.dp),
            verticalAlignment = Alignment.CenterVertically,
            horizontalArrangement = Arrangement.SpaceBetween
        ) {
            Column(Modifier.padding(end = 12.dp)) {
                Text(title, style = MaterialTheme.typography.titleSmall)
                Text(subtitle, style = MaterialTheme.typography.bodySmall)
            }
            Switch(
                checked = checked,
                onCheckedChange = onCheckedChange,
                modifier = Modifier.testTag(testTag)
            )
        }
    }
}
