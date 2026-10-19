package za.co.quickfix.app.data.api

import okhttp3.Interceptor
import okhttp3.OkHttpClient
import okhttp3.Response
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import za.co.quickfix.app.BuildConfig
import java.util.concurrent.TimeUnit

/**
 * Attaches the signed-in user's Firebase ID token to every outgoing request.
 *
 * The token is a short-lived JWT issued by the hosted authentication service.
 * The PHP API verifies it with Google before touching the database, so the app
 * never sends - and the API never trusts - a raw user identifier.
 */
class AuthInterceptor(private val tokenProvider: () -> String?) : Interceptor {
    override fun intercept(chain: Interceptor.Chain): Response {
        val token = tokenProvider()
        val request = chain.request().newBuilder()
            .addHeader("Accept", "application/json")
            .apply { if (!token.isNullOrBlank()) addHeader("Authorization", "Bearer $token") }
            .build()
        return chain.proceed(request)
    }
}

object ApiClient {

    @Volatile
    private var cachedToken: String? = null

    /** Called by AuthRepository whenever the signed-in user changes. */
    fun updateToken(token: String?) {
        cachedToken = token
    }

    fun create(baseUrl: String = BuildConfig.API_BASE_URL): QuickFixApi {
        val logging = HttpLoggingInterceptor().apply {
            level = if (BuildConfig.DEBUG) HttpLoggingInterceptor.Level.BASIC
            else HttpLoggingInterceptor.Level.NONE
        }

        val client = OkHttpClient.Builder()
            .addInterceptor(AuthInterceptor { cachedToken })
            .addInterceptor(logging)
            .connectTimeout(15, TimeUnit.SECONDS)
            .readTimeout(30, TimeUnit.SECONDS)
            .build()

        return Retrofit.Builder()
            .baseUrl(baseUrl)
            .client(client)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(QuickFixApi::class.java)
    }
}
