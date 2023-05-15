@include('new_layouts.header')
<style>
.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
    width: 13%;
    float: right;
}
</style>

<div class="page-wrapper"> 
    @include('crm.side-menu')

    <div class="page-wrapper"> 


<div class="row">
  <div class="col-md-6">
     <h2>Sources</h2>
  </div>
  <div class="col-md-6 float-end ">
        <a class="floatrght btn btn-sm btn-primary" href="#" data-size="md" data-url="{{ route('sources.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Sources')}}" >
            <i class="ti ti-plus"></i>
        </a>
  </div>
</div>


    <div class="row">
        <div class="col-3">
            @include('layouts.crm_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Source')}}</th>
                                <th width="250px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($sources as $source)
                                    <tr>
                                        <td>{{ $source->name }}</td>
                                        <td class="Active">
                                            <div class="ms-2" style="display:flex;gap:10px;">
                                                @can('edit source')
                                                    <a href="#" class="btn btn-md " data-url="{{ URL::to('sources/'.$source->id.'/edit') }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Source')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                @endcan
                                                @can('delete source')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['sources.destroy', $source->id]]) !!}
                                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
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
        </div>
    </div>
@include('new_layouts.footer')