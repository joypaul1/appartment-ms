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
            <li class="sidebar-item {{ strpos($strpos, 'backend.rent.index') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.rent.index')}}">
                    <span class="align-middle">@lang('langdata.rent_statement') </span>

                </a>
            </li>
            <li class="sidebar-item {{ strpos($strpos, 'backend.report.rental-report') === 0 ? 'active' : ' ' }}">
                <a class="sidebar-link" href="{{ route('backend.report.rental-report')}}">
                    <span class="align-middle">@lang('langdata.rental_report') </span>

                </a>
            </li>


            {{-- <li class="sidebar-item {{ request()->segment(2) == 'rent' ? 'active' : ' ' }} active">
                <a class="sidebar-link" href="{{ url('admin/dashboard') }}">
                    <span class="align-middle">@lang('langdata.rent_statement') </span>

                </a>
            </li> --}}






        </ul>

    </div>
</nav>
