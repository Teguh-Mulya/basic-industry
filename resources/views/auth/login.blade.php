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
        max-width: 400px;
        padding: 18px;
    }

    /* =========================
       BRAND
    ========================= */

    .brand {
        text-align: center;
        margin-bottom: 35px;
    }

    .brand h1 {
        font-size: 21px;
        font-weight: bold;
        color: white;
    }

    /* =========================
       LOGIN CARD
    ========================= */

    .login-card {
        border: 2px solid white;
        border-radius: 7px;
        padding: 27px 20px 22px;
        background: #146b7a;
    }

    .login-title {
        text-align: center;
        margin-bottom: 25px;
    }

    .login-title h2 {
        font-size: 19px;
        font-weight: normal;
        color: white;
    }

    .login-title p {
        margin-top: 7px;
        font-size: 11px;
        color: #dff7fa;
    }

    /* =========================
       ERROR
    ========================= */

    .error {
        background: #f8d7da;
        color: #842029;
        padding: 9px;
        border-radius: 5px;
        margin-bottom: 16px;
        font-size: 12px;
    }

    /* =========================
       FORM
    ========================= */

    .form-group {
        margin-bottom: 13px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        color: white;
    }

    .form-group input {
        width: 100%;
        height: 36px;
        padding: 8px 10px;
        border: none;
        border-radius: 6px;
        background: #d9d9d9;
        color: #333;
        font-size: 13px;
        outline: none;
    }

    .form-group input:focus {
        background: #ffffff;
    }

    /* =========================
       BUTTON LOGIN
    ========================= */

    .button-container {
        text-align: center;
        margin-top: 27px;
    }

    .btn-login {
        min-width: 80px;
        height: 35px;
        padding: 0 18px;
        border: none;
        border-radius: 6px;
        background: #d9d9d9;
        color: #146b7a;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-login:hover {
        background: white;
    }

    /* =========================
       LOGIN CUSTOMER
    ========================= */

    .customer-login {
        margin-top: 15px;
        text-align: center;
        font-size: 12px;
    }

    .customer-login a {
        color: white;
        text-decoration: none;
    }

    .customer-login a:hover {
        text-decoration: underline;
    }

    /* =========================
       AKUN DEMO
    ========================= */

    .demo-account {
        margin-top: 13px;
    }

    .demo-toggle {
        width: 100%;
        height: 30px;
        padding: 0 10px;
        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 5px;
        background: transparent;
        color: white;
        font-size: 11px;
        cursor: pointer;
        text-align: left;
        transition: 0.2s;
    }

    .demo-toggle:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .demo-icon {
        float: right;
        font-size: 14px;
        line-height: 11px;
    }

    .demo-content {
        display: none;
        margin-top: 7px;
        padding: 6px 8px;
        border-radius: 5px;
        background: rgba(255, 255, 255, 0.07);
        font-size: 10px;
    }

    .demo-content.show {
        display: block;
    }

    .demo-item {
        padding: 7px 2px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.13);
    }

    .demo-item:last-child {
        border-bottom: none;
    }

    .demo-role {
        display: block;
        margin-bottom: 5px;
        font-size: 11px;
        font-weight: bold;
        color: white;
    }

    /* =========================
       DATA AKUN
    ========================= */

    .demo-row {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 3px;
    }

    .demo-text {
        flex: 1;
        min-width: 0;
        color: #dff7fa;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .copy-btn {
        flex-shrink: 0;
        border: none;
        border-radius: 4px;
        padding: 3px 7px;
        background: rgba(255, 255, 255, 0.85);
        color: #146b7a;
        font-size: 9px;
        cursor: pointer;
    }

    .copy-btn:hover {
        background: white;
    }

    .copy-btn.copied {
        background: #dff7fa;
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

            <p>
                Admin, Admin Penjualan, dan Pemilik
            </p>

        </div>


        <!-- Pesan Error -->

        @if ($errors->any())

            <div class="error">
                {{ $errors->first() }}
            </div>

        @endif


        <form action="{{ route('login.process') }}" method="POST">

            @csrf


            <!-- Email -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

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

                <label for="password">
                    Kata Sandi
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

            </div>


            <!-- Tombol Login -->

            <div class="button-container">

                <button
                    type="submit"
                    class="btn-login"
                >
                    Masuk
                </button>

            </div>


            <!-- Login Customer -->

            <div class="customer-login">

                <a href="{{ route('customer.login') }}">
                    Login Customer
                </a>

            </div>


            <!-- =========================
                 AKUN DEMO
            ========================= -->

            <div class="demo-account">

                <button
                    type="button"
                    class="demo-toggle"
                    onclick="toggleDemo()"
                >
                    Lihat Akun Demo

                    <span
                        id="demo-icon"
                        class="demo-icon"
                    >
                        +
                    </span>

                </button>


                <!-- Isi Akun Demo -->

                <div
                    id="demo-content"
                    class="demo-content"
                >

                    <!-- Administrator -->

                    <div class="demo-item">

                        <span class="demo-role">
                            Administrator
                        </span>

                        <div class="demo-row">

                            <span class="demo-text">
                                admin@basicindustry.test
                            </span>

                            <button
                                type="button"
                                class="copy-btn"
                                onclick="copyText(this, 'admin@basicindustry.test')"
                            >
                                Copy
                            </button>

                        </div>

                        <div class="demo-row">

                            <span class="demo-text">
                                Admin12345
                            </span>

                            <button
                                type="button"
                                class="copy-btn"
                                onclick="copyText(this, 'Admin12345')"
                            >
                                Copy
                            </button>

                        </div>

                    </div>


                    <!-- Pemilik -->

                    <div class="demo-item">

                        <span class="demo-role">
                            Pemilik
                        </span>

                        <div class="demo-row">

                            <span class="demo-text">
                                pemilik@basicindustry.test
                            </span>

                            <button
                                type="button"
                                class="copy-btn"
                                onclick="copyText(this, 'pemilik@basicindustry.test')"
                            >
                                Copy
                            </button>

                        </div>

                        <div class="demo-row">

                            <span class="demo-text">
                                Pemilik12345
                            </span>

                            <button
                                type="button"
                                class="copy-btn"
                                onclick="copyText(this, 'Pemilik12345')"
                            >
                                Copy
                            </button>

                        </div>

                    </div>


                    <!-- Admin Penjualan -->

                    <div class="demo-item">

                        <span class="demo-role">
                            Admin Penjualan
                        </span>

                        <div class="demo-row">

                            <span class="demo-text">
                                penjualan@basicindustry.test
                            </span>

                            <button
                                type="button"
                                class="copy-btn"
                                onclick="copyText(this, 'penjualan@basicindustry.test')"
                            >
                                Copy
                            </button>

                        </div>

                        <div class="demo-row">

                            <span class="demo-text">
                                Penjualan12345
                            </span>

                            <button
                                type="button"
                                class="copy-btn"
                                onclick="copyText(this, 'Penjualan12345')"
                            >
                                Copy
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

    function toggleDemo() {

        const content =
            document.getElementById('demo-content');

        const icon =
            document.getElementById('demo-icon');


        content.classList.toggle('show');


        if (content.classList.contains('show')) {

            icon.textContent = '−';

        } else {

            icon.textContent = '+';

        }

    }


    function copyText(button, text) {

        navigator.clipboard.writeText(text)
            .then(function () {

                const originalText = button.textContent;

                button.textContent = '✓';

                button.classList.add('copied');


                setTimeout(function () {

                    button.textContent = originalText;

                    button.classList.remove('copied');

                }, 1200);

            })
            .catch(function () {

                alert('Gagal menyalin data.');

            });

    }

</script>


</body>
</html>