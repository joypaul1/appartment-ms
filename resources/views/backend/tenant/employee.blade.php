@extends('backend.layout.app')
@include('backend._partials.delete_alert')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-list"></i> @lang("langdata.Tenant-List")
@stop
@section('table_header')
@include('backend._partials.page_header', [

])
@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body  ">
                <div class="table-responsive text-break">
                    <table id="datatables-reponsive" class="table table-bordered table-sm text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('langdata.sl')</th>
                                <th>@lang('langdata.name')</th>
                                <th>@lang('langdata.image') </th>
                                <th>@lang('langdata.email') </th>
                                <th>@lang('langdata.mobile') </th>
                                <th>@lang('langdata.address') </th>
                                <th>@lang('langdata.appartment') </th>
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
                                <td>
                                    <img src="{{ asset($row->image) }}" alt="" style="width: 50px;height:50px;border-radius:50%" srcset="">
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
                                    Floor:{{ optional($row->floor)->name??'Data Deleted' }}/Unit:{{ optional($row->unit)->name??'Data Deleted' }}
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
