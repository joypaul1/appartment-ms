@extends('backend.layout.app')
@include('backend._partials.delete_alert')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-list"></i> @lang('langdata.Bill-Type-List')
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-plus-circle',
'name' => 'Create Bill Type',
'name' => __('langdata.Create-Bill-Type') ,
'route' =>route('backend.site-config.bill-type.create'),
])
@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <div class="table-responsive text-break">
                    <table id="datatable-reponsive" class="table  table-bordered table-sm text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('langdata.sl')</th>
                                <th>@lang('langdata.name')</th>
                                <th>@lang('langdata.action') </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$row)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>
                                    {{ $row->name }}
                                </td>

                                <td class="table-action">
                                    <a href="{{ route('backend.site-config.bill-type.edit', $row) }}">
                                        <button class="btn btn-sm btn-info"> <i class="fa fa-pencil" aria-hidden="true"></i> </button>

                                    </a>
                                    <a data-href="{{ route('backend.site-config.bill-type.destroy', $row) }}" href="#" class="delete_check">
                                        <button class="btn btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                    </a>
                                </td>

                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
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
