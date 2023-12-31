@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> {{ __('langdata.Create-Management-Management') }}
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
                <form action="{{ route('backend.management-committee.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'name', 'label' =>__('langdata.name'),
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'mobile', 'label' =>__('langdata.mobile'),'number' =>true,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('mobile'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'email', 'label' =>__('langdata.email'), 'inType' => 'email',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('email'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'password', 'label' =>__('langdata.password'),
                        'required' => true,
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
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('member_type_id'),
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'label' =>__('langdata.Present Address'),
                        'name' => 'pre_address',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('pre_address'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'label' =>__('langdata.Permanent Address'),
                        'name' => 'per_address',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('per_address'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                         'name' =>'nid', 'label' =>__('langdata.nid'),'number' =>true,
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
                    <div class="col-md-6"></div>
                    <hr>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' =>'joining_date', 'label' =>__('langdata.joining_date'),
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
                        // 'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('joining_date'),
                        ])
                    </div>



                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                        'name' =>'status', 'label' =>__('langdata.status'),
                        'selectedKey' => 1,
                        'required' => true,

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
@endpush
