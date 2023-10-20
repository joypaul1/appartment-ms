@extends('backend.layout.app')
@push('css')

@endpush
@section('page-header')
<i class="fa fa-plus-circle"></i> @lang("langdata.Email Config")
@stop

@section('content')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => ' ',
'route' => route('backend.site-config.email.index')
])


<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{ route('backend.site-config.email.store') }}" method="Post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        <div class="form-group">
                            @include('components.backend.forms.input.input-type',[ 'name' => 'driver', 'placeholder' => 'driver name will be here...',
                            'value' => $emailConfig->driver??old('driver') ])
                            @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('driver')])
                        </div>

                        <div class="form-group">
                            @include('components.backend.forms.input.input-type',[ 'name' => 'host', 'placeholder' => 'host will be here...','value'
                            => $emailConfig->host??old('host') ])
                            @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('host')])
                        </div>

                        <div class="form-group">
                            @include('components.backend.forms.input.input-type',[ 'name' => 'port', 'placeholder' => 'port will be here...' , 'value'
                            => $emailConfig->port??old('port')])
                            @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('port')])
                        </div>

                        <div class="form-group">
                            @include('components.backend.forms.input.input-type',[ 'name' => 'encryption', 'placeholder' => 'encryption will be
                            here...','value' => $emailConfig->encryption??old('encryption') ])
                            @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('encryption')])
                        </div>


                        <div class="form-group">
                            @include('components.backend.forms.input.input-type',[ 'name' => 'user_name', 'placeholder' => 'email user name...'
                            ,'value' => $emailConfig->user_name??old('user_name')])
                            @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('user_name')])
                        </div>

                        <div class="form-group">
                            @include('components.backend.forms.input.input-type',[ 'name' =>'password', 'label' =>__('langdata.password'),
                            'placeholder' => 'email user name...', 'value' => $emailConfig->password??old('password') ])
                            @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('password')])
                        </div>

                        <div class="form-group">
                            @include('components.backend.forms.input.input-type',[ 'name' => 'sender_name', 'placeholder' => 'sender name...','value'
                            => $emailConfig->sender_name??old('sender_name') ])
                            @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('sender_name')])
                        </div>


                        <div class="form-group">
                            @include('components.backend.forms.input.input-type',[ 'name' => 'sender_email', 'placeholder' => 'sender email...' ,
                            'value' => $emailConfig->sender_email??old('sender_email')])
                            @include('components.backend.forms.input.errorMessage', ['message' =>$errors->first('sender_email')])
                        </div>




                        <div class="d-block mt-2 ">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">{{ __('button.submit_data') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection


