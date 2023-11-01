@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@php
$remainBalance = 0;
$remainBalance += $maintenanceCost;
$remainBalance += $employeeSalary;

@endphp

<div class="row">
    <div class="col-12">
        <div class="card p-3">
            <p class="text-center" id="print"><button class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i></button></p>
            <div id="printArea">
                <div class="card mx-auto" style="width: 25%;">
                    <img class="card-img-top" src="{{ asset(session('site_info')['logo']) }}" alt="logo">
                    <div class="card-body">
                        <strong class="card-header"><u>{{ $branch->name }}</u></strong>
                        <p class="card-text">Mobile : {{ $branch->mobile }}
                            <br> Email: {{ $branch->email }}
                        </p>
                    </div>
                </div>
                <div class="card-title text-center"><u>Expense Report</u> </div>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table id="datatables-reponsive" class="table table-bordered text-center" style="width:100%">
                            <thead>
                                <tr style="
                                background: #45c745;
                                color: white;
                            ">
                                    <th>Sl.</th>
                                    <th>Name</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Maintenance Cost </td>
                                    <td class="text-end">{{ number_format($maintenanceCost ,2) }} </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Salary </td>
                                    <td class="text-end">{{ number_format($employeeSalary, 2) }} </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Total Expense : </strong></td>
                                    <td class="text-end"><u><strong>{{ number_format($remainBalance, 2) }}</strong></u></td>
                                </tr>
                            </tfoot>
                        </table>
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
