@extends('backend.layout.app')
@include('backend._partials.delete_alert')

@push('css')
@endpush
@section('content')

@section('page-header')
    <i class="fa fa-list"></i> @lang('title.Bill-Deposit-List')
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-plus-circle',
        'name' => __('title.Create-Bill-Deposit'),
        'route' => route('backend.bill-deposit.create'),
    ])
@endsection


<div class="row">
    <div class="col-12">
        <div class="card p-3">
            @yield('table_header')
            <div class="card-body  table-responsive">
                <table id="datatables-reponsive" class="table table-bordered table-responsive text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>@lang('table.sl')</th>
                            <th>@lang('table.type')</th>
                            <th>@lang('table.date')</th>
                            <th>@lang('table.month')</th>
                            <th>@lang('table.year')</th>
                            <th>@lang('table.amount')</th>
                            <th>@lang('table.deposit_account')</th>
                            <th>@lang('table.action')</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($billDeposits as $key => $row)
                            <tr>
                                <td>
                                    {{ $key++ }}
                                </td>

                                <td>
                                    {{ optional($row->billType)->name }}
                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($row->date)) }}
                                </td>
                                <td>
                                    {{ optional($row->month)->name }}
                                </td>
                                <td>
                                    {{ optional($row->year)->name }}
                                </td>
                                <td>
                                    {{ $row->total_amount }}
                                </td>
                                <td>
                                    {{ $row->deposit_account_name }}
                                </td>


                                <td class="table-action">
                                    <a href="{{ route('backend.bill-deposit.edit', $row) }}">
                                        <button class="btn btn-sm btn-info"> <i class="fa fa-pencil"
                                                aria-hidden="true"></i> </button>
                                    </a>
                                    <a data-href="{{ route('backend.bill-deposit.destroy', $row) }}" href="#"
                                        class="delete_check">
                                        <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"
                                                aria-hidden="true"></i> </button>
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
