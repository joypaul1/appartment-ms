@extends('backend.layout.app')
@include('backend._partials.delete_alert')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-list"></i> {{ __('langdata.visitor_list') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-plus-circle',
'name' =>  __('langdata.visitor_create'),
'route' =>route('backend.visitor.create'),
])
@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <div class="table-responsive text-break">
                    <table id="datatables-reponsive" class="table table-bordered table-sm text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('langdata.sl')</th>
                                <th>@lang('langdata.entry_date')</th>
                                <th>@lang('langdata.name')</th>
                                <th>@lang('langdata.mobile')</th>
                                <th>@lang('langdata.address')</th>
                                <th>@lang('langdata.unit')</th>
                                <th>@lang('langdata.in_time')</th>
                                <th>@lang('langdata.out_time')</th>
                                <th>@lang('langdata.action')</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $key=>$row)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>
                                    {{ date('d-m-y', strtotime($row->date)) }}
                                </td>
                                <td>
                                    {{ $row->name }}
                                </td>

                                <td>
                                    {{ $row->mobile }}
                                </td>
                                <td>
                                    {{ $row->address }}
                                </td>

                                <td>
                                    {{ optional($row->unit)->name }}

                                </td>
                                <td>
                                    {{ $row->in_time }}
                                </td>
                                <td>
                                    {{ $row->out_time }}
                                </td>

                                <td class="table-action">
                                    <a data-href="{{ route('backend.visitor.destroy', $row) }}" href="#" class="delete_check">
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
