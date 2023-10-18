@extends('backend.layout.app')
@push('css')
@endpush
@section('content')

@section('page-header')
<i class="fa fa-list"></i> {{ __('title.Owner-Utilit-List') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
// 'fa' => 'fa fa-plus-circle',
// 'name' => 'Create Owner Utility',
// 'route' => route('backend.owner-utility.create'),
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
                                <th>@lang('table.invoice_no')</th>
                                <th>@lang('table.renter_name')</th>
                                <th>@lang('table.floor')</th>
                                <th>@lang('table.unit')</th>
                                <th>@lang('table.month')</th>
                                <th>@lang('table.year')</th>
                                <th>@lang('table.total_utility')</th>
                                <th>@lang('table.action') </th>

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
