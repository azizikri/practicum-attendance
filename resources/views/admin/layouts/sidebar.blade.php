<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            Practicum <span>Attendance</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ active_class(['admin.dashboard']) }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dasbor</span>
                </a>
            </li>
            <li class="nav-item nav-category">Transaksi</li>
            <li class="nav-item {{ active_class(['admin.orders.index', 'admin.orders.show']) }}">
                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="shopping-cart"></i>
                    <span class="link-title">Pemesanan</span>
                </a>
            </li>
            <li class="nav-item nav-category">Inventori</li>
            <li
                class="nav-item {{ active_class(['admin.products.index', 'admin.products.create', 'admin.products.edit']) }}">
                <a href="{{ route('admin.products.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Produk</span>
                </a>
            </li>
            <li
                class="nav-item {{ active_class(['admin.services.index', 'admin.services.create', 'admin.services.edit']) }}">
                <a href="{{ route('admin.services.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="shopping-bag"></i>
                    <span class="link-title">Servis</span>
                </a>
            </li>
            <li class="nav-item nav-category">Pengguna</li>
            <li
                class="nav-item {{ active_class(['admin.users.index', 'admin.users.create', 'admin.users.edit', 'admin.users.show']) }}">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">User</span>
                </a>
            </li>
            @can('isSuperAdmin', auth('admin')->user())
                <li
                    class="nav-item {{ active_class(['admin.admins.index', 'admin.admins.create', 'admin.admins.edit']) }}">
                    <a href="{{ route('admin.admins.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="shield"></i>
                        <span class="link-title">Admin</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</nav>
