<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand text-center" href="{{ route('home') }}">
            <img class="" src="{{ asset('assets') }}/img/brand/afresto.png" class="navbar-brand-img" alt="..."><br>
            <span class="text-success text-center">Afresto </span>
            <span class="text-success font-weight-bold text-center">SIM</span>

        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ env('SPACES_URL') . Auth()->user()->avatar }}">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                <i class="ni ni-tv-2 text-muted"></i> {{ __('Dashboard') }}
                </a>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('magazine') }}">
                        <i class="ni ni-single-copy-04 text-muted"></i>
                        <span class="nav-link-text">Semua E-Magazine</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('own.magazine') }}">
                        <i class="ni ni-spaceship text-muted"></i>
                        <span class="nav-link-text">E-Magazine Saya</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user') }}">
                        <i class="fas fa-users"></i>
                        <span class="nav-link-text">User</span>
                    </a>
                </li>
                @endif
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <!-- Navigation -->

        </div>
    </div>
</nav>