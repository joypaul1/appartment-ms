@extends('backend.layout.app')
@include('backend._partials.delete_alert')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-list"></i> {{ __('Building-Config') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-plus-circle',
'name' => __('Create-Building'),
'route' =>route('backend.site-config.building.create'),
])
@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <table id="datatables-reponsive" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>@lang('table.sl')</th>
                            <th>@lang('table.name')</th>
                            <th>@lang('table.image') </th>
                            <th>@lang('table.email') </th>
                            <th>@lang('table.mobile') </th>
                            <th>@lang('table.address') </th>
                            <th>@lang('table.status') </th>
                            <th>@lang('table.action') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $key=>$row)
                        <tr>
                            <td>
                                {{ $key+1 }}
                            </td>
                            <td>
                                {{ $row->name }}
                            </td>
                            <td>
                                <img src="{{ asset($row->building_image) }}" alt="" style="width: 50px;height:50px;border-radius:50%" srcset="">
                            </td>
                            <td>
                                {{ $row->email }}
                            </td>
                            <td>
                                {{ $row->mobile }}
                            </td>
                            <td>
                                {{ $row->address }}
                            </td>
                            <td>
                                {{ $row->status == 1? 'Active':'Deactive' }}



                            </td>

                            <td class="table-action">
                                <a href="{{ route('backend.site-config.building.edit', $row) }}">
                                    <button class="btn btn-sm btn-info"> <i class="fa fa-pencil" aria-hidden="true"></i> </button>

                                </a>
                                {{-- <a data-href="{{ route('backend.site-config.building.destroy', $row) }}" href="#" class="delete_check">
                                    <button class="btn btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                </a> --}}
                            </td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

<script>
    $(document).ready(function() {
        $("#toggleFilter").click(function() {
            $("#filterContainer").slideToggle();
        });
    });

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Choices.js
        new Choices(document.querySelector(".choices-single"));

        // Responsive Datatables
        $("#datatables-reponsive").DataTable({
            responsive: true
        });
    });

</script>
@endpush
