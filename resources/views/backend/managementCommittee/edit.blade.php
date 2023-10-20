@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-pencil"></i> {{ __('langdata.Edit-Management-Committe') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => __('langdata.Management-Committe-List'),
'route' => route('backend.management-committee.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.management-committee.update', $managementCommittee) }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'name', 'label' =>__('langdata.name'),
                        'required' => true,
                        'value' => $managementCommittee->name,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('name'),
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'mobile', 'label' =>__('langdata.mobile'),'number' =>true,
                        'required' => true,
                        'value' => $managementCommittee->mobile,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'email', 'label' =>__('langdata.email'), 'inType' => 'email',
                        'required' => true,
                        'value' => $managementCommittee->email,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('email'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'password', 'label' =>__('langdata.password'),
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('password'),
                        ])
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'member_type_id',
                        'required' => true,
                        'label' =>__('langdata.member_type'),
                        'optionData' => $member_types,
                        'selectedKey' => $managementCommittee->member_type_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('member_type_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'pre_address',
                        'label' =>__('langdata.Present Address'),
                        'value' => $managementCommittee->pre_address,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('pre_address'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'per_address',
                        'label' =>__('langdata.Permanent Address'),
                        'value' => $managementCommittee->per_address,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('per_address'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'nid', 'label' =>__('langdata.nid'),'number' =>true,
                        'value' => $managementCommittee->nid,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('nid'),
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

                    <div class="col-md-6">
                        <img src="{{ asset($managementCommittee->image) }}" alt="" srcset="">
                    </div>
                    <hr>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' =>'joining_date', 'label' =>__('langdata.joining_date'),
                        'value' => $managementCommittee->joining_date,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('joining_date'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' =>'resign_date', 'label' =>__('langdata.resign_date'),
                        'value' => $managementCommittee->resign_date,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('joining_date'),
                        ])

                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                        'name' =>'status', 'label' =>__('langdata.status'),
                        'selectedKey' => $managementCommittee->status,
                        'required' => true,

                        'optionData' => $status,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('status'),
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
    $(function() {
        getUnitData();
        $('#Floorid').on('change', function(e) {
            e.preventDefault();
            getUnitData();

        });

        function getUnitData() {
            let url = "{{ route('backend.unit.index') }}"
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'JSON',
                data: {
                    'Floorid': $('#Floorid').val(),
                    'getFreeUnits': true
                },

                success: function(res) {
                    $("#Unitid").html(' ');
                    $.map(res.data, function(val, i) {
                        var newOption = new Option(val.name, val.id, false, false);
                        $('#Unitid').append(newOption).trigger('change');
                        $('#Unitid').val("{{ $managementCommittee->unit_id }}").trigger(
                            'change')

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
        }
    });
</script>
@endpush
