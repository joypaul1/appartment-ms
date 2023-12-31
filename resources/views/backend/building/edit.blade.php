@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-pencil"></i> Edit Building Informaiton
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => __('Bill-Informaiton-List'),
'route' => route('backend.site-config.building.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.site-config.building.update', $buildingInformation) }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('PUT')

                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'name', 'label' =>__('langdata.name'),
                        'required' => true,
                        'value' => $buildingInformation->name,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'mobile', 'label' =>__('langdata.mobile'),'number' =>true,
                        'required' => true,
                        'value' => $buildingInformation->mobile,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'email', 'label' =>__('langdata.email'), 'inType' => 'email',
                        'value' => $buildingInformation->email,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('email'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'security_guard_mobile',
                        'label' =>__('langdata.Security Mobile No'),
                        'value' => $buildingInformation->security_guard_mobile,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('security_guard_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'secretary_mobile',
                        'label' =>__('langdata.Secretary Mobile No'),
                        'value' => $buildingInformation->secretary_mobile,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('secretary_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'moderator_mobile',
                        'label' =>__('langdata.moderator Mobile No'),

                        'value' => $buildingInformation->moderator_mobile,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('moderator_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'address', 'label' =>__('langdata.address'),
                        'required' => true,
                        'value' => $buildingInformation->address,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('address'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'file',
                        'label' =>__('langdata.image'),
                        'name' => 'building_image',
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('building_image'),
                        ])
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                        'name' =>'status', 'label' =>__('langdata.status'),
                        'optionData' => $status,
                        'required' => true,
                        'selectedKey' => $buildingInformation->status,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('status'),
                        ])
                    </div>
                    {{-- @dd($buildingInformation); --}}
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="card text-center">

                            <div class="card-body">
                                <img src="{{ url($buildingInformation->building_image) }}" alt="" width="200px" height="100px">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h2><u>Builder/Company Information :</u> </h2>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'builder_name', 'label' =>__('langdata.builder_name'),
                        'value' => $buildingInformation->builder_name,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('builder_name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'builder_mobile', 'label' =>__('langdata.builder_mobile'),
                        // 'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('builder_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'builder_address', 'label' =>__('langdata.builder_address'),
                        'value' => $buildingInformation->builder_address,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('builder_address'),
                        ])
                    </div>
                    <h2><u> Building Rules : </u></h2>

                    <div class="col-md-12">
                        @include('components.backend.forms.texteditor.editor', [
                        'name' =>'building_rules', 'label' =>__('langdata.building_rules'),

                        'value' => $buildingInformation->building_rules,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('building_rules'),
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
@endpush
