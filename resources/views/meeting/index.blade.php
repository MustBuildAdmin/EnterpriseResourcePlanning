@extends('layouts.admin')

@section('page-title')
    {{__('Manage Meeting')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Meeting')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
    @can('create meeting')
            <a href="#" data-url="{{ route('meeting.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Meeting')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>

        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Meeting title')}}</th>
                                <th>{{__('Meeting Date')}}</th>
                                <th>{{__('Meeting Time')}}</th>
                                @if(Gate::check('edit meeting') || Gate::check('delete meeting'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($meetings as $meeting)
                                <tr>

                                    <td>{{ $meeting->title }}</td>
                                    <td>{{  \Auth::user()->dateFormat($meeting->date) }}</td>
                                    <td>{{  \Auth::user()->timeFormat($meeting->time) }}</td>
                                    @if(Gate::check('edit meeting') || Gate::check('delete meeting'))
                                        <td>
                                            @can('edit meeting')
                                            <div class="action-btn bg-primary ms-2">

                                                <a href="#" data-url="{{ URL::to('meeting/'.$meeting->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Meeting')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                                @endcan
                                            @can('delete meeting')
                                            <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['meeting.destroy', $meeting->id],'id'=>'delete-form-'.$meeting->id]) !!}

                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$meeting->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>
                                            @endcan
                                        </td>
                                    @endif
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

@push('script-page')

    <script>

        $(document).ready(function () {
            var b_id = $('#branch_id').val();
            getDepartment(b_id);
        });
        $(document).on('change', 'select[name=branch_id]', function () {

            var branch_id = $(this).val();
            getDepartment(branch_id);
        });

        function getDepartment(bid) {

            $.ajax({
                url: '{{route('meeting.getdepartment')}}',
                type: 'POST',
                data: {
                    "branch_id": bid, "_token": "{{ csrf_token() }}",
                },

                success: function (data) {
                    console.log(data);
                    $('#department_id').empty();

                    $("#department_div").html('');
                    $('#department_div').append('<select class="form-control" id="department_id" name="department_id[]"  multiple></select>');

                    $('#department_id').append('<option value="">{{__('Select Department')}}</option>');

                    $('#department_id').append('<option value="0"> {{__('All Department')}} </option>');
                    $.each(data, function (key, value) {
                        console.log(key, value);
                        $('#department_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    var multipleCancelButton = new Choices('#department_id', {
                        removeItemButton: true,
                    });


                }

            });
        }

        $(document).on('change', '#department_id', function () {
            var department_id = $(this).val();
            getEmployee(department_id);
        });

        function getEmployee(did) {

            $.ajax({
                url: '{{route('meeting.getemployee')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    console.log(data);
                    $('#employee_id').empty();

                    $("#employee_div").html('');
                    $('#employee_div').append('<select class="form-control" id="employee_id" name="employee_id[]"  multiple></select>');


                    $('#employee_id').append('<option value="">{{__('Select Employee')}}</option>');
                    $('#employee_id').append('<option value="0"> {{__('All Employee')}} </option>');

                    $.each(data, function (key, value) {
                        $('#employee_id').append('<option value="' + key + '">' + value + '</option>');
                    });

                    var multipleCancelButton = new Choices('#employee_id', {
                        removeItemButton: true,
                    });
                }
            });
        }
    </script>
@endpush
