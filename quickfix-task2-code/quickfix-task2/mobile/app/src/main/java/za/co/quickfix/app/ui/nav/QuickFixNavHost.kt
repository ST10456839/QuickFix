package za.co.quickfix.app.ui.nav

import androidx.compose.foundation.layout.padding
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Build
import androidx.compose.material.icons.filled.Home
import androidx.compose.material.icons.filled.Info
import androidx.compose.material.icons.filled.List
import androidx.compose.material.icons.filled.Search
import androidx.compose.material.icons.filled.Settings
import androidx.compose.material3.Icon
import androidx.compose.material3.NavigationBar
import androidx.compose.material3.NavigationBarItem
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavDestination.Companion.hierarchy
import androidx.navigation.NavGraph.Companion.findStartDestination
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.currentBackStackEntryAsState
import androidx.navigation.compose.rememberNavController
import za.co.quickfix.app.auth.AuthViewModel
import za.co.quickfix.app.ui.screen.BookRepairScreen
import za.co.quickfix.app.ui.screen.HelpScreen
import za.co.quickfix.app.ui.screen.HomeScreen
import za.co.quickfix.app.ui.screen.LoginScreen
import za.co.quickfix.app.ui.screen.PricingScreen
import za.co.quickfix.app.ui.screen.RegisterScreen
import za.co.quickfix.app.ui.screen.SettingsScreen
import za.co.quickfix.app.ui.screen.TrackRepairScreen

object Routes {
    const val LOGIN = "login"
    const val REGISTER = "register"
    const val HOME = "home"
    const val BOOK = "book"
    const val TRACK = "track"
    const val PRICING = "pricing"
    const val SETTINGS = "settings"
    const val HELP = "help"
}

private data class Tab(val route: String, val label: String, val icon: ImageVector)

private val tabs = listOf(
    Tab(Routes.HOME, "Home", Icons.Filled.Home),
    Tab(Routes.BOOK, "Book", Icons.Filled.Build),
    Tab(Routes.TRACK, "Track", Icons.Filled.Search),
    Tab(Routes.PRICING, "Pricing", Icons.Filled.List),
    Tab(Routes.SETTINGS, "Settings", Icons.Filled.Settings),
    Tab(Routes.HELP, "Help", Icons.Filled.Info)
)

@Composable
fun QuickFixNavHost() {
    val navController = rememberNavController()
    val authViewModel: AuthViewModel = viewModel()
    val authState by authViewModel.state.collectAsState()

    val backStackEntry by navController.currentBackStackEntryAsState()
    val currentRoute = backStackEntry?.destination
    val showBottomBar = authState.isSignedIn &&
        currentRoute?.hierarchy?.any { dest -> tabs.any { it.route == dest.route } } == true

    Scaffold(
        bottomBar = {
            if (showBottomBar) {
                NavigationBar {
                    tabs.forEach { tab ->
                        NavigationBarItem(
                            selected = currentRoute?.hierarchy?.any { it.route == tab.route } == true,
                            onClick = {
                                navController.navigate(tab.route) {
                                    popUpTo(navController.graph.findStartDestination().id) {
                                        saveState = true
                                    }
                                    launchSingleTop = true
                                    restoreState = true
                                }
                            },
                            icon = { Icon(tab.icon, contentDescription = tab.label) },
                            label = { Text(tab.label) }
                        )
                    }
                }
            }
        }
    ) { padding ->
        NavHost(
            navController = navController,
            startDestination = if (authState.isSignedIn) Routes.HOME else Routes.LOGIN,
            modifier = Modifier.padding(padding)
        ) {
            composable(Routes.LOGIN) {
                LoginScreen(
                    viewModel = authViewModel,
                    onSignedIn = {
                        navController.navigate(Routes.HOME) {
                            popUpTo(Routes.LOGIN) { inclusive = true }
                        }
                    },
                    onRegister = { navController.navigate(Routes.REGISTER) }
                )
            }
            composable(Routes.REGISTER) {
                RegisterScreen(
                    viewModel = authViewModel,
                    onSignedIn = {
                        navController.navigate(Routes.HOME) {
                            popUpTo(Routes.LOGIN) { inclusive = true }
                        }
                    },
                    onBack = { navController.popBackStack() }
                )
            }
            composable(Routes.HOME) {
                HomeScreen(
                    displayName = authState.displayName,
                    onBook = { navController.navigate(Routes.BOOK) },
                    onTrack = { navController.navigate(Routes.TRACK) },
                    onPricing = { navController.navigate(Routes.PRICING) }
                )
            }
            composable(Routes.BOOK) { BookRepairScreen() }
            composable(Routes.TRACK) { TrackRepairScreen() }
            composable(Routes.PRICING) { PricingScreen() }
            composable(Routes.SETTINGS) {
                SettingsScreen(
                    onSignOut = {
                        authViewModel.signOut()
                        navController.navigate(Routes.LOGIN) {
                            popUpTo(0) { inclusive = true }
                        }
                    }
                )
            }
            composable(Routes.HELP) { HelpScreen() }
        }
    }
}
