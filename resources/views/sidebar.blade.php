<aside class="sidebar p-3">

    <ul class="nav flex-column sidebar-menu">

        <li class="nav-item">
            <a href="{{ url('home') }}" 
               class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-grid me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('/piutang') }}" 
               class="nav-link {{ request()->is('piutang') ? 'active' : '' }}">
                <i class="bi bi-folder me-2"></i> Piutang
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('/laporan') }}" 
               class="nav-link {{ request()->is('laporan') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i> Laporan
            </a>
        </li>

    </ul>

</aside>