@include('new_layouts.header')
@include('crm.side-menu')
<style>
i.ti.ti-plus {
    color: #FFF !important;
}
#edit,#view {
    background: unset !important;
}
</style>
<link rel="stylesheet" href="{{asset('css/summernote/summernote-lite.css')}}">
<div class="page-wrapper">
    <div class="row">
       <div class="col-md-6">
          <h2>{{__('Manage Leads')}}</h2>
       </div>
       <div class="col-auto ms-auto d-print-none">
            <div class="input-group-btn">
                <a href="{{ route('leads.index') }}" data-bs-toggle="tooltip"
                    title="{{__('Kanban View')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-layout-grid"></i>
                </a>
                <a href="#" data-size="lg" data-url="{{ route('leads.create') }}"
                    data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New User')}}"
                    class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
                </a>
            </div>
        </div>
    </div>
    @if($pipeline)
    <div class="row">
       <div class="col-xl-12">
          <div class="card">
             <div class="card-body table-border-style">
                <div class="table-responsive">
                   <table class="table datatable" aria-describedby="directions">
                      <thead>
                         <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Subject')}}</th>
                            <th>{{__('Stage')}}</th>
                            <th>{{__('Users')}}</th>
                            <th>{{__('Action')}}</th>
                         </tr>
                      </thead>
                      <tbody>
                         @foreach ($leads as $lead)
                         <tr>
                            <td>{{ $lead->name }}</td>
                            <td>{{ $lead->subject }}</td>
                            <td>{{  !empty($lead->stage)?$lead->stage->name:'-' }}</td>
                            <td>
                               @foreach($lead->users as $user)
                               <a href="#" class="btn btn-sm mr-1 p-0 rounded-circle">
                               <img alt="image" data-toggle="tooltip"
                                    data-original-title="{{$user->name}}"
                                    @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}"
                                    @else src="{{asset('/storage/uploads/avatar/avatar.png')}}"
                                    @endif class="rounded-circle " width="25" height="25">
                               </a>
                               @endforeach
                            </td>
                            @if(Auth::user()->type != 'client')
                            <td class="Action">
                               <div class="ms-2" style="display:flex;gap:10px;">
                                  @can('view lead')
                                  @if($lead->is_active)
                                  <a id="view" href="{{route('leads.show',$lead->id)}}"
                                     class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                     data-size="xl" data-bs-toggle="tooltip" title="{{__('View')}}"
                                     data-title="{{__('Lead Detail')}}">
                                  <i class="ti ti-eye text-white"></i>
                                  </a>
                                  @endif
                                  @endcan
                                  @can('edit lead')
                                  <a id="edit" href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                     data-url="{{ route('leads.edit',$lead->id) }}"
                                     data-ajax-popup="true" data-size="xl"
                                     data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Lead Edit')}}">
                                  <i class="ti ti-pencil text-white"></i>
                                  </a>
                                  @endcan
                                  @can('delete lead')
                                  {!! Form::open(['method' => 'DELETE', 'route' => ['leads.destroy', $lead->id],
                                  'id'=>'delete-form-'.$lead->id]) !!}
                                  <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                     data-bs-toggle="tooltip" title="{{__('Delete')}}" >
                                     <i class="ti ti-trash text-white"></i>
                                  </a>
                                  {!! Form::close() !!}
                                  @endif
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
       </div>
    </div>
    @endif
 </div>
@include('new_layouts.footer')
<script src="{{asset('css/summernote/summernote-lite.js')}}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script>
    $(document).on("change", ".change-pipeline select[name=default_pipeline_id]", function () {
        $('#change-pipeline').submit();
    });
</script>