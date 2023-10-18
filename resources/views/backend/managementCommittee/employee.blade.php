@extends('backend.layout.app')
@include('backend._partials.delete_alert')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-list"></i> {{ ('title.Management-Committe-List') }}
@stop
@section('table_header')
@include('backend._partials.page_header', [
// 'fa' => 'fa fa-plus-circle',
// 'name' => 'Create Management-Committe',
// 'route' =>route('backend.management-committee.create'),
])
@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            @yield('table_header')
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatables-reponsive" class="table text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('table.sl')</th>
                                <th>@lang('table.name')</th>
                                <th>@lang('table.image') </th>
                                <th>@lang('table.email') </th>
                                <th>@lang('table.mobile') </th>
                                <th>@lang('table.member_type') </th>

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
                                    <img src="{{ asset($row->image) }}" alt="" style="width: 50px;height:50px;border-radius:50%" srcset="">
                                </td>
                                <td>
                                    {{ $row->email }}
                                </td>
                                <td>
                                    {{ $row->mobile }}
                                </td>


                                </td>
                                <td>
                                    {{ optional($row->memberType)->name }}
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
