@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-plus-circle"></i> {{ __('langdata.Edit-Owner-Utility') }}
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
                <form action="{{ route('backend.owner-utility.update', $ownerUtility) }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'floor_id',
                            'required' => true,
                            'label' => 'Floor',
                            'optionData' => $floors,
                            'selectedKey' => $ownerUtility->floor_id,
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
                            'optionData' => $units,
                            'selectedKey' => $ownerUtility->unit_id,
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
                            'value' =>  optional($ownerUtility->owner)->name,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('owner_id'),
                        ])
                        <input type="hidden" name="owner_id" id="owner_id" value="{{ $ownerUtility->owner_id }}">
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'date',
                           'name' =>'issue_date', 'label' =>__('langdata.issue_date'),
                            'required' => true,
                            'value' =>  date('Y-m-d', strtotime($ownerUtility->issue_date)),
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('issue_date'),
                        ])
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'month_id',
                            'required' => true,
                             'label' =>__('langdata.month'),
                            'optionData' => $months,
                            'selectedKey' => $ownerUtility->month_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('month_id'),
                        ])
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'year_id',
                            'required' => true,
                             'label' =>__('langdata.year'),
                            'optionData' => $years,
                            'selectedKey' => $ownerUtility->year_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('year_id'),
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                           'name' =>'renter_name', 'label' =>__('langdata.renter_name'),
                            'required' => true,
                            'readonly' => true,
                            'value' => $ownerUtility->rent_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('rent_id'),
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => $ownerUtility->water_bill,

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
                            'value' => $ownerUtility->electric_bill,

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
                            'value' => $ownerUtility->gas_bill,

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
                            'value' => $ownerUtility->security_bill,
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
                            'value' => $ownerUtility->utility_bill,
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
                            'value' => $ownerUtility->other_bill,
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
                            'value' => $ownerUtility->total_utility,
                            'label' => 'Total utility',
                            'name' => 'total_utility',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('total_utility'),
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'file',
                           'name' =>'image', 'label' =>__('langdata.image'),
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('image'),
                        ])
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                           'name' =>'status', 'label' =>__('langdata.status'),
                            'selectedKey' => 1,
                            'required' => true,
                            'label' => 'status',
                            'optionData' => $status,
                            'selectedKey' => $ownerUtility->status,
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
                'Floorid': e.target.value,
                'getFreeUnits': true
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
