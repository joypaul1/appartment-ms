@extends('backend.layout.app')
@push('css')
@endpush
@section('content')

@section('page-header')
<i class="fa fa-list"></i> {{ __('langdata.Owner-Utilit-List') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [

])
@endsection


<div class="row">
    <div class="col-12">
        <div class="card p-3">
            @yield('table_header')
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatables-reponsive" class="table table-bordered table-sm text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('langdata.invoice_no')</th>
                                <th>@lang('langdata.renter_name')</th>
                                <th>@lang('langdata.floor')</th>
                                <th>@lang('langdata.unit')</th>
                                <th>@lang('langdata.month')</th>
                                <th>@lang('langdata.year')</th>
                                <th>@lang('langdata.total_utility')</th>
                                <th>@lang('langdata.action') </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ownerUtilitys as $key => $row)
                            <tr>
                                <td>
                                    {{ $row->invoice_number }}
                                </td>
                                <td>
                                    {{ optional($row->owner)->name }}
                                </td>
                                <td>
                                    {{ optional($row->floor)->name }}
                                </td>
                                <td>
                                    {{ optional($row->unit)->name }}
                                </td>
                                <td>
                                    {{ optional($row->month)->name }}
                                </td>
                                <td>
                                    {{ optional($row->year)->name }}
                                </td>
                                <td>
                                    {{ $row->total_utility }}
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
