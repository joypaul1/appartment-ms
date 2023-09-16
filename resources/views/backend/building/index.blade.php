@extends('backend.layout.app')
@include('backend._partials.delete_alert')
@push('css')
@endpush
@section('content')
@section('page-header')
<i class="fa fa-list"></i> Owner List
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-plus-circle',
'name' => 'Create Owner',
'route' =>route('backend.owner.create'),
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
                            <th>Sl.</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $key=>$row)
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
                            <td>
                                {{ $row->address }}
                            </td>
                            <td>
                                {{ $row->status == 1? 'Active':'Deactive' }}

                                {{-- @foreach (optional($row->units)->pluck('name') as $unitName)
                                {{ $unitName }}
                                @endforeach --}}

                            </td>


                            <td class="table-action">
                                <a href="{{ route('backend.site-config.building.edit', $row) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-edit-2 align-middle">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                                <a data-href="{{ route('backend.site-config.building.destroy', $row) }}" href="#" class="delete_check">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-trash align-middle">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
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