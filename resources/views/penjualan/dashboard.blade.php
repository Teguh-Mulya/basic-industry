<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Penjualan - Basic Industry</title>

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
            margin-bottom: 25px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,.06);
        }

        .card h3 {
            color: #777;
            font-size: 15px;
            margin-bottom: 12px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
        }

        .transaction {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        .transaction h2 {
            margin-bottom: 20px;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .menu-item {
            border: 1px solid #ddd;
            padding: 18px;
            border-radius: 8px;
        }

        .menu-item strong {
            display: block;
            margin-bottom: 6px;
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
        <span>Admin Penjualan</span>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Dashboard Penjualan</h1>
            <p>Selamat datang, {{ auth()->user()->name }}.</p>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Transaksi Hari Ini</h3>
                <p>0</p>
            </div>

            <div class="card">
                <h3>Penjualan Hari Ini</h3>
                <p>Rp 0</p>
            </div>

            <div class="card">
                <h3>Customer</h3>
                <p>0</p>
            </div>

        </div>

        <div class="transaction">

            <h2>Menu Penjualan</h2>

            <div class="menu">

                <div class="menu-item">
                    <strong>Transaksi Penjualan</strong>
                    <span>Input dan proses transaksi.</span>
                </div>

                <div class="menu-item">
                    <strong>Customer</strong>
                    <span>Kelola data pelanggan.</span>
                </div>

                <div class="menu-item">
                    <strong>Stok Produk</strong>
                    <span>Cek ketersediaan produk.</span>
                </div>

            </div>

            <div class="logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>

        </div>

    </div>

</body>
</html>