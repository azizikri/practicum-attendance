<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth()->user()->name }}
                </a>
                <div class="p-0 dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="px-5 py-3 d-flex flex-column align-items-center border-bottom">
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ auth()->user()->name }}</p>
                            <small>{{ auth()->user()->role }}</small>
                            <p class="tx-12 text-muted">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <ul class="p-1 list-unstyled">
                        <li class="py-2 dropdown-item">
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <a href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault();
                    this.closest('form').submit();">
                                    <div class="text-body ms-0">
                                        <i class="me-2 icon-md" data-feather="log-out"></i>
                                        <span>Logout</span>
                                    </div>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
