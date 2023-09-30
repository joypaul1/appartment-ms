@php
$strpos = Route::currentRouteName();
@endphp


<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        {{-- <a class="sidebar-brand" href="{{ url('admin/dashboard') }}">
            <span class="sidebar-brand-text align-middle">
                {{ session('site_info')['name'] }}
            </span>

        </a> --}}

        <div class="sidebar-user">
            <div class="d-flex justify-content-center">
                <div class="flex-shrink-0">
                    <img src="{{ auth('admin')->user()->logo ? asset(auth('admin')->user()->logo): asset('assets/backend/img/avatars/avatar.jpg') }}"
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
            <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.tenant.index') }}">@lang('sidebar.tenant_list')</a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.management-committee.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.management-committee.index') }}">
                    @lang('sidebar.management_committee_list')
                </a>
            </li>

            <li class="sidebar-item {{ strpos($strpos, 'backend.owner.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.owner.index') }}">@lang('sidebar.owner_list')</a>
            </li>


            <li class="sidebar-item {{ strpos($strpos, 'backend.visitor.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.visitor.index') }}">
                    @lang('sidebar.visitor_list')
                </a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.report.salary-report') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.report.salary-report') }}">
                    @lang('sidebar.salary_report')
                </a>
            </li>







        </ul>

    </ div>
</nav>
