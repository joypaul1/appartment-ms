@extends('backend.layout.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/backend') }}/vendor/dropify/css/dropify.min.css">
@endpush
@section('page-header')
<i class="fa fa-plus-circle"></i> Admin Profile
@stop

@section('content')
@include('backend._partials.page_header', [

])


<div class="row">
    <div class="col-lg-8">
        <div class="card">

            <div class="card-body">
                <div class="form-validation">

                    <div class="mb-3 row">
                        <div class="col-lg-8">
                            @include('components.backend.forms.input.input-type', [
                            'name' => 'name',
                            'value' => old('name', auth('admin')->user()->name),
                            'placeholder' => 'name will be here...',
                            'disabled' => true,
                            ])
                            @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('name'),
                            ])
                        </div>
                    </div>
                    <div class="mb-3 row">

                        <div class="col-lg-8">
                            @include('components.backend.forms.input.input-type', [
                            'name' => 'email',
                            'inType' => 'email',
                            'disabled' => true,
                            'value' => old('email', auth('admin')->user()->email),
                            'placeholder' => 'email will be here...',
                            ])
                            @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('email'),
                            ])
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-lg-8">
                            @include('components.backend.forms.input.input-type', [
                             'name' => 'mobile','number' =>true,
                            'disabled' => true,
                            'value' => old('mobile', auth('admin')->user()->mobile),
                            'placeholder' => 'mobile will be here (01...)',
                            ])
                            @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('mobile'),
                            ])
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Profile Image</h4>
            </div>
            <div class="card-body">
                <a href="#" onClick="javascript:showMyModalImage('{{ asset( auth('admin')->user()->image) }}')">
                    <img class="card-img-top img-fluid" src="{{ asset(auth('admin')->user()->image) }}" alt="Current Image">
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

<script>
    function showMyModalImage(imgsrc) {
            $("#outputImage").attr("src", imgsrc);
            $('#defaultModal').modal('show');
        }
</script>
@endpush
