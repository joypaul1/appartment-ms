@extends('backend.layout.app')
@push('css')
@endpush
@section('content')

@section('page-header')
    <i class="fa fa-list"></i> Maintenance Cost List
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        // 'fa' => 'fa fa-plus-circle',
        // 'name' => 'Create Owner Utility',
        // 'route' => route('backend.maintenance-cost.create'),
    ])
@endsection


<div class="row">
    <div class="col-12">
        <div class="card p-3">
            @yield('table_header')
            <div class="card-body  table-responsive">
                <table id="datatables-reponsive" class="table table-striped text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>@lang('table.sl')</th>
                            <th>@lang('table.title')</th>
                            <th>@lang('table.date')</th>
                            <th>@lang('table.month')</th>
                            <th>@lang('table.year')</th>
                            <th>@lang('table.amount')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maintenanceCosts as $key => $row)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>
                                    {{ $row->title }}
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
