<!DOCTYPE html>
<html>
<head>
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <!-- Top Navbar -->
    <header class="customer-header">
        <div class="customer-navbar">

            <!-- Logo -->
            <a href="/customerHomePage" class="customer-brand">
                <img src="/img/winsoftlogo.png" alt="Winsoft Logo">

                <div class="customer-brand-text">
                    <span class="brand-name">Winsoft Solution</span>
                    <span class="brand-tagline">Your Trusted IT Partner</span>
                </div>
            </a>

            <!-- Customer Actions -->
            <div class="customer-account-nav">

                <a href="/customer/cart" class="customer-action-link" title="Shopping Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Cart</span>
                </a>

                <a href="/customer/profile" class="customer-action-link" title="My Profile">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>

                <a href="/logout" class="customer-logout-btn" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>

            </div>

        </div>

        <!-- Main Navigation -->
        <nav class="customer-second-nav">
            <div class="customer-nav-container">

                <a href="/customerHomePage"
                   class="{{ request()->is('customerHomePage') ? 'active' : '' }}">
                    <i class="fas fa-house"></i>
                    Home
                </a>

                <a href="/customer/shop"
                   class="{{ request()->is('customer/shop*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i>
                    Shopping
                </a>

                <a href="/customer/service"
                   class="{{ request()->is('customer/service*') ? 'active' : '' }}">
                    <i class="fas fa-screwdriver-wrench"></i>
                    Service
                </a>

                <a href="/customer/contactUs"
                   class="{{ request()->is('customer/contactUs*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    Contact Us
                </a>

                <a href="/customer/storeLocation"
                   class="{{ request()->is('customer/storeLocation*') ? 'active' : '' }}">
                    <i class="fas fa-location-dot"></i>
                    Store Location
                </a>

            </div>
        </nav>
    </header>

</body>
</html>