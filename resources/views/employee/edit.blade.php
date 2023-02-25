@extends('layouts.admin')
@section('page-title')
    {{__('Edit Employee')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></li>
    <li class="breadcrumb-item">{{$employeesId}}</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            {{ Form::model($employee, array('route' => array('employee.update', $employee->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data', 'id'=>'employee_edit_form')) }}
            @csrf
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card emp_details">
                <div class="card-header"><h6 class="mb-0">{{__('Personal Detail')}}</h6></div>
                <div class="card-body employee-detail-edit-body">

                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('name', __('Name'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 35 ,'required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('phone', __('Phone'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::number('phone',null, ['class' => 'form-control','maxlength' => 35,'required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-6">

                            {!! Form::label('dob', __('Date of Birth'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::date('dob', null, ['class' => 'form-control','required' => 'required']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('gender', __('Gender'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                            <div class="d-flex radio-check mt-2">
                                <div class="form-check form-check-inline form-group">
                                    <input type="radio" id="g_male" value="Male" required name="gender" class="form-check-input" {{($employee->gender == 'Male')?'checked':''}}>
                                    <label class="form-check-label" for="g_male">{{__('Male')}}</label>
                                </div>
                                <div class="form-check form-check-inline form-group">
                                    <input type="radio" id="g_female" value="Female" required name="gender" class="form-check-input" {{($employee->gender == 'Female')?'checked':''}}>
                                    <label class="form-check-label" for="g_female">{{__('Female')}}</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('address', __('Address'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::textarea('address',null, ['class' => 'form-control','required' => 'required','rows'=>2]) !!}
                    </div>
                    @if(\Auth::user()->type=='employee')
                        {!! Form::submit('Update', ['class' => 'btn-create btn-xs badge-blue radius-10px float-right']) !!}
                    @endif
                </div>
            </div>
        </div>
        @if(\Auth::user()->type!='employee')
            <div class="col-md-6 ">
                <div class="card emp_details">
                    <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                            <div class="form-group col-md-12">
                                {!! Form::label('employee_id', __('Employee ID'),['class'=>'form-label']) !!}
                                {!! Form::text('employee_id',$employeesId, ['class' => 'form-control','disabled'=>'disabled']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {{ Form::label('branch_id', __('Branch'),['class'=>'form-label']) }}<span class="text-danger pl-1">*</span>
                                {{ Form::select('branch_id', $branches,null, array('class' => 'form-control select','required'=>'required','id' => 'branch_id')) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('department_id', __('Department'),['class'=>'form-label']) }}<span class="text-danger pl-1">*</span>
                                <select class=" select form-control " id="department_id" name="department_id"  required>
{{--                                    <option value="">{{__('Select any Department')}}</option>--}}
                                    @foreach($departmentData as $key=>$val )
                                        <option value="{{$key}}" {{$key==$employee->department_id?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('designation_id', __('Designation'),['class'=>'form-label']) }}<span class="text-danger pl-1">*</span>
                                <select class="select form-control " id="designation_id" name="designation_id" required ></select>

                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('company_doj', 'Company Date Of Joining',['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::date('company_doj', null, ['class' => 'form-control ','required' => 'required']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6 ">
                <div class="employee-detail-wrap ">
                    <div class="card emp_details">
                        <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Branch')}}</strong>
                                        <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Department')}}</strong>
                                        <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Designation')}}</strong>
                                        <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Date Of Joining')}}</strong>
                                        <span>{{\Auth::user()->dateFormat($employee->company_doj)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if(\Auth::user()->type!='employee')
        <div class="row">
            <div class="col-md-6 ">
                <div class="card emp_details">
                    <div class="card-header"><h6 class="mb-0">{{__('Document')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        @php
                            $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                        @endphp

                        @foreach($documents as $key=>$document)
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="float-left col-4">
                                        <label for="document" class="float-left pt-1 form-label">{{ $document->name }} @if($document->is_required == 1) <span class="text-danger">*</span> @endif</label>
                                    </div>
                                    <div class="float-right col-4">
                                        <input type="hidden" name="emp_doc_id[{{ $document->id}}]" id="" value="{{$document->id}}">
                                        <div class="choose-file form-group">
                                            <label for="document[{{ $document->id }}]">
                                                <input class="form-control @if(!empty($employeedoc[$document->id])) float-left @endif @error('document') is-invalid @enderror border-0" @if($document->is_required == 1 && empty($employeedoc[$document->id]) ) required @endif name="document[{{ $document->id}}]"  onchange="document.getElementById('{{'blah'.$key}}').src = window.URL.createObjectURL(this.files[0])" type="file"  data-filename="{{ $document->id.'_filename'}}">
                                            </label>
                                            <p class="{{ $document->id.'_filename'}}"></p>

                                            @php
                                                $logo=\App\Models\Utility::get_file('uploads/document/');
                                            @endphp

{{--                                            <img id="{{'blah'.$key}}" src=""  width="25%" />--}}
                                            <img id="{{'blah'.$key}}" src="{{ (isset($employeedoc[$document->id]) && !empty($employeedoc[$document->id])?$logo.'/'.$employeedoc[$document->id]:'') }}"  width="25%" />

                                        </div>


{{--                                        @if(!empty($employeedoc[$document->id]))--}}
{{--                                            <br> <span class="text-xs"><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a>--}}
{{--                                                    </span>--}}
{{--                                        @endif--}}
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card emp_details">
                    <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                {!! Form::label('account_holder_name', __('Account Holder Name'),['class'=>'form-label']) !!}
                                {!! Form::text('account_holder_name', null, ['class' => 'form-control']) !!}

                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('account_number', __('Account Number'),['class'=>'form-label']) !!}
                                {!! Form::number('account_number', null, ['class' => 'form-control']) !!}

                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('bank_name', __('Bank Name'),['class'=>'form-label']) !!}
                                {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}

                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('bank_identifier_code', __('Bank Identifier Code'),['class'=>'form-label']) !!}
                                {!! Form::text('bank_identifier_code',null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('branch_location', __('Branch Location'),['class'=>'form-label']) !!}
                                {!! Form::text('branch_location',null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('tax_payer_id', __('Tax Payer Id'),['class'=>'form-label']) !!}
                                {!! Form::text('tax_payer_id',null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card emp_details">
                        <div class="card-header"><h6 class="mb-0">{{__('Document Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                @php
                                    $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                                @endphp
                                @foreach($documents as $key=>$document)
                                    <div class="col-md-12">
                                        <div class="info">
                                            <strong>{{$document->name }}</strong>
                                            <span><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card emp_details">
                        <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Account Holder Name')}}</strong>
                                        <span>{{$employee->account_holder_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Account Number')}}</strong>
                                        <span>{{$employee->account_number}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Bank Name')}}</strong>
                                        <span>{{$employee->bank_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Bank Identifier Code')}}</strong>
                                        <span>{{$employee->bank_identifier_code}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Branch Location')}}</strong>
                                        <span>{{$employee->branch_location}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Tax Payer Id')}}</strong>
                                        <span>{{$employee->tax_payer_id}}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(\Auth::user()->type != 'employee')
        <div class="row">
            <div class="col-12">
                <input type="submit" value="{{__('Update')}}" class="btn btn-primary float-end">
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('script-page')

    <script type="text/javascript">
    
        // $("#employee_edit_form").validate();
        // $(document).on("click", 'input[type=submit]', function () {
        //     $(this).closest('form').validate();
        // });
        $(document).on('change', '#branch_id', function() {
            var branch_id = $(this).val();
            getDepartment(branch_id);
        });

        function getDepartment(branch_id)
        {
            var data = {
                "branch_id": branch_id,
                "_token": "{{ csrf_token() }}",
            }

            $.ajax({
                url: '{{ route('employee.getdepartment') }}',
                method: 'POST',
                data: data,
                success: function(data) {
                    $('#department_id').empty();
                    $('#department_id').append('<option value="" disabled>{{ __('Select any Department') }}</option>');

                    $.each(data, function(key, value) {
                        $('#department_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    $('#department_id').val('');
                }
            });
        }
    </script>
    <script type="text/javascript">

        function getDesignation(did) {
            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">Select any Designation</option>');
                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                    });
                }
            });
        }

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '{{ $employee->designation_id }}';
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

    </script>
    
@endpush
