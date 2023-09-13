@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-pencil"></i> Edit Owner
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => 'Owner List',
'route' =>route('backend.owner.index'),
])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.owner.update', $Owner) }}" method="POST" class="row g-3">
                    @method('PUT')
                    @csrf
                    <div class="col-md-12">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'name',
                        'required' => true,
                        'value' => $Owner->name
                        ])
                        @include('components.backend.forms.input.errorMessage', ['message'=>$errors->first('name')])
                    </div>
                    {{--  --}}
                    <div class="col-md-12">
                        @include('components.backend.forms.select2.option',[ 'name' => 'floor_id', 'selectedKey' =>$Owner->floor_id, 'required' => true,'label'=>'Floor','optionData'=>$floors])
                        @include('components.backend.forms.input.errorMessage', ['message' => $errors->first('floor_id')])
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
