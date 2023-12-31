@extends('backend.layout.app')
@push('css')

@endpush
@section('page-header')
    <i class="fa fa-plus-circle"></i> @lang('langdata.Edit-Admin')
@stop

@section('content')
    @include('backend._partials.page_header', [
        // 'fa' => 'fa fa-list',
        // 'name' => 'Admin List',
        // 'route' => route('backend.site-config.admin.index'),
    ])


    <div class="row">
        <div class="col-lg-8">
            <div class="card">

                <div class="card-body">
                    <div class="form-validation">
                        <form action="{{ route('backend.site-config.admin.update', $admin) }}" method="Post"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3 row">
                                {{-- <label class="col-lg-4 col-form-label" for="name">Name   <span class="text-danger">*</span> </label> --}}
                                <div class="col-lg-8">
                                    @include('components.backend.forms.input.input-type', [
                                         'name' =>'name', 'label' =>__('langdata.name'),
                                        'value' => old('name', $admin->name),
                                        'placeholder' => 'name will be here...',
                                        'required' => true,
                                    ])
                                    @include('components.backend.forms.input.errorMessage', [
                                        'message' => $errors->first('name'),
                                    ])
                                </div>
                            </div>
                            <div class="mb-3 row">
                                {{-- <label class="col-lg-4 col-form-label" for="email">Email   <span class="text-danger">*</span> </label> --}}
                                <div class="col-lg-8">
                                    @include('components.backend.forms.input.input-type', [
                                         'name' =>'email', 'label' =>__('langdata.email'),
                                        'inType' => 'email',
                                        'required' => true,
                                        'value' => old('email', $admin->email),
                                        'placeholder' => 'email will be here...',
                                    ])
                                    @include('components.backend.forms.input.errorMessage', [
                                        'message' => $errors->first('email'),
                                    ])
                                </div>
                            </div>
                            <div class="mb-3 row">
                                {{-- <label class="col-lg-4 col-form-label" for="mobile">Mobile  <span class="text-danger">*</span> </label> --}}
                                <div class="col-lg-8">
                                    @include('components.backend.forms.input.input-type', [
                                          'name' =>'mobile', 'label' =>__('langdata.mobile'),'number' =>true,
                                        'number' => true,
                                        'required' => true,
                                        'value' => old('mobile', $admin->mobile),
                                        'placeholder' => 'mobile will be here (01...)',
                                    ])
                                    @include('components.backend.forms.input.errorMessage', [
                                        'message' => $errors->first('mobile'),
                                    ])
                                </div>
                            </div>
                            <div class="mb-3 row">
                                {{-- <label class="col-lg-4 col-form-label" for="password">Password  <span class="text-danger">*</span> </label> --}}
                                <div class="col-lg-8">
                                    @include('components.backend.forms.input.input-type', [
                                         'name' =>'password', 'label' =>__('langdata.password'),
                                        'inType' => 'text',
                                        'placeholder' => 'Password will be here...',
                                    ])
                                    @include('components.backend.forms.input.errorMessage', [
                                        'message' => $errors->first('password'),
                                    ])
                                </div>
                            </div>
                            {{-- <div class="col-md-8">
                                @include('components.backend.forms.select2.option', [
                                    'name' => 'branch_id',
                                    'required' => true,
                                    'label' => 'Branch',
                                    'optionData' => $branches,
                                    'selectedKey' => $admin->branch_id
                                ])
                                @include('components.backend.forms.input.errorMessage', [
                                    'message' => $errors->first('branch_id'),
                                ])
                            </div> --}}

                            <div class="mb-3 ">
                                <label class="col-lg-4 col-form-label" for="image">Image</label>

                                <div class="col-lg-8">
                                    <input type="file" name="image" class="form-control">
                                    {{-- <strong class="text-danger text-bold">Image Will be (200x200) px </strong> --}}
                                    @include('components.backend.forms.input.errorMessage', [
                                        'message' => $errors->first('image'),
                                    ])
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title >Uploaded Document</h4>
                </div>
                <div class="card-body">
                    <a href="#" onClick="javascript:showMyModalImage('{{ asset($admin->image) }}')">
                        <img class="card-img-top img-fluid" src="{{ asset($admin->image) }}" alt="Current Image">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="langdata. id="defaultModalLabel">Admin Image View</h4>
                </div>
                <div class="modal-body">
                    <img src="#" alt="" id="outputImage" width='100%' height="50%">
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
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
