@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-pencil"></i> {{ __('langdata.Edit-Maintenance-Cost') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => __('langdata.Maintenance-Cost-List'),
'route' => route('backend.maintenance-cost.index'),
])
@endsection

<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.maintenance-cost.update', $maintenanceCost) }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-md-12">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'title', 'label' =>__('langdata.title'),
                        'value' => $maintenanceCost->title,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('title'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' =>'date', 'label' =>__('langdata.date'),
                        'required' => true,
                        'value' => $maintenanceCost->date,

                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('date'),
                        ])
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'month_id',
                        'required' => true,
                        'label' =>__('langdata.month'),
                        'optionData' => $months,
                        'selectedKey' => $maintenanceCost->month_id,
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
                        'selectedKey' => $maintenanceCost->year_id,

                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('year_id'),
                        ])
                    </div>


                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'number',
                        'value' => 0.0,
                        'name' =>'amount', 'label' =>__('langdata.amount'),
                        'required' => true,
                        'value' => $maintenanceCost->amount,

                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('amount'),
                        ])
                    </div>
                    <div class="col-md-12">
                        @include('components.backend.forms.texteditor.editor', [
                        'name' =>'details', 'label' =>__('langdata.details'),
                        'required' => true,
                        'value' => $maintenanceCost->details,

                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('details'),
                        ])
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">@lang('button.update_data')</button>
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
