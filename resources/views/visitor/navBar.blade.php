<!DOCTYPE html>
<html>
<head>
    <title>Winsoft Solutions</title>
    <link href="/css/visitor.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <!-- Top Navbar -->
    <header class="visitor-header">
        <div class="visitor-navbar">

            <!-- Logo -->
            <a href="/" class="visitor-brand">
                <img src="/img/winsoftlogo.png" alt="Winsoft Logo">
                <div class="visitor-brand-text">
                    <span class="brand-name">Winsoft Solutions</span>
                    <span class="brand-tagline">Your Trusted IT Partner</span>
                </div>
            </a>

            <!-- Account Actions -->
            <div class="visitor-account-nav">
                <a href="/" class="account-link">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>

                <a href="/login" class="account-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>

                <a href="/register" class="register-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Register</span>
                </a>
            </div>

        </div>

        <!-- Main Navigation -->
        <nav class="visitor-second-nav">
            <div class="visitor-nav-container">

                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-house"></i>
                    Home
                </a>

                <a href="/shop" class="{{ request()->is('shop*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i>
                    Shopping
                </a>

                <a href="/login">
                    <i class="fas fa-screwdriver-wrench"></i>
                    Service
                </a>

                <a href="/contactUs" class="{{ request()->is('contactUs*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    Contact Us
                </a>

                <a href="/storeLocation" class="{{ request()->is('storeLocation*') ? 'active' : '' }}">
                    <i class="fas fa-location-dot"></i>
                    Store Location
                </a>

            </div>
        </nav>
    </header>

</body>
</html>
```