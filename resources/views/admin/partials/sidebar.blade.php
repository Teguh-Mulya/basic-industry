<style>
    .layout {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        position: static;
        width: 194px;
        min-height: 100vh;
        height: auto;
        background: #126b7a;
        padding: 18px 13px;
        flex-shrink: 0;
    }

    .sidebar-title {
        color: white;
        font-size: 22px;
        font-weight: normal;
        margin-bottom: 15px;
        padding-left: 3px;
        text-align: left;
    }

    .menu {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .menu .menu-link {
        width: 155px;
        height: 36px;
        border: 2px solid #79c1cc;
        border-radius: 7px;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding-left: 13px;
        font-size: 13px;
        transition: 0.2s;
    }

    .menu .menu-link:hover {
        background: #ffffff;
        color: #126b7a;
    }

    .menu .menu-link.active {
        background: #126b7a;
        color: white;
    }

    .logout {
        position: static;
        margin-top: 20px;
        bottom: auto;
        left: auto;
        right: auto;
        text-align: left;
    }

    .logout button {
        width: 155px;
        height: 35px;
        border: none;
        border-radius: 7px;
        padding: 0;
        background: #ff0808;
        color: white;
        font-size: 14px;
        cursor: pointer;
    }

    .logout button:hover {
        background: #d90000;
    }

    .content {
        flex: 1;
        min-height: 0;
        margin-left: 0;
        padding: 30px 18px;
        overflow-x: auto;
    }

    @media (max-width: 900px) {
        .sidebar {
            width: 180px;
        }

        .menu .menu-link,
        .logout button {
            width: 150px;
        }
    }

    @media (max-width: 650px) {
        .layout {
            display: flex;
        }

        .sidebar {
            width: 180px;
        }

        .content {
            padding: 30px 18px;
        }
    }

    @media (max-width: 600px) {
        .layout {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            min-height: auto;
        }

        .sidebar-title {
            text-align: center;
        }

        .menu {
            align-items: center;
            gap: 10px;
        }

        .logout {
            text-align: center;
        }

        .content {
            padding: 20px 12px;
        }
    }
</style>

<aside class="sidebar">
    <div class="sidebar-title">Basic Industry</div>

    <nav class="menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.categories.index') }}" class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Kelola Kategori</a>
        <a href="{{ route('admin.products.index') }}" class="menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Kelola Produk</a>
        <a href="{{ route('admin.stocks.index') }}" class="menu-link {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}">Kelola Stok</a>
        <a href="{{ route('admin.customers.index') }}" class="menu-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">Kelola Pelanggan</a>
        <a href="{{ route('admin.payment-methods.index') }}" class="menu-link {{ request()->routeIs('admin.payment-methods.*') ? 'active' : '' }}">Kelola Pembayaran</a>
        <a href="{{ route('admin.reports.index') }}" class="menu-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">Kelola Laporan</a>
        <a href="{{ route('admin.users.index') }}" class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Kelola Pengguna</a>
    </nav>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </div>
</aside>
