# Retrofit / Gson model classes are created reflectively.
-keep class za.co.quickfix.app.data.model.** { *; }
-keepattributes Signature, InnerClasses, *Annotation*
-dontwarn okhttp3.**
-dontwarn retrofit2.**
