@extends('backend.layout.app')
@include('backend._partials.delete_alert')
@push('css')
@endpush
@section('content')

@section('page-header')
<i class="fa fa-list"></i> {{ __('langdata.Owner-Utility-List') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-plus-circle',
'name' => 'Create Owner Utility',
'route' => route('backend.owner-utility.create'),
])
@endsection


<div class="row">
    <div class="col-12">
        <div class="card p-3">
            @yield('table_header')
            <div class="card-body">
                <div class="table-responsive text-break">
                    <table id="datatables-reponsive" class="table table-bordered table-sm text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('langdata.invoice_no')</th>
                                <th>@lang('langdata.renter_name')</th>
                                <th>@lang('langdata.floor')</th>
                                <th>@lang('langdata.unit')</th>
                                <th>@lang('langdata.month')</th>
                                <th>@lang('langdata.year')</th>
                                <th>@lang('langdata.total_utility')</th>
                                <th>@lang('langdata.action') </th>


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


                                <td class="table-action">
                                    <a href="{{ route('backend.owner-utility.edit', $row) }}">
                                        <button class="btn btn-sm btn-info"> <i class="fa fa-pencil" aria-hidden="true"></i> </button>

                                    </a>
                                    <a data-href="{{ route('backend.owner-utility.destroy', $row) }}" href="#" class="delete_check">
                                        <button class="btn btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </button>

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
