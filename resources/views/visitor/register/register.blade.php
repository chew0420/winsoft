<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Winsoft Solutions</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;
            background: #f4f6f8;
            color: #1f2937;
        }

        /* ==============================
           TOP NAVBAR
        ================================= */

        .register-navbar {
            width: 100%;
            height: 72px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 40px;

            background: #ffffff;
            border-bottom: 1px solid #eeeeee;

            position: fixed;
            top: 0;
            left: 0;

            z-index: 1000;
        }

        .register-navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;

            text-decoration: none;
        }

        .register-navbar-brand img {
            height: 42px;
            width: auto;
        }

        .register-navbar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .register-navbar-brand-text strong {
            color: #222;
            font-size: 18px;
        }

        .register-navbar-brand-text span {
            color: #888;
            font-size: 11px;
            margin-top: 2px;
        }

        .back-login {
            display: flex;
            align-items: center;
            gap: 7px;

            text-decoration: none;
            color: #555;

            font-size: 14px;
            font-weight: 500;

            padding: 9px 14px;

            border-radius: 8px;

            transition: 0.25s;
        }

        .back-login:hover {
            background: #fff1f1;
            color: #e42b2b;
        }

        /* ==============================
           PAGE
        ================================= */

        .register-page {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 110px 30px 40px;
        }

        .register-container {
            width: 100%;
            max-width: 1050px;
            min-height: 620px;

            display: grid;
            grid-template-columns: 1.05fr 0.95fr;

            background: #ffffff;

            border-radius: 20px;

            overflow: hidden;

            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.10);
        }

        /* ==============================
           LEFT BRAND SECTION
        ================================= */

        .register-brand-section {
            position: relative;

            background:
                linear-gradient(
                    rgba(17, 24, 39, 0.91),
                    rgba(31, 41, 55, 0.94)
                );

            padding: 60px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            color: white;
        }

        .register-brand-section::before {
            content: "";

            position: absolute;

            width: 260px;
            height: 260px;

            border-radius: 50%;

            background: rgba(228, 43, 43, 0.15);

            top: -100px;
            right: -80px;
        }

        .register-brand-section::after {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.04);

            bottom: -70px;
            left: -60px;
        }

        .register-brand-content {
            position: relative;
            z-index: 2;
        }

        .register-logo-box {
            display: inline-flex;

            background: white;

            padding: 10px;

            border-radius: 12px;

            margin-bottom: 30px;
        }

        .register-logo-box img {
            height: 60px;
            width: auto;
        }

        .register-brand-section h1 {
            font-size: 38px;
            line-height: 1.2;

            margin-bottom: 18px;
        }

        .register-brand-section h1 span {
            color: #ff5a5a;
        }

        .register-brand-description {
            max-width: 430px;

            color: #d1d5db;

            font-size: 15px;
            line-height: 1.7;

            margin-bottom: 35px;
        }

        .register-features {
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .register-feature {
            display: flex;
            align-items: center;
            gap: 12px;

            color: #e5e7eb;

            font-size: 14px;
        }

        .register-feature-icon {
            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: rgba(228, 43, 43, 0.18);

            color: #ff6565;
        }

        /* ==============================
           RIGHT FORM
        ================================= */

        .register-form-section {
            padding: 55px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-form-header {
            margin-bottom: 28px;
        }

        .register-form-header span {
            color: #e42b2b;

            font-size: 13px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .register-form-header h2 {
            color: #1f2937;

            font-size: 30px;

            margin: 8px 0 10px;
        }

        .register-form-header p {
            color: #7a7a7a;

            font-size: 14px;
            line-height: 1.5;
        }

        /* form */
        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;

            margin-bottom: 8px;

            color: #374151;

            font-size: 14px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper > i {
            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #9ca3af;

            font-size: 14px;
        }

        .input-wrapper input {
            width: 100%;

            padding: 13px 45px 13px 42px;

            border: 1px solid #dcdfe4;

            border-radius: 9px;

            font-size: 14px;

            background: #ffffff;

            transition: 0.25s;
        }

        .input-wrapper input:focus {
            outline: none;

            border-color: #e42b2b;

            box-shadow: 0 0 0 3px rgba(228, 43, 43, 0.08);
        }

        .password-toggle {
            position: absolute;

            right: 15px;
            top: 50%;

            transform: translateY(-50%);

            border: none;
            background: transparent;

            color: #9ca3af;

            cursor: pointer;

            padding: 0;
        }

        .password-toggle:hover {
            color: #e42b2b;
        }

        /* register button */
        .register-btn {
            width: 100%;

            border: none;

            padding: 14px;

            margin-top: 5px;

            border-radius: 9px;

            background: #e42b2b;

            color: white;

            font-size: 15px;
            font-weight: 700;

            cursor: pointer;

            transition: 0.25s;
        }

        .register-btn:hover {
            background: #c91f1f;

            transform: translateY(-1px);

            box-shadow: 0 8px 20px rgba(228, 43, 43, 0.22);
        }

        .register-btn i {
            margin-right: 6px;
        }

        .login-area {
            margin-top: 23px;

            padding-top: 20px;

            border-top: 1px solid #eeeeee;

            text-align: center;

            font-size: 14px;
            color: #777;
        }

        .login-area a {
            color: #e42b2b;
            font-weight: 600;
            text-decoration: none;
        }

        .login-area a:hover {
            text-decoration: underline;
        }

        /* message */
        .form-message {
            display: flex;
            align-items: center;
            gap: 9px;

            padding: 12px 15px;

            margin-bottom: 18px;

            border-radius: 8px;

            font-size: 13px;
        }

        .form-error {
            color: #b42318;
            background: #fff1f0;
            border: 1px solid #ffd1cc;
        }

        .form-success {
            color: #166534;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        /* ==============================
           RESPONSIVE
        ================================= */

        @media (max-width: 850px) {

            .register-container {
                grid-template-columns: 1fr;
                max-width: 550px;
            }

            .register-brand-section {
                padding: 45px 40px;
            }

            .register-brand-section h1 {
                font-size: 30px;
            }

            .register-features {
                display: none;
            }

            .register-form-section {
                padding: 45px 40px;
            }
        }

        @media (max-width: 550px) {

            .register-navbar {
                padding: 0 18px;
            }

            .register-navbar-brand-text {
                display: none;
            }

            .back-login span {
                display: none;
            }

            .register-page {
                padding: 95px 15px 25px;
            }

            .register-container {
                border-radius: 14px;
            }

            .register-brand-section {
                padding: 35px 28px;
            }

            .register-logo-box img {
                height: 48px;
            }

            .register-brand-section h1 {
                font-size: 26px;
            }

            .register-brand-description {
                margin-bottom: 0;
            }

            .register-form-section {
                padding: 38px 28px;
            }

            .register-form-header h2 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <nav class="register-navbar">

        <a href="/" class="register-navbar-brand">
            <img src="/img/winsoftlogo.png" alt="Winsoft Solutions Logo">

            <div class="register-navbar-brand-text">
                <strong>Winsoft Solutions</strong>
                <span>Your Trusted IT Partner</span>
            </div>
        </a>

        <a href="/" class="back-login">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>

    </nav>

    <main class="register-page">

        <div class="register-container">

            <!-- Left -->
            <section class="register-brand-section">

                <div class="register-brand-content">

                    <div class="register-logo-box">
                        <img src="/img/winsoftlogo.png" alt="Winsoft Solutions Logo">
                    </div>

                    <h1>
                        Join<br>
                        <span>Winsoft Solutions</span>
                    </h1>

                    <p class="register-brand-description">
                        Create your account to shop for IT products,
                        manage your orders and access our technical services.
                    </p>

                    <div class="register-features">

                        <div class="register-feature">
                            <div class="register-feature-icon">
                                <i class="fas fa-cart-shopping"></i>
                            </div>

                            <span>Shop IT products easily</span>
                        </div>

                        <div class="register-feature">
                            <div class="register-feature-icon">
                                <i class="fas fa-box"></i>
                            </div>

                            <span>Manage and track your orders</span>
                        </div>

                        <div class="register-feature">
                            <div class="register-feature-icon">
                                <i class="fas fa-screwdriver-wrench"></i>
                            </div>

                            <span>Access professional technical services</span>
                        </div>

                    </div>

                </div>

            </section>

            <!-- Right -->
            <section class="register-form-section">

                <div class="register-form-header">
                    <span>Create Account</span>

                    <h2>Get Started Today</h2>

                    <p>
                        Fill in your information below to create your account.
                    </p>
                </div>

                @if(session()->has('error'))
                    <div class="form-message form-error">
                        <i class="fas fa-circle-exclamation"></i>
                        {{ session()->get('error') }}
                    </div>
                @elseif(session()->has('success'))
                    <div class="form-message form-success">
                        <i class="fas fa-circle-check"></i>
                        {{ session()->get('success') }}
                    </div>
                @endif

                <form method="post" action="{{ url('/register') }}">

                    @csrf

                    <div class="form-group">

                        <label>Full Name</label>

                        <div class="input-wrapper">

                            <i class="fas fa-user"></i>

                            <input
                                type="text"
                                name="name"
                                placeholder="Enter your full name"
                                value="{{ old('name') }}"
                                required
                            >

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Email Address</label>

                        <div class="input-wrapper">

                            <i class="fas fa-envelope"></i>

                            <input
                                type="email"
                                name="email"
                                placeholder="Enter your email address"
                                value="{{ old('email') }}"
                                required
                            >

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Phone Number</label>

                        <div class="input-wrapper">

                            <i class="fas fa-phone"></i>

                            <input
                                type="text"
                                name="phone_number"
                                placeholder="Enter your phone number"
                                value="{{ old('phone_number') }}"
                            >

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Password</label>

                        <div class="input-wrapper">

                            <i class="fas fa-lock"></i>

                            <input
                                type="password"
                                name="password"
                                id="registerPassword"
                                placeholder="Create your password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword()"
                                aria-label="Show or hide password"
                            >
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </button>

                        </div>

                    </div>

                    <button type="submit" name="register" class="register-btn">
                        <i class="fas fa-user-plus"></i>
                        Create Account
                    </button>

                </form>

                <div class="login-area">
                    Already have an account?
                    <a href="/login">Login here</a>
                </div>

            </section>

        </div>

    </main>

    <script>
        function togglePassword() {

            const passwordInput = document.getElementById('registerPassword');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');

            } else {

                passwordInput.type = 'password';

                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        @if(session()->has('success'))
            setTimeout(function() {
                window.location.href = "{{ url('/login') }}";
            }, 1500);
        @endif
    </script>

</body>
</html>