@extends('backend.layout.app')
@push('css')
@endpush
@section('content')
@section('page-header')
    <i class="fa fa-pencil"></i> {{ __('langdata.Edit-Employee-Salary') }} Edit Employee Salary
@stop
@section('table_header')
    @include('backend._partials.page_header', [
        'fa' => 'fa fa-list',
        'name' => __('langdata.Employee-Salary-List'),
        'route' => route('backend.employee.index'),
    ])
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">

            @yield('table_header')
            <div class="card-body">
                <form action="{{ route('backend.employee-salary.update', $employeeSalary) }}" method="POST"
                    class="row g-3" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'employee_id',
                            'label' => 'Select Employee',
                            'required' => true,
                            'optionData' => $employees,
                            'selectedKey' => $employeeSalary->employee_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('status'),
                        ])
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'month_id',
                             'label' =>__('langdata.month'),
                            'required' => true,
                            'optionData' => $months,
                            'selectedKey' => $employeeSalary->employee_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('month_id'),
                        ])
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        @include('components.backend.forms.select2.option', [
                            'name' => 'year_id',
                            'label' => 'year',
                            'required' => true,
                            'optionData' => $years,
                            'selectedKey' => $employeeSalary->employee_id,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('year_id'),
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'date',
                           'name' =>'issue_date', 'label' =>__('langdata.issue_date'),
                            'required' => true,
                            'value' => $employeeSalary->issue_date,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('issue_date'),
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.backend.forms.input.input-type', [
                            'inType' => 'number',
                            'name' => 'salary',
                            'required' => true,
                            'value' => $employeeSalary->amount,
                        ])
                        @include('components.backend.forms.input.errorMessage', [
                            'message' => $errors->first('salary'),
                        ])
                    </div>


                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">@lang('button.update_data')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $('#Employeeid').on('change', function(e) {
        e.preventDefault();
        let url = "{{ route('backend.employee.index') }}"
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'JSON',
            data: {
                'Employeeid': e.target.value,
                'getSalary': true
            },

            success: function(res) {
                $("#salary").val(0);
                $("#salary").val(res.data);
                // $.map( res.data, function( val, i ) {
                //     var newOption = new Option(val.name, val.id, false, false);
                //     $('#salary').append(newOption).trigger('change');

                // });
            },
            error: function(jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                console.log(msg);
            },
        });

    });
</script>
@endpush
