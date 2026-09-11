<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Customer - Basic Industry</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f8;
        }

        .navbar {
            background: #222;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
        }

        .container {
            padding: 30px;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .welcome h1 {
            margin-bottom: 10px;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,.06);
        }

        .card h2 {
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
        }

        .logout {
            margin-top: 25px;
        }

        button {
            padding: 10px 18px;
            background: #222;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <strong>Basic Industry</strong>
        <span>Customer</span>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Selamat Datang</h1>
            <p>
                Halo, {{ auth()->user()->name }}.
                Selamat datang di Sistem Informasi Basic Industry.
            </p>
        </div>

        <div class="menu">

            <div class="card">
                <h2>Produk</h2>
                <p>Lihat produk yang tersedia.</p>
            </div>

            <div class="card">
                <h2>Pemesanan</h2>
                <p>Lakukan pemesanan produk.</p>
            </div>

            <div class="card">
                <h2>Riwayat Transaksi</h2>
                <p>Lihat riwayat transaksi Anda.</p>
            </div>

        </div>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>

    </div>

</body>
</html>