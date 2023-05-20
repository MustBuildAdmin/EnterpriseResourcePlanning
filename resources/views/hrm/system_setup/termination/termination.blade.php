@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => ''])



<div class="row">
  <div class="col-md-6">
     <h2>Termination Type</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create termination type')
        <a class="floatrght mb-3 btn btn-sm btn-primary" href="#" data-url="{{ route('terminationtype.create') }}" data-ajax-popup="true" data-title="{{__('Create New Termination Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>



                        
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Termination Type')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($terminationtypes as $terminationtype)
                    <tr>
                        <td>{{ $terminationtype->name }}</td>
                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit termination type')
                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('terminationtype/'.$terminationtype->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Document Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                        <i class="ti ti-pencil text-white"></i>
                                    </a>
                                @endcan

                                @can('delete termination type')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['terminationtype.destroy', $terminationtype->id],'id'=>'delete-form-'.$terminationtype->id]) !!}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white text-white"></i></a>
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