@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i>{{ __('langdata.Edit-Complain') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => __('langdata.Complain-List') ,
'route' => route('backend.complain.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.complain.update', $complain) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="col-md-12">
                        @include('components.backend.forms.input.input-type', [
                        'name' =>'maintenance', 'label' =>__('langdata.maintenance'),
                        'required' => true,
                        'value' => $complain->title
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('title'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' =>'date', 'label' =>__('langdata.date')
                        'required' => true,
                        'value' => $complain->date

                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('date'),
                        ])
                    </div>

                    <div class="col-md-12">
                        @include('components.backend.forms.texteditor.editor', [
                    
                        'name' =>'description', 'label' =>__('langdata.description'),
                        'required' => true,
                        'value' => $complain->description

                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('description'),
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
