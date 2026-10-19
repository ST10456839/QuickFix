package za.co.quickfix.app.data.api

import retrofit2.Response
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.POST
import retrofit2.http.Path
import retrofit2.http.Query
import za.co.quickfix.app.data.model.ApiResponse
import za.co.quickfix.app.data.model.AppUser
import za.co.quickfix.app.data.model.PurchaseEnquiry
import za.co.quickfix.app.data.model.RepairBooking
import za.co.quickfix.app.data.model.RepairPrice
import za.co.quickfix.app.data.model.TradeInRequest
import za.co.quickfix.app.data.model.TrackingResult

/**
 * REST contract between the Android app and the QuickFix PHP API.
 *
 * Every endpoint except [pricing] requires a Firebase ID token, which
 * [AuthInterceptor] attaches as `Authorization: Bearer <token>`.
 */
interface QuickFixApi {

    @GET("pricing.php")
    suspend fun pricing(
        @Query("category") category: String? = null
    ): Response<ApiResponse<List<RepairPrice>>>

    @POST("auth_sync.php")
    suspend fun syncUser(
        @Body body: Map<String, String>
    ): Response<ApiResponse<AppUser>>

    @POST("bookings.php")
    suspend fun createBooking(
        @Body booking: RepairBooking
    ): Response<ApiResponse<RepairBooking>>

    @GET("bookings.php")
    suspend fun myBookings(): Response<ApiResponse<List<RepairBooking>>>

    @GET("track.php/{reference}")
    suspend fun track(
        @Path("reference") reference: String
    ): Response<ApiResponse<TrackingResult>>

    @POST("trade_in.php")
    suspend fun createTradeIn(
        @Body request: TradeInRequest
    ): Response<ApiResponse<TradeInRequest>>

    @POST("enquiries.php")
    suspend fun createEnquiry(
        @Body enquiry: PurchaseEnquiry
    ): Response<ApiResponse<PurchaseEnquiry>>
}
