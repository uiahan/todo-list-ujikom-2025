<nav class="navbar bg-white w-100 shadow-lg rounded-3 navbar-expand-xl bg-body-tertiary">
    <div class="container-fluid">
        
        <a class="navbar-brand text-second ms-2">Hallo, {{ $user->name }} </a>
        <div class="d-flex d-block d-xl-none">
            <li class="nav-item dropdown me-2 d-flex align-items-center">
                <a class="nav-link position-relative text-second fs-5" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false" id="notification-link">
                    <i class="fa-regular fa-bell fa-lg"></i>
                    @if ($user->unreadNotifications->count() > 0)
                        <span
                            class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger"
                            id="notification-badge">
                            {{ $user->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="width: 300px;">
                    <li class="dropdown-header text-dark fw-bold">Notifikasi</li>
                    @forelse ($user->unreadNotifications as $notification)
                        <li>
                            <a href="{{ route('job') }}" class="dropdown-item small"
                                data-id="{{ $notification->id }}">
                                {{ $notification->data['message'] }}
                                <br>
                                <small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </a>
                        </li>
                    @empty
                        <li>
                            <span class="dropdown-item text-muted">Tidak ada notifikasi baru.</span>
                        </li>
                    @endforelse
                    <a href="{{ route('notification') }}" class="dropdown-item"
                        style="font-size: 13px; color: #6b757d;">History</a>
                </ul>
            </li>
            <button class="border-0 bg-transparent fs-3 d-block d-xl-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fa-solid text-second fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-none d-xl-block">
                <div class="d-flex">
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link position-relative fs-5" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" id="notification-link">
                            <i class="fa-regular fa-bell fa-lg"></i>
                            @if ($user->unreadNotifications->count() > 0)
                                <span
                                    class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger"
                                    id="notification-badge">
                                    {{ $user->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="width: 300px;">
                            <li class="dropdown-header text-dark fw-bold">Notifikasi</li>
                            @forelse ($user->unreadNotifications as $notification)
                                <li>
                                    <a href="{{ route('job') }}" class="dropdown-item small"
                                        data-id="{{ $notification->id }}">
                                        {{ $notification->data['message'] }}
                                        <br>
                                        <small
                                            class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <span class="dropdown-item text-muted">Tidak ada notifikasi baru.</span>
                                </li>
                            @endforelse
                            <a href="{{ route('notification') }}" class="dropdown-item"
                                style="font-size: 13px; color: #6b757d;">History</a>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if ($user->profile)
                                <img src="{{ asset('storage/' . $user->profile) }}" class="rounded-circle"
                                    width="40" height="40" alt="">
                            @else
                                <img src="{{ asset('images/profile-default.png') }}" class="rounded-circle"
                                    width="40" height="40" alt="">
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                            <li class="mb-1"><a class="dropdown-item" style="color: #3D0A05"
                                    href="{{ route('profile') }}"><i class="fa-regular fa-user"></i> Profile</a></li>
                            <li class="mb-1"><a class="dropdown-item" style="color: #3D0A05"
                                    href="{{ route('profile') }}"><i class="fa-regular fa-lock"></i> Password</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" style="color: #3D0A05"
                                        class="rounded-0 dropdown-item btn w-100 text-start">
                                        <i class="fa-regular fa-left-from-bracket"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </div>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-block d-xl-none">
                <hr>
                @if ($user->role == 'admin')
                    <small class="text-second ms-1 mb-1">Home</small>
                    <li class="nav-item mb-3 {{ request()->routeIs('dashboard.admin') ? 'active-nav-link' : '' }}">
                        <a href="{{ route('dashboard.admin') }}" class="nav-link ps-3 text-second">
                            <i class="fa-regular fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <small class="text-second ms-1 mb-1">Manage</small>
                    <li class="nav-item {{ request()->routeIs('manage.tasker') ? 'active-nav-link' : '' }}">
                        <a href="{{ route('manage.tasker') }}" class="nav-link ps-3 text-second">
                            <i class="fa-duotone fa-regular fa-user-tie me-2"></i> Tasker
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('manage.worker') ? 'active-nav-link' : '' }}">
                        <a href="{{ route('manage.worker') }}" class="nav-link ps-3 text-second">
                            <i class="fa-regular fa-user-helmet-safety me-2"></i> Worker
                        </a>
                    </li>
                @endif
                @if ($user->role == 'tasker')
                    <small class="text-second ms-1 mb-1">Home</small>
                    <li class="nav-item mb-3 {{ request()->routeIs('dashboard.tasker') ? 'active-nav-link' : '' }}">
                        <a href="{{ route('dashboard.tasker') }}" class="nav-link ps-3 text-second">
                            <i class="fa-regular fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <small class="text-second ms-1 mb-1">Menu</small>
                    <li class="nav-item {{ request()->routeIs('manage.job') ? 'active-nav-link' : '' }}">
                        <a href="{{ route('manage.job') }}" class="nav-link ps-3 text-second">
                            <i class="fa-regular fa-briefcase me-2"></i> Jobs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('manage.job') }}" class="nav-link ps-3 text-second">
                            <i class="fa-regular fa-clock-rotate-left me-2"></i> History
                        </a>
                    </li>
                @endif
                @if ($user->role == 'worker')
                    <small class="text-second ms-1 mb-1">Home</small>
                    <li
                        class="nav-item mb-3 ps-3 {{ request()->routeIs('dashboard.worker') ? 'active-nav-link' : '' }}">
                        <a href="{{ route('dashboard.worker') }}" class="nav-link text-second">
                            <i class="fa-regular fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <small class="text-second ms-1 mb-1">Menu</small>
                    <li class="nav-item ps-3 {{ request()->routeIs('job') ? 'active-nav-link' : '' }}">
                        <a href="{{ route('job') }}" class="nav-link text-second">
                            <i class="fa-regular fa-briefcase me-2"></i> My Job
                        </a>
                    </li>
                    <li class="nav-item ps-3 mb-3 {{ request()->routeIs('job.private') ? 'active-nav-link' : '' }}">
                        <a href="{{ route('job.private') }}" class="nav-link text-second">
                            <i class="fa-regular fa-lock me-2"></i> Private Job
                        </a>
                    </li>
                @endif
                <small class="text-second ms-1 mb-1">Settings</small>
                <li
                    class="nav-item mb-1 ps-3 {{ request()->routeIs('profile') ? 'active-nav-link' : '' }}">
                    <a href="{{ route('profile') }}" class="nav-link text-second">
                        <i class="fa-regular fa-user me-1"></i> Profile
                    </a>
                </li>
                <li
                    class="nav-item mb-1 ps-3">
                    <a href="{{ route('profile') }}" class="nav-link text-second">
                        <i class="fa-regular fa-lock me-1"></i> Password
                    </a>
                </li>
                <li
                    class="nav-item mb-1 ps-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn w-100 text-start btn-lg btn-tranparent text-second">
                            <i class="fa-regular fa-left-from-bracket me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .badge {
        font-size: 0.7rem;
        padding: 0.4rem 0.5rem;
        width: auto;
        height: auto;
        min-width: 1.5rem;
    }

    .dropdown-menu {
        max-height: 400px;
        overflow-y: auto;
    }

    .read {
        background-color: #f8f9fa;
        color: #6c757d;
    }
</style>

<script>
    document.querySelectorAll('.dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const notificationId = item.getAttribute('data-id');
            const badge = document.getElementById('notification-badge');

            if (badge) {
                badge.style.display = 'none';
            }

            fetch('/mark-notification-as-read', {
                method: 'POST',
                body: JSON.stringify({
                    notification_id: notificationId
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json()).then(data => {
                if (data.status === 'success') {
                    console.log('Notifikasi berhasil ditandai sebagai dibaca');
                }
            });
        });
    });

    document.querySelectorAll('.dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const notificationId = item.getAttribute('data-id');
            const badge = document.getElementById('notification-badge');

            if (badge) {
                badge.style.display = 'none';
            }

            item.classList.add('read');

            fetch('/notification/mark-notification-as-read', {
                method: 'POST',
                body: JSON.stringify({
                    notification_id: notificationId
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json()).then(data => {
                if (data.status === 'success') {
                    console.log('Notifikasi berhasil ditandai sebagai dibaca');
                }
            });
        });
    });
</script>
