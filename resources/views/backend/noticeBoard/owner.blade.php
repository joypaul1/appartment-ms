@extends('backend.layout.app')
@push('css')
@endpush
@section('content')

@section('page-header')
<i class="fa fa-list"></i> {{ __('langdata.Complain-List') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
// 'fa' => 'fa fa-plus-circle',
// 'name' => 'Create Complain',
// 'route' => route('backend.complain.create'),
])
@endsection


<div class="row">
    <div class="col-12">
        <div class="card p-3">
            @yield('table_header')
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatables-reponsive" class="table table-bordered table-sm text-center" style="width:100%">
                        <thead>
                            <tr>
                                th>@lang('langdata.sl')</th>
                                <th>@lang('langdata.langdata.)</th>
                                <th>@lang('langdata.date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complains as $key => $row)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $row->langdata.}}
                                </td>
                                <td>
                                    {{ date('d-m-y', strtotime($row->date)) }}
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
