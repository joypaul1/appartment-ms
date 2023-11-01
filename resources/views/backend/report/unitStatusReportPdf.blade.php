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
                    <div class="card-title text-center"><u>Unit Report</u> </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="datatables-reponsive" class="table table-bordered text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Name</th>
                                        <th>Floor Name</th>
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
                                            {{ optional($row->floor)->name }}
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
