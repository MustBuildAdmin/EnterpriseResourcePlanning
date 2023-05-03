@include('new_layouts.header')
@include('hrm.hrm_main')

<div class="row">
  <div class="col-md-6">
     <h2>Job Category</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create job category')
        <a class="floatrght mb-3 btn btn-sm btn-primary" href="#" data-url="{{ route('job-category.create') }}" data-ajax-popup="true" data-title="{{__('Create New Job Category')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>


    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Category')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->title }}</td>
                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit job category')
                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ route('job-category.edit',$category->id) }}" data-ajax-popup="true" data-title="{{__('Edit Job Category')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                        <i class="ti ti-pencil text-white"></i>
                                    </a>
                                @endcan
                                @can('delete job category')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['job-category.destroy', $category->id],'id'=>'delete-form-'.$category->id]) !!}
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