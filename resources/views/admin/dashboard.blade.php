<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - Basic Industry</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f8;
            color: #333;
        }

        .navbar {
            background: #222;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            font-size: 20px;
        }

        .navbar span {
            font-size: 14px;
        }

        .container {
            padding: 30px;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h1 {
            margin-bottom: 8px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
            font-size: 15px;
            color: #777;
            margin-bottom: 12px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
        }

        .menu {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        .menu h2 {
            margin-bottom: 20px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .menu-item {
            padding: 18px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .menu-item strong {
            display: block;
            margin-bottom: 5px;
        }

        .logout {
            margin-top: 25px;
        }

        .logout button {
            padding: 10px 18px;
            background: #222;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        @media (max-width: 800px) {
            .cards,
            .menu-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Basic Industry</h2>
        <span>Administrator</span>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Dashboard Admin</h1>
            <p>Selamat datang, {{ auth()->user()->name }}.</p>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Total Produk</h3>
                <p>0</p>
            </div>

            <div class="card">
                <h3>Total Stok</h3>
                <p>0</p>
            </div>

            <div class="card">
                <h3>Total Customer</h3>
                <p>0</p>
            </div>

            <div class="card">
                <h3>Total Transaksi</h3>
                <p>0</p>
            </div>

        </div>

        <div class="menu">

            <h2>Menu Utama</h2>

            <div class="menu-grid">

                <div class="menu-item">
                    <strong>Kategori</strong>
                    <span>Kelola kategori produk</span>
                </div>

                <div class="menu-item">
                    <strong>Produk</strong>
                    <span>Kelola data produk</span>
                </div>

                <div class="menu-item">
                    <strong>Stok</strong>
                    <span>Kelola persediaan produk</span>
                </div>

                <div class="menu-item">
                    <strong>Customer</strong>
                    <span>Kelola data pelanggan</span>
                </div>

                <div class="menu-item">
                    <strong>Transaksi</strong>
                    <span>Kelola transaksi penjualan</span>
                </div>

                <div class="menu-item">
                    <strong>Laporan</strong>
                    <span>Melihat laporan sistem</span>
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