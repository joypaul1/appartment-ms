@php
$strpos = Route::currentRouteName();
@endphp


<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ url('admin/dashboard') }}">
            <span class="sidebar-brand-text align-middle">
                {{ session('site_info')['name'] }}
            </span>
        </a>

        <div class="sidebar-user">
            <div class="d-flex justify-content-center">
                <div class="flex-shrink-0">
                    <img src="{{ auth('admin')->user()->image ? asset(auth('admin')->user()->image): asset('assets/backend/img/avatars/avatar.jpg') }}"
                        class="avatar img-fluid rounded me-1" alt="admin-logo" />
                </div>
                <div class="flex-grow-1 ps-2">
                    <a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        {{ auth('admin')->user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-start">
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log
                            out</a>

                    </div>
                </div>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->segment(2) == 'dashboard' ? 'active' : ' ' }} active">
                <a class="sidebar-link" href="{{ url('admin/dashboard') }}">
                    <span class="align-middle">@lang('sidebar.dashboard') </span>

                </a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.rent.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.rent.index')}}">
                    <span class="align-middle">@lang('sidebar.rent_statement') </span>

                </a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.report.rental-report') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.report.rental-report')}}">
                    <span class="align-middle">@lang('sidebar.rental_report') </span>

                </a>
            </li>


            {{-- <li class="sidebar-item {{ request()->segment(2) == 'rent' ? 'active' : ' ' }} active">
                <a class="sidebar-link" href="{{ url('admin/dashboard') }}">
                    <span class="align-middle">@lang('sidebar.rent_statement') </span>

                </a>
            </li> --}}






        </ul>

    </div>
</nav>
