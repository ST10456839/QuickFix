package za.co.quickfix.app

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import za.co.quickfix.app.data.prefs.UserSettings
import za.co.quickfix.app.ui.nav.QuickFixNavHost
import za.co.quickfix.app.ui.theme.QuickFixTheme

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContent {
            val settings by QuickFixApp.instance.settingsStore.settings
                .collectAsState(initial = UserSettings())
            QuickFixTheme(darkTheme = settings.darkTheme) {
                QuickFixNavHost()
            }
        }
    }
}
