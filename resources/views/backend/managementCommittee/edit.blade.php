@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-pencil"></i> Edit Management-Committe
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => 'Management-Committe List',
'route' =>route('backend.management-committe.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.management-committe.update', $management-committe) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'name',
                        'required' => true,
                        'value' => $management-committe->name
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'mobile',
                        'required' => true,
                        'value' => $management-committe->mobile

                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('mobile')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'email',
                        'required' => true,
                        'value' => $management-committe->email
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('email')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'password',
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('password')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.select2.option',[ 'name' => 'member_type_id',
                        'required' => true,'label'=>'Member Type','optionData'=> $member_types, 'selectedKey' => $management-committe->member_type_id])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('member_type_id')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'pre_address',
                        'label' => 'Present Address',
                        'value' => $management-committe->pre_address,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('pre_address')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'per_address',
                        'label' => 'Permanent Address',
                        'value' => $management-committe->per_address,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('per_address')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'nid',
                        'value' => $management-committe->nid,
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
                        <img src="{{ asset($management-committe->image) }}" alt="" srcset="">
                    </div>
                    <hr>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' => 'joining_date',
                        'value' => $management-committe->joining_date,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('joining_date')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' => 'resign_date',
                        'value' => $management-committe->resign_date,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('joining_date')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'number',
                        'name' => 'salary',
                        'required' => true,
                        'value' => $management-committe->salary
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('salary')])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.select2.option',[ 'name' => 'status','selectedKey'=>$management-committe->status,
                        'required' => true,'label'=>'status','optionData'=> $status])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('status')])
                    </div>


                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">Update Data</button>
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
        getUnitData();
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
                    $('#Unitid').val("{{$management-committe->unit_id}}").trigger('change')

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
