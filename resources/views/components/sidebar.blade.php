<div class="d-flex flex-column position-fixed flex-shrink-0 rounded-4 p-3 bg-white shadow"
    style="width: 250px; height: 94vh;">
    <div class="text-center">
        <a href="/" class="text-second text-decoration-none fs-4 d-block">
            <i class="fa-light fa-calendar-lines"></i> Todo List
        </a>
    </div>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        @if ($user->role == 'admin')
        <small class="text-second ms-1 mb-1">Home</small>
            <li class="nav-item mb-3 {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                <a href="{{ route('dashboard.admin') }}"
                    class="nav-link text-second {{ request()->is('dashboard') ? 'active bg-primary' : '' }}">
                    <i class="fa-regular fa-home me-1"></i> Dashboard
                </a>
            </li>
            <small class="text-second ms-1 mb-1">Manage</small>
            <li class="nav-item {{ request()->routeIs('manage.tasker') ? 'active' : '' }}">
                <a href="{{ route('manage.tasker') }}"
                    class="nav-link text-second">
                    <i class="fa-duotone fa-regular fa-user-tie me-2"></i> Tasker
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('manage.worker') ? 'active' : '' }}">
                <a href="{{ route('manage.worker') }}"
                    class="nav-link text-second">
                    <i class="fa-regular fa-user-helmet-safety me-2"></i> Worker
                </a>
            </li>
        @endif
        @if ($user->role == 'tasker')
            <li class="nav-item {{ request()->routeIs('dashboard.tasker') ? 'active' : '' }}">
                <a href="{{ route('dashboard.tasker') }}"
                    class="nav-link text-second">
                    <i class="fa-regular fa-home me-1"></i> Dashboard
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('manage.job') ? 'active' : '' }}">
                <a href="{{ route('manage.job') }}"
                    class="nav-link text-second">
                    <i class="fa-regular fa-briefcase me-2"></i> My Job
                </a>
            </li>
        @endif
        @if ($user->role == 'worker')
            <li class="nav-item">
                <a href=""
                    class="nav-link text-second">
                    <i class="fa-regular fa-home me-1"></i> Dashboard
                </a>
            </li>
            <li>
                <a href=""
                    class="nav-link text-second">
                    <i class="fa-regular fa-briefcase me-2"></i> Job
                </a>
            </li>
        @endif
    </ul>

</div>

<style>
    .active {
        background-color: #f2f2f2;
        border-radius: 12px;
    }
</style>
