@include('new_layouts.header')
@include('hrm.hrm_main')

 

<div class="row">
  <div class="col-md-6">
     <h2>Performance Type</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    <a  class="floatrght mb-3 btn btn-sm btn-primary" href="#" data-url="{{ route('performanceType.create') }}" data-ajax-popup="true" data-title="{{__('Create New Performance Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
        {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
    </a>

  </div>
</div>





    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col" class="">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($types as $type)
                    <tr class="font-style">
                        <td>{{ $type->name }}</td>
                        <td class="">
                            <div class="ms-2" style="display:flex;gap:10px;">
                                <a href="#" data-url="{{ route('performanceType.edit',$type->id) }}" data-ajax-popup="true" title="{{__('Edit')}}" data-title="{{__('Edit Performance Type')}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                    <i class="ti ti-pencil text-white"></i>
                                </a>

                                {!! Form::open(['method' => 'DELETE', 'route' => ['performanceType.destroy', $type->id],'id'=>'delete-form-'.$type->id]) !!}
                                    <a href="#!" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$type->id}}').submit();">
                                        <i class="ti ti-trash text-white"></i>
                                    </a>
                                {!! Form::close() !!}
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
