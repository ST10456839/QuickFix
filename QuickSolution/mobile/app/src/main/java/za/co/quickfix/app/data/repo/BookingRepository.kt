package za.co.quickfix.app.data.repo

import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext
import retrofit2.Response
import za.co.quickfix.app.data.api.QuickFixApi
import za.co.quickfix.app.data.model.ApiResponse
import za.co.quickfix.app.data.model.RepairBooking
import za.co.quickfix.app.data.model.RepairPrice
import za.co.quickfix.app.data.model.TrackingResult
import java.io.IOException

/**
 * Outcome of a repository call. Nothing in the UI layer ever sees an exception,
 * which is what keeps the app from crashing on bad input or a dropped connection.
 */
sealed class DataResult<out T> {
    data class Success<T>(val data: T) : DataResult<T>()
    data class Failure(
        val message: String,
        val fieldErrors: Map<String, String> = emptyMap()
    ) : DataResult<Nothing>()
}

class BookingRepository(private val api: QuickFixApi) {

    suspend fun submitBooking(booking: RepairBooking): DataResult<RepairBooking> =
        call { api.createBooking(booking) }

    suspend fun myBookings(): DataResult<List<RepairBooking>> =
        call { api.myBookings() }

    suspend fun pricing(category: String? = null): DataResult<List<RepairPrice>> =
        call { api.pricing(category) }

    suspend fun track(reference: String): DataResult<TrackingResult> =
        call { api.track(reference.trim().uppercase()) }

    /**
     * Single place where HTTP, transport and validation failures are turned into
     * a [DataResult]. Every branch returns a message that is safe to put in front
     * of a customer - stack traces and SQL errors never reach the screen.
     */
    private suspend fun <T> call(block: suspend () -> Response<ApiResponse<T>>): DataResult<T> =
        withContext(Dispatchers.IO) {
            try {
                val response = block()
                val body = response.body()
                when {
                    response.isSuccessful && body?.success == true && body.data != null ->
                        DataResult.Success(body.data)

                    response.isSuccessful && body?.success == true ->
                        DataResult.Failure("The server returned an empty response.")

                    response.code() == 401 ->
                        DataResult.Failure("Your session has expired. Please sign in again.")

                    response.code() == 422 || body?.errors != null ->
                        DataResult.Failure(
                            body?.message ?: "Please check the highlighted fields.",
                            body?.errors.orEmpty()
                        )

                    response.code() in 500..599 ->
                        DataResult.Failure("Something went wrong on our side. Please try again shortly.")

                    else ->
                        DataResult.Failure(body?.message ?: "Request failed (HTTP ${response.code()}).")
                }
            } catch (e: IOException) {
                DataResult.Failure("No connection. Check your data or Wi-Fi and try again.")
            } catch (e: Exception) {
                DataResult.Failure("Unexpected error. Please try again.")
            }
        }
}
