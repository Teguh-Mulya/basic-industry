<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Basic Industry</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #146b7a;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        /* Judul Basic Industry */
        .brand {
            text-align: center;
            margin-bottom: 42px;
        }

        .brand h1 {
            font-size: 22px;
            font-weight: bold;
            color: white;
        }

        /* Kotak login */
        .login-card {
            border: 3px solid white;
            border-radius: 7px;
            padding: 30px 22px 36px;
            background: #146b7a;
        }

        .login-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title h2 {
            font-size: 20px;
            font-weight: normal;
            color: white;
        }

        /* Form */
        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            color: white;
        }

        .form-group input {
            width: 100%;
            height: 37px;
            padding: 8px 10px;
            border: none;
            border-radius: 6px;
            background: #d9d9d9;
            color: #333;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            background: #ffffff;
        }

        /* Tombol */
        .button-container {
            text-align: center;
            margin-top: 32px;
        }

        .btn-login {
            min-width: 84px;
            height: 37px;
            padding: 0 20px;
            border: none;
            border-radius: 6px;
            background: #d9d9d9;
            color: #146b7a;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-login:hover {
            background: white;
        }

        /* Pesan error */
        .error {
            background: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        /* Footer */
        .footer {
            display: none;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <!-- Nama aplikasi -->
        <div class="brand">
            <h1>Basic Industry</h1>
        </div>

        <!-- Form Login -->
        <div class="login-card">

            <div class="login-title">
                <h2>Login Internal</h2>
                <p style="margin-top: 8px; font-size: 12px; color: #dff7fa;">Admin, Admin Penjualan, dan Pemilik</p>
            </div>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">

                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Kata Sandi</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >
                </div>

                <!-- Tombol -->
                <div class="button-container">
                    <button type="submit" class="btn-login">
                        Masuk
                    </button>
                </div>

                <p style="margin-top: 18px; text-align: center; font-size: 13px;"><a href="{{ route('customer.login') }}" style="color: white;">Login Customer</a></p>

            </form>

        </div>

    </div>

</body>
</html>