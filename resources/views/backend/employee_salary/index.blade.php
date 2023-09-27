@extends('backend.layout.app')
@include('backend._partials.delete_alert')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-list"></i>{{ __('title.Employee-Salary-List') }}
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-plus-circle',
        'name' =>  __('title.Create-Employee-Salary'),
        'route' => route('backend.employee-salary.create'),
    ])
@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <table id="datatables-reponsive" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>@lang('table.sl')</th>
                            <th>@lang('table.name')</th>
                            <th>@lang('table.month')</th>
                            <th>@lang('table.year')</th>
                            <th>@lang('table.issue_date')</th>
                            <th>@lang('table.salary')</th>
                            <th>@lang('table.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $row)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ optional($row->employee)->name }}
                                </td>
                                <td>
                                    {{ optional($row->month)->name }}

                                </td>
                                <td>
                                    {{ optional($row->year)->name }}

                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($row->issue_date)) }}
                                </td>
                                <td>
                                    {{ $row->amount }}
                                </td>


                                <td class="table-action">
                                    <a href="{{ route('backend.employee-salary.edit', $row) }}">
                                        <button class="btn btn-sm btn-info"> <i class="fa fa-pencil"
                                                aria-hidden="true"></i> </button>

                                    </a>
                                    <a data-href="{{ route('backend.employee-salary.destroy', $row) }}" href="#"
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
