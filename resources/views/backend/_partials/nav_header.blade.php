<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-flag dropdown-toggle" href="#" id="languageDropdown" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/backend') }}/img/flags/us.png" alt="English" />
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                    <a class="dropdown-item" href="#">
                        <img src="{{ asset('assets/backend') }}/img/flags/us.png" alt="English" width="20"
                            class="align-middle me-1" />
                        <span class="align-middle">English</span>
                    </a>

                </div>
            </li>
            <li class="nav-item">
                <a class="nav-icon js-fullscreen d-none d-lg-block" href="#">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="maximize"></i>
                    </div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-icon pe-md-0 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/backend') }}/img/avatars/avatar.jpg" class="avatar img-fluid rounded"
                        alt="Charles Hall" />
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="user"></i>
                        Profile
                    </a>

                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>
                    <form id="logout-form" action="{{ route('backend.admin.logout') }}" method="POST"
                        style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
