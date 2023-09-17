@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-plus-circle"></i> Create Building Informaiton
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-list',
        'name' => 'Building List',
        'route' => route('backend.site-config.building.index'),
    ])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.site-config.building.store') }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'name',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'label' => 'Mobile No',
                            'name' => 'mobile',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'email',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('email'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'security_guard_mobile',
                            'label' => 'Security Mobile No.',
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('security_guard_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'secretary_mobile',
                            'label' => 'Secretary Mobile No.',
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('secretary_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'moderator_mobile',
                            'label' => 'moderator Mobile No.',
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('moderator_mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'address',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('address'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'file',
                            'name' => 'building_image',
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('building_image'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'status',
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
                            'name' => 'builder_name',
                            // 'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('builder_name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'builder_name',
                            // 'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('builder_name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'builder_address',
                            // 'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('builder_address'),
                        ])
                    </div>
                    <h2><u> Building Rules : </u></h2>

                    <div class="col-md-12">
                        @include('components.backend.forms.texteditor.editor', [
                            'name' => 'building_rules',
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
