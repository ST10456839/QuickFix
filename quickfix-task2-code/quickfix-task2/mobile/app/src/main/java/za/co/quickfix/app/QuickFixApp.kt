package za.co.quickfix.app

import android.app.Application
import za.co.quickfix.app.data.api.ApiClient
import za.co.quickfix.app.data.api.QuickFixApi
import za.co.quickfix.app.data.prefs.SettingsStore
import za.co.quickfix.app.data.repo.BookingRepository

/**
 * Application entry point. Holds the single shared instances of the API client,
 * repository and settings store - a lightweight service locator that keeps the
 * project free of a DI framework the module does not require.
 */
class QuickFixApp : Application() {

    lateinit var api: QuickFixApi
        private set
    lateinit var bookingRepository: BookingRepository
        private set
    lateinit var settingsStore: SettingsStore
        private set

    override fun onCreate() {
        super.onCreate()
        api = ApiClient.create()
        bookingRepository = BookingRepository(api)
        settingsStore = SettingsStore(this)
        instance = this
    }

    companion object {
        lateinit var instance: QuickFixApp
            private set
    }
}
