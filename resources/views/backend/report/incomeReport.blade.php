@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> @lang("langdata.Income Report Form")
@stop
@section('table_header')
@include('backend._partials.page_header')
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.report.income-report') }}" method="GET" class="row g-3">
                    @method('GET')

                    <div class="col-md-4">
                        @include('components.backend.forms.input.input-type', [
                             'name' =>'start_date', 'label' =>__('langdata.start_date'),
                            'label' => 'Start Date',
                            'inType' => 'date',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('start_date'),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.input.input-type', [
                             'name' =>'end_date', 'label' =>__('langdata.end_date'),
                            'inType' => 'date',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('end_date'),
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
