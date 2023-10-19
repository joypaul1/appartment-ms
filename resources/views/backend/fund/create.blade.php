@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> @lang('langdata.Create-Fund')
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => __('langdata.Fund-List'),
'route' => route('backend.fund.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.fund.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'owner_id',
                        'required' => true,
                        'label' =>__('langdata.owner'),
                        'optionData' => $owners,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('owner_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'date',
                        'name' =>__('langdata.date'),
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('date'),
                        ])
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'month_id',
                        'required' => true,
                         'label' =>__('langdata.month'),
                        'optionData' => $months,
                        'selectedKey' => date('m'),
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('month_id'),
                        ])
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'year_id',
                        'required' => true,
                         'label' =>__('langdata.year'),
                        'optionData' => $years,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('year_id'),
                        ])
                    </div>


                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                        'inType' => 'number',
                        'value' => 0.0,
                        'name' => 'amount',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('amount'),
                        ])
                    </div>
                    <div class="col-md-12">
                        @include('components.backend.forms.texteditor.editor', [
                        'label' => 'Fund Purpose',
                        'name' => 'purpose',
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                        'message' => $errors->first('purpose'),
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
