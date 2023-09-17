@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> Tenant Report Form
@stop
@section('table_header')
@include('backend._partials.page_header')
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.report.tenant-report') }}" method="GET" class="row g-3">
                    @method('GET')

                    <div class="col-md-12">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'tenant_status',
                        'label' => 'Tenant Status',
                        'optionData' => [
                            ['id'=>1, 'name'=>'Active'],
                            ['id'=>2, 'name'=>'Inactive'],
                        ],
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">@lang('button.submit_data')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
