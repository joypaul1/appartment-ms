@extends('backend.layout.app')
@push('css')
@endpush
@section('content')

@section('page-header')
<i class="fa fa-list"></i> {{ __('langdata.Fund-List') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
// 'fa' => 'fa fa-plus-circle',
// 'name' => 'Create Fund',
// 'route' => route('backend.fund.create'),
])
@endsection
@php
$remainBalance = $fundBalance = $maintainCosts = 0;

@endphp

<div class="row">
    <div class="col-12">
        <div class="card p-3">
            <p class="text-center" id="print"><button><i class="fa fa-print" aria-hidden="true"></i></button></p>
            <div id="printArea">
                <div class="card d-block text-center" style="">
                    <img class="" src="{{ asset(session('site_info')['logo']) }}" alt="logo" width="150px">
                    <div class="card-body">
                        <strong class="card-header"><u>{{ $branch->name }}</u></strong>
                        <p class="card-text">Mobile : {{ $branch->mobile }}
                            <br> Email: {{ $branch->email }}
                        </p>
                    </div>
                </div>
                <div class="card-title text-center">Fund Management List </div>
                <div class="card-body">
                    <div class="table-responsive text-break">
                        <table id="datatables-reponsive" class="table table-bordered table-sm text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>@lang('langdata.sl')</th>
                                    <th>@lang('langdata.owner')</th>
                                    <th>@lang('langdata.date')</th>
                                    <th>@lang('langdata.month')</th>
                                    <th>@lang('langdata.year')</th>
                                    <th>@lang('langdata.amount')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($funds as $key => $row)
                                @php
                                $fundBalance += $row->amount;
                                @endphp
                                <tr>
                                    <td>
                                        {{ $key++ }}
                                    </td>


                                    <td>
                                        {{ optional($row->owner)->name }}
                                    </td>
                                    <td>
                                        {{ date('d-m-y', strtotime($row->date)) }}
                                    </td>
                                    <td>
                                        {{ optional($row->month)->name }}
                                    </td>
                                    <td>
                                        {{ optional($row->year)->name }}
                                    </td>
                                    <td>
                                        {{ $row->amount }}
                                    </td>


                                </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <td colspan="6">
                                        <strong><u> {{ number_format($fundBalance, 2) }}</u></strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card-title text-center">Maintenance Cost List</div>
                <div class="card-body">
                    <div class="table-responsive text-break">
                        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>
                                        Title
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Month
                                    </th>
                                    <th>
                                        Year
                                    </th>
                                    <th>
                                        Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maintenanceCosts as $key => $costRow)
                                @php
                                $maintainCosts += $costRow->amount;
                                @endphp
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $costRow->title}}
                                    </td>
                                    <td>
                                        {{ date('d-m-y', strtotime($costRow->date)) }}
                                    </td>
                                    <td>
                                        {{ optional($costRow->month)->name }}
                                    </td>
                                    <td>
                                        {{ optional($costRow->year)->name }}
                                    </td>
                                    <td>
                                        {{ $costRow->amount }}
                                    </td>



                                </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <td colspan="6">
                                        <strong><u> {{ number_format($maintainCosts, 2) }}</u></strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <p class="text-center">Balance : <strong><u>
                                    {{ number_format($fundBalance - $maintainCosts, 2) }}</u></strong> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $("#print").click(function() {
            var printContents = document.getElementById("printArea").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
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
