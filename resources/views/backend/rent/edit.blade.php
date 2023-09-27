@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-plus-circle"></i> {{ __('title.Edit-Rent-Collection') }}
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-list',
        'name' => __('title.List-Rent-Collection'),
        'route' => route('backend.tenant.index'),
    ])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.rent.update', $rentCollection) }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'floor_id',
                            'optionData' => $floors,
                            'selectedKey' => $rentCollection->floor_id,
                            'required' => true,
                            'label' => 'Floor',
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('floor_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'unit_id',
                            'required' => true,
                            'label' => 'Unit',
                            'optionData' => $units,
                            'selectedKey' => $rentCollection->unit_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('unit_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'month_id',
                            'required' => true,
                            'label' => 'Month',
                            'optionData' => $months,
                            'selectedKey' => $rentCollection->month_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('month_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'year_id',
                            'required' => true,
                            'label' => 'Year',
                            'optionData' => $years,
                            'selectedKey' => $rentCollection->year_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('year_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'renter_name',
                            'required' => true,
                            'readonly' => true,
                            'value' => $rentCollection->tenant->name,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('rent_id'),
                        ])
                    </div>
                    <input type="hidden" name="rent_id" id="rent_id" value="{{ $rentCollection->tenant_id }}">
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'rent',
                            'required' => true,
                            'readonly' => true,
                            'value' => $rentCollection->rent,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('rent'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => $rentCollection->water_bill,
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
                            'value' => $rentCollection->electric_bill,
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
                            'value' => $rentCollection->electric_bill,
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
                            'value' => $rentCollection->electric_bill,
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
                            'value' => $rentCollection->electric_bill,
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
                            'value' => $rentCollection->electric_bill,
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
                            'value' => $rentCollection->electric_bill,
                            'label' => 'Total Rent',
                            'name' => 'total_rent',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('total_rent'),
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'file',
                            'name' => 'image',
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('image'),
                        ])
                    </div>
                    {{-- @dd($rentCollection); --}}
                    <div class="col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'bill_status',
                            'selectedKey' => $rentCollection->bill_status,
                            'required' => true,
                            'label' => 'status',
                            'optionData' => $status,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('bill_status'),
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
