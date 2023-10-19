@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-pencil"></i> {{ __('Edit Member Type') }}
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-list',
        'name' => __('Member Type List'),
        'route' => route('backend.site-config.member-type.index'),
    ])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.site-config.member-type.update', $memberType) }}" method="POST"
                    class="row g-3">
                    @method('PUT')
                    @csrf
                    <div class="col-md-12">
                        @include('components.backend.forms.input.input-type', [
                             'name' =>'name', 'label' =>__('langdata.name')
                            'required' => true,
                            'value' => $memberType->name,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('name'),
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
