package za.co.quickfix.app.ui.screen

import androidx.compose.animation.AnimatedVisibility
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.Card
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.testTag
import androidx.compose.ui.unit.dp

private data class HelpTopic(val question: String, val answer: String)

/** In-app help system. Mirrors section 12 of the user documentation. */
private val HELP_TOPICS = listOf(
    HelpTopic(
        "How do I book a repair?",
        "Open the Book tab, fill in your contact and device details, choose the problem " +
            "that best matches your fault and describe what happened in at least 20 characters. " +
            "Tap Submit booking request. You will receive a reference number and a confirmation email."
    ),
    HelpTopic(
        "Where do I find my reference number?",
        "It appears on the screen immediately after you submit a booking, and in the " +
            "confirmation email we send you. It looks like QF-2026-00042."
    ),
    HelpTopic(
        "What do the repair statuses mean?",
        "New means we have your request but have not contacted you yet. Contacted means a " +
            "technician has quoted you. In Progress means the repair is under way. Ready for " +
            "Pickup means your device is waiting at the store. Resolved means the job is closed."
    ),
    HelpTopic(
        "Why does the app say my phone number is invalid?",
        "We accept South African numbers in the format 082 123 4567, +27 82 123 4567 or " +
            "0821234567. Spaces and dashes are fine - the app removes them for you."
    ),
    HelpTopic(
        "I forgot my password.",
        "On the sign-in screen, enter your email address and tap Continue with Google if you " +
            "registered with Google. Otherwise contact the store and we will send you a reset link."
    ),
    HelpTopic(
        "Is my data safe?",
        "Your password is held by Google Firebase Authentication as a salted hash and is never " +
            "stored by QuickFix. All traffic between the app and our servers uses HTTPS. " +
            "We handle your personal information in line with POPIA."
    ),
    HelpTopic(
        "How accurate is the pricing?",
        "Prices shown are estimates that include VAT and standard labour. Laptop parts vary by " +
            "make and model, so give us your exact model or serial number for a firm quote."
    ),
    HelpTopic(
        "How do I change my notification settings?",
        "Open the Settings tab and switch email or SMS notifications on or off. Your choice is " +
            "saved on this device immediately."
    ),
    HelpTopic(
        "Can I sell or trade in my old device?",
        "Yes. Contact the store or use the Sell Device page on quickfix.co.za. We assess " +
            "storage, battery health, screen condition and whether the device is unlocked."
    ),
    HelpTopic(
        "Who do I contact for anything else?",
        "Call +27 62 161 4699 or email support@quickfix.co.za. We are at 296 Pretorius Street, " +
            "Pretoria Central, Monday to Friday 08:00-18:00 and Saturday 09:00-13:00."
    )
)

@Composable
fun HelpScreen() {
    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(20.dp),
        verticalArrangement = Arrangement.spacedBy(10.dp)
    ) {
        Text("Help and support", style = MaterialTheme.typography.headlineSmall)
        Text("Tap a question to see the answer.", style = MaterialTheme.typography.bodyMedium)

        HELP_TOPICS.forEachIndexed { index, topic ->
            var expanded by remember { mutableStateOf(false) }
            Card(
                modifier = Modifier
                    .fillMaxWidth()
                    .clickable { expanded = !expanded }
                    .testTag("help_topic_$index")
            ) {
                Column(Modifier.padding(14.dp), verticalArrangement = Arrangement.spacedBy(6.dp)) {
                    Text(topic.question, style = MaterialTheme.typography.titleSmall)
                    AnimatedVisibility(visible = expanded) {
                        Text(topic.answer, style = MaterialTheme.typography.bodyMedium)
                    }
                }
            }
        }
    }
}
