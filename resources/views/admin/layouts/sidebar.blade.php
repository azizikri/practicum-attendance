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
            @can('isAdmin', auth()->user())
                <li class="nav-item nav-category">Manajemen Admin</li>
                <li class="nav-item {{ active_class(['admin.classes.index', 'admin.classes.create', 'admin.classes.edit', 'admin.classes.show']) }}">
                    <a href="{{ route('admin.classes.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="book"></i>
                        <span class="link-title">Kelas</span>
                    </a>
                </li>
                <li class="nav-item {{ active_class(['admin.subjects.index', 'admin.subjects.create', 'admin.subjects.edit']) }}">
                    <a href="{{ route('admin.subjects.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="book"></i>
                        <span class="link-title">Mata Praktikum</span>
                    </a>
                </li>

                <li class="nav-item nav-category">Pengguna</li>
                <li class="nav-item {{ active_class(['admin.admins.index', 'admin.admins.create', 'admin.admins.edit']) }}">
                    <a href="{{ route('admin.admins.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="shield"></i>
                        <span class="link-title">Admin</span>
                    </a>
                </li>
                <li
                    class="nav-item {{ active_class(['admin.assistants.index', 'admin.assistants.create', 'admin.assistants.edit']) }}">
                    <a href="{{ route('admin.assistants.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="user"></i>
                        <span class="link-title">Asisten</span>
                    </a>
                </li>
                <li
                    class="nav-item {{ active_class(['admin.students.index', 'admin.students.create', 'admin.students.edit']) }}">
                    <a href="{{ route('admin.students.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="user"></i>
                        <span class="link-title">Praktikan</span>
                    </a>
                </li>
                <li
                    class="nav-item {{ active_class(['admin.settings.edit']) }}">
                    <a href="{{ route('admin.settings.edit') }}" class="nav-link">
                        <i class="link-icon" data-feather="settings"></i>
                        <span class="link-title">Settings</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</nav>
