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



        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->segment(2) == 'dashboard' ? 'active' : ' ' }} active">
                <a class="sidebar-link" href="{{ url('admin/dashboard') }}">
                    <span class="align-middle">@lang('langdata.dashboard') </span>

                </a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.tenant.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.tenant.index') }}">@lang('langdata.tenant_list')</a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.management-committee.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.management-committee.index') }}">
                    @lang('langdata.management_committee_list')
                </a>
            </li>

            <li class="sidebar-item {{ strpos($strpos, 'backend.owner.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.owner.index') }}">@lang('langdata.owner_list')</a>
            </li>


            <li class="sidebar-item {{ strpos($strpos, 'backend.visitor.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.visitor.index') }}">
                    @lang('langdata.visitor_list')
                </a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.report.salary-report') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.report.salary-report') }}">
                    @lang('langdata.salary_report')
                </a>
            </li>







        </ul>

    </ div>
</nav>
