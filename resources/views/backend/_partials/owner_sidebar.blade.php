@php
    $strpos = Route::currentRouteName();
@endphp


<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="sidebar-brand-text align-middle">
                Appartment
                {{-- <sup><small class="badge bg-primary text-uppercase">Pro</small></sup> --}}
            </span>

        </a>

        <div class="sidebar-user">
            <div class="d-flex justify-content-center">
                <div class="flex-shrink-0">
                    <img src="{{ asset('assets/backend') }}/img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1"
                        alt="{{ auth('admin')->user()->name }}" />
                </div>
                <div class="flex-grow-1 ps-2">
                    <a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        {{ auth('admin')->user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-start">
                        <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>

                    </div>


                </div>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->segment(2) == 'dashboard' ? 'active' : ' ' }} active">
                <a class="sidebar-link" href="{{ url('admin/dashboard') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#Unit" data-bs-toggle="collapse"
                    class="sidebar-link {{ request()->segment(2) == 'unit' ? 'active' : ' ' }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Unit</span>
                </a>
                <ul id="Unit"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'unit' ? 'show' : ' ' }}  "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.unit.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.unit.index') }}">Unit List</a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#tenant" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Tenant</span>
                </a>
                <ul id="tenant"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'tenant' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.tenant.index') }}">Tenant List</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#employee" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Employee</span>
                </a>
                <ul id="employee"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'employee' ? 'show' : ' ' }}
                    {{ request()->segment(2) == 'employee-salary' ? 'show' : ' ' }}  "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee.index') }}">Employee List</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#Rent" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Rent</span>
                </a>
                <ul id="Rent"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'rent' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.rent.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.rent.index') }}">Rent List</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#owner-utility" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Owner Utility</span>
                </a>
                <ul id="owner-utility"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'owner-utility' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li
                        class="sidebar-item {{ strpos($strpos, 'backend.owner-utility.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner-utility.index') }}">Owner Utility
                            List
                        </a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#maintenance-cost" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Maintenance Cost</span>
                </a>
                <ul id="maintenance-cost"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'maintenance-cost' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li
                        class="sidebar-item {{ strpos($strpos, 'backend.maintenance-cost.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.maintenance-cost.index') }}">Maintenance Cost
                            List
                        </a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#fund" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Fund Management</span>
                </a>
                <ul id="fund"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'fund' ? 'show' : ' ' }} "
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
                    <span class="align-middle"> Complain</span>
                </a>
                <ul id="complain"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'complain' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.complain.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.complain.index') }}">
                            Complain List
                        </a>
                    </li>

                </ul>
            </li>


             <li class="sidebar-item">
                <a data-bs-target="#Report" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Report </span>
                </a>
                <ul id="Report"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'report' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li
                        class="sidebar-item {{ strpos($strpos, 'backend.notice-board.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.notice-board.index') }}">
                          Rental Report
                        </a>
                    </li>

                </ul>
            </li>




        </ul>

    </div>
</nav>
