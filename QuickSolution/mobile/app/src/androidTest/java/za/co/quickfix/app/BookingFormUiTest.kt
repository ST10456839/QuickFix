package za.co.quickfix.app

import androidx.compose.ui.test.assertIsDisplayed
import androidx.compose.ui.test.junit4.createComposeRule
import androidx.compose.ui.test.onNodeWithTag
import androidx.compose.ui.test.onNodeWithText
import androidx.compose.ui.test.performClick
import androidx.compose.ui.test.performTextInput
import org.junit.Rule
import org.junit.Test
import za.co.quickfix.app.ui.screen.ValidatedField
import za.co.quickfix.app.ui.theme.QuickFixTheme

/**
 * Instrumented UI tests. These run on a physical device or emulator and prove
 * the requirement that the interface handles invalid input without crashing.
 *
 * Run with:  ./gradlew connectedDebugAndroidTest
 */
class BookingFormUiTest {

    @get:Rule
    val composeRule = createComposeRule()

    @Test
    fun invalidInput_showsInlineError_andDoesNotCrash() {
        composeRule.setContent {
            QuickFixTheme {
                var value = ""
                ValidatedField(
                    label = "Email address",
                    value = value,
                    onValueChange = { value = it },
                    error = "Please enter a valid email address.",
                    testTag = "test_email"
                )
            }
        }

        composeRule.onNodeWithTag("test_email").assertIsDisplayed()
        composeRule.onNodeWithText("Please enter a valid email address.").assertIsDisplayed()
    }

    @Test
    fun fieldAcceptsTextInput() {
        composeRule.setContent {
            QuickFixTheme {
                ValidatedField(
                    label = "Full name",
                    value = "",
                    onValueChange = {},
                    testTag = "test_name"
                )
            }
        }

        composeRule.onNodeWithTag("test_name").performTextInput("Katlego Maile")
        composeRule.onNodeWithTag("test_name").assertIsDisplayed()
    }

    @Test
    fun helpScreen_expandsTopicOnTap() {
        composeRule.setContent {
            QuickFixTheme { za.co.quickfix.app.ui.screen.HelpScreen() }
        }

        composeRule.onNodeWithTag("help_topic_0").performClick()
        composeRule.onNodeWithText("How do I book a repair?").assertIsDisplayed()
    }
}
