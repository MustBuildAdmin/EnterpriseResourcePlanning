@include('new_layouts.header')
<style>
.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
    width: 13%;
    float: right;
}
i.ti.ti-plus {
    color: #FFF !important;
}
</style>
<div class="page-wrapper">
    @include('crm.side-menu')
    <div class="row">
       <div class="col-md-6">
          <h2>{{__('Manage Pipelines')}}</h2>
       </div>
       <div class="col-md-6 float-end ">
          <a class="floatrght btn btn-sm btn-primary" href="#"
             data-size="md" data-url="{{ route('pipelines.create') }}" data-ajax-popup="true"
             data-bs-toggle="tooltip" title="{{__('Create New Pipeline')}}">
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
                            <th>{{__('Pipeline')}}</th>
                            <th>{{__('Action')}}</th>
                         </tr>
                      </thead>
                      <tbody>
                         @foreach ($pipelines as $pipeline)
                         <tr>
                            <td>{{ $pipeline->name }}</td>
                            <td class="Action">
                               <span>
                                  <div class="ms-2" style="display:flex;gap:10px;">
                                     @if(count($pipelines) > 1)
                                     @can('delete pipeline')
                                     {!! Form::open(['method' => 'DELETE',
                                         'route' => ['pipelines.destroy', $pipeline->id]]) !!}
                                     <a href="#" class="btn btn-md btn-danger bs-pass-para"
                                        data-bs-toggle="tooltip" title="{{__('Delete')}}">
                                     <i class="ti ti-trash text-white"></i>
                                     </a>
                                     {!! Form::close() !!}
                                     @endcan
                                     @endif
                                     @can('edit pipeline')
                                     <a href="#" class="btn btn-md"
                                        data-url="{{ URL::to('pipelines/'.$pipeline->id.'/edit') }}"
                                        data-ajax-popup="true" data-size="md"
                                        data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                        data-title="{{__('Edit Pipeline')}}">
                                     <i class="ti ti-pencil text-white"></i>
                                     </a>
                                     @endcan
                                  </div>
                               </span>
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