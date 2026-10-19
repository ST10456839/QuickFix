package za.co.quickfix.app.data.model

import com.google.gson.annotations.SerializedName

/** Generic API envelope returned by every QuickFix endpoint. */
data class ApiResponse<T>(
    @SerializedName("success") val success: Boolean,
    @SerializedName("data") val data: T? = null,
    @SerializedName("message") val message: String? = null,
    @SerializedName("errors") val errors: Map<String, String>? = null
)

data class RepairBooking(
    @SerializedName("booking_id") val bookingId: Int = 0,
    @SerializedName("reference") val reference: String = "",
    @SerializedName("full_name") val fullName: String,
    @SerializedName("phone") val phone: String,
    @SerializedName("email") val email: String,
    @SerializedName("device_brand") val deviceBrand: String,
    @SerializedName("device_model") val deviceModel: String,
    @SerializedName("primary_issue") val primaryIssue: String,
    @SerializedName("description") val description: String,
    @SerializedName("status") val status: String = "New",
    @SerializedName("submitted_date") val submittedDate: String? = null
)

data class TradeInRequest(
    @SerializedName("request_id") val requestId: Int = 0,
    @SerializedName("device_type") val deviceType: String,
    @SerializedName("condition") val condition: String,
    @SerializedName("brand_model") val brandModel: String,
    @SerializedName("storage_capacity") val storageCapacity: String,
    @SerializedName("full_name") val fullName: String,
    @SerializedName("phone") val phone: String,
    @SerializedName("email") val email: String,
    @SerializedName("faults_description") val faultsDescription: String,
    @SerializedName("status") val status: String = "New"
)

data class PurchaseEnquiry(
    @SerializedName("enquiry_id") val enquiryId: Int = 0,
    @SerializedName("full_name") val fullName: String,
    @SerializedName("phone") val phone: String,
    @SerializedName("email") val email: String,
    @SerializedName("device_wanted") val deviceWanted: String,
    @SerializedName("budget") val budget: Double,
    @SerializedName("preferred_brand") val preferredBrand: String? = null,
    @SerializedName("main_use") val mainUse: String,
    @SerializedName("additional_preferences") val additionalPreferences: String? = null,
    @SerializedName("status") val status: String = "New"
)

data class RepairPrice(
    @SerializedName("price_id") val priceId: Int,
    @SerializedName("category") val category: String,
    @SerializedName("service_part_name") val servicePartName: String,
    @SerializedName("description") val description: String? = null,
    @SerializedName("estimated_price") val estimatedPrice: String
)

data class TrackingResult(
    @SerializedName("reference") val reference: String,
    @SerializedName("device") val device: String,
    @SerializedName("status") val status: String,
    @SerializedName("submitted_date") val submittedDate: String,
    @SerializedName("history") val history: List<TrackingEvent> = emptyList()
)

data class TrackingEvent(
    @SerializedName("status") val status: String,
    @SerializedName("changed_at") val changedAt: String,
    @SerializedName("note") val note: String? = null
)

/** Mirrors a row in app_user; created on first sign-in via /auth_sync.php. */
data class AppUser(
    @SerializedName("user_id") val userId: Int,
    @SerializedName("firebase_uid") val firebaseUid: String,
    @SerializedName("full_name") val fullName: String,
    @SerializedName("email") val email: String,
    @SerializedName("phone") val phone: String? = null,
    @SerializedName("auth_provider") val authProvider: String
)
