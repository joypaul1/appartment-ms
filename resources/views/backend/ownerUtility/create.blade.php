@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-plus-circle"></i> {{ __('langdata.Create-Owner-Utility') }}
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-list',
        'name' => __('langdata.Owner-Utility-List'),
        'route' => route('backend.owner-utility.index'),
    ])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.owner-utility.store') }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'floor_id',
                            'required' => true,
                            'label' => 'Floor',
                            'optionData' => $floors,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('floor_id'),
                        ])
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'unit_id',
                            'required' => true,
                            'label' => 'Unit',
                            'optionData' => [],
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('unit_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'owner_name',
                            'required' => true,
                            'readonly' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('owner_id'),
                        ])
                        <input type="hidden" name="owner_id" id="owner_id" value="">
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'date',
                            'name' => 'issue_date',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('issue_date'),
                        ])
                    </div>

                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'month_id',
                            'required' => true,
                            'label' => 'Month',
                            'optionData' => $months,
                            'selectedKey' => date('m'),
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('month_id'),
                        ])
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'year_id',
                            'required' => true,
                            'label' => 'Year',
                            'optionData' => $years,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('year_id'),
                        ])
                    </div>



                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => 0.0,
                            'name' => 'water_bill',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('water_bill'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => 0.0,
                            'name' => 'electric_bill',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('electric_bill'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => 0.0,
                            'name' => 'gas_bill',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('gas_bill'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => 0.0,
                            'name' => 'security_bill',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('security_bill'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => 0.0,
                            'name' => 'utility_bill',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('utility_bill'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => 0.0,
                            'name' => 'other_bill',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('other_bill'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => 0.0,
                            'label' => 'Total Rent',
                            'name' => 'total_utility',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('total_utility'),
                        ])
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'status',
                            'selectedKey' => 1,
                            'required' => true,
                            'label' => 'status',
                            'optionData' => $status,
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
                getUnitOwner();

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
    $('#Unitid').on('change', function(e) {
        e.preventDefault();

        getUnitOwner();

    });

    function getUnitOwner() {
        let url = "{{ route('backend.owner.index') }}"
        $("#owner_name").val(null);
        $("#owner_id").val(null);
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'JSON',
            data: {
                'floor_id': $('#Floorid').val(),
                'unit_id': $('#Unitid').val(),
                'getUnitOwner': true
            },

            success: function(res) {
                $("#owner_name").val(res.data.name);
                $("#owner_id").val(res.data.id);
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
    }

    function totalUtility() {
        let total = 0;
        // let rent = $('#rent').val();
        let water_bill = $('#water_bill').val();
        let electric_bill = $('#electric_bill').val();
        let gas_bill = $('#gas_bill').val();
        let security_bill = $('#security_bill').val();
        let utility_bill = $('#utility_bill').val();
        let other_bill = $('#other_bill').val();
        total = Number(water_bill) + Number(electric_bill) + Number(gas_bill) + Number(security_bill) +
            Number(utility_bill) + Number(other_bill);
        console.log(Number(water_bill) + Number(electric_bill))
        $('#total_utility').val(total);
    }

    $(document).on('change', '#water_bill, #electric_bill, #gas_bill, #security_bill, #utility_bill, #other_bill',
        function() {
            // console.log(333);
            totalUtility();
        });
</script>
@endpush
