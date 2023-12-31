@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-plus-circle"></i> {{ __('langdata.Edit-Notice-Board') }}
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-list',
        'name' =>  __('langdata.Notice-Board-List') ,
        'route' => route('backend.notice-board.index'),
    ])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.notice-board.update', $noticeBoard) }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="col-md-12">
                        @include('components.backend.forms.input.input-type', [
                            'name' =>'title', 'label' =>__('langdata.title'),
                            'required' => true,
                            'value' => $noticeBoard->title
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('title'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'date',
                             'name' =>'end_date', 'label' =>__('langdata.end_date'),
                            'required' => true,
                            'value' => $noticeBoard->end_date

                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('end_date'),
                        ])
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                           'name' =>'status', 'label' =>__('langdata.status'),
                            'required' => true,
                            'selectedKey' => $noticeBoard->status,
                            'optionData' => [['id' => 1, 'name' => 'Publish'],['id' => 0, 'name' => 'Unpublish']],
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('status'),
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
