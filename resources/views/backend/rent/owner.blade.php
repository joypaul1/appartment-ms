@extends('backend.layout.app')
@push('css')
@endpush
@section('content')

@section('page-header')
    <i class="fa fa-list"></i> {{ __('title.Rent-Collection-List') }}
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        // 'fa' => 'fa fa-plus-circle',
        // 'name' => 'Create Rent Collection',
        // 'route' => route('backend.rent.create'),
    ])
@endsection


<div class="row">
    <div class="col-12">
        <div class="card p-3">
            @yield('table_header')
            <div class="card-body">
                <table id="datatables-reponsive" class="table table-bordered table-responsive text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>@lang('table.invoice_no')</th>
                            <th>@lang('table.renter_name')</th>
                            <th>@lang('table.floor')</th>
                            <th>@lang('table.unit')</th>
                            <th>@lang('table.month')</th>
                            <th>@lang('table.year')</th>
                            <th>@lang('table.total_rent')</th>
                            <th>@lang('table.bill_status')</th>
                            <th>@lang('table.bill_created_date')</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentCollections as $key => $row)
                            <tr>
                                <td>
                                    {{ $row->invoice_number }}
                                </td>
                                <td>
                                    {{ optional($row->tenant)->name }}
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
                                    {{ $row->total_rent }}
                                </td>
                                <td>
                                    {{ $row->status == 1 ? 'Paid' : 'Due' }}
                                </td>
                                <td>
                                    {{ date('d-m-y', strtotime($row->issue_date)) }}
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
