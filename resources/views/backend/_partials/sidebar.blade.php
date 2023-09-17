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
                    <img src="{{ asset('assets/backend') }}/img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="{{ auth('admin')->user()->name }}" />
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
                    <i class="align-middle" data-feather="home"></i>
                     <span class="align-middle">@lang('sidebar.dashboard') </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#floor" data-bs-toggle="collapse" class="sidebar-link {{ strpos($strpos, 'backend.floor') === 0 ? 'active' : ' ' }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.floor')</span>
                </a>
                <ul id="floor" class="sidebar-dropdown list-unstyled collapse {{ strpos($strpos, 'backend.floor') === 0 ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.floor.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.floor.index') }}">@lang('sidebar.floor_list')</</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.floor.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.floor.create') }}">@lang('sidebar.floor_create') </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#Unit" data-bs-toggle="collapse" class="sidebar-link {{ request()->segment(2) == 'unit' ? 'active' : ' ' }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.unit')</span>
                </a>
                <ul id="Unit" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'unit' ? 'show' : ' ' }}  " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.unit.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.unit.index') }}">@lang('sidebar.unit_list')</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.unit.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.unit.create') }}">@lang('sidebar.unit_create') </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#owner" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.owner')</span>
                </a>
                <ul id="owner" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'owner' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner.index') }}">@lang('sidebar.owner_list')</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner.create') }}">@lang('sidebar.owner_create')</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#tenant" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.tenant')</span>
                </a>
                <ul id="tenant" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'tenant' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.tenant.index') }}">@lang('sidebar.tenant_list')</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.tenant.create') }}">@lang('sidebar.tenant_create')</a>
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
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee.create') }}">@lang('sidebar.employee_create') </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee-salary.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee-salary.index') }}"> @lang('sidebar.salary_list')</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee-leave.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee-leave.create') }}">@lang('sidebar.salary_create')
                        </a>
                    </li>
                </ul>
            </li>
            {{-- @dd(App::getLocale()); --}}
            <li class="sidebar-item">
                <a data-bs-target="#Rent" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.rent')</span>
                </a>
                <ul id="Rent" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'rent' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.rent.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.rent.index') }}">@lang('sidebar.rent_list')</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.rent.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.rent.create') }}">@lang('sidebar.rent_create') </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#owner-utility" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.owner_utility')</span>
                </a>
                <ul id="owner-utility" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'owner-utility' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner-utility.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner-utility.index') }}">
                            @lang('sidebar.owner_utility_list')
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner-utility.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner-utility.create') }}">
                            @lang('sidebar.owner_utility_create')
                        </a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#maintenance-cost" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">@lang('sidebar.maintenance_cost')</span>
                </a>
                <ul id="maintenance-cost" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'maintenance-cost' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.maintenance-cost.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.maintenance-cost.index') }}">
                            @lang('sidebar.maintenance_cost_list')

                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.maintenance-cost.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.maintenance-cost.create') }}">
                            @lang('sidebar.maintenance_cost_create')
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#management-committee" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> @lang('sidebar.management_committee')</span>
                </a>
                <ul id="management-committee" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'maintenance-cost' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.management-committee.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.management-committee.index') }}">
                            @lang('sidebar.management_committee_list')
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.management-committee.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.management-committee.create') }}">
                            @lang('sidebar.management_committee_create')
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#fund" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> @lang('sidebar.fund_management')</span>
                </a>
                <ul id="fund" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'fund' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.fund.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.fund.index') }}">
                            @lang('sidebar.fund_management_list')
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.fund.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.fund.create') }}">Create
                            @lang('sidebar.fund_management_create')
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#Bill" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> @lang('sidebar.bill_collection')</span>
                </a>
                <ul id="Bill" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'bill-deposit' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.bill-deposit.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.bill-deposit.index') }}">
                            @lang('sidebar.bill_collection_list')
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.bill-deposit.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.bill-deposit.create') }}">
                            @lang('sidebar.bill_collection_create')
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#complain" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> @lang('sidebar.complain')</span>
                </a>
                <ul id="complain" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'complain' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.complain.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.complain.index') }}">
                            @lang('sidebar.complain_list')
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.complain.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.complain.create') }}">
                            @lang('sidebar.complain_create')
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#visitor" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> @lang('sidebar.visitor')</span>
                </a>
                <ul id="visitor" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'visitor' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.visitor.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.visitor.index') }}">
                            @lang('sidebar.visitor_list')
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.visitor.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.visitor.create') }}">
                            @lang('sidebar.visitor_create')
                        </a>
                    </li>
                </ul>
            </li>
            {{-- <li class="sidebar-item">
                <a data-bs-target="#visitor" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Notice Board</span>
                </a>
                <ul id="visitor"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'notice-board' ? 'show' : ' ' }} "
            data-bs-parent="#sidebar">
            <li class="sidebar-item {{ strpos($strpos, 'backend.notice-board.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.notice-board.index') }}">
                    Notice Board
                </a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.notice-board.create') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.notice-board.create') }}">
                    Create Notice Board
                </a>
            </li>
        </ul>
        </li> --}}
        <li class="sidebar-item">
            <a data-bs-target="#report" data-bs-toggle="collapse" class="sidebar-link ">
                <i class="align-middle" data-feather="sliders"></i>
                <span class="align-middle"> @lang('sidebar.report') </span>
            </a>
            <ul id="report" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'report' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                <li class="sidebar-item {{ strpos($strpos, 'backend.report.rental-report') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.report.rental-report') }}">
                        @lang('sidebar.rental_report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.report.tenant-report') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.report.tenant-report') }}">
                        @lang('sidebar.tenant_report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.report.visitor-report') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.report.visitor-report') }}">
                        @lang('sidebar.visitor_report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.report.complain-report') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.report.complain-report') }}">
                        @lang('sidebar.complain_report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.report.unit-report') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.report.unit-report') }}">
                        @lang('sidebar.unit_status_report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.report.fund-report') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.report.fund-report') }}">
                        @lang('sidebar.fund_report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.report.salary-report') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.report.salary-report') }}">
                        @lang('sidebar.salary_report')
                    </a>
                </li>

            </ul>
        </li>
        <li class="sidebar-item">
            <a data-bs-target="#settings" data-bs-toggle="collapse" class="sidebar-link ">
                <i class="align-middle" data-feather="sliders"></i>
                <span class="align-middle"> @lang('sidebar.report') </span>
            </a>
            <ul id="settings" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'site-config' ? 'show' : ' ' }} " data-bs-parent="#sidebar">
                <li class="sidebar-item {{ strpos($strpos, 'backend.site-config.admin.index') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.site-config.admin.index') }}">
                        @lang('sidebar.report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.site-config.building.index') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.site-config.building.index') }}">
                        @lang('sidebar.report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.site-config.bill-type.index') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.site-config.bill-type.index') }}">
                        @lang('sidebar.report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.site-config.member-type.index') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.site-config.member-type.index') }}">
                        @lang('sidebar.report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.site-config.month.index') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.site-config.month.index') }}">
                        @lang('sidebar.report')
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.site-config.year.index') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.site-config.year.index') }}">
                        Year Config
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.site-config.system.index') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.site-config.system.index') }}">
                        System Config
                    </a>
                </li>
                <li class="sidebar-item {{ strpos($strpos, 'backend.site-config.email.index') === 0 ? 'active' : ' ' }}">
                    <a class="sidebar-link" href="{{ route('backend.site-config.email.index') }}">
                        Email Config
                    </a>
                </li>
            </ul>
        </li>




        </ul>

        {{-- --}}
    </div>
</nav>
