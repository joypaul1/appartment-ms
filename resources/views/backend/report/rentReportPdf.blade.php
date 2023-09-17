@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@php
$remainBalance = 0;
@endphp

<div class="row">
    <div class="col-12">
        <div class="card p-3">
            <p class="text-center" id="print"><button class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i></button></p>
            <div id="printArea">
                <div class="card mx-auto" style="width: 25%;">
                    <img class="card-img-top" src="{{ asset(session('site_info')['logo']) }}" alt="Card image">
                    <div class="card-body">
                        <strong class="card-header"><u>{{ $branch->name }}</u></strong>
                        <p class="card-text">Mobile : {{ $branch->mobile }}
                            <br> Email: {{ $branch->email }}
                        </p>
                    </div>
                </div>
                <div class="card-title text-center"><u>Rent Collection Report</u> </div>
                <div class="card-body">
                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>Renter Name</th>
                                <th>Floor </th>
                                <th>
                                    Unit
                                </th>
                                <th>
                                    Month
                                </th>
                                <th>
                                    Year
                                </th>

                                <th>
                                    Water Bill
                                </th>
                                <th>
                                    Electric Bill
                                </th>
                                <th>
                                    Gas Bill
                                </th>
                                <th>
                                    Security Bill
                                </th>
                                <th>
                                    Utility Bill
                                </th>
                                <th>
                                    Others Bill
                                </th>
                                <th>
                                    Total Rent
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rentCollections as $key => $row)
                            @php
                            $remainBalance += $row->total_rent;
                            @endphp
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
                                    {{ $row->water_bill }}
                                </td>
                                <td>
                                    {{ $row->electric_bill }}
                                </td>
                                <td>
                                    {{ $row->gas_bill }}
                                </td>
                                <td>
                                    {{ $row->security_bill }}
                                </td>
                                <td>
                                    {{ $row->utility_bill }}
                                </td>
                                <td>
                                    {{ $row->other_bill }}
                                </td>
                                <td>
                                    {{ $row->total_rent }}
                                </td>




                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                {{-- @dd(session('site_info')) --}}
                <p class="text-center">Balance :
                    <strong>
                        <u>
                            @if (session('site_info')['currency_symbol_placement'] == 'before')
                            {{ session('site_info')['currency_symbol'] }}
                            @endif
                            {{ number_format($remainBalance, 2) }}
                            @if (session('site_info')['currency_symbol_placement'] == 'after')
                            {{ session('site_info')['currency_symbol'] }}
                            @endif
                        </u>

                    </strong>
                </p>
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
