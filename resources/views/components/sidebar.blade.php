<div class="d-flex flex-column position-fixed flex-shrink-0 rounded-4 p-3 bg-white shadow"
    style="width: 250px; height: 94vh;">
    <div class="text-center">
        <a href="/" class="text-second text-decoration-none fs-4 d-block">
            <i class="fa-regular fa-clipboard"></i> Todo List
        </a>
    </div>
    <div class="my-3" style="background-color: #3D0A05; height: 2px;"></div>
    <ul class="nav nav-pills flex-column mb-auto">
        @if ($user->role == 'admin')
            <small class="text-second ms-1 mb-1">Home</small>
            <li class="nav-item mb-3 {{ request()->routeIs('dashboard.admin') ? 'active-nav-link' : '' }}">
                <a href="{{ route('dashboard.admin') }}" class="nav-link text-second">
                    <i class="fa-regular fa-home me-1"></i> Dashboard
                </a>
            </li>
            <small class="text-second ms-1 mb-1">Manage</small>
            <li class="nav-item {{ request()->routeIs('manage.tasker') ? 'active-nav-link' : '' }}">
                <a href="{{ route('manage.tasker') }}" class="nav-link text-second">
                    <i class="fa-duotone fa-regular fa-user-tie me-2"></i> Tasker
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('manage.worker') ? 'active-nav-link' : '' }}">
                <a href="{{ route('manage.worker') }}" class="nav-link text-second">
                    <i class="fa-regular fa-user-helmet-safety me-2"></i> Worker
                </a>
            </li>
        @endif
        @if ($user->role == 'tasker')
            <small class="text-second ms-1 mb-1">Home</small>
            <li class="nav-item mb-3 {{ request()->routeIs('dashboard.tasker') ? 'active-nav-link' : '' }}">
                <a href="{{ route('dashboard.tasker') }}" class="nav-link text-second">
                    <i class="fa-regular fa-home me-1"></i> Dashboard
                </a>
            </li>
            <small class="text-second ms-1 mb-1">Menu</small>
            <li class="nav-item {{ request()->routeIs('manage.job') ? 'active-nav-link' : '' }}">
                <a href="{{ route('manage.job') }}" class="nav-link text-second">
                    <i class="fa-regular fa-briefcase me-2"></i> My Job
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('manage.job') }}" class="nav-link text-second">
                    <i class="fa-regular fa-clock-rotate-left me-2"></i> History
                </a>
            </li>
        @endif
        @if ($user->role == 'worker')
            <small class="text-second ms-1 mb-1">Home</small>
            <li class="nav-item mb-3 {{ request()->routeIs('dashboard.worker') ? 'active-nav-link' : '' }}">
                <a href="{{ route('dashboard.worker') }}" class="nav-link text-second">
                    <i class="fa-regular fa-home me-1"></i> Dashboard
                </a>
            </li>
            <small class="text-second ms-1 mb-1">Menu</small>
            <li class="nav-item {{ request()->routeIs('job') ? 'active-nav-link' : '' }}">
                <a href="{{ route('job') }}" class="nav-link text-second">
                    <i class="fa-regular fa-briefcase me-2"></i> My Job
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('manage.job') }}" class="nav-link text-second">
                    <i class="fa-regular fa-clock-rotate-left me-2"></i> History
                </a>
            </li>
        @endif
    </ul>
</div>

<style>
    .active-nav-link {
        background-color: #f2f2f2;
        border-right: #3D0A05 solid 4px;
    }

    .nav-link:hover {
        color: blue !important
    }
</style>
