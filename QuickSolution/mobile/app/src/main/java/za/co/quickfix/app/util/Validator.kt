package za.co.quickfix.app.util

/**
 * Result of a single field validation.
 *
 * [message] is null when the field is valid, otherwise it holds the message that
 * is shown underneath the input control.
 */
data class ValidationResult(val isValid: Boolean, val message: String? = null) {
    companion object {
        val Valid = ValidationResult(true)
        fun invalid(message: String) = ValidationResult(false, message)
    }
}

/**
 * All input validation rules for the QuickFix mobile app.
 *
 * The rules are deliberately pure functions with no Android dependencies so that
 * they can be covered by fast JVM unit tests (see ValidatorTest) and reused by
 * every screen. The same rules are enforced again server-side in the PHP API -
 * client-side validation is for usability, server-side validation is for safety.
 */
object Validator {

    private val EMAIL_PATTERN =
        Regex("^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$")

    /** South African mobile/landline numbers in national format: 0 + 9 digits. */
    private val SA_PHONE_PATTERN = Regex("^0\\d{9}$")

    private val NAME_PATTERN = Regex("^[\\p{L} '-]{2,100}$")

    const val MIN_PASSWORD_LENGTH = 8
    const val MIN_DESCRIPTION_LENGTH = 20

    fun fullName(value: String?): ValidationResult {
        val v = value?.trim().orEmpty()
        return when {
            v.isEmpty() -> ValidationResult.invalid("Please enter your full name.")
            v.length < 2 -> ValidationResult.invalid("Please enter your full name.")
            !NAME_PATTERN.matches(v) ->
                ValidationResult.invalid("Name may only contain letters, spaces, apostrophes and hyphens.")
            else -> ValidationResult.Valid
        }
    }

    fun email(value: String?): ValidationResult {
        val v = value?.trim().orEmpty()
        return when {
            v.isEmpty() -> ValidationResult.invalid("Please enter your email address.")
            !EMAIL_PATTERN.matches(v) ->
                ValidationResult.invalid("Please enter a valid email address.")
            else -> ValidationResult.Valid
        }
    }

    /**
     * Accepts 0XXXXXXXXX, +27XXXXXXXXX, 27XXXXXXXXX and numbers containing
     * spaces, hyphens or brackets. All are normalised before checking.
     */
    fun phone(value: String?): ValidationResult {
        val v = normalisePhone(value)
        return when {
            v.isEmpty() -> ValidationResult.invalid("Please enter your phone number.")
            !SA_PHONE_PATTERN.matches(v) ->
                ValidationResult.invalid("Please enter a valid 10-digit South African number.")
            else -> ValidationResult.Valid
        }
    }

    /** Strips formatting and converts +27 / 27 prefixes into the national 0 prefix. */
    fun normalisePhone(value: String?): String {
        var v = value?.filter { it.isDigit() || it == '+' }.orEmpty()
        if (v.startsWith("+27")) v = "0" + v.removePrefix("+27")
        else if (v.startsWith("27") && v.length == 11) v = "0" + v.removePrefix("27")
        return v.filter { it.isDigit() }
    }

    /**
     * Password strength rule enforced before the credential is handed to
     * Firebase Authentication, which stores it as a salted scrypt hash.
     */
    fun password(value: String?): ValidationResult {
        val v = value.orEmpty()
        return when {
            v.isEmpty() -> ValidationResult.invalid("Please enter a password.")
            v.length < MIN_PASSWORD_LENGTH ->
                ValidationResult.invalid("Password must be at least $MIN_PASSWORD_LENGTH characters.")
            v.none { it.isDigit() } ->
                ValidationResult.invalid("Password must contain at least one number.")
            v.none { it.isUpperCase() } ->
                ValidationResult.invalid("Password must contain at least one capital letter.")
            v.none { it.isLowerCase() } ->
                ValidationResult.invalid("Password must contain at least one lowercase letter.")
            else -> ValidationResult.Valid
        }
    }

    fun passwordsMatch(password: String?, confirm: String?): ValidationResult =
        if (password.orEmpty() == confirm.orEmpty()) ValidationResult.Valid
        else ValidationResult.invalid("Passwords do not match.")

    fun required(value: String?, fieldLabel: String): ValidationResult =
        if (value?.trim().isNullOrEmpty())
            ValidationResult.invalid("Please enter the $fieldLabel.")
        else ValidationResult.Valid

    fun minLength(value: String?, min: Int, fieldLabel: String): ValidationResult {
        val v = value?.trim().orEmpty()
        return if (v.length < min)
            ValidationResult.invalid("Please describe the $fieldLabel in at least $min characters.")
        else ValidationResult.Valid
    }

    fun selection(value: String?, fieldLabel: String): ValidationResult =
        if (value.isNullOrBlank()) ValidationResult.invalid("Please select a $fieldLabel.")
        else ValidationResult.Valid

    /** Budget / price fields. Rejects negatives, zero, letters and blank input. */
    fun positiveAmount(value: String?): ValidationResult {
        val v = value?.trim()?.replace(" ", "")?.replace(",", "")?.removePrefix("R").orEmpty()
        if (v.isEmpty()) return ValidationResult.invalid("Please enter your budget.")
        val amount = v.toDoubleOrNull()
            ?: return ValidationResult.invalid("Budget must be a number, for example 4500.")
        return if (amount <= 0.0) ValidationResult.invalid("Budget must be greater than zero.")
        else ValidationResult.Valid
    }

    /** Booking reference format issued by the API, e.g. QF-2026-00042. */
    fun bookingReference(value: String?): ValidationResult {
        val v = value?.trim()?.uppercase().orEmpty()
        return when {
            v.isEmpty() -> ValidationResult.invalid("Enter a reference number or phone number.")
            Regex("^QF-\\d{4}-\\d{5}$").matches(v) -> ValidationResult.Valid
            SA_PHONE_PATTERN.matches(normalisePhone(v)) -> ValidationResult.Valid
            else -> ValidationResult.invalid("Enter a reference such as QF-2026-00042, or your phone number.")
        }
    }

    /** Convenience helper: true only when every supplied result is valid. */
    fun allValid(vararg results: ValidationResult): Boolean = results.all { it.isValid }
}
