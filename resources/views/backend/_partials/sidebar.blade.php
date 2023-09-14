@php
$strpos = Route::currentRouteName();
// {{ request()->segment(2) == 'appointment' ? 'active' : ' ' }}
// {{ strpos($strpos, 'backend.pharmacy') === 0 ? 'active' : ' ' }}
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

                        <a class="dropdown-item" href="#">Log out</a>
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
                <a data-bs-target="#floor" data-bs-toggle="collapse"
                    class="sidebar-link {{ strpos($strpos, 'backend.floor') === 0 ? 'active' : ' ' }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Floor</span>
                </a>
                <ul id="floor" class="sidebar-dropdown list-unstyled collapse {{ strpos($strpos, 'backend.floor') === 0 ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.floor.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.floor.index') }}">Floor List</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.floor.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.floor.create') }}">Create Floor </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#Unit" data-bs-toggle="collapse" class="sidebar-link {{ request()->segment(2) == 'unit' ? 'active' : ' ' }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Unit</span>
                </a>
                <ul id="Unit" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'unit' ? 'show' : ' ' }}  "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.unit.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.unit.index') }}">Unit List</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.unit.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.unit.create') }}">Create Unit </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#owner" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Owner</span>
                </a>
                <ul id="owner" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'owner' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner.index') }}">Owner List</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner.create') }}">Create Owner </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#tenant" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Tenant</span>
                </a>
                <ul id="tenant" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'tenant' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.tenant.index') }}">Tenant List</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.tenant.create') }}">Create Tenant </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#employee" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Employee</span>
                </a>
                <ul id="employee" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'employee' ? 'show' : ' ' }}
                    {{ request()->segment(2) == 'employee-salary' ? 'show' : ' ' }}  "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee.index') }}">Employee List</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee.create') }}">Create Employee </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee-salary.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee-salary.index') }}"> Salary List</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.employee-leave.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.employee-leave.create') }}">Create Salary </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#Rent" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Rent</span>
                </a>
                <ul id="Rent" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'rent' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.rent.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.rent.index') }}">Rent List</a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.rent.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.rent.create') }}">Create Rent </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#owner-utility" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Owner Utility</span>
                </a>
                <ul id="owner-utility" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'owner-utility' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner-utility.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner-utility.index') }}">Owner Utility
                            List
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.owner-utility.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.owner-utility.create') }}">Create Owner
                            Utility
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
                    <li class="sidebar-item {{ strpos($strpos, 'backend.maintenance-cost.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.maintenance-cost.index') }}">Maintenance Cost
                            List
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.maintenance-cost.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.maintenance-cost.create') }}">
                            Create Maintenance Cost
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#management-committee" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Management Committee</span>
                </a>
                <ul id="management-committee"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'maintenance-cost' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.management-committee.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.management-committee.index') }}">Management
                            Committee List
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.management-committee.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.management-committee.create') }}">Create
                            Management Committee
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
                    <li class="sidebar-item {{ strpos($strpos, 'backend.fund.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.fund.create') }}">Create
                            Fund Create
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#Bill" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Bill Collection</span>
                </a>
                <ul id="Bill" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'bill-deposit' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.bill-deposit.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.bill-deposit.index') }}">
                            Bill List
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.bill-deposit.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.bill-deposit.create') }}">
                            Create Bill
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#complain" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Complain</span>
                </a>
                <ul id="complain" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'complain' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.complain.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.complain.index') }}">
                            Complain List
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.complain.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.complain.create') }}">
                            Create Complain
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#visitor" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Visitor</span>
                </a>
                <ul id="visitor" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'visitor' ? 'show' : ' ' }} "
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ strpos($strpos, 'backend.visitor.index') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.visitor.index') }}">
                            Visitor List
                        </a>
                    </li>
                    <li class="sidebar-item {{ strpos($strpos, 'backend.visitor.create') === 0 ? 'active' : ' ' }}">
                        <a class="sidebar-link" href="{{ route('backend.visitor.create') }}">
                            Create Visitor
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#visitor" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Notice Board</span>
                </a>
                <ul id="visitor" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'notice-board' ? 'show' : ' ' }} "
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
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#visitor" data-bs-toggle="collapse" class="sidebar-link ">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle"> Repot </span>
                </a>
                <ul id="visitor" class="sidebar-dropdown list-unstyled collapse {{ request()->segment(2) == 'notice-board' ? 'show' : ' ' }} "
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
            </li>



        </ul>

        {{-- --}}
    </div>
</nav>
