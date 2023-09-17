@extends('backend.layout.app')
@push('css')
@endpush
@section('content')

@section('page-header')
    <i class="fa fa-list"></i> {{ __('title.Complain-List') }}
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
                <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            th>@lang('table.sl')</th>
                            <th>@lang('table.title')</th>
                            <th>@lang('table.date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($complains as $key => $row)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $row->title }}
                                </td>
                                <td>
                                    {{ date('d-m-y', strtotime($row->date)) }}
                                </td>
                                {{-- <td>
                                    {{ $row->status }}
                                </td> --}}
                                {{-- <td>
                            {{ $row->status }}
                        </td> --}}



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
