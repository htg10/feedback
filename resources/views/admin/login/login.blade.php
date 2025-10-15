<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Northern Railway</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Help Together Group" />

    @include('layouts.backend.partials.style')
    @yield('style')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">

    <!-- Custom login page styles -->
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #241F54, #3C3C72);
            /* Updated background gradient */
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            background: rgba(36, 31, 84, 0.75);
            /* Primary Blue with opacity */
            border-radius: 16px;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 40px 30px;
            color: #FFFFFF;
            box-shadow: 0 0 30px rgba(163, 198, 255, 0.3);
            /* Light blue shadow */
        }

        .circular-logo {
            height: 100px;
            width: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #A3C6FF;
            /* Optional: matches theme */
            box-shadow: 0 0 10px rgba(163, 198, 255, 0.5);
            /* Optional: subtle glow */
        }

        .login-wrapper h2 {
            text-align: center;
            font-size: 26px;
            font-weight: 600;
            color: #A3C6FF;
            /* Accent color */
        }

        .login-wrapper h4 {
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #A3C6FF;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #FFFFFF;
        }

        .form-control:focus {
            border-color: #A3C6FF;
            box-shadow: 0 0 0 0.15rem rgba(163, 198, 255, 0.4);
        }

        .btn-primary {
            background-color: #A3C6FF;
            color: #241F54;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #F4B2A1;
            /* optional hover effect */
            color: #312979;
        }

        .footer-text a {
            color: #A3C6FF;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <!-- Logo -->
        <div class="logo text-center">
            <img src="{{ asset('assets/images/images.jpeg') }}" alt="Logo" class="circular-logo">
        </div>

        <!-- Title -->
        <h2 class="mt-3">Northern Railway</h2>
        <h4 class="mb-3">( Delhi Division )</h4>

        <!-- Alerts -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group auth-pass-inputgroup">
                    <input type="password" name="password" class="form-control" id="password"
                        placeholder="Enter password" required>
                    <button class="btn btn-primary" type="button" id="password-addon">
                        <i class="mdi mdi-eye-outline"></i>
                    </button>
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="remember-check">
                <label class="form-check-label" for="remember-check">Remember me</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Log In</button>
            </div>
        </form>
        <br>
        <!-- Footer -->
        <div class="footer-text">
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script> Northern Railway. Designed by
            <a href="https://helptogethergroup.com/" target="_blank">Help Together Group</a>
        </div>
    </div>

    @include('layouts.backend.partials.script')
    @yield('script')

    <!-- Password Toggle -->
    <script>
        document.getElementById('password-addon').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove('mdi-eye-outline');
                icon.classList.add('mdi-eye-off-outline');
            } else {
                passwordField.type = "password";
                icon.classList.remove('mdi-eye-off-outline');
                icon.classList.add('mdi-eye-outline');
            }
        });
    </script>

</body>

</html>
