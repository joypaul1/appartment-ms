<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/">
            <span class="sidebar-brand-text align-middle">
                SmartApartment
                {{-- <sup><small class="badge bg-primary text-uppercase">Pro</small></sup> --}}
            </span>
            <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
                <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                <path d="M20 12L12 16L4 12"></path>
                <path d="M20 16L12 20L4 16"></path>
            </svg>
        </a>

        <div class="sidebar-user">
            <div class="d-flex justify-content-center">
                <div class="flex-shrink-0">
                    <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                </div>
                <div class="flex-grow-1 ps-2">
                    <a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Sulaiman Hosain
                    </a>
                    <div class="dropdown-menu dropdown-menu-start">
                        <a class="dropdown-item" href="pages-profile"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages-settings"><i class="align-middle me-1" data-feather="settings"></i> Settings &
                            Privacy</a>
                        <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Log out</a>
                    </div>

                    <div class="sidebar-user-subtitle">
                        System Administrator
                    </div>
                </div>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Dashboard
            </li>
            <li class="sidebar-item active"><a class="sidebar-link" href="/">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a></li>

            <li class="sidebar-header">
                Floor Information
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#products" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    {{-- product icon --}}
                    <i class="align-middle" data-feather="shopping-cart"></i>
                    {{-- <i class="align-middle" data-feather="layout"></i> --}}
                    <span class="align-middle">
                        Floor Management
                    </span>
                </a>
                <ul id="products" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">
                            Floor List
                        <span class="sidebar-badge badge bg-info">8</span></a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            Add New Floor
                        </a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#orders" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Orders</span>
                </a>
                <ul id="orders" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">Order List <span class="sidebar-badge badge bg-info">26 Pending</span></a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            Order Status
                        </a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Payment Status</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Shipping Status</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#purchase" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="credit-card"></i>
                    <span class="align-middle">Purchase</span>
                </a>
                <ul id="purchase" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">Purchase List</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            Suppliers
                        </a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Purchase Status</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Payment Status</a></li>
                </ul>
            </li>

            <li class="sidebar-header">
                Report & Analysis
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#report" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Report</span>
                </a>
                <ul id="report" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">Sales Report</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            Purchase Report
                        </a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Stock Report</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Profit Report</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#analysis" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="pie-chart"></i> <span class="align-middle">Analysis</span>
                </a>
                <ul id="analysis" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">Sales Analysis</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            Purchase Analysis
                        </a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Stock Analysis</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Profit Analysis</a></li>
                </ul>
            </li>

            <li class="sidebar-header">
                User Management
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#users" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Users</span>
                </a>
                <ul id="users" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">User List</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            User Role
                        </a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">User Permission</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#customers" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Customers</span>
                </a>
                <ul id="customers" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">Customer List</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            Customer Group
                        </a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Customer Reviews</a></li>
                </ul>
            </li>


            <li class="sidebar-header">
                Settings
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#settings" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
                </a>
                <ul id="settings" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">General Settings</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">User Settings</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Email Settings</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">SMS Settings</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#languages" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="globe"></i> <span class="align-middle">
                        Privacy & Policy
                    </span>
                </a>
                <ul id="languages" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">Privacy Policy</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            Terms & Conditions
                        </a></li>
                </ul>
            </li>

            <li class="sidebar-header">
                Admin & Support
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#admins" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Admins</span>
                </a>
                <ul id="admins" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-projects">Admin List</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-settings">
                            Admin Role
                        </a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-clients">Admin Permission</a></li>
                </ul>
            </li>

            <li class="sidebar-header">
                Profile & Settings
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="pages-profile">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="pages-settings">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="pages-settings">
                    <i class="align-middle" data-feather="help-circle"></i> <span class="align-middle">Help</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="pages-settings">
                    <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Logout</span>
                </a>
            </li>
        </ul>


    </div>
</nav>
