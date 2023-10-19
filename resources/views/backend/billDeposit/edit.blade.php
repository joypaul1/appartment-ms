@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-pencil"></i> @lang('langdata.Edit-Bill-Deposit')
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
                <form action="{{ route('backend.bill-deposit.update', $billDeposit) }}" method="POST" class="row g-3"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'bill_type_id',
                            'required' => true,
                            'label' => 'Bill Type',
                            'optionData' => $billTypes,
                            'selectedKey' => $billDeposit->bill_type_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('bill_type_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'date',
                             'name' =>'date', 'label' =>__('langdata.date')
                             'name' =>'date', 'label' =>__('langdata.date')
                            'required' => true,
                            'value' => $billDeposit->date,
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
                            'selectedKey' => $billDeposit->month_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('month_id'),
                        ])
                    </div>
                    <div  <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'year_id',
                            'required' => true,
                             'label' =>__('langdata.year'),
                            'optionData' => $years,
                            'selectedKey' => $billDeposit->year_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('year_id'),
                        ])
                    </div>



                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'name' => 'deposit_account_name',
                            'required' => true,
                            'value' => $billDeposit->deposit_account_name,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('deposit_account_name'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'label' =>__('langdata.amount')
                            'name' => 'total_amount',
                            'required' => true,
                            'value' => $billDeposit->total_amount,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('total_amount'),
                        ])
                    </div>
                    <div class="col-md-12">
                        @include('components.backend.forms.texteditor.editor', [
                             'name' =>'details', 'label' =>__('langdata.details')
                            'required' => true,
                            'value' => $billDeposit->details,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('details'),
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
