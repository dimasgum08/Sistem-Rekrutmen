<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary d-flex align-items-center">
                <h5 class="mb-0 text-uppercase">PT Al-Falah Banyuwangi</h5>
            </a>
        </div>
        <div class="navbar-content">
            <div class="card pc-user-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ getInfoLogin()->image ? asset('storage/images/users/' . getInfoLogin()->image) : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(getInfoLogin()->name)}}" alt="user-image"
                                class="user-avtar wid-45 rounded-circle" />
                        </div>
                        <div class="flex-grow-1 ms-3 me-2">
                            <h6 class="mb-0">{{ getInfoLogin()->name }}</h6>
                            <small>{{ getInfoLogin()->roles[0]->name }}</small>
                        </div>
                        <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse"
                            href="#pc_sidebar_userlink">
                            <span class="pc-icon">
                                <i class="ti ti-chevrons-down"></i>
                            </span>
                        </a>
                    </div>
                    <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                        <div class="pt-3">
                            <a href="#!">
                                <i class="ti ti-power"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="pc-navbar">
                <li class="pc-caption">
                    <span class="pc-label">Menu</span>
                </li>

                <li class="pc-item {{ request()->is('apps/dashboard*') ? 'active' : '' }}">
                    <a href="{{ route('apps.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-smart-home"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->is('apps/job-vacancies*') ? 'active' : '' }}">
                    <a href="{{ route('apps.job-vacancies') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-template"></i></span>
                        <span class="pc-mtext">Lowongan Kerja</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->is('apps/candidates*') ? 'active' : '' }}">
                    <a href="{{ route('apps.candidates') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-check"></i></span>
                        <span class="pc-mtext">Pelamar</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->is('apps/schedules*') ? 'active' : '' }}">
                    <a href="{{ route('apps.schedules') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar"></i></span>
                        <span class="pc-mtext">Jadwal Interview</span>
                    </a>
                </li>

                <li class="pc-caption">
                    <span class="pc-label">Pengaturan</span>
                </li>
                <li class="pc-item {{ request()->is('apps/users*') ? 'active' : '' }}">
                    <a href="{{ route('apps.users') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Pengguna</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>
