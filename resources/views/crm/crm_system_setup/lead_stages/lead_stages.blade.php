@include('new_layouts.header')
<div class="page-wrapper"> 
    @include('crm.side-menu', ['hrm_header' => 'Manage Lead Stages'])
	<div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('lead_stages.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create Lead Stage')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
	<br>

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
                                <button class="nav-link @if($i==0) active @endif" id="pills-user-tab-1" data-bs-toggle="pill"
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
                                <div class="tab-pane fade show @if($i==0) active @endif" id="tab{{$key}}" role="tabpanel" aria-labelledby="pills-user-tab-1">
                                    <ul class="list-group sortable">
                                        @foreach ($pipeline['lead_stages'] as $lead_stages)
                                            <li class="list-group-item" data-id="{{$lead_stages->id}}">
                                                <span class="text-xs text-dark">{{$lead_stages->name}}</span>
                                                <span class="float-end">
                                                    <div class="ms-2" style="display:flex;gap:10px;">
                                                        @can('edit lead stage')
                                                            <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('lead_stages/'.$lead_stages->id.'/edit') }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Lead Stages')}}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        @endcan
                                                        @if(count($pipeline['lead_stages']))
                                                            @can('delete lead stage')
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['lead_stages.destroy', $lead_stages->id]]) !!}
                                                                    <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        @endif
                                            </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @php($i++)
                            @endforeach
                        </div>
                        <p class="text-muted mt-4"><strong>{{__('Note')}} : </strong>{{__('You can easily change order of lead stage using drag & drop.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>  
@include('new_layouts.footer')

<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script>
    $(function () {
        $(".sortable").sortable();
        $(".sortable").disableSelection();
        $(".sortable").sortable({
            stop: function () {
                var order = [];
                $(this).find('li').each(function (index, data) {
                    order[index] = $(data).attr('data-id');
                });

                $.ajax({
                    url: "{{route('lead_stages.order')}}",
                    data: {order: order, _token: $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (data) {
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error, 'error')
                    }
                })
            }
        });
    });
</script>