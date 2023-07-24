@include('new_layouts.header')
<link rel="stylesheet" href="{{asset('css/summernote/summernote-lite.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}" id="main-style-link">
@include('crm.side-menu')
<style>
i.ti.ti-plus {
    color: #FFF !important;
}
</style>
<div class="row">
    <div class="col-md-6">
       <h2>{{__('Manage Deals - Sales')}}</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="input-group-btn">
            <a href="{{ route('deals.list') }}" data-size="lg" data-bs-toggle="tooltip"
               title="{{__('List View')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-list"></i>
            </a>
            @can('create deal')
            <a href="#" data-size="lg" data-url="{{ route('deals.create') }}"
               data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Deal')}}"
               class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
            @endcan
        </div>
    </div>
 </div>
 
 <div class="row">
    <div class="col-sm-3">
       <div class="card">
          <div class="card-body">
             <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                   <small class="text-muted">{{__('Total Deals')}}</small>
                   <h4 class="m-0">{{ $cnt_deal['total'] }}</h4>
                </div>
                <div class="col-auto">
                   <div class="theme-avtar bg-info">
                      <i class="ti ti-layers-difference"></i>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="col-sm-3">
       <div class="card">
          <div class="card-body">
             <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                   <small class="text-muted">{{__('This Month Total Deals')}}</small>
                   <h4 class="m-0">{{ $cnt_deal['this_month'] }}</h4>
                </div>
                <div class="col-auto">
                   <div class="theme-avtar bg-primary">
                      <i class="ti ti-layers-difference"></i>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="col-sm-3">
       <div class="card">
          <div class="card-body">
             <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                   <small class="text-muted">{{__('This Week Total Deals')}}</small>
                   <h4 class="m-0">{{ $cnt_deal['this_week'] }}</h4>
                </div>
                <div class="col-auto">
                   <div class="theme-avtar bg-warning">
                      <i class="ti ti-layers-difference"></i>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="col-sm-3">
       <div class="card">
          <div class="card-body">
             <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                   <small class="text-muted">{{__('Last 30 Days Total Deals')}}</small>
                   <h4 class="m-0">{{ $cnt_deal['last_30days'] }}</h4>
                </div>
                <div class="col-auto">
                   <div class="theme-avtar bg-danger">
                      <i class="ti ti-layers-difference"></i>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="row">
    <div class="col-sm-12">
       @php
       $stages = $pipeline->stages;
       $json = [];
       foreach ($stages as $stage){
       $json[] = 'task-list-'.$stage->id;
       }
       @endphp
       <div class="row kanban-wrapper horizontal-scroll-cards"
            data-containers='{!! json_encode($json) !!}' data-plugin="dragula">
          @foreach($stages as $stage)
          @php($deals = $stage->deals())
          <div class="col">
             <div class="card">
                <div class="card-header">
                   <div class="float-end">
                      <span class="btn btn-sm btn-primary btn-icon count">
                      {{count($deals)}}
                      </span>
                   </div>
                   <h4 class="mb-0">{{$stage->name}}</h4>
                </div>
                <div class="card-body kanban-box" id="task-list-{{$stage->id}}" data-id="{{$stage->id}}">
                   @foreach($deals as $deal)
                   <div class="card" data-id="{{$deal->id}}">
                      <div class="pt-3 ps-3">
                         @php($labels = $deal->labels())
                         @if($labels)
                         @foreach($labels as $label)
                         <div class="badge-xs badge bg-{{$label->color}} p-2 px-3 rounded">{{$label->name}}</div>
                         @endforeach
                         @endif
                      </div>
                      <div class="card-header border-0 pb-0 position-relative">
                         <h5>
                            <a href="@can('view deal')
                                @if($deal->is_active){{route('deals.show',$deal->id)}}@else#@endif
                                @else#@endcan">
                                {{$deal->name}}
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
                                  @can('edit deal')
                                  <a href="#!" data-size="md" data-url="{{ URL::to('deals/'.$deal->id.'/labels') }}"
                                     data-ajax-popup="true" class="dropdown-item"
                                     data-bs-original-title="{{__('Labels')}}">
                                  <i class="ti ti-bookmark"></i>
                                  <span>{{__('Labels')}}</span>
                                  </a>
                                  <a href="#!" data-size="lg" data-url="{{ URL::to('deals/'.$deal->id.'/edit') }}"
                                     data-ajax-popup="true" class="dropdown-item"
                                     data-bs-original-title="{{__('Edit Deal')}}">
                                  <i class="ti ti-pencil"></i>
                                  <span>{{__('Edit')}}</span>
                                  </a>
                                  @endcan
                                  @can('delete deal')
                                  {!! Form::open(['method' => 'DELETE',
                                      'route' => ['deals.destroy', $deal->id],'id'=>'delete-form-'.$deal->id]) !!}
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
                         $products = $deal->products();
                         $sources = $deal->sources();
                         ?>
                      <div class="card-body">
                         <div class="d-flex align-items-center justify-content-between mb-2">
                            <ul class="list-inline mb-0">
                               <li class="list-inline-item d-inline-flex align-items-center" data-bs-toggle="tooltip"
                                   title="{{__('Tasks')}}">
                                  <i class="f-16 text-primary ti ti-list"></i>
                                   {{count($deal->tasks)}}/{{count($deal->complete_tasks)}}
                               </li>
                            </ul>
                            <div class="user-group">
                               <i class="text-primary ti ti-report-money"></i>
                               {{\Auth::user()->priceFormat($deal->price)}}
                            </div>
                         </div>
                         <div class="d-flex align-items-center justify-content-between">
                            <ul class="list-inline mb-0">
                               <li class="list-inline-item d-inline-flex align-items-center" data-bs-toggle="tooltip"
                                   title="{{__('Product')}}">
                                  <i class="f-16 text-primary ti ti-shopping-cart"></i> {{count($products)}}
                               </li>
                               <li class="list-inline-item d-inline-flex align-items-center"
                                    data-bs-toggle="tooltip" title="{{__('Source')}}">
                                  <i class="f-16 text-primary ti ti-social"></i>{{count($sources)}}
                               </li>
                            </ul>
                            <div class="user-group">
                               @foreach($deal->users as $user)
                               <img src="@if($user->avatar) {{asset('/storage/uploads/avatar/'.$user->avatar)}}
                                    @else {{asset('storage/uploads/avatar/avatar.png')}} @endif"
                                    data-bs-toggle="tooltip" title="{{$user->name}}" alt="">
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
 @include('new_layouts.footer')
 </div>

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
						url: '{{route('deals.order')}}',
						type: 'POST',
						data: {deal_id: id, stage_id: stage_id, order: order, new_status: new_status,
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
	$(document).on("change", ".change-pipeline select[name=default_pipeline_id]", function () {
		$('#change-pipeline').submit();
	});
</script>
