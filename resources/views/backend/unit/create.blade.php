@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-plus-circle"></i> @lang("langdata.Create-Unit")
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' =>  __('langdata.unit_list'),
'route' =>route('backend.unit.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.unit.store') }}" method="POST" class="row g-3">
                    @method('POST')
                    @csrf
                    <div class="col-md-12">
                        @include('components.backend.forms.input.input-type', [
                         'name' =>'name', 'label' =>__('langdata.name'),
                        'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>
                    <div class="col-md-12">
                        @include('components.backend.forms.select2.option',[ 'name' => 'floor_id', 'required' => true,'label'=>
                        'Floor','optionData'=>$floors])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('floor_id')])
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
