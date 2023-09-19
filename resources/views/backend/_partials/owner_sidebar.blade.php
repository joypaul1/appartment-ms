@php
$strpos = Route::currentRouteName();
@endphp


<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ url('admin/dashboard') }}">
            <span class="sidebar-brand-text align-middle">
                Appartment
                {{-- <sup><small class="badge bg-primary text-uppercase">Pro</small></sup> --}}
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

            <li class="sidebar-item">
                <a data-bs-target="#Unit" data-bs-toggle="collapse" class="sidebar-link {{ request()->segment(2) == 'unit' ? 'active' : ' ' }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.unit')</span>
                </a>
            <li class="sidebar-item {{ strpos($strpos, 'backend.unit.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.unit.index') }}">@lang('sidebar.unit_list')</a>
            </li>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#tenant" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.tenant')</span>
                </a>
                <ul id="tenant" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'tenant' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.tenant.index') }}">@lang('sidebar.tenant_list')</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#employee" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.employee')</span>

                </a>
                <ul id="employee" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'employee' ? 'show' : ' ' }}
                    {{ request()->segment(2) == 'employee-salary' ? 'show' : ' ' }}  " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee.index') }}">@lang('sidebar.employee_list')</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#Rent" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.rent')</span>
                </a>
                <ul id="Rent" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'rent' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.rent.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.rent.index') }}">@lang('sidebar.rent_list')</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#owner-utility" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.owner_utility')</span>

                </a>
                <ul id="owner-utility" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'owner-utility' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner-utility.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner-utility.index') }}">
                            @lang('sidebar.owner_utility_list')
                        </a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#maintenance-cost" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.maintenance_cost')</span>
                </a>
                <ul id="maintenance-cost"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'maintenance-cost' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.maintenance-cost.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.maintenance-cost.index') }}">
                            @lang('sidebar.maintenance_cost_list')

                        </a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#fund" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Fund Management</span>
                </a>
                <ul id="fund" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'fund' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.fund.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.fund.index') }}">
                            Fund List
                        </a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#complain" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> @lang('sidebar.complain')</span>
                </a>
                <ul id="complain" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'complain' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.complain.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.complain.index') }}">
                            @lang('sidebar.complain_list')
                        </a>
                    </li>

                </ul>
            </li>


            <li class="sidebar-item">
                <a data-bs-target="#Report" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Report </span>
                    <span class="align-middle"> @lang('sidebar.report')</span>
                </a>
                <ul id="Report" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'report' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.notice-board.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.notice-board.index') }}">
                            @lang('sidebar.rental_report')
                        </a>
                    </li>

                </ul>
            </li>




        </ul>

    </div>
</nav>
