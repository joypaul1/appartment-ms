@extends('backend.layout.app')

@section('content')
    @push('css')

        <link rel="stylesheet" href="{{ asset('assets/backend') }}/vendor/select2/select2.css" />
        <link rel="stylesheet" href="{{ asset('assets/backend') }}/css/main.css">

    @endpush
@section('page-header')
    <i class="fa fa-info-circle"></i> Setting Information
@stop

@section('content')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-info-circle',
    ])

    <form class="needs-validation" action="{{ route('backend.site-config.system.store') }}" method="Post"
        enctype="multipart/form-data">
        @method('POST')
        @csrf
        <div class="card">
            <div class="card-body row">
                <div class="col-lg-6">
                    <div class="form-validation">
                        <div class="form-group">
                            @include('components.backend.forms.input.input-type', [
                                'name' => 'name',
                                'value' => old('name', $siteInfo->name),
                                'placeholder' => ' Name will be here...',
                                'required' => 'yes',
                            ])
                            @include('components.backend.forms.input.errorMessage', [
                                'message' => $errors->first('name'),
                            ])
                        </div>

                        <div class="form-group">
                            @include('components.backend.forms.input.input-type', [
                                'name' => 'email',
                                'value' => old('email', $siteInfo->email),
                                'placeholder' => 'Email will be here...',
                                'required' => 'yes',
                            ])
                            @include('components.backend.forms.input.errorMessage', [
                                'message' => $errors->first('email'),
                            ])
                        </div>
                        <div class="form-group">
                            @include('components.backend.forms.input.input-type', [
                                 'name' => 'mobile','number' =>true,
                                'value' => old('mobile', $siteInfo->mobile),
                                'placeholder' => 'Mobile will be here...',
                                'required' => 'yes',
                            ])
                            @include('components.backend.forms.input.errorMessage', [
                                'message' => $errors->first('mobile'),
                            ])

                        </div>
                        <div class="form-group">
                            @include('components.backend.forms.input.input-type', [
                                'name' => 'logo',
                                'inType' => 'file',
                                'placeholder' => 'logo  will be here...',
                                // 'required' => 'yes',
                            ])
                            @include('components.backend.forms.input.errorMessage', [
                                'message' => $errors->first('logo'),
                            ])
                        </div>




                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-validation">



                        <div class="form-group">
                            <label class=" col-form-label" for="country">Country <span class="text-danger">*</span>
                            </label>
                            <select class="form-control show-tick ms select2" id="country" name="country"
                                data-placeholder="Select" required>
                                @forelse ($countries as $countrieskey=>$country)
                                    <option value="{{ $country['name'] }}"
                                        {{ $siteInfo->country == $country['name'] ? 'Selected' : ' ' }}>
                                        {{ $country['name'] }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label class=" col-form-label" for="country">Default currency <span
                                    class="text-danger">*</span> </label>
                            <select class="form-control show-tick ms select2" id="currency" name="currency"
                                data-placeholder="Select" required>
                                @forelse ($currencies as $currencykey=>$currency)
                                    <option value="{{ $currency['name'] }}"
                                        {{ $siteInfo->currency == $currency['name'] ? 'Selected' : ' ' }}>
                                        {{ $currency['name'] }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            @include('components.backend.forms.input.input-type', [
                                'name' => 'currency_symbol',
                                'value' => old('name', $siteInfo->currency_symbol),
                                'placeholder' => 'currency symbol(Ex:$,৳)...',
                                'required' => 'yes',
                            ])
                            @include('components.backend.forms.input.errorMessage', [
                                'message' => $errors->first('currency_symbol'),
                            ])
                        </div>

                        <div class="form-group">
                            <label for="currency_symbol_placement">Currency Symbol Placement:</label>
                            <select class="form-control select2" required id="currency_symbol_placement"
                                name="currency_symbol_placement">
                                <option value="before" {{ $siteInfo->currency_symbol_placement == 'before' ? 'selected' : ' ' }}>
                                    Before amount</option>
                                <option value="after" {{ $siteInfo->currency_symbol_placement == 'after' ? 'selected' : ' ' }}>
                                    After amount</option>
                            </select>
                        </div>




                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection


@push('js')

    <script src="{{ asset('assets/backend') }}/vendor/select2/select2.min.js"></script>

    <script>
        $("#country").select2();
        $("#currency").select2();
        $("#dateTimeZone").select2();
    </script>
