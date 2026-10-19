package za.co.quickfix.app.ui.theme

import androidx.compose.foundation.isSystemInDarkTheme
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.darkColorScheme
import androidx.compose.material3.lightColorScheme
import androidx.compose.runtime.Composable
import androidx.compose.ui.graphics.Color

private val QuickFixPurple = Color(0xFF6D28D9)
private val QuickFixPurpleLight = Color(0xFFC4B5FD)
private val QuickFixInk = Color(0xFF111827)
private val QuickFixSurface = Color(0xFFF9FAFB)

private val LightColors = lightColorScheme(
    primary = QuickFixPurple,
    onPrimary = Color.White,
    secondary = Color(0xFF0EA5E9),
    background = QuickFixSurface,
    surface = Color.White,
    onSurface = QuickFixInk,
    error = Color(0xFFB3261E)
)

private val DarkColors = darkColorScheme(
    primary = QuickFixPurpleLight,
    onPrimary = QuickFixInk,
    secondary = Color(0xFF38BDF8),
    background = Color(0xFF0B1020),
    surface = Color(0xFF151A2C),
    onSurface = Color(0xFFE5E7EB),
    error = Color(0xFFF2B8B5)
)

@Composable
fun QuickFixTheme(
    darkTheme: Boolean = isSystemInDarkTheme(),
    content: @Composable () -> Unit
) {
    MaterialTheme(
        colorScheme = if (darkTheme) DarkColors else LightColors,
        content = content
    )
}
