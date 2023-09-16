@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> Complain Report Form
@stop
@section('table_header')
@include('backend._partials.page_header')
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.floor.store') }}" method="POST" class="row g-3">
                    @method('POST')
                    @csrf
                    <div class="col-md-4">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'date',
                        'label' => 'Select Date',
                        'inType' => 'date',
                        'optionData' => [],
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'month',
                        'label' => 'Month',
                        'optionData' => [
                        ['id'=>1, 'name'=>'January'],
                        ['id'=>2, 'name'=>'February'],
                        ['id'=>3, 'name'=>'March'],
                        ['id'=>4, 'name'=>'April'],
                        ['id'=>5, 'name'=>'May'],
                        ['id'=>6, 'name'=>'June'],
                        ['id'=>7, 'name'=>'July'],
                        ['id'=>8, 'name'=>'August'],
                        ['id'=>9, 'name'=>'September'],
                        ['id'=>10, 'name'=>'October'],
                        ['id'=>11, 'name'=>'November'],
                        ['id'=>12, 'name'=>'December'],
                        ],
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'year',
                        'label' => 'Year',
                        'optionData' => [
                        ['id'=>1, 'name'=>'2021'],
                        ['id'=>2, 'name'=>'2022'],
                        ['id'=>3, 'name'=>'2023'],
                        ['id'=>4, 'name'=>'2024'],
                        ['id'=>5, 'name'=>'2025'],
                        ['id'=>6, 'name'=>'2026'],
                        ['id'=>7, 'name'=>'2027'],
                        ['id'=>8, 'name'=>'2028'],
                        ['id'=>9, 'name'=>'2029'],
                        ['id'=>10, 'name'=>'2030'],
                        ],
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
