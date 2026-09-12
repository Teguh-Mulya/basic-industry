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

    .sidebar-toggle { display: flex; align-items: center; justify-content: center; width: 100%; min-height: 34px; margin: 0 0 12px; border: 2px solid #79c1cc; border-radius: 7px; background: transparent; color: #fff; cursor: pointer; }
    .sidebar-toggle:hover { background: #fff; color: #126b7a; }
    .sidebar-toggle-icon, .sidebar-toggle-icon::before, .sidebar-toggle-icon::after { display: block; width: 18px; height: 2px; border-radius: 2px; background: currentColor; }
    .sidebar-toggle-icon { position: relative; }
    .sidebar-toggle-icon::before, .sidebar-toggle-icon::after { position: absolute; left: 0; content: ''; }
    .sidebar-toggle-icon::before { top: -6px; }
    .sidebar-toggle-icon::after { top: 6px; }
    .sidebar-label { overflow: hidden; white-space: nowrap; }
    .sidebar-short { display: none; }

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

    .sidebar.is-collapsed { width: 68px; padding-right: 9px; padding-left: 9px; }
    .sidebar.is-collapsed .sidebar-title { overflow: hidden; margin-left: 0; padding-left: 0; font-size: 0; white-space: nowrap; }
    .sidebar.is-collapsed .sidebar-title::after { font-size: 22px; content: 'BI'; }
    .sidebar.is-collapsed .sidebar-label { display: none; }
    .sidebar.is-collapsed .sidebar-short { display: inline; }
    .sidebar.is-collapsed .menu .menu-link { justify-content: center; width: 100%; padding-right: 4px; padding-left: 4px; }
    .sidebar.is-collapsed .logout button { width: 100%; overflow: hidden; font-size: 0; }
    .sidebar.is-collapsed .logout button::after { font-size: 13px; content: 'Keluar'; }

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

        .sidebar.is-collapsed { width: 100%; height: 58px; min-height: 58px; padding: 10px 12px; }
        .sidebar.is-collapsed .sidebar-title { display: none; }
        .sidebar.is-collapsed .sidebar-toggle { width: auto; margin: 0 auto; }
        .sidebar.is-collapsed .menu, .sidebar.is-collapsed .logout { display: none; }

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
    <button class="sidebar-toggle" type="button" aria-label="Minimalkan sidebar" title="Minimalkan sidebar" aria-expanded="true"><span class="sidebar-toggle-icon" aria-hidden="true"></span></button>

    <nav class="menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="sidebar-label">Dashboard</span><span class="sidebar-short" aria-hidden="true">D</span></a>
        <a href="{{ route('admin.categories.index') }}" class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><span class="sidebar-label">Kelola Kategori</span><span class="sidebar-short" aria-hidden="true">K</span></a>
        <a href="{{ route('admin.products.index') }}" class="menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><span class="sidebar-label">Kelola Produk</span><span class="sidebar-short" aria-hidden="true">P</span></a>
        <a href="{{ route('admin.stocks.index') }}" class="menu-link {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}"><span class="sidebar-label">Kelola Stok</span><span class="sidebar-short" aria-hidden="true">S</span></a>
        <a href="{{ route('admin.customers.index') }}" class="menu-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"><span class="sidebar-label">Kelola Pelanggan</span><span class="sidebar-short" aria-hidden="true">L</span></a>
        <a href="{{ route('admin.payment-methods.index') }}" class="menu-link {{ request()->routeIs('admin.payment-methods.*') ? 'active' : '' }}"><span class="sidebar-label">Kelola Pembayaran</span><span class="sidebar-short" aria-hidden="true">B</span></a>
        <a href="{{ route('admin.reports.index') }}" class="menu-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><span class="sidebar-label">Kelola Laporan</span><span class="sidebar-short" aria-hidden="true">R</span></a>
        <a href="{{ route('admin.users.index') }}" class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><span class="sidebar-label">Kelola Pengguna</span><span class="sidebar-short" aria-hidden="true">U</span></a>
    </nav>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </div>
</aside>
<script>
    (() => {
        const sidebar = document.querySelector('.sidebar');
        const toggle = document.querySelector('.sidebar-toggle');
        const storageKey = 'admin-sidebar-collapsed';
        if (!sidebar || !toggle) return;
        const setCollapsed = (collapsed) => {
            sidebar.classList.toggle('is-collapsed', collapsed);
            toggle.setAttribute('aria-expanded', String(!collapsed));
            toggle.setAttribute('aria-label', `${collapsed ? 'Maksimalkan' : 'Minimalkan'} sidebar`);
            toggle.setAttribute('title', `${collapsed ? 'Maksimalkan' : 'Minimalkan'} sidebar`);
            localStorage.setItem(storageKey, String(collapsed));
        };
        setCollapsed(localStorage.getItem(storageKey) === 'true');
        toggle.addEventListener('click', () => setCollapsed(!sidebar.classList.contains('is-collapsed')));
    })();
</script>
