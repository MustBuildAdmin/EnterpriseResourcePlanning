@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => ''])


<div class="row">
  <div class="col-md-6">
     <h2>Designation</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create designation')
        <a class="floatrght mb-3 btn  btn-primary" href="#" data-url="{{ route('designation.create') }}" data-ajax-popup="true" data-title="{{__('Create New Designation')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan  

  </div>
</div>


    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Department')}}</th>
                    <th>{{__('Designation')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($designations as $designation)
                    @php
                        $department = \App\Models\Department::where('id', $designation->department_id)->first();
                    @endphp
                    <tr>
                        <td>{{ !empty($department->name)?$department->name:'' }}</td>
                        <td>{{ $designation->name }}</td>

                        <td class="Action">
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit designation')
                                    <a href="#" class="btn btn-md bg-primary" data-url="{{route('designation.edit',$designation->id) }}" data-ajax-popup="true" data-title="{{__('Edit Designation')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="ti ti-pencil text-white"></i>
                                    </a>
                                @endcan

                                @can('delete designation')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['designation.destroy', $designation->id],'id'=>'delete-form-'.$designation->id]) !!}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$designation->id}}').submit();">
                                            <i class="ti ti-trash text-white"></i>
                                        </a>
                                    {!! Form::close() !!}
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
@include('new_layouts.footer')