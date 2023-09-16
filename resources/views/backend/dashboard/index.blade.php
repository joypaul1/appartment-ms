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
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                            <h5 class="card-title">Total Unit
                            </h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $unitCount }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $ownerCount }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $tenantCount }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $employeeCount }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $managementCommitteeCount }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $totalRentCollection }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalMaintenanceCost ?? 0, 2) }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalFund ?? 0, 2) }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalOwnerUtility ?? 0, 2) }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalEmployeeSalary ?? 0, 2) }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                                <i class="align-middle" data-feather="home"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $totalComplain ?? 0 }}</h1>
                    <div class="mb-0">
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
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
                        <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> Click </span>
                        {{-- <span class="text-muted">Since last week</span> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('js')
@endpush
