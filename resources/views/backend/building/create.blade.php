@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> Building Create
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => ('List Building'),
'route' => route('backend.site-config.building.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.site-config.building.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'name', 'label' =>__('langdata.name')
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'mobile', 'label' =>__('langdata.mobile')'number' =>true,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'email', 'label' =>__('langdata.email') 'inType' => 'email',
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
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('security_guard_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'secretary_mobile',
                        'label' =>__('langdata.Secretary Mobile No'),
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('secretary_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'moderator_mobile',
                        'label' =>__('langdata.moderator Mobile No'),
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('moderator_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'address', 'label' =>__('langdata.address'),
                        'required' => true,
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
                        'selectedKey' => 1,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('status'),
                        ])
                    </div>
                    <hr>
                    <h2><u>Builder/Company Information :</u> </h2>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                       'name' =>'builder_name', 'label' =>__('langdata.builder_name'),
                        // 'required' => true,
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
                        // 'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('builder_address'),
                        ])
                    </div>
                    <h2><u> Building Rules : </u></h2>

                    <div class="col-md-12">
                        @include('components.backend.forms.texteditor.editor', [
                       'name' =>'building_rules', 'label' =>__('langdata.building_rules'),
                        // 'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('building_rules'),
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
