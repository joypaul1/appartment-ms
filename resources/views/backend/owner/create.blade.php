@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> {{ __('langdata.Create-Owner')  }}  Owner
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' =>  __('langdata.Owner-List'),
'route' =>route('backend.owner.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.owner.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                         'name' =>'name', 'label' =>__('langdata.name')
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                         'name' => 'mobile','number' =>true,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('mobile')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'email',  'inType' => 'email',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('email')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'password',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('password')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'pre_address',
                        'label' => 'Present Address',

                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('pre_address')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'label' => 'Permanent Address',
                        'name' => 'per_address',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('per_address')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                         'name' => 'nid','number' =>true,
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
                    <div class="col-xs-6 col-sm-6 col-md-6">

                        @include('components.backend.forms.select2.option',[ 'name' => 'unit_id[]',
                        'label'=>'Unit','optionData'=> $units, 'multiple' => true])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('unit_id')])
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
