@include('new_layouts.header')

<style>
.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
    width: 13%;
    float: right;
}
</style>

<div class="page-wrapper"> 
    @include('crm.side-menu')

<div class="row">
  <div class="col-md-6">
     <h2>Manage Deal Stages</h2>
  </div>
  <div class="col-md-6 float-end ">
        <a  class="floatrght btn btn-sm btn-primary" href="#" data-size="md" data-url="{{ route('stages.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create Deal Stage')}}" >
            <i class="ti ti-plus"></i>
        </a>
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
                                        @foreach ($pipeline['stages'] as $stage)
                                            <li class="list-group-item" data-id="{{$stage->id}}">
                                                <span class="text-xs text-dark">{{$stage->name}}</span>
                                                <span class="float-end">
                                                    <div class="ms-2" style="display:flex;gap:10px;">
                                                        @can('edit lead stage')
                                                            <a href="#" class="btn btn-md" data-url="{{ URL::to('stages/'.$stage->id.'/edit') }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Lead Stages')}}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        @endcan
                                                        @if(count($pipeline['stages']))
                                                            @can('delete lead stage')
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['stages.destroy', $stage->id]]) !!}
                                                                    <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
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
                        <p class="text-muted mt-4"><strong>{{__('Note')}} : </strong>{{__('You can easily change order of deal stage using drag & drop.')}}</p>
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
                    url: "{{route('stages.order')}}",
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