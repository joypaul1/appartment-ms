@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
Book Room
@stop
@section('table_header')
@include('backend._partials.page_header', [
'fa' => 'fa fa-list',
'name' => 'All Bookings',
'modelName' => 'create_data',
'route' =>'#',
])
@endsection
@yield('table_header')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="row g-3 needs-validation" novalidate>
                    <div class="col-md-3">
                        @include('components.backend.forms.select2.option', [
                        'name' => 'room_type',
                        'label' => 'Room Type',
                        'optionData' => [],
                        'inType' => 'date',
                        'required' => true,
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.input.input-date-range', [
                        'name' => 'Check In - Check Out Date',
                        'label' => 'Check In - Check Out Date ',
                        'placeholder' => 'Select Date',
                        'required' => true,
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.backend.forms.input.input-type', [
                        'name' => 'room_count',
                        'label' => 'Room',
                        'inType' => 'number',
                        'placeholder' => 'How many room you want?',
                        'required' => true,
                        ])
                    </div>
                    <div class="col-1">
                        <button class="btn btn-primary py-2 mt-4 w-full" type="submit">
                            <i class="fa fa-search"></i>
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between border-bottom pb-3">
                    <span href="#" style="font-size: 18px;font-weight:700">
                        Booking Information
                    </span>
                </div>

                <div class="d-flex mt-3 mb-2" style="gap: 14px;">
                    <div class="d-flex align-items-center" style="gap: 4px;">
                        <div class="bg-danger" style="width: 15px; height: 15px; border-radius: 50%;"></div> <span>Not Available</span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 4px;">
                        <div class="bg-success" style="width: 15px; height: 15px; border-radius: 50%;"></div> <span>Selected</span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 4px;">
                        <div class="bg-primary" style="width: 15px; height: 15px; border-radius: 50%;"></div> <span>Available</span>
                    </div>
                </div>
                <div class="alert alert-info alert-dismissible mt-4" role="alert">
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                    <div class="alert-message">
                        <p class="mb-0">Every room can be select or deselect by a single click without booked room. Make sure that selected rooms in each date is equal to the number of rooms you have searched.</p>
                    </div>
                </div>

                <table class="table table-bordered w-full">
                    <thead class="bg-info text-light">
                        <tr>
                            <th>Date</th>
                            <th>Room</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                12 Sept, 2023 - 13 Sept, 2023
                            </td>

                            <td>
                                <button class="btn btn-pill btn-success">102</button>
                                <button class="btn btn-pill btn-primary">103</button>
                                <button class="btn btn-pill btn-primary">104</button>
                                <button class="btn btn-pill btn-primary">106</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                12 Sept, 2023 - 13 Sept, 2023
                            </td>

                            <td>
                                <button class="btn btn-pill btn-primary">102</button>
                                <button class="btn btn-pill btn-primary">103</button>
                                <button class="btn btn-pill btn-success">104</button>
                                <button class="btn btn-pill btn-primary">106</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between border-bottom pb-3">
                    <span href="#" style="font-size: 18px;font-weight:700">
                        Book Room
                    </span>
                </div>

                <form action="">
                    <div class="mt-3">
                        <label for="address">Guest Type</label>
                        <select class="form-control">
                            <option value="">Select Guest Type</option>
                            <option value="">Walk-In Guest</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name">
                    </div>
                    <div class="mt-3">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter Phone">
                    </div>
                    <div class="mt-3">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Enter Email">
                    </div>
                    <div class="mt-3">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" rows="2"></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="address">Payment</label>
                        <select class="form-control">
                            <option value="">Select Payment</option>
                            <option value="">Cash</option>
                            <option value="">Card</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">
                        
                    </button>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })

        flatpickr(".flatpickr-range", {
            mode: "range"
            , dateFormat: "Y-m-d"
        });
    });

</script>
@endpush
