@include('new_layouts.header')
@include('crm.side-menu')
<style>
   i.ti.ti-plus {
       color: #FFF !important;
   }
</style>
<link rel="stylesheet" href="{{asset('css/summernote/summernote-lite.css')}}">
@php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp

<div class="container-fluid">
    <div class="row">
       <div class="col-md-6">
          <h2>{{__('Manage Leads')}}</h2>
       </div>
       <div class="col-md-6 float-end ">
          <form action="{{ route('clients.index') }}" method="GET">
             <div class="input-group">
                {{ Form::text('search',isset($_GET['search'])?$_GET['search']:'',
                array('class' => 'form-control d-inline-block w-9 me-3 mt-auto',
                'id'=>'search','placeholder'=>__('Search by Name or Email'))) }}
                <div class="input-group-btn">
          </form>
          {{ Form::open(array('route' => 'deals.change.pipeline','id'=>'change-pipeline','class'=>'btn btn-sm ')) }}
          {{ Form::select('default_pipeline_id', $pipelines,$pipeline->id, array('class' => 'form-control select',
          'id'=>'default_pipeline_id')) }}
          {{ Form::close() }}
          <a href="{{ route('leads.list') }}" data-size="lg" data-bs-toggle="tooltip" title="{{__('List View')}}"
             class="btn btn-sm btn-primary">
          <i class="ti ti-list"></i>
          </a>
          <a href="#" data-size="lg" data-url="{{ route('leads.create') }}" data-ajax-popup="true"
             data-bs-toggle="tooltip" title="{{__('Create New Lead')}}" class="btn btn-sm btn-primary">
          <i class="ti ti-plus"></i>
          </a>
          </div>
          </div>
       </div>
       <div class="float-end">
       </div>
       <br><br><br>
       <div class="row">
          <div class="col-sm-12">
             @php
             $lead_stages = $pipeline->leadStages;
             $json = [];
             foreach ($lead_stages as $lead_stage){
             $json[] = 'task-list-'.$lead_stage->id;
             }
             @endphp
             <div class="row kanban-wrapper horizontal-scroll-cards"
                data-containers='{!! json_encode($json) !!}' data-plugin="dragula">
                @foreach($lead_stages as $lead_stage)
                @php($leads = $lead_stage->lead())
                <div class="col">
                   <div class="card">
                      <div class="card-header">
                         <div class="float-end">
                            <span class="btn btn-sm btn-primary btn-icon count">
                            {{count($leads)}}
                            </span>
                         </div>
                         <h4 class="mb-0">{{$lead_stage->name}}</h4>
                      </div>
                      <div class="card-body kanban-box" id="task-list-{{$lead_stage->id}}"
                         data-id="{{$lead_stage->id}}">
                         @foreach($leads as $lead)
                         <div class="card" data-id="{{$lead->id}}">
                            <div class="pt-3 ps-3">
                               @php($labels = $lead->labels())
                               @if($labels)
                               @foreach($labels as $label)
                               <div class="badge-xs badge bg-{{$label->color}} p-2 px-3 rounded">{{$label->name}}</div>
                               @endforeach
                               @endif
                            </div>
                            <div class="card-header border-0 pb-0 position-relative">
                               <h5>
                                  <a href="@can('view lead')
                                     @if($lead->is_active){{route('leads.show',$lead->id)}}
                                     @else
                                     #
                                     @endif @else#@endcan">{{$lead->name}}
                                  </a>
                               </h5>
                               <div class="card-header-right">
                                  @if(Auth::user()->type != 'client')
                                  <div class="btn-group card-option">
                                     <button type="button" class="btn dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                     <i class="ti ti-dots-vertical"></i>
                                     </button>
                                     <div class="dropdown-menu dropdown-menu-end">
                                        @can('edit lead')
                                        <a href="#!" data-size="md"
                                           data-url="{{ URL::to('leads/'.$lead->id.'/labels') }}"
                                           data-ajax-popup="true" class="dropdown-item"
                                           data-bs-original-title="{{__('Labels')}}">
                                        <i class="ti ti-bookmark"></i>
                                        <span>{{__('Labels')}}</span>
                                        </a>
                                        <a href="#!" data-size="lg"
                                           data-url="{{ URL::to('leads/'.$lead->id.'/edit') }}"
                                           data-ajax-popup="true" class="dropdown-item"
                                           data-bs-original-title="{{__('Edit Lead')}}">
                                        <i class="ti ti-pencil"></i>
                                        <span>{{__('Edit')}}</span>
                                        </a>
                                        @endcan
                                        @can('delete lead')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['leads.destroy', $lead->id],
                                        'id'=>'delete-form-'.$lead->id]) !!}
                                        <a href="#!" class="dropdown-item bs-pass-para">
                                        <i class="ti ti-archive"></i>
                                        <span> {{__('Delete')}} </span>
                                        </a>
                                        {!! Form::close() !!}
                                        @endcan
                                     </div>
                                  </div>
                                  @endif
                               </div>
                            </div>
                            <?php
                               $products = $lead->products();
                               $sources = $lead->sources();
                            ?>
                            <div class="card-body">
                               <div class="d-flex align-items-center justify-content-between">
                                  <ul class="list-inline mb-0">
                                     <li class="list-inline-item d-inline-flex align-items-center"
                                        data-bs-toggle="tooltip" title="{{__('Product')}}">
                                        <i class="f-16 text-primary ti ti-shopping-cart"></i>
                                        {{count($products)}}
                                     </li>
                                     <li class="list-inline-item d-inline-flex align-items-center"
                                        data-bs-toggle="tooltip" title="{{__('Source')}}">
                                        <i class="f-16 text-primary ti ti-social"></i>
                                        {{count($sources)}}
                                     </li>
                                  </ul>
                                  <div class="user-group">
                                 
                                     @foreach($lead->users as $user)
                                 
                                        @if($user->avatar!=null)
                                             @if ( ! Storage::disk('s3')->exists($profile.$user->avatar))
                                                <img src="{{ $profile.$user->avatar}}"
                                                 class="avatar avatar-sm mb-3 rounded"
                                                  title="{{$user->name}}" alt="IMG"/>
                                             @else
                                                <img src="{{ Config::get('constants.IMG') }}" title="{{$user->name}}"
                                                 class="avatar avatar-sm mb-3 rounded" alt="IMG"/>
                                             @endif
                                         @else
                                                <img src="{{ Config::get('constants.IMG') }}" title="{{$user->name}}"
                                                 class="avatar avatar-sm mb-3 rounded" alt="IMG"/>
                                         @endif
                                      
                                     @endforeach
                                  </div>
                               </div>
                            </div>
                         </div>
                         @endforeach
                      </div>
                   </div>
                </div>
                @endforeach
             </div>
          </div>
       </div>
    </div>
	
@include('new_layouts.footer')
<script src="{{asset('css/summernote/summernote-lite.js')}}"></script>
<script src="{{ asset('assets/js/plugins/dragula.min.js') }}"></script>
<script>
    !function (a) {
        "use strict";
        var t = function () {
            this.$body = a("body")
        };
        t.prototype.init = function () {
            a('[data-plugin="dragula"]').each(function () {
                var t = a(this).data("containers"), n = [];
                if (t) for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]); else n = [a(this)[0]];
                var r = a(this).data("handleclass");
                r ? dragula(n, {
                    moves: function (a, t, n) {
                        return n.classList.contains(r)
                    }
                }) : dragula(n).on('drop', function (el, target, source, sibling) {

                    var order = [];
                    $("#" + target.id + " > div").each(function () {
                        order[$(this).index()] = $(this).attr('data-id');
                    });

                    var id = $(el).attr('data-id');

                    var old_status = $("#" + source.id).data('status');
                    var new_status = $("#" + target.id).data('status');
                    var stage_id = $(target).attr('data-id');
                    var pipeline_id = '{{$pipeline->id}}';

                    $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div").length);
                    $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div").length);
                    $.ajax({
                        url: '{{route('leads.order')}}',
                        type: 'POST',
                        data: {lead_id: id, stage_id: stage_id, order: order, new_status: new_status,
                               old_status: old_status, pipeline_id: pipeline_id,
                               "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                        },
                        error: function (data) {
                            data = data.responseJSON;
                            show_toastr('Error', data.error, 'error')
                        }
                    });
                });
            })
        }, a.Dragula = new t, a.Dragula.Constructor = t
    }(window.jQuery), function (a) {
        "use strict";

        a.Dragula.init()

    }(window.jQuery);


</script>
<script>
    $(document).on("change", "#default_pipeline_id", function () {
        $('#change-pipeline').submit();
    });
</script>