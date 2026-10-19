package za.co.quickfix.app.ui.screen

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import za.co.quickfix.app.QuickFixApp
import za.co.quickfix.app.data.model.RepairBooking
import za.co.quickfix.app.data.repo.BookingRepository
import za.co.quickfix.app.data.repo.DataResult
import za.co.quickfix.app.util.Validator

data class BookingUiState(
    val fullName: String = "",
    val phone: String = "",
    val email: String = "",
    val deviceBrand: String = "",
    val deviceModel: String = "",
    val primaryIssue: String = "",
    val description: String = "",
    val nameError: String? = null,
    val phoneError: String? = null,
    val emailError: String? = null,
    val brandError: String? = null,
    val modelError: String? = null,
    val issueError: String? = null,
    val descriptionError: String? = null,
    val formError: String? = null,
    val successMessage: String? = null,
    val isBusy: Boolean = false
)

class BookingViewModel(
    private val repo: BookingRepository = QuickFixApp.instance.bookingRepository
) : ViewModel() {

    private val _state = MutableStateFlow(BookingUiState())
    val state: StateFlow<BookingUiState> = _state.asStateFlow()

    fun onNameChange(v: String) { _state.value = _state.value.copy(fullName = v, nameError = null) }
    fun onPhoneChange(v: String) { _state.value = _state.value.copy(phone = v, phoneError = null) }
    fun onEmailChange(v: String) { _state.value = _state.value.copy(email = v, emailError = null) }
    fun onBrandChange(v: String) { _state.value = _state.value.copy(deviceBrand = v, brandError = null) }
    fun onModelChange(v: String) { _state.value = _state.value.copy(deviceModel = v, modelError = null) }
    fun onIssueChange(v: String) { _state.value = _state.value.copy(primaryIssue = v, issueError = null) }
    fun onDescriptionChange(v: String) {
        _state.value = _state.value.copy(description = v, descriptionError = null)
    }

    /**
     * Validates every field before any network call is made. Validation failures
     * are reported inline; nothing here can throw, so invalid input can never
     * crash the screen.
     */
    fun submit() {
        val s = _state.value
        val name = Validator.fullName(s.fullName)
        val phone = Validator.phone(s.phone)
        val email = Validator.email(s.email)
        val brand = Validator.minLength(s.deviceBrand, 2, "device brand")
        val model = Validator.minLength(s.deviceModel, 2, "device model or serial")
        val issue = Validator.selection(s.primaryIssue, "primary issue")
        val description =
            Validator.minLength(s.description, Validator.MIN_DESCRIPTION_LENGTH, "problem")

        _state.value = s.copy(
            nameError = name.message,
            phoneError = phone.message,
            emailError = email.message,
            brandError = brand.message,
            modelError = model.message,
            issueError = issue.message,
            descriptionError = description.message,
            formError = null,
            successMessage = null
        )

        if (!Validator.allValid(name, phone, email, brand, model, issue, description)) return

        val booking = RepairBooking(
            fullName = s.fullName.trim(),
            phone = Validator.normalisePhone(s.phone),
            email = s.email.trim(),
            deviceBrand = s.deviceBrand.trim(),
            deviceModel = s.deviceModel.trim(),
            primaryIssue = s.primaryIssue,
            description = s.description.trim()
        )

        viewModelScope.launch {
            _state.value = _state.value.copy(isBusy = true)
            when (val result = repo.submitBooking(booking)) {
                is DataResult.Success ->
                    _state.value = BookingUiState(
                        successMessage = "Booking received. Your reference is " +
                            "${result.data.reference}. We will contact you with a quote."
                    )
                is DataResult.Failure ->
                    _state.value = _state.value.copy(
                        isBusy = false,
                        formError = result.message,
                        nameError = result.fieldErrors["full_name"],
                        phoneError = result.fieldErrors["phone"],
                        emailError = result.fieldErrors["email"],
                        descriptionError = result.fieldErrors["description"]
                    )
            }
        }
    }
}
