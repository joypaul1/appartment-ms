@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <style>
        .ui-autocomplete {
            position: absolute;
            cursor: default;
            z-index: 99999999999999 !important
        }

        .product-grid-container {
            display: grid;
            grid-template-columns: 1fr;
        }

        .tb-active {
            background: green !important;
        }

        @media (min-width: 768px) {
            .product-grid-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
            }
        }
    </style>
@endpush

<div>
    <div class="row">
        <div class="card d-flex  mt-5">
            <div class="header">
                <span href="#" style="font-size: 18px;font-weight:700">
                    <i class="fa fa-desktop"></i> Dialysis Point OF Sell (POS)
                </span>

                <div class="pull-right">
                    <a href="{{ url('admin/dialysis/pos') }}">
                        <button class="btn btn-warning text-white btn-md mr-1" onclick="deleteAll()">New Sale</button>
                    </a>
                    <a href="{{ route('backend.dialysis.order.order-list-delivered.index') }}" target="_blank"><button
                            class="btn btn-success btn-md mr-1">Order List</button></a>
                    <a href="{{ route('backend.dashboard.index') }}" target="_blank"><button
                            class="btn btn-info btn-md mr-1">Home</button></a>

                </div>
            </div>
        </div>


        <div class="col-lg-7">
            <div class="card border-top">
                <div class="body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                </div>
                                @include('components.backend.forms.input.input-type2', [
                                    'name' => 'user_id',
                                    'placeholder' => 'Customer Name/Mobile num..',
                                    'value' => $userDetails,
                                    'required' => true,
                                ])

                                <div class="input-group-prepend">
                                    <span class="input-group-text" data-toggle="modal" data-target="#custModal"
                                        style="cursor:pointer;" aria-hidden="true">
                                        <i class="fa fa-plus" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search-plus"
                                            aria-hidden="true"></i></span>
                                </div>
                                @include('components.backend.forms.input.input-type2', [
                                    'name' => 'product_name',
                                    'placeholder' => 'Enter Product Name / SKU',
                                    'required' => true,
                                ])

                                <div class="input-group-prepend">
                                    <span class="input-group-text" data-toggle="modal" data-target="#product-add-modal">
                                        <i class="fa fa-plus" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table ellspacing='0' class="table table-bordered text-center pos-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Sub Total</th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($basket as $itemId=>$item)
                                    <livewire:backend.pos.component.cart-item :item="$item" :itemId="$itemId"
                                        wire:key="{{ $loop->index }}" />
                                @empty
                                @endforelse


                            </tbody>
                        </table>

                        <table class="table table-bordered text-center mt-5">
                            <tbody>
                                <tr>

                                    <td colspan="3" class="text-center">
                                        <b>Qty:</b>&nbsp;
                                        <span class="mr-5">{{ number_format($this->itemQty ?? 0, 2) }}</span>
                                        <b>Items:</b>&nbsp;
                                        <span class="mr-5">{{ number_format($this->itemCount ?? 0, 2) }}</span>
                                        <b>Subtotal:</b> &nbsp;
                                        <strong
                                            class="sub_total">{{ number_format($this->cartSubTotal ?? 0, 2) }}</strong>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            Discount (-): <i class="fa fa-pencil-square-o" style="cursor:pointer;"
                                                data-toggle="modal" data-target="#discountModal" style="cursor:pointer;"
                                                aria-hidden="true"></i>
                                        </strong>
                                        <span
                                            id="total_discount">{{ number_format($this->discount_amount ?? 0, 2) }}</span>
                                    </td>
                                    {{-- <td class="">
                                        <span>
                                            <b>Order Tax(+): <i class="fa fa-pencil-square-o" data-toggle="modal" data-target="#taxModal"
                                                    style="cursor:pointer;" aria-hidden="true"></i> </b>
                                            <span id="order_tax">{{ number_format($this->tax_amount ?? 0, 2) }}</span>
                                        </span>
                                    </td> --}}

                                </tr>

                            </tbody>
                            <tfoot>

                                <tr>
                                    <td colspan="3" class="text-right">
                                        <h6>
                                            <b>Total:</b> &nbsp;
                                            <strong class="total">{{ number_format($cartTotal ?? 0, 2) }}</strong>
                                        </h6>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 h-full mb-4">
            <div class="card border-top h-100">
                <div class="body h-100">
                    <h5>
                        Products Management
                    </h5>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-search-plus"
                                            aria-hidden="true"></i></span>
                                </div>
                                @include('components.backend.forms.select2.option2', [
                                    'label' => 'Category',
                                    'name' => 'product_subcategory',
                                    'optionData' => $this->subcategories,
                                ])


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-search-plus"
                                            aria-hidden="true"></i></span>
                                </div>
                                @include('components.backend.forms.select2.option2', [
                                    'name' => 'product_brand',
                                    'optionData' => $this->brands,
                                ])

                            </div>
                        </div>


                    </div>

                    <div class="product-grid-container">
                        @forelse ($items as $item)
                            <a href="#" wire:click="addToCard({{ $item->id }})">
                                <div class="card text-center h-100 d-flex justify-contnet-between"
                                    style="flex-direction: column;
                                display: flex !important;
                                justify-content: space-between;">
                                    <div>
                                        <img src="{{ asset($item->image) }}" class="card-img-top" alt="...">
                                        <div class="card-body" style="padding:.75em">
                                            <h6 class="card-title">{{ $item->name }}</h6>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <h6>{{ number_format($item->sell_price, 2) }} /
                                            {{ round(optional($item->itemCount)->available_qty) }}p
                                        </h6>
                                    </div>
                                </div>
                            </a>

                        @empty
                        @endforelse


                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row position-fixed fixed-bottom bg-white">
        <div class="col-12 text-center">
            <button type="button" wire:click="storeData('paid')" class="btn btn-info">
                <i class="fa fa-money"></i> Save &amp; Print
            </button>

            <button onclick="deleteAll()" type="button" class="btn btn-danger">
                <i class="fa fa-times"></i>Cancel
            </button>
        </div>
    </div>






    {{-- discount modal --}}

    <div wire:ignore.self class="modal fade" id="discountModal" data-backdrop="static" data-bs-keyboard="false"
        data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">{{ __('Discount') }}</h5>
                </div>
                <div class="modal-body" wire:ignore.self>
                    <form action="#">
                        <div class="mb-3 row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="contact_id">Discount:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa fa-info" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <input type="text" wire:model="discount" class="form-control"
                                            placeholder="Discount Amount">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="contact_id">Discount type:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa fa-info" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <select class="form-control" wire:change="discountCal($event.target.value)">
                                            <option value="{{ null }}" hidden>Please Select</option>
                                            <option value="fixed">Fixed</option>
                                            <option value="percentage">Percentage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="contact_id">Discount Amount:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa fa-info" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <input type="text" readonly wire:model="discount_amount"
                                            class="form-control" placeholder="Discount Amount">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>

    {{-- tax modal --}}

    <div wire:ignore.self class="modal fade" id="taxModal" data-backdrop="static" data-bs-keyboard="false"
        data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">{{ __('Tax') }}</h5>
                </div>
                <div class="modal-body" wire:ignore.self>
                    <form action="#">
                        <div class="mb-3 row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="contact_id">Tax(%):</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa fa-info" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <input type="text" wire:model="tax_percent"
                                            wire:keyup="taxCalculation($event.target.value)" class="form-control"
                                            placeholder="percent of tax/vat">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="contact_id">Tax Amount:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa fa-info" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <input type="text" readonly wire:model="tax_amount" class="form-control"
                                            placeholder="Tax Amount">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>

    {{-- custModal --}}
    <div wire:ignore class="modal fade" id="custModal" dta-backdrop="static" data-bs-keyboard="false"
        data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="needs-validation" id="patient_add_form">
                    @method('POST')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="">{{ __('Customer') }}</h5>
                        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">

                                    <label class="col-form-label" for="name">
                                        Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Enter Name" value="" autocomplete="off" required="">
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="form-group">

                                    <label class="col-form-label" for="mobile">

                                        Mobile

                                    </label>

                                    <input type="text" name="mobile" class="form-control" id="mobile"
                                        min="0" step="0.01" title="amount" pattern="^\d+(?:\.\d{1,2})?$"
                                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                        placeholder="Enter Mobile" value="" autocomplete="off">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    a




    @if ($invoice_url)
        <div wire:ignore.self class="modal fade" id="inv_modal" data-backdrop="static" data-bs-keyboard="false"
            data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">{{ __('Invoice') }}</h5>
                    </div>
                    <div class="modal-body">
                        <iframe src="{{ $invoice_url }}" frameborder="0" width="100%;" height="600px;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function openModal() {
                var myModal = new bootstrap.Modal(document.getElementById('inv_modal'));
                myModal.show();
            }
            openModal();
        </script>
    @endif

</div>


@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        let total = 0;
        $('#product_subcategory').on('change', function(e) {
            @this.set('subcategory_id', e.target.value);
            console.log(@this.set('subcategory_id', e.target.value));
        });
        $('#product_brand').on('change', function(e) {
            @this.set('brand_id', e.target.value);
        });
        // document.addEventListener('livewire:load', function () {
        $("#product_name").autocomplete({
            source: function(request, response) {
                var optionData = request.term;
                $.ajax({
                    method: 'GET',
                    url: "{{ route('backend.dialysis.itemConfig.item.index') }}",
                    data: {
                        'optionData': optionData
                    },
                    success: function(res) {
                        var resArray = $.map(res.data, function(obj) {
                            return {
                                value: obj.name, //Fillable in input field
                                value_id: obj.id, //Fillable in input field
                                label: 'Name:' + obj
                                    .name //Show as label of input fieldname: obj.name, sku: obj.sku
                            }
                        })
                        response(resArray);
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                @this.addToCard(ui.item.value_id)
            }
        });
        $("#user_id").autocomplete({
            source: function(request, response) {
                var optionData = request.term;
                $.ajax({
                    method: 'GET',
                    url: "{{ route('backend.patient.index') }}",
                    data: {
                        'optionData': optionData
                    },
                    success: function(res) {
                        var resArray = $.map(res.data, function(obj) {
                            return {
                                value: obj.name + '(' + obj.mobile +')', //Fillable in input field
                                value_id: obj.id, //for selected data
                                label: obj.name + ' mobile:' + obj
                                    .mobile, //Show as label of input fieldname: obj.name, mobile: obj.mobile
                            }
                        })
                        response(resArray);
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                console.log(ui.item.value_id);
                @this.userId = ui.item.value_id;
                @this.userDetails = ui.item.value;
            }
        });




        $(document).on('click', '.pos-table .increment', function(event) {
            @this.qtyCalculation('increment', $(this).attr("data-itemId"))

        });
        $(document).on('click', '.pos-table .decrement', function(event) {
            let getData = $(this).closest('.input-group').find('input[type=number]').val().replaceAll(',', '');
            if (Number(getData) > 1) {
                @this.qtyCalculation('decrement', $(this).attr("data-itemId"))
            }
        });



        function deleteItem(here, itemId) {
            here.parents('tr').fadeOut("normal", function() {
                $(this).remove();
            });

            @this.deleteItem(itemId)

        }

        function deleteAll() {
            $(".pos-table > tbody").fadeOut("normal").empty();
            @this.resetData()
        }

        $(document).on('submit', '#patient_add_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = "{{ route('backend.patient.store') }}";
            var method = "POST";
            var data = {
                name: form.find('#name').val(),
                mobile: form.find('#mobile').val(),

            };
            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    if (response.status_code == 200) {
                        @this.userId = response.data.id;
                        @this.userDetails = response.data.name;
                        $('#custModal').modal('hide');
                    }
                },
                error: function(response) {}
            });
        });
        window.addEventListener('alert', event => {
            toastr[event.detail.type](event.detail.message, event.detail.title ?? ''), toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
        });


        // $(document).on('change', '#tax_percent', function(e) {
        //     // taxCalculation();
        //     // console.log(23123);
        // });


        // function taxCalculation() {
        // let orderTaxRate = 0;
        // let $tax_data_type = $('#tax_id').find(':selected').data('type') || null;
        // let $tax_data_rate = $('#tax_id').find(':selected').data('rate') || 0;
        // if ($tax_data_type == 'percent') {
        // orderTaxRate = Number((Number(ordersubAmount.text()) * Number($tax_data_rate)) / 100);
        // } else if ($tax_data_type == 'flat') {
        //     orderTaxRate = Number($tax_data_rate);
        // }
        // console.log(orderTaxRate);
        // @this.set('tax_amount', orderTaxRate);
        // laravel livewire function call wire:model="tax_amount"
        // @this.tax_amount = orderTaxRate;
        // @this.taxRate(orderTaxRate)
        // }
    </script>
@endpush
