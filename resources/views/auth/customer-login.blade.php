<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Customer - Basic Industry</title>

<style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        display: grid;
        place-items: center;
        padding: 20px;
        background: #126b7a;
        font-family: Arial, sans-serif;
        color: #fff;
    }

    .card {
        width: min(430px, 100%);
        padding: 30px;
        border: 2px solid #fff;
        border-radius: 10px;
        background: #126b7a;
        box-shadow: 0 12px 28px rgba(0, 0, 0, .15);
    }

    h1 {
        margin: 0 0 8px;
        font-size: 25px;
        font-weight: normal;
    }

    .sub {
        margin: 0 0 24px;
        color: #dff7fa;
        font-size: 13px;
    }

    /* =========================
       FORM
    ========================= */

    .field {
        margin-bottom: 16px;
    }

    .field label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
    }

    .field input {
        width: 100%;
        min-height: 44px;
        padding: 10px;
        border: 0;
        border-radius: 5px;
        font: inherit;
        outline: none;
    }

    .field input:focus {
        box-shadow: 0 0 0 2px rgba(255,255,255,.5);
    }

    /* =========================
       BUTTON LOGIN
    ========================= */

    .button {
        width: 100%;
        min-height: 44px;
        border: 0;
        border-radius: 5px;
        background: #fff;
        color: #126b7a;
        font-weight: bold;
        cursor: pointer;
    }

    .button:hover {
        background: #e8f6f7;
    }

    /* =========================
       ERROR
    ========================= */

    .error {
        margin-bottom: 16px;
        padding: 10px;
        border-radius: 5px;
        background: #ffe4e4;
        color: #8b0000;
        font-size: 13px;
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
        border: 1px solid rgba(255,255,255,.45);
        border-radius: 5px;
        background: transparent;
        color: white;
        font-size: 11px;
        cursor: pointer;
        text-align: left;
        transition: .2s;
    }

    .demo-toggle:hover {
        background: rgba(255,255,255,.1);
    }

    .demo-icon {
        float: right;
        font-size: 14px;
        line-height: 11px;
    }

    .demo-content {
        display: none;
        margin-top: 7px;
        padding: 7px 8px;
        border-radius: 5px;
        background: rgba(255,255,255,.07);
        font-size: 10px;
    }

    .demo-content.show {
        display: block;
    }

    .demo-role {
        display: block;
        margin-bottom: 5px;
        font-size: 11px;
        font-weight: bold;
    }

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
        padding: 3px 7px;
        border: 0;
        border-radius: 4px;
        background: rgba(255,255,255,.85);
        color: #126b7a;
        font-size: 9px;
        cursor: pointer;
    }

    .copy-btn:hover {
        background: #fff;
    }

    .copy-btn.copied {
        background: #dff7fa;
    }

    /* =========================
       LINKS
    ========================= */

    .links {
        margin: 15px 0 0;
        text-align: center;
        font-size: 13px;
    }

    .links a {
        color: #fff;
    }

    .internal-login {
        margin-top: 8px;
        text-align: center;
        font-size: 12px;
    }

    .internal-login a {
        color: #dff7fa;
        text-decoration: none;
    }

    .internal-login a:hover {
        text-decoration: underline;
    }

    @media(max-width:420px) {

        .card {
            padding: 24px;
        }

    }

</style>

</head>

<body>

<section class="card">

    <!-- =========================
         JUDUL
    ========================= -->

    <h1>Login Customer</h1>

    <p class="sub">
        Masuk untuk melihat produk dan mengelola pesanan Anda.
    </p>


    <!-- =========================
         ERROR
    ========================= -->

    @if($errors->any())

        <div class="error">
            {{ $errors->first() }}
        </div>

    @endif


    <!-- =========================
         FORM LOGIN
    ========================= -->

    <form
        action="{{ route('customer.login.process') }}"
        method="POST"
    >

        @csrf


        <!-- Email -->

        <div class="field">

            <label for="email">
                Email
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >

        </div>


        <!-- Password -->

        <div class="field">

            <label for="password">
                Password
            </label>

            <input
                id="password"
                type="password"
                name="password"
                required
            >

        </div>


        <!-- Tombol Login -->

        <button
            class="button"
            type="submit"
        >
            Masuk
        </button>



    <p class="links">

        Belum punya akun?

        <a href="{{ route('customer.register') }}">
            Daftar Customer
        </a>

    </p>

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


            <!-- Data Akun Demo -->

            <div
                id="demo-content"
                class="demo-content"
            >

                <span class="demo-role">
                    Customer
                </span>


                <!-- Email -->

                <div class="demo-row">

                    <span class="demo-text">
                        customer@basicindustry.test
                    </span>

                    <button
                        type="button"
                        class="copy-btn"
                        onclick="copyText(this, 'customer@basicindustry.test')"
                    >
                        Copy
                    </button>

                </div>


                <!-- Password -->

                <div class="demo-row">

                    <span class="demo-text">
                        Customer12345
                    </span>

                    <button
                        type="button"
                        class="copy-btn"
                        onclick="copyText(this, 'Customer12345')"
                    >
                        Copy
                    </button>

                </div>

            </div>

        </div>

    </form>

</section>


<!-- =========================
     JAVASCRIPT
========================= -->

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

                const originalText =
                    button.textContent;

                button.textContent = '✓';

                button.classList.add('copied');


                setTimeout(function () {

                    button.textContent =
                        originalText;

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
