@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> Rental Collection Report Form
@stop
@section('table_header')
@include('backend._partials.page_header')
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                @if (auth('admin')->user()->role_type == 'tenant')
                <form action="{{ route('backend.report.rental-report') }}" method="GET" class="row g-3">
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
                    <div class="col-md-4">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'payment_status',
                        'label' => 'Payment Status',
                        'optionData' => [['id' => 1, 'name' => 'Paid'], ['id' => 0, 'name' => 'Unpaid']],
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('payment_status'),
                        ])
                    </div>
                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">@lang('button.submit_data')</button>
                    </div>
                </form>
                @else
                <form action="{{ route('backend.report.rental-report') }}" method="GET" class="row g-3">
                    @method('GET')
                    <div class="col-md-4">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'floor_id',
                        'label' => 'Floor',
                        'optionData' => $floors,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('floor_id'),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'unit_id',
                        'label' => 'unit',
                        'optionData' => [],
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('unit_id'),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'month',
                         'label' =>__('langdata.month'),
                        'optionData' => $months,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('name'),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'year',
                         'label' =>__('langdata.year'),
                        'optionData' => $years,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('name'),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'payment_status',
                        'label' => 'Payment Status',
                        'optionData' => [['id' => 1, 'name' => 'Paid'], ['id' => 2, 'name' => 'Unpaid']],
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('payment_status'),
                        ])
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">@lang('button.submit_data')</button>
                    </div>
                </form>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $('#Floorid').on('change', function(e) {
        e.preventDefault();
        let url = "{{ route('backend.unit.index') }}"
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'JSON',
            data: {
                'floor_id': e.target.value,
                'getUnit': true
            },

            success: function(res) {
                $("#Unitid").html(' ');
                $.map(res.data, function(val, i) {
                    var newOption = new Option(val.name, val.id, false, false);
                    $('#Unitid').append(newOption).trigger('change');

                });
            },
            error: function(jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                console.log(msg);
            },
        });

    });
</script>
@endpush
