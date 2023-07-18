@include('new_layouts.header')

<style>
.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
    width: 13%;
    float: right;
}
i.ti.ti-plus {
    color: #FFF !important;
}
a#edit {
    background: unset !important;
}
</style>
<div class="row">
   <div class="col-md-6">
      <h2>{{__('Manage Labels')}}</h2>
   </div>
   <div class="col-md-6 float-end ">
      @can('create label')
      <div class="float-end">
         <a href="#" data-size="md" data-url="{{ route('labels.create') }}"
            data-ajax-popup="true" data-bs-toggle="tooltip"
            title="{{__('Create Labels')}}" class="btn btn-sm btn-primary">
         <i class="ti ti-plus"></i>
         </a>
      </div>
      @endcan
   </div>
</div>
<div class="row">
   <div class="col-3">
      @include('layouts.crm_setup')
   </div>
   <div class="col-9">
      <div class="row justify-content-center">
         <div class="p-3 card">
            <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
               @php($i=0)
               @foreach($pipelines as $key => $pipeline)
               <li class="nav-item" role="presentation">
                  <button class="nav-link @if($i==0) active @endif"
                     id="pills-user-tab-1" data-bs-toggle="pill"
                     data-bs-target="#tab{{$key}}" type="button">{{$pipeline['name']}}
                  </button>
               </li>
               @php($i++)
               @endforeach
            </ul>
         </div>
         <div class="card">
            <div class="card-body">
               <div class="tab-content" id="pills-tabContent">
                  @php($i=0)
                  @foreach($pipelines as $key => $pipeline)
                  <div class="tab-pane fade show @if($i==0) active @endif"
                     id="tab{{$key}}" role="tabpanel" aria-labelledby="pills-user-tab-1">
                     <ul class="list-group sortable">
                        @foreach ($pipeline['labels'] as $label)
                        <li class="list-group-item" data-id="{{$label->id}}">
                           <span class="text-sm text-dark">{{$label->name}}</span>
                           <span class="float-end">
                              <div class="ms-2" style="display:flex;gap:10px;">
                                 @can('edit label')
                                 <a id="edit" href="#" class="btn btn-md bg-primary"
                                    data-url="{{ URL::to('labels/'.$label->id.'/edit') }}"
                                    data-ajax-popup="true" data-size="md"
                                    data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                    data-title="{{__('Edit Labels')}}">
                                 <i class="ti ti-pencil text-black"></i>
                                 </a>
                                 @endcan
                                 @if(count($pipeline['labels']))
                                 @can('delete label')
                                 {!! Form::open(['method' => 'DELETE',
                                 'route' => ['labels.destroy', $label->id]]) !!}
                                 <a href="#" class="btn btn-md btn-danger
                                    bs-pass-para" data-bs-toggle="tooltip"
                                    title="{{__('Delete')}}">
                                 <i class="ti ti-trash text-white"></i>
                                 </a>
                                 {!! Form::close() !!}
                                 @endcan
                                 @endif
                              </div>
                           </span>
                        </li>
                        @endforeach
                     </ul>
                  </div>
                  @php($i++)
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('new_layouts.footer')