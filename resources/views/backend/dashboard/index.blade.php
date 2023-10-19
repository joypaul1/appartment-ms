@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
<div class="row">
    <div class="col-sm-12">
        @forelse ($noticeBoards as $noticeBoard)
        <div class="card">
            <div class="card-header text-danger">
                <marquee>{{ $noticeBoard->langdata.}}</marquee>
            </div>
        </div>
        @empty
        @endforelse
    </div>
    @if (auth('admin')->user()->role_type == 'super_admin')
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_floor')</h5>
                        <h1 class="mt-1 mb-3">{{ $floorCount }}</h1>
                    </div>

                    <div class="col-auto">
                        {{-- style="background: url('{{ asset('assets/backend') }}/img/login_bgs.jpg'); background-size: cover; background-repeat:
                        no-repeat; " --}}
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/1.png" alt="">
                        {{-- <div class="stat text-primary">
                            <i class="align-middle" data-feather="home"></i>
                        </div> --}}
                    </div>
                </div>

                <div class="mb-0 text-center bg-light p-2">
                    <a href="{{ route('backend.floor.index') }}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_unit')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ $unitCount }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/2.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.unit.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_owner')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ $ownerCount }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/3.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.owner.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_tenant')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ $tenantCount }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/4.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.tenant.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_employee')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ $employeeCount }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/5.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.employee.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_committee')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ $managementCommitteeCount }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/6.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.management-committee.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_rent')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ $totalRentCollection }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/7.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.rent.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_maintenance')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ number_format($totalMaintenanceCost ?? 0, 2) }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/8.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.maintenance-cost.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_fund')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ number_format($totalFund ?? 0, 2) }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/9.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.fund.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.owner_utility')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ number_format($totalOwnerUtility ?? 0, 2) }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/10.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.owner-utility.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.employee_salary')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ number_format($totalEmployeeSalary ?? 0, 2) }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/11.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.employee.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_complain')
                        </h5>
                        <h1 class="mt-1 mb-3">{{ $totalComplain ?? 0 }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/12.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.complain.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-langdata.>@lang('dashboard.total_house')

                        </h5>
                        <h1 class="mt-1 mb-3">{{ $totalHouse ?? 0 }}</h1>
                    </div>

                    <div class="col-auto">
                        <img class="mb-3" src="{{ asset('assets/backend') }}/img/icons/13.png" alt="">
                    </div>
                </div>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2">
                        <a href="{{ route('backend.site-config.building.index') }}" class="p-2">
                            More Info
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (auth('admin')->user()->role_type == 'super_admin' || auth('admin')->user()->role_type == 'owner')
    <div class="col-12 col-lg-8 col-xxl-9 d-flex">
        <div class="card flex-fill">
            <div class="card-header text-center text-white" style="background: linear-gradient(to right, #373b44, #4286f4);">

                <h5 class="card-langdata.text-white mb-0">@lang('dashboard.building_rules') </h5>
            </div>
            <div class="card-body">
                {!! $buildingInformation->building_rules !!}
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row  clearfix">
                <div class="col-lg-6 col-md-6">
                    <div class="card overflowhidden">
                        <div class="card-body">
                            <h3 class="card-langdata.text-center"> @lang('dashboard.Monthly Bill Collection Report')</h3>
                            <canvas id="monthlyBooking" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card overflowhidden">
                        <div class="card-body">
                            <h3 class="card-langdata.text-center" > @lang('dashboard.Monthly Rent Report') </h3>
                            <canvas id="rentMonthlyReport" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        new Chart("monthlyBooking", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: ["#900C3F", "#900C3F", "#900C3F", "#900C3F", "#900C3F", "#900C3F",
                        "#900C3F", "#900C3F", "#900C3F",
                        "#900C3F", "#900C3F", "#900C3F"
                    ],
                    data: jQuery.parseJSON('{!! json_encode($depositMonthlyReport['monthlyReport']) !!}')
                }]
            },
            options: {
                legend: {
                    display: false
                },
            }

        });

        new Chart("rentMonthlyReport", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: ["#00CC00", "#00CC00", "##00CC00", "#00CC00", "#00CC00", "#00CC00",
                        "#00CC00", "#00CC00", "#00CC00", "#00CC00", "#00CC00", "#00CC00"
                    ],
                    data: jQuery.parseJSON('{!! json_encode($rentMonthlyReport['monthlyReport']) !!}')
                }]
            },
            options: {
                legend: {
                    display: false
                },
            }

        });
</script>
@endpush
