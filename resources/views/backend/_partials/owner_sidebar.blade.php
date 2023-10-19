@php
$strpos = Route::currentRouteName();
@endphp


<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ url('admin/dashboard') }}">
            <span class="sidebar-brand-text align-middle">
                {{ session('site_info')['name'] }}
                {{-- <sup><small class="badge bg-primary text-uppercase">Pro</small></sup> --}}
            </span>

        </a>



        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->segment(2) == 'dashboard' ? 'active' : ' ' }} ">
                <a class="sidebar-link" href="{{ url('admin/dashboard') }}">
                    <i class="align-middle" data-feather="home"></i>
                    <span class="align-middle">@lang('langdata.dashboard') </span>

                </a>
            </li>

            <li class="sidebar-item {{ strpos($strpos, 'backend.unit.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.unit.index') }}">
                    <i class="align-middle" data-feather="crosshair"></i>
                    <span class="align-middle"> @lang('langdata.unit_list') </span>
                </a>
            </li>


            <li class="sidebar-item">
                <a data-bs-target="#tenant" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="anchor"></i>
                    <span class="align-middle">@lang('langdata.tenant')</span>
                </a>
                <ul id="tenant" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'tenant' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.tenant.index') }}">@lang('langdata.tenant_list')</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#employee" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="briefcase"></i>
                    <span class="align-middle">@lang('langdata.employee')</span>

                </a>
                <ul id="employee" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'employee' ? 'show' : ' ' }}
                    {{ request()->segment(2) == 'employee-salary' ? 'show' : ' ' }}  " data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee.index') }}">@lang('langdata.employee_list')</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#Rent" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="circle"></i>
                    <span class="align-middle">@lang('langdata.rent')</span>
                </a>
                <ul id="Rent" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'rent' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.rent.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.rent.index') }}">@lang('langdata.rent_list')</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#owner-utility" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="gitlab"></i>
                    <span class="align-middle"> @lang('langdata.owner_utility')</span>

                </a>
                <ul id="owner-utility" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'owner-utility' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner-utility.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner-utility.index') }}">
                            @lang('langdata.owner_utility_list')
                        </a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#maintenance-cost" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="dollar-sign"></i>
                    <span class="align-middle">@lang('langdata.maintenance_cost')</span>
                </a>
                <ul id="maintenance-cost"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'maintenance-cost' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.maintenance-cost.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.maintenance-cost.index') }}">
                            @lang('langdata.maintenance_cost_list')

                        </a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#fund" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="book"></i>
                    <span class="align-middle">@lang('langdata.fund_management')</span>
                </a>
                <ul id="fund" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'fund' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.fund.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.fund.index') }}">
                            @lang('langdata.fund_management_list')
                        </a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#complain" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="code"></i>
                    <span class="align-middle"> @lang('langdata.complain')</span>
                </a>
                <ul id="complain" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'complain' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.complain.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.complain.index') }}">
                            @lang('langdata.complain_list')
                        </a>
                    </li>

                </ul>
            </li>






        </ul>

    </div>
</nav>
