<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <ul class="navbar-nav d-none d-lg-flex">


        @php
            $activeBranch = App\Models\Backend\BuildingInformation::where('id', session('branch_id'))
                ->select('id', 'name')
                ->first();
            $allBranchs = App\Models\Backend\BuildingInformation::select('id', 'name')->get();

        @endphp
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-info" href="#" id="resourcesDropdown" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{-- <strong> {{ $activeBranch->name }} </strong> --}}
            </a>
            <div class="dropdown-menu" aria-labelledby="resourcesDropdown">
                @foreach ($allBranchs as $branch)
                    <a class="dropdown-item" href="{{ route('backend.dashboard.branch', $branch->id) }}" >
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home align-middle me-1">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        {{ $branch->name }}
                    </a>
                @endforeach


            </div>
        </li>
    </ul>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-flag dropdown-toggle" href="#" id="languageDropdown" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/backend') }}/img/flags/us.png" alt="" />
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                    <a class="dropdown-item" href="{{ route('backend.dashboard.language', 'en') }}">
                        <img src="{{ asset('assets/backend') }}/img/flags/us.png" alt="English" width="20"
                            class="align-middle me-1" />
                        <span class="align-middle">English</span>
                    </a>
                    <a class="dropdown-item" href="{{ route('backend.dashboard.language', 'bn') }}">
                        <img src="{{ asset('assets/backend') }}/img/flags/bd.png" alt="Bangla" width="20"
                            class="align-middle me-1" />
                        <span class="align-middle">Bangla</span>
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
