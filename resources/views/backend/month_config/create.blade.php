@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-plus-circle"></i> {{ __('langdata.Create-Month') }}
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-list',
        'name' => __('langdata.Month-List'),
        'route' => route('backend.site-config.month.index'),
    ])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.site-config.month.store') }}" method="POST" class="row g-3">
                    @method('POST')
                    @csrf
                    <div class="col-md-12">
                        @include('components.backend.forms.input.input-type', [
                             'name' =>'name', 'label' =>__('langdata.name')
                            'required' => true,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('name'),
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
