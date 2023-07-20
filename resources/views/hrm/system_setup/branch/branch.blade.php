@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => ''])



<div class="row">
  <div class="col-md-6">
     <h2>Branch</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create branch')
        <a class="floatrght mb-3 btn  btn-primary" href="#" data-url="{{ route('branch.create') }}" data-ajax-popup="true" data-title="{{__('Create New Branch')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>


    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Branch')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($branches as $branch)
                    <tr>
                        <td>{{ $branch->name }}</td>
                        <td class="Action text-end">
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit branch')
                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('branch/'.$branch->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Branch')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                @endcan
                                @can('delete branch')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['branch.destroy', $branch->id],'id'=>'delete-form-'.$branch->id]) !!}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$branch->id}}').submit();"><i class="ti ti-trash text-white text-white"></i></a>
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