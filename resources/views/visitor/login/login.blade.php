<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Winsoft Solutions</title>

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

        .login-navbar {
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

        .login-navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;

            text-decoration: none;
        }

        .login-navbar-brand img {
            height: 42px;
            width: auto;
        }

        .login-navbar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .login-navbar-brand-text strong {
            color: #222;
            font-size: 18px;
        }

        .login-navbar-brand-text span {
            color: #888;
            font-size: 11px;
            margin-top: 2px;
        }

        .back-home {
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

        .back-home:hover {
            background: #fff1f1;
            color: #e42b2b;
        }

        /* ==============================
           PAGE
        ================================= */

        .login-page {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 110px 30px 40px;
        }

        .login-container {
            width: 100%;
            max-width: 1050px;
            min-height: 580px;

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

        .login-brand-section {
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

        .login-brand-section::before {
            content: "";

            position: absolute;

            width: 260px;
            height: 260px;

            border-radius: 50%;

            background: rgba(228, 43, 43, 0.15);

            top: -100px;
            right: -80px;
        }

        .login-brand-section::after {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.04);

            bottom: -70px;
            left: -60px;
        }

        .login-brand-content {
            position: relative;
            z-index: 2;
        }

        .login-logo-box {
            display: inline-flex;

            background: white;

            padding: 10px;

            border-radius: 12px;

            margin-bottom: 30px;
        }

        .login-logo-box img {
            height: 60px;
            width: auto;
        }

        .login-brand-section h1 {
            font-size: 38px;
            line-height: 1.2;

            margin-bottom: 18px;
        }

        .login-brand-section h1 span {
            color: #ff5a5a;
        }

        .login-brand-description {
            max-width: 430px;

            color: #d1d5db;

            font-size: 15px;
            line-height: 1.7;

            margin-bottom: 35px;
        }

        .login-features {
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .login-feature {
            display: flex;
            align-items: center;
            gap: 12px;

            color: #e5e7eb;

            font-size: 14px;
        }

        .login-feature-icon {
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

        .login-form-section {
            padding: 65px 55px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-header {
            margin-bottom: 32px;
        }

        .login-form-header span {
            color: #e42b2b;

            font-size: 13px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 1px;
        }

        .login-form-header h2 {
            color: #1f2937;

            font-size: 30px;

            margin: 8px 0 10px;
        }

        .login-form-header p {
            color: #7a7a7a;

            font-size: 14px;
            line-height: 1.5;
        }

        /* form */
        .form-group {
            margin-bottom: 20px;
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

        /* login button */
        .login-btn {
            width: 100%;

            border: none;

            padding: 14px;

            margin-top: 7px;

            border-radius: 9px;

            background: #e42b2b;

            color: white;

            font-size: 15px;
            font-weight: 700;

            cursor: pointer;

            transition: 0.25s;
        }

        .login-btn:hover {
            background: #c91f1f;

            transform: translateY(-1px);

            box-shadow: 0 8px 20px rgba(228, 43, 43, 0.22);
        }

        .login-btn i {
            margin-right: 6px;
        }

        /* register */
        .register-area {
            margin-top: 25px;

            padding-top: 22px;

            border-top: 1px solid #eeeeee;

            text-align: center;

            font-size: 14px;

            color: #777;
        }

        .register-area a {
            color: #e42b2b;

            font-weight: 600;

            text-decoration: none;
        }

        .register-area a:hover {
            text-decoration: underline;
        }

        /* error */
        .login-error {
            display: flex;
            align-items: center;
            gap: 9px;

            padding: 12px 15px;

            margin-bottom: 20px;

            color: #b42318;

            background: #fff1f0;

            border: 1px solid #ffd1cc;

            border-radius: 8px;

            font-size: 13px;
        }

        /* ==============================
           RESPONSIVE
        ================================= */

        @media (max-width: 850px) {

            .login-container {
                grid-template-columns: 1fr;
                max-width: 550px;
            }

            .login-brand-section {
                padding: 45px 40px;
            }

            .login-brand-section h1 {
                font-size: 30px;
            }

            .login-features {
                display: none;
            }

            .login-form-section {
                padding: 45px 40px;
            }
        }

        @media (max-width: 550px) {

            .login-navbar {
                padding: 0 18px;
            }

            .login-navbar-brand-text {
                display: none;
            }

            .back-home span {
                display: none;
            }

            .login-page {
                padding: 95px 15px 25px;
            }

            .login-container {
                border-radius: 14px;
            }

            .login-brand-section {
                padding: 35px 28px;
            }

            .login-logo-box img {
                height: 48px;
            }

            .login-brand-section h1 {
                font-size: 26px;
            }

            .login-brand-description {
                margin-bottom: 0;
            }

            .login-form-section {
                padding: 38px 28px;
            }

            .login-form-header h2 {
                font-size: 26px;
            }
        }

    </style>
</head>

<body>

    <!-- Top Navbar -->
    <nav class="login-navbar">

        <a href="/" class="login-navbar-brand">
            <img src="/img/winsoftlogo.png" alt="Winsoft Solutions Logo">

            <div class="login-navbar-brand-text">
                <strong>Winsoft Solutions</strong>
                <span>Your Trusted IT Partner</span>
            </div>
        </a>

        <a href="/" class="back-home">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>

    </nav>

    <main class="login-page">

        <div class="login-container">

            <!-- Left -->
            <section class="login-brand-section">

                <div class="login-brand-content">

                    <div class="login-logo-box">
                        <img src="/img/winsoftlogo.png" alt="Winsoft Solutions Logo">
                    </div>

                    <h1>
                        Welcome to<br>
                        <span>Winsoft Solutions</span>
                    </h1>

                    <p class="login-brand-description">
                        Your reliable destination for IT products,
                        professional technical services and dependable support.
                    </p>

                    <div class="login-features">

                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-laptop"></i>
                            </div>

                            <span>Quality IT products and solutions</span>
                        </div>

                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-screwdriver-wrench"></i>
                            </div>

                            <span>Professional repair and technical services</span>
                        </div>

                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>

                            <span>Reliable customer support</span>
                        </div>

                    </div>

                </div>

            </section>

            <!-- Right -->
            <section class="login-form-section">

                <div class="login-form-header">
                    <span>Welcome Back</span>

                    <h2>Login to Your Account</h2>

                    <p>
                        Enter your email and password to continue.
                    </p>
                </div>

                @if(session()->has('fail'))
                    <div class="login-error">
                        <i class="fas fa-circle-exclamation"></i>
                        {{ session()->get('fail') }}
                    </div>
                @endif

                <form method="post" action="{{ url('/login') }}">

                    @csrf

                    <div class="form-group">

                        <label>Email Address</label>

                        <div class="input-wrapper">

                            <i class="fas fa-envelope"></i>

                            <input
                                type="email"
                                name="email"
                                placeholder="Enter your email address"
                                required
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
                                id="loginPassword"
                                placeholder="Enter your password"
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

                    <button type="submit" name="login" class="login-btn">
                        <i class="fas fa-right-to-bracket"></i>
                        Login
                    </button>

                </form>

                <div class="register-area">
                    Don't have an account?
                    <a href="/register">Create an account</a>
                </div>

            </section>

        </div>

    </main>

    <script>
        function togglePassword() {

            const passwordInput = document.getElementById('loginPassword');
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
    </script>

</body>
</html>