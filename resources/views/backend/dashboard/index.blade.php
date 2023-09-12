@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-4">
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
                    <h1 class="mt-1 mb-3">2.382</h1>
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
