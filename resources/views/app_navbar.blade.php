<script src="https://kit.fontawesome.com/6775ea104e.js" crossorigin="anonymous"></script>
<header class="navbar navbar-expand-md navbar-light bg-purple">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="." class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3 text-white">
            <img src="{{ asset('assets/images/logo/favicon-32x32.png') }}" class="header-brand-img"
                 alt="{{ config('app.name') }}"> <span> UniPass</span>
        </a>
        @if(Auth::check())
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
                        <span
                            class="avatar bg-blue-lt">@if(Auth::user()) {{ strtoupper(substr(Auth::user()->name, 0, 2)) }} @endif</span>
                    <div class="d-none d-xl-block pl-2">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="mt-1 small text-muted">@if(Auth::user()->admin) Admin @else
                            User @endif
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#modalAppMyUser" data-toggle="modal" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                            <path d="M5.5 21v-2a4 4 0 0 1 4 -4h5a4 4 0 0 1 4 4v2"></path>
                        </svg>
                        My user
                    </a>

                    @if(Auth::user()->admin == 1)
                    <a href="#modalAppMyPlan" data-toggle="modal" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"></path>
                            <circle cx="12" cy="12" r="9"></circle>
                            <path
                                d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                            <path d="M12 6v2m0 8v2"></path>
                        </svg>
                        My plan</a>
                    @endif

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"></path>
                            <path d="M7 6a7.75 7.75 0 1 0 10 0"></path>
                            <line x1="12" y1="4" x2="12" y2="12"></line>
                        </svg>
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">

            </div>
        </div>
    </div>
    <nav class="nav flex-column sidenav" id="ulMenu">
        <a href="{{ url('passwords') }}" class="nav-item @if(Request::is('passwords')) active @endif nav-link">
            <span class="nav-link-title"><i class="fa-solid fa-lock"></i>   Passwords</span>
        </a>
        <a href="{{ url('security-center') }}" class="nav-item @if(Request::is('security-center')) active @endif nav-link">
            <span class="nav-link-title"><i class="fa-solid fa-shield-halved"></i>   Security Center</span>
        </a>
        @can('folder-view')
        <a href="{{ url('folders') }}" class="nav-item @if(Request::is('folders')) active @endif nav-link">
            <span class="nav-link-title"><i class="fa-solid fa-folder"></i>   Folders</span>
        </a>
        @endcan
        @can('user-view')
        <a href="{{ url('users') }}" class="nav-item @if(Request::is('users')) active @endif nav-link">
            <span class="nav-link-title"><i class="fa-solid fa-user"></i>    Users</span>
        </a>
        @endcan
        @can('group-view')
        <a href="{{ url('groups') }}" class="nav-item @if(Request::is('groups')) active @endif nav-link">
            <span class="nav-link-title"><i class="fa-solid fa-user-group"></i>  Groups</span>
        </a>
        @endcan
    </nav>
</header>
