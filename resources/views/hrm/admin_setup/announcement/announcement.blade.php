@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="row">
  <div class="col-md-6">
     <h2>Announcement</h2>
  </div>
  <div class="col-md-6 float-end">

    @can('create announcement')
        <a class="floatrght mb-3 btn btn-primary" href="#" data-url="{{ route('announcement.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Announcement')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>


    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Start Date')}}</th>
                    <th>{{__('End Date')}}</th>
                    <th>{{__('description')}}</th>
                    @if(Gate::check('edit announcement') || Gate::check('delete announcement'))
                        <th>{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>{{  \Auth::user()->dateFormat($announcement->start_date) }}</td>
                        <td>{{  \Auth::user()->dateFormat($announcement->end_date) }}</td>
                        <td>{{ $announcement->description }}</td>
                        @if(Gate::check('edit announcement') || Gate::check('delete announcement'))
                            <td>
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit announcement')
                                        <a href="#" data-url="{{ URL::to('announcement/'.$announcement->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Announcement')}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    @endcan
                                    @can('delete announcement')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['announcement.destroy', $announcement->id],'id'=>'delete-form-'.$announcement->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$announcement->id}}').submit();">
                                                <i class="ti ti-trash text-white text-white"></i>
                                            </a>
                                        {!! Form::close() !!}
                                    @endcan
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
<script>
    //Branch Wise Deapartment Get
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
            url: '{{route('announcement.getdepartment')}}',
            type: 'POST',
            data: {
                "branch_id": bid, "_token": "{{ csrf_token() }}",
            },
            success: function (data) {
                $('#department_id').empty();
                $('#department_id').append('<option value="">{{__('Select Department')}}</option>');

                $('#department_id').append('<option value="0"> {{__('All Department')}} </option>');
                $.each(data, function (key, value) {
                    $('#department_id').append('<option value="' + key + '">' + value + '</option>');
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
            url: '{{route('announcement.getemployee')}}',
            type: 'POST',
            data: {
                "department_id": did, "_token": "{{ csrf_token() }}",
            },
            success: function (data) {

                $('#employee_id').empty();
                $('#employee_id').append('<option value="">{{__('Select Employee')}}</option>');
                $('#employee_id').append('<option value="0"> {{__('All Employee')}} </option>');

                $.each(data, function (key, value) {
                    $('#employee_id').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }
</script>
@include('new_layouts.footer')