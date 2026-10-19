package za.co.quickfix.app.data.prefs

import android.content.Context
import androidx.datastore.preferences.core.Preferences
import androidx.datastore.preferences.core.booleanPreferencesKey
import androidx.datastore.preferences.core.edit
import androidx.datastore.preferences.core.stringPreferencesKey
import androidx.datastore.preferences.preferencesDataStore
import kotlinx.coroutines.flow.Flow
import kotlinx.coroutines.flow.map

private val Context.dataStore by preferencesDataStore(name = "quickfix_settings")

/** User-changeable settings, persisted on the device with Jetpack DataStore. */
data class UserSettings(
    val darkTheme: Boolean = false,
    val emailNotifications: Boolean = true,
    val smsNotifications: Boolean = false,
    val preferredContact: String = "Email",
    val defaultDeviceBrand: String = ""
)

class SettingsStore(private val context: Context) {

    private object Keys {
        val DARK_THEME = booleanPreferencesKey("dark_theme")
        val EMAIL_NOTIFICATIONS = booleanPreferencesKey("email_notifications")
        val SMS_NOTIFICATIONS = booleanPreferencesKey("sms_notifications")
        val PREFERRED_CONTACT = stringPreferencesKey("preferred_contact")
        val DEFAULT_BRAND = stringPreferencesKey("default_brand")
    }

    val settings: Flow<UserSettings> = context.dataStore.data.map { it.toSettings() }

    private fun Preferences.toSettings() = UserSettings(
        darkTheme = this[Keys.DARK_THEME] ?: false,
        emailNotifications = this[Keys.EMAIL_NOTIFICATIONS] ?: true,
        smsNotifications = this[Keys.SMS_NOTIFICATIONS] ?: false,
        preferredContact = this[Keys.PREFERRED_CONTACT] ?: "Email",
        defaultDeviceBrand = this[Keys.DEFAULT_BRAND] ?: ""
    )

    suspend fun setDarkTheme(enabled: Boolean) =
        context.dataStore.edit { it[Keys.DARK_THEME] = enabled }

    suspend fun setEmailNotifications(enabled: Boolean) =
        context.dataStore.edit { it[Keys.EMAIL_NOTIFICATIONS] = enabled }

    suspend fun setSmsNotifications(enabled: Boolean) =
        context.dataStore.edit { it[Keys.SMS_NOTIFICATIONS] = enabled }

    suspend fun setPreferredContact(value: String) =
        context.dataStore.edit { it[Keys.PREFERRED_CONTACT] = value }

    suspend fun setDefaultDeviceBrand(value: String) =
        context.dataStore.edit { it[Keys.DEFAULT_BRAND] = value }
}
