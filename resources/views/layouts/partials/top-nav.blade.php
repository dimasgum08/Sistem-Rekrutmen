
@if (getInfoLogin()->roles[0]->name == 'Admin')
    <header class="pc-header">
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <!-- ======= Menu collapse Icon ===== -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    @include('layouts.components.notification')
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="{{ getInfoLogin()->image ? asset('storage/images/users/' . getInfoLogin()->image) : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(getInfoLogin()->name) }}"
                                alt="user-image" class="user-avtar" />
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Profile</h5>
                            </div>
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative"
                                    style="max-height: calc(100vh - 225px)">
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0">
                                            <img src="{{ getInfoLogin()->image ? asset('storage/images/users/' . getInfoLogin()->image) : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(getInfoLogin()->name) }}"
                                                alt="user-image" class="user-avtar wid-35" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ getInfoLogin()->name }}</h6>
                                            <span>{{ getInfoLogin()->email }}</span>
                                        </div>
                                    </div>
                                    <hr class="border-secondary border-opacity-50" />
                                    <div class="d-grid mb-3">
                                        <a href="{{ route('apps.logout') }}" class="btn btn-primary">
                                            <span class="pc-icon me-2 m-0 p-0">
                                                <i class="ti ti-power"></i>
                                            </span>Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
@else
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Toggler di kiri -->
            <button class="navbar-toggler order-1 border-0 text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="ti ti-menu fs-4"></i>
            </button>

            <span class="navbar-brand fw-bold text-white d-none d-lg-block mx-3">PT Al-Falah Banyuwangi</span>

            <!-- Notifikasi & User - Mobile -->
            <div class="d-flex align-items-center gap-3 order-2 d-lg-none">
                <!-- Notifikasi -->
                @include('layouts.components.notification')

                <!-- User -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#"
                        id="userDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ getInfoLogin()->image ? asset('storage/images/users/' . getInfoLogin()->image) : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(getInfoLogin()->name) }}"
                            alt="User" class="rounded-circle" width="32" height="32">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm" aria-labelledby="userDropdownMobile">
                        <li class="px-3 py-2">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->roles[0]->display_name ?? 'User' }}</small>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><a href="{{ route('apps.logout') }}" class="dropdown-item text-danger">Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Menu Utama -->
            <div class="collapse navbar-collapse w-100 order-3 order-lg-1 mt-2 mt-lg-0" id="navbarContent">
                <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0">
                    <li class="nav-item px-3"><a class="nav-link text-white {{ request()->is('apps/dashboard*') ? 'active nav-underline' : '' }}" aria-current="page" href="{{ route('apps.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item px-3"><a class="nav-link text-white {{ request()->is('apps/job-vacancies*') ? 'active nav-underline' : '' }}" href="{{ route('apps.job-vacancies')}}">{{ getInfoLogin()->roles[0]->name == 'Applicant' ? 'Informasi' : 'Data'}} Lowongan Kerja</a></li>

                    @if (getInfoLogin()->roles[0]->name == 'Applicant')
                    <li class="nav-item px-3"><a class="nav-link text-white {{ request()->is('apps/apply/jobs*') ? 'active nav-underline' : '' }}" href="{{ route('apps.apply.jobs') }}">Lamaran Saya</a></li>
                    @endif

                    @if (getInfoLogin()->roles[0]->name !== 'Applicant')
                    <li class="nav-item px-3"><a class="nav-link text-white {{ request()->is('apps/candidates*') ? 'active nav-underline' : '' }}" href="{{ route('apps.candidates') }}">Kandidat</a></li>
                    <li class="nav-item px-3"><a class="nav-link text-white {{ request()->is('apps/schedules*') ? 'active nav-underline' : '' }}" href="{{ route('apps.schedules') }}">Jadwal</a></li>
                    @endif
                </ul>
            </div>

            <!-- Notifikasi & User - Desktop -->
            <ul class="navbar-nav d-none d-lg-flex align-items-center gap-3 order-lg-2">
                <!-- Notifikasi -->
                <li class="nav-item">
                    @include('layouts.components.notification')
                </li>
                <!-- User -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ getInfoLogin()->image ? asset('storage/images/users/' . getInfoLogin()->image) : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(getInfoLogin()->name) }}"
                            alt="User" class="rounded-circle me-2" width="32" height="32">
                        <div class="d-none d-lg-block text-start me-2">
                            <div class="fw-bold lh-1">{{ auth()->user()->name }}</div>
                            <small
                                class="text-white-50">{{ auth()->user()->roles[0]->display_name ?? 'User' }}</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm" aria-labelledby="userDropdown">
                        <li class="px-3 py-2">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->roles[0]->display_name ?? 'User' }}</small>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a href="{{ route('apps.logout') }}" class="dropdown-item text-danger"> <i class="ti ti-power"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
@endif
