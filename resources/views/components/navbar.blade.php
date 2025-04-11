<nav class="navbar bg-white w-100 shadow-lg rounded-3 navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a href="" class="navbar-brand text-second ms-2">{{ $user->name }} </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ asset('images/profile.jpg') }}" class="rounded-circle" width="40" height="40" alt="">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                        <li class="mb-1"><a class="dropdown-item" href="#"><i class="fa-regular fa-user"></i> Profile</a></li>
                        <li class="mb-1"><a class="dropdown-item" href="#"><i class="fa-regular fa-gear"></i> Setting</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item btn w-100 text-start">
                                    <i class="fa-regular fa-left-from-bracket"></i> Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
