package za.co.quickfix.app.util

import org.junit.Assert.assertEquals
import org.junit.Assert.assertFalse
import org.junit.Assert.assertTrue
import org.junit.Test

/**
 * Unit tests for the input-control rules.
 *
 * These run on the JVM in a few seconds and are executed on every push by the
 * GitHub Actions workflow (.github/workflows/android-ci.yml).
 */
class ValidatorTest {

    // ---------- Full name ----------

    @Test
    fun `full name accepts a normal South African name`() {
        assertTrue(Validator.fullName("Katlego Maile").isValid)
        assertTrue(Validator.fullName("Muvhuso Ndanduleni").isValid)
        assertTrue(Validator.fullName("O'Brien Smith-Jones").isValid)
    }

    @Test
    fun `full name rejects blank and single character input`() {
        assertFalse(Validator.fullName("").isValid)
        assertFalse(Validator.fullName("   ").isValid)
        assertFalse(Validator.fullName("K").isValid)
    }

    @Test
    fun `full name rejects digits and symbols`() {
        assertFalse(Validator.fullName("Robert123").isValid)
        assertFalse(Validator.fullName("<script>alert(1)</script>").isValid)
    }

    // ---------- Email ----------

    @Test
    fun `email accepts valid addresses`() {
        assertTrue(Validator.email("support@quickfix.co.za").isValid)
        assertTrue(Validator.email("first.last+tag@example.com").isValid)
    }

    @Test
    fun `email rejects malformed addresses`() {
        assertFalse(Validator.email("").isValid)
        assertFalse(Validator.email("not-an-email").isValid)
        assertFalse(Validator.email("missing@domain").isValid)
        assertFalse(Validator.email("@quickfix.co.za").isValid)
        assertFalse(Validator.email("spaces in@mail.com").isValid)
    }

    // ---------- Phone ----------

    @Test
    fun `phone accepts the three South African formats`() {
        assertTrue(Validator.phone("0821234567").isValid)
        assertTrue(Validator.phone("082 123 4567").isValid)
        assertTrue(Validator.phone("+27 82 123 4567").isValid)
    }

    @Test
    fun `phone rejects wrong length and non numeric input`() {
        assertFalse(Validator.phone("").isValid)
        assertFalse(Validator.phone("08212345").isValid)
        assertFalse(Validator.phone("08212345678").isValid)
        assertFalse(Validator.phone("not a phone").isValid)
    }

    @Test
    fun `normalise phone converts international prefixes to national format`() {
        assertEquals("0821234567", Validator.normalisePhone("+27 82 123 4567"))
        assertEquals("0821234567", Validator.normalisePhone("27821234567"))
        assertEquals("0821234567", Validator.normalisePhone("082-123-4567"))
    }

    // ---------- Password ----------

    @Test
    fun `password accepts a compliant password`() {
        assertTrue(Validator.password("QuickFix2026").isValid)
    }

    @Test
    fun `password rejects short passwords`() {
        val result = Validator.password("Qf1a")
        assertFalse(result.isValid)
        assertTrue(result.message!!.contains("8"))
    }

    @Test
    fun `password requires a digit a capital and a lowercase letter`() {
        assertFalse(Validator.password("quickfixpassword").isValid)
        assertFalse(Validator.password("QUICKFIX2026").isValid)
        assertFalse(Validator.password("Quickfixpassword").isValid)
    }

    @Test
    fun `passwords match only when identical`() {
        assertTrue(Validator.passwordsMatch("QuickFix2026", "QuickFix2026").isValid)
        assertFalse(Validator.passwordsMatch("QuickFix2026", "quickfix2026").isValid)
    }

    // ---------- Description, selection, amount ----------

    @Test
    fun `description must reach the minimum length`() {
        assertFalse(Validator.minLength("Broken", 20, "problem").isValid)
        assertTrue(
            Validator.minLength(
                "The screen cracked after I dropped the laptop yesterday.", 20, "problem"
            ).isValid
        )
    }

    @Test
    fun `selection rejects an empty choice`() {
        assertFalse(Validator.selection(null, "primary issue").isValid)
        assertFalse(Validator.selection("", "primary issue").isValid)
        assertTrue(Validator.selection("Screen Damage", "primary issue").isValid)
    }

    @Test
    fun `positive amount accepts formatted rand values`() {
        assertTrue(Validator.positiveAmount("4500").isValid)
        assertTrue(Validator.positiveAmount("R4 500").isValid)
        assertTrue(Validator.positiveAmount("4,500.50").isValid)
    }

    @Test
    fun `positive amount rejects zero negatives and text`() {
        assertFalse(Validator.positiveAmount("0").isValid)
        assertFalse(Validator.positiveAmount("-100").isValid)
        assertFalse(Validator.positiveAmount("cheap").isValid)
        assertFalse(Validator.positiveAmount("").isValid)
    }

    // ---------- Booking reference ----------

    @Test
    fun `booking reference accepts a reference or a phone number`() {
        assertTrue(Validator.bookingReference("QF-2026-00042").isValid)
        assertTrue(Validator.bookingReference("qf-2026-00042").isValid)
        assertTrue(Validator.bookingReference("0821234567").isValid)
    }

    @Test
    fun `booking reference rejects anything else`() {
        assertFalse(Validator.bookingReference("").isValid)
        assertFalse(Validator.bookingReference("12345").isValid)
        assertFalse(Validator.bookingReference("QF-26-42").isValid)
    }

    @Test
    fun `allValid is true only when every result passes`() {
        assertTrue(
            Validator.allValid(
                Validator.email("a@b.co.za"),
                Validator.phone("0821234567")
            )
        )
        assertFalse(
            Validator.allValid(
                Validator.email("a@b.co.za"),
                Validator.phone("nope")
            )
        )
    }
}
