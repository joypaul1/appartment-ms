@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-pencil"></i> Edit Tenant
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => 'Tenant List',
'route' =>route('backend.tenant.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.tenant.update', $tenant) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                         'name' =>'name', 'label' =>__('langdata.name')
                        'required' => true,
                        'value' => $tenant->name
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                          'name' =>'mobile', 'label' =>__('langdata.mobile')'number' =>true,
                        'required' => true,
                        'number' => true,
                        'value' => $tenant->mobile

                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('mobile')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                         'name' =>'email', 'label' =>__('langdata.email')  'inType' => 'email',
                        'required' => true,
                        'value' => $tenant->email
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('email')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'password',
                        'value' => $tenant->password
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('password')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' =>'address', 'label' =>__('langdata.address'),
                        'label' => 'Present Address',
                        'value' => $tenant->address,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('address')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                         'name' => 'nid','number' =>true,
                        'value' => $tenant->nid,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('nid')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'file',
                        'name' => 'image'
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('image')])
                    </div>

                    <div class="col-md-6">
                        <img src="{{ asset($tenant->image) }}" alt="" srcset="">
                    </div>
                    <hr>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option',[ 'name' => 'floor_id','selectedKey' => $tenant->floor_id,
                        'required' => true,'label'=>'Floor','optionData'=> $floors])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('floor_id')])
                    </div>
                    {{-- @dd($units,$tenant->unit_id) --}}
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option',[ 'name' => 'unit_id',
                        'required' => true,'label'=>'Unit','optionData'=> $units ,'selectedKey' => $tenant->unit_id])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('unit_id')])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'number',
                        'name' => 'advance_rent',
                        'value' => $tenant->advance_rent,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('advance_rent')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'number',
                        'name' => 'rent_per_month',
                        'value' => $tenant->rent_per_month,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('rent_per_month')])
                    </div>
                    {{-- @dd(date('m')) --}}
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option',[ 'name' => 'month_id',
                        'required' => true,'label'=>'Month','optionData'=> $months , 'selectedKey' => $tenant->month_id])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('month_id')])
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option',[ 'name' => 'year_id',
                        'required' => true,'label'=>'Year','optionData'=> $years,'selectedKey' => $tenant->year_id])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('year_id')])
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option',['name' =>'status', 'label' =>__('langdata.status'),'selectedKey'=>$tenant->status,
                        'required' => true,'label'=>'status','optionData'=> $status])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('status')])
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
    $(function() {
        // getUnitData();
    $('#Floorid').on('change', function(e) {
        e.preventDefault();
        getUnitData();

    });

    function getUnitData(){
        let url ="{{route('backend.unit.index') }}"
        $.ajax({
            type: "GET",
            url: url ,
            dataType: 'JSON',
            data:{ 'Floorid':$('#Floorid').val(), 'getFreeUnits' :true},

            success: function (res) {
                $("#Unitid").html(' ');
                $.map( res.data, function( val, i ) {
                    var newOption = new Option(val.name, val.id, false, false);
                    $('#Unitid').append(newOption).trigger('change');
                    $('#Unitid').val("{{$tenant->unit_id}}").trigger('change')

                });
            },
            error: function (jqXHR, exception) {
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
});


</script>
@endpush
