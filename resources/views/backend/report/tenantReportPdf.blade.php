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
                <p class="text-center" id="print"><button class="btn btn-info"><i class="fa fa-print"
                            aria-hidden="true"></i></button></p>
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
                    <div class="card-title text-center"><u>Tenant Report</u> </div>
                    <div class="table-responsive text-break">
                        <table id="datatables-reponsive" class="table table-bordered text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Tenant Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Appartment</th>
                                    <th>Advance Payment</th>
                                    <th>Rent Per Month</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $row)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($row->image) }}" alt=""
                                                style="width: 50px;height:50px;border-radius:50%" srcset="">

                                        </td>
                                        <td>
                                            {{ $row->name }}
                                        </td>

                                        <td>
                                            {{ $row->email }}
                                        </td>
                                        <td>
                                            {{ $row->mobile }}
                                        </td>

                                        <td>
                                            Floor:{{ $row->floor->name }}/Unit:{{ $row->unit->name }}
                                        </td>
                                        <td>
                                            @if (session('site_info')['currency_symbol_placement'] == 'before')
                                                {{ session('site_info')['currency_symbol'] }}
                                            @endif
                                            {{ $row->advance_rent }}
                                            @if (session('site_info')['currency_symbol_placement'] == 'after')
                                                {{ session('site_info')['currency_symbol'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (session('site_info')['currency_symbol_placement'] == 'before')
                                                {{ session('site_info')['currency_symbol'] }}
                                            @endif
                                            {{ $row->rent_per_month }}
                                            @if (session('site_info')['currency_symbol_placement'] == 'after')
                                                {{ session('site_info')['currency_symbol'] }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ date('d-m-y', strtotime($row->date)) }}
                                        </td>
                                        <td>
                                            {{ $row->status == 1 ? 'Active' : 'Inactive' }}
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
