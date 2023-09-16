@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> Unit Status Report Form
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
                    <div class="col-md-12">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'tenant_status',
                        'label' => 'Unit Status',
                        'optionData' => [
                            ['id'=>1, 'name'=>'Available'],
                            ['id'=>2, 'name'=>'Booked'],
                            ['id'=>3, 'name'=>'Occupied'],
                            ['id'=>4, 'name'=>'Vacant'],
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
