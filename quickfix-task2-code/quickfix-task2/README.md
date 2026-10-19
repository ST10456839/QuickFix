# QuickFix Laptop Solutions

Repair booking, trade-in and pre-owned device platform for QuickFix Laptop
Solutions, 296 Pretorius Street, Pretoria Central.

Built for **XISD6329 – Work Integrated Learning, Task 2** by *Causal Fun*:
Sibusiso Sindane, Lesego Mogara, Muvhuso Ndanduleni and Thabiso Dlamini.

---

## What is in this repository

| Path | What it holds |
|---|---|
| `mobile/` | Android app (Kotlin, Jetpack Compose, MVVM) |
| `api/v1/` | REST API consumed by the app (PHP 8.2, PDO) |
| `database/` | MySQL schema, seed data and the seed verification query |
| `QuickSolution/` | The existing public website and admin panel |
| `.github/workflows/` | GitHub Actions pipelines for the app and the website |

## Architecture at a glance

```
Android app (Kotlin/Compose)
        │  Firebase ID token (JWT) in the Authorization header
        ▼
Firebase Authentication  ──verified by──►  QuickFix REST API (PHP)
  email/password + Google SSO                        │
  salted password hashes                             ▼
                                              MySQL  quickfix_db
                                                     ▲
                                 QuickFix website and admin panel
```

The app never stores a password and never sends a user id of its own. Identity is
proven on every request by a short-lived Firebase ID token, which the API verifies
with Google before touching the database.

## Running the mobile app

1. Install Android Studio (Ladybug or newer) with the **Android 16 (API 36) SDK**.
2. Open the `mobile/` folder.
3. Generate the Gradle wrapper once: `gradle wrapper --gradle-version 8.13`
   (CI uses `gradle/actions/setup-gradle`, so the wrapper jar is not committed).
4. Copy `mobile/local.properties.example` to `mobile/local.properties` and fill in
   `API_BASE_URL` and `GOOGLE_WEB_CLIENT_ID`.
5. Download `google-services.json` from the Firebase console into `mobile/app/`,
   then uncomment the `google-services` plugin in `mobile/app/build.gradle.kts`.
6. Run on a **physical phone** – the marked demonstration video may not use an emulator.

> Dependency versions in `mobile/gradle/libs.versions.toml` were current at the time
> of writing. If one fails to resolve, update it in that file only.

## Running the tests

```bash
cd mobile
gradle testDebugUnitTest          # JVM unit tests - Validator, BookingRepository
gradle connectedDebugAndroidTest  # UI tests on a connected device
gradle lintDebug                  # Android Lint
```

## Setting up the database

```bash
mysql -u root -p -e "CREATE DATABASE quickfix_db CHARACTER SET utf8mb4;"
mysql -u root -p quickfix_db < database/schema.sql
mysql -u root -p quickfix_db < database/seed_data.sql
mysql -u root -p quickfix_db < database/verify_seed.sql   # every table ≥ 10 rows
```

## Configuration and secrets

Copy `.env.example` to `.env` on the server and fill it in. **`.env` is never
committed** – the PHP CI workflow fails the build if a tracked `.env` is found.

## Continuous integration

| Workflow | Trigger | What it does |
|---|---|---|
| `Android CI` | push / PR | Unit tests, Android Lint, assembles and publishes a debug APK |
| `Website and API CI` | push / PR | Lints every PHP file, applies the schema and seed data to a MySQL service, asserts every table holds at least ten records |

Instrumented emulator tests run on manual dispatch (`workflow_dispatch`).

## Branching

`main` is protected and always deployable. Work happens on `feature/<short-name>`
branches and reaches `main` through a pull request that must pass both workflows.
