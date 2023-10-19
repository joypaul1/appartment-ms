@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> {{ __('langdata.Create-Employee') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' =>   __('langdata.Employee-List') ,
'route' =>route('backend.employee.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.employee.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
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
                          'name' =>'mobile', 'label' =>__('langdata.mobile')'number' =>true,
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('mobile')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                         'name' =>'email', 'label' =>__('langdata.email')  'inType' => 'email',
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
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option',[ 'name' => 'member_type_id',
                        'required' => true,'label'=>'Member Type','optionData'=> $member_types])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('member_type_id')])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'label' => 'Present Address',
                        'name' => 'pre_address',
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
                    <div class="col-md-6"></div>
                    <hr>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' => 'joining_date',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('joining_date')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' => 'resign_date',
                        // 'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('joining_date')])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'number',
                        'name' => 'salary',
                        'required' => true,
                        'value' =>0.00
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('salary')])
                    </div>


                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option',[ 'name' => 'status','selectedKey'=>1,
                        'required' => true,'label'=>'status','optionData'=> $status])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('status')])
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
