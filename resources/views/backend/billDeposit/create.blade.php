@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-plus-circle"></i> @lang('langdata.Create-Bill-Deposit')
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-list',
        'name' => __('Bill-Deposit-List'),
        'route' => route('backend.bill-deposit.index'),
    ])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.bill-deposit.store') }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'bill_type_id',
                            'required' => true,
                            'label' => 'Bill Type',
                            'optionData' => $billTypes,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('bill_type_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'date',
                             'name' =>__('langdata.date'),
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
                            'label' => 'Month',
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
                            'label' => 'Year',
                            'optionData' => $years,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('year_id'),
                        ])
                    </div>



                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'deposit_account_name',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('deposit_account_name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'value' => 0.0,
                            'label' => 'Amount',
                            'name' => 'total_amount',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('total_amount'),
                        ])
                    </div>
                    <div class="col-md-12">
                        @include('components.backend.forms.texteditor.editor', [
                            'name' => 'details',
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('details'),
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
