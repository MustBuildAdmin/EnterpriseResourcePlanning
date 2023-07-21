@include('new_layouts.header')
@include('hrm.hrm_main')



<div class="row">
  <div class="col-md-6">
     <h2>Job Stage</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create job stage')
        <a class="floatrght mb-3 btn  btn-primary" href="#" data-url="{{ route('job-stage.create') }}" data-ajax-popup="true" data-title="{{__('Create New Job Stage')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>


    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{ __('Job Stage') }}</th>
                    @if(Gate::check('edit job stage') || Gate::check('delete job stage'))
                        <th>{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($stages as $stage)
                    <tr>
                        <td>{{$stage->title}}</td>
                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit job stage')
                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ route('job-stage.edit',$stage->id) }}" data-ajax-popup="true" data-title="{{__('Edit Job Stage')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                        <i class="ti ti-pencil text-white"></i>
                                    </a>
                                @endcan
                                @can('delete job stage')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['job-stage.destroy', $stage->id],'id'=>'delete-form-'.$stage->id]) !!}
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
