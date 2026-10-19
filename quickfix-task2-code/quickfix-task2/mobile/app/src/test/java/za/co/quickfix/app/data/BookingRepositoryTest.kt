package za.co.quickfix.app.data

import io.mockk.coEvery
import io.mockk.mockk
import kotlinx.coroutines.test.runTest
import okhttp3.MediaType.Companion.toMediaType
import okhttp3.ResponseBody.Companion.toResponseBody
import org.junit.Assert.assertEquals
import org.junit.Assert.assertTrue
import org.junit.Test
import retrofit2.Response
import za.co.quickfix.app.data.api.QuickFixApi
import za.co.quickfix.app.data.model.ApiResponse
import za.co.quickfix.app.data.model.RepairBooking
import za.co.quickfix.app.data.repo.BookingRepository
import za.co.quickfix.app.data.repo.DataResult
import java.io.IOException

/**
 * Tests the error-handling contract of the repository: no matter what the API
 * does, the UI layer receives a DataResult and never an exception.
 */
class BookingRepositoryTest {

    private val api: QuickFixApi = mockk()
    private val repo = BookingRepository(api)

    private fun sampleBooking(reference: String = "QF-2026-00042") = RepairBooking(
        bookingId = 42,
        reference = reference,
        fullName = "Katlego Maile",
        phone = "0821234567",
        email = "katlego@example.co.za",
        deviceBrand = "Dell",
        deviceModel = "XPS 15 9500",
        primaryIssue = "Screen Damage",
        description = "The screen cracked after the laptop was dropped."
    )

    @Test
    fun `successful booking returns the saved record`() = runTest {
        coEvery { api.createBooking(any()) } returns
            Response.success(ApiResponse(success = true, data = sampleBooking()))

        val result = repo.submitBooking(sampleBooking())

        assertTrue(result is DataResult.Success)
        assertEquals("QF-2026-00042", (result as DataResult.Success).data.reference)
    }

    @Test
    fun `validation failure is surfaced with field errors`() = runTest {
        coEvery { api.createBooking(any()) } returns Response.success(
            ApiResponse<RepairBooking>(
                success = false,
                message = "Please check the highlighted fields.",
                errors = mapOf("phone" to "Please enter a valid 10-digit South African number.")
            )
        )

        val result = repo.submitBooking(sampleBooking())

        assertTrue(result is DataResult.Failure)
        val failure = result as DataResult.Failure
        assertEquals("Please check the highlighted fields.", failure.message)
        assertTrue(failure.fieldErrors.containsKey("phone"))
    }

    @Test
    fun `expired token produces a sign in again message`() = runTest {
        coEvery { api.myBookings() } returns Response.error(
            401, "".toResponseBody("application/json".toMediaType())
        )

        val result = repo.myBookings()

        assertTrue(result is DataResult.Failure)
        assertTrue((result as DataResult.Failure).message.contains("sign in", ignoreCase = true))
    }

    @Test
    fun `server error produces a friendly message rather than a stack trace`() = runTest {
        coEvery { api.myBookings() } returns Response.error(
            500, "".toResponseBody("application/json".toMediaType())
        )

        val result = repo.myBookings()

        assertTrue(result is DataResult.Failure)
        assertTrue((result as DataResult.Failure).message.contains("our side"))
    }

    @Test
    fun `network loss is reported without throwing`() = runTest {
        coEvery { api.pricing(any()) } throws IOException("offline")

        val result = repo.pricing("Screen Replacement")

        assertTrue(result is DataResult.Failure)
        assertTrue((result as DataResult.Failure).message.contains("No connection"))
    }

    @Test
    fun `unexpected exception is caught and reported`() = runTest {
        coEvery { api.pricing(any()) } throws IllegalStateException("boom")

        val result = repo.pricing(null)

        assertTrue(result is DataResult.Failure)
        assertEquals("Unexpected error. Please try again.", (result as DataResult.Failure).message)
    }

    @Test
    fun `tracking reference is trimmed and upper cased before the call`() = runTest {
        coEvery { api.track("QF-2026-00042") } returns Response.success(
            ApiResponse(
                success = true,
                data = za.co.quickfix.app.data.model.TrackingResult(
                    reference = "QF-2026-00042",
                    device = "Dell XPS 15 9500",
                    status = "In Progress",
                    submittedDate = "2026-10-12"
                )
            )
        )

        val result = repo.track("  qf-2026-00042 ")

        assertTrue(result is DataResult.Success)
        assertEquals("In Progress", (result as DataResult.Success).data.status)
    }
}
