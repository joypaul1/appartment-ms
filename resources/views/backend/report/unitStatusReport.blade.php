@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-plus-circle"></i> Unit Status Report Form
@stop
@section('table_header')
    @include('backend._partials.page_header')
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.report.unit-report') }}" method="GET" class="row g-3">
                    @method('GET')

                    <div class="col-md-12">
                        @include('components.backend.forms.select2.option', [
                           'name' =>'status', 'label' =>__('langdata.status'),
                            'label' => 'Unit Status',
                            'optionData' => [['id' => 1, 'name' => 'Available'], ['id' => 2, 'name' => 'Booked']],
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('status'),
                        ])
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
