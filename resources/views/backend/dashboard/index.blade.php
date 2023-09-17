@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
<div class="row">
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Floor</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="home"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $floorCount }}</h1>
                <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.floor.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Unit
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="activity"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $unitCount }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.unit.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Owner
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="award"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $ownerCount }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.owner.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Tenant
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="box"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $tenantCount }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.tenant.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Employee
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="briefcase"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $employeeCount }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.employee.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Committee
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="eye"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $managementCommitteeCount }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.management-committee.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Rent
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $totalRentCollection }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.rent.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Maintenance
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="tool"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($totalMaintenanceCost ?? 0, 2) }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.maintenance-cost.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Fund
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="credit-card"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($totalFund ?? 0, 2) }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.fund.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Owner Utility
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="shield"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($totalOwnerUtility ?? 0, 2) }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.owner-utility.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Employee Salary
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($totalEmployeeSalary ?? 0, 2) }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.employee.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Complain
                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="alert-octagon"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $totalComplain ?? 0 }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.complain.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total House

                        </h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="home"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $totalHouse ?? 0 }}</h1>
                <div class="mb-0">
                    <div class="mb-0 text-center bg-light p-2" >
                    <a href="{{ route('backend.site-config.building.index')}}" class="p-2">
                        More Info
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                    {{-- <span class="text-muted">Since last week</span> --}}
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@push('js')
@endpush
