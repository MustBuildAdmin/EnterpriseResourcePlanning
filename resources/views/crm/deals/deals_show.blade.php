@include('new_layouts.header')
<link rel="stylesheet" href="{{asset('css/summernote/summernote-lite.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/dropzone.min.css')}}">
<style>
    i.ti.ti-pencil,i.ti.ti-plus{
        color:#FFF !important;
    }
<<<<<<< HEAD
    .bg-danger{
        background: unset !important;
    }
    .bg-info{
        background: unset !important;
    }
   
    i.ti.ti-trash.text-white {
        color: black !important;
        background: unset !important;
    }
</style>
=======
    i.ti.ti-trash {
    color: #FFF !important;
    background: unset !important;
    }
    a.btn.btn-sm {
        background: unset !important;
    }
    </style>
>>>>>>> 12c4405dedde47bbfd4f0e195d90717b2918140b
<div class="page-wrapper">
    @include('crm.side-menu', ['hrm_header' => 'Manage Leads'])

	<div class="float-end">
        @can('convert deal to deal')
            @if(!empty($deal))
                <a href="@can('View Deal')
                @if($deal->is_active) {{route('deals.show',$deal->id)}} @else # @endif
                @else # @endcan"
                    data-size="lg" data-bs-toggle="tooltip" title=" {{__('Already Converted To Deal')}}"
                    class="btn btn-sm btn-primary">
                    <i class="ti ti-exchange"></i>
                </a>
            @else
                <a href="#" data-size="lg" data-url="{{ URL::to('deals/'.$deal->id.'/show_convert') }}"
                    data-bs-toggle="tooltip" title="{{__('Convert ['.$deal->subject.'] To Deal')}}"
                    class="btn btn-sm btn-primary">
                    <i class="ti ti-exchange"></i>
                </a>
            @endif
        @endcan
        <a href="#" data-url="{{ URL::to('deals/'.$deal->id.'/labels') }}"
             data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
             title="{{__('Label')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-bookmark"></i>
        </a>
        <a href="#" data-size="lg" data-url="{{ route('deals.edit',$deal->id) }}"
           data-ajax-popup="true" data-bs-toggle="tooltip"
           title="{{__('Edit')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-pencil"></i>
        </a>
    </div>
    <br><br><br>

	<div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="deal-sidenav">

                            <a href="#general" class="list-group-item list-group-item-action border-0">{{__('General')}}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>


                            <a href="#tasks" class="list-group-item list-group-item-action border-0">{{__('Task')}}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>


                            <a href="#users_products" class="list-group-item list-group-item-action border-0">
                                {{__('Users').' | '.__('Products')}}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>


                            <a href="#sources_emails" class="list-group-item list-group-item-action border-0">
                                {{__('Sources').' | '.__('Emails')}}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>


                            <a href="#discussion_note" class="list-group-item list-group-item-action border-0">
                                {{__('Discussion').' | '.__('Notes')}}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>


                            <a href="#files" class="list-group-item list-group-item-action border-0">{{__('Files')}}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>


                            <a href="#calls" class="list-group-item list-group-item-action border-0">{{__('Calls')}}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>


                            <a href="#activity" class="list-group-item list-group-item-action border-0">
                                {{__('Activity')}}
                                <div class="float-end">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                            </a>


                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <?php
                    $tasks = $deal->tasks;
                    $products = $deal->products();
                    $sources = $deal->sources();
                    $calls = $deal->calls;
                    $emails = $deal->emails;
                    ?>
                    <div id="general" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-success">
                                            <i class="ti ti-test-pipe"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">{{__('Pipeline')}}</p>
                                            <h5 class="mb-0 text-success">{{$deal->pipeline->name}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 my-3 my-sm-0">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-server"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">{{__('Stage')}}</p>
                                            <h5 class="mb-0 text-primary">{{$deal->stage->name}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-warning">
                                            <i class="ti ti-calendar"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">{{__('Created')}}</p>
                                            <h5 class="mb-0 text-warning">
                                                {{\Auth::user()->dateFormat($deal->created_at)}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-info">
                                            <i class="ti ti-report-money"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">{{__('Price')}}</p>
                                            <h5 class="mb-0 text-info">{{\Auth::user()->priceFormat($deal->price)}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-auto mb-3 mb-sm-0">
                                            <small class="text-muted">{{__('Task')}}</small>
                                            <h3 class="m-0">{{count($tasks)}}</h3>
                                        </div>
                                        <div class="col-auto">
                                            <div class="theme-avtar bg-danger">
                                                <i class="ti ti-subtask"></i>
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
                                            <small class="text-muted">{{__('Product')}}</small>
                                            <h3 class="m-0">{{count($products)}}</h3>
                                        </div>
                                        <div class="col-auto">
                                            <div class="theme-avtar bg-info">
                                                <i class="ti ti-shopping-cart"></i>
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
                                            <small class="text-muted">{{__('Source')}}</small>
                                            <h3 class="m-0">{{count($sources)}}</h3>
                                        </div>
                                        <div class="col-auto">
                                            <div class="theme-avtar bg-primary">
                                                <i class="ti ti-social"></i>
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
                                            <small class="text-muted">{{__('Files')}}</small>
                                            <h3 class="m-0">{{count($deal->files)}}</h3>
                                        </div>
                                        <div class="col-auto">
                                            <div class="theme-avtar bg-warning">
                                                <i class="ti ti-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="tasks" class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5>{{__('Tasks')}}</h5>
                                @can('create task')
                                    <div class="float-end">
                                         <a  href="#" data-size="lg"
                                             data-url="{{ route('deals.tasks.create',$deal->id) }}"
                                             data-ajax-popup="true" data-bs-toggle="tooltip"
                                             title="{{__('Add Task')}}" class="btn btn-sm btn-primary">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                    </div>
                                @endcan

                            </div>
                        </div>
                        <div class="card-body">
                            @if(!$tasks->isEmpty())
                                <ul class="list-group list-group-flush mt-2">
                                    @foreach($tasks as $task)
                                        <li class="list-group-item px-0">
                                            <div class="d-block d-sm-flex align-items-start">
                                                <div class="form-check form-switch form-switch-right img-fluid me-3
                                                     mb-2 mb-sm-0">
                                                    <input class="form-check-input task-checkbox" type="checkbox"
                                                     role="switch" id="task_{{$task->id}}"
                                                     @if($task->status) checked="checked" @endcan
                                                     value="{{$task->status}}"
                                                      data-url="{{route('deals.tasks.update_status',
                                                      [$deal->id,$task->id])}}">
                                                    <label class="form-check-label pe-5" for="task_{{$task->id}}">
                                                    </label>
                                                </div>
                                                <div class="w-100">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="mb-3 mb-sm-0">
                                                            <h5 class="mb-0">
                                                                {{$task->name}}
                                                                @if($task->status)
                                                                    <div class="badge bg-success mb-1">
                                                                        {{__(\App\Models\DealTask::
                                                                        $status[$task->status])}}
                                                                    </div>
                                                                @else
                                                                    <div class="badge bg-warning mb-1">
                                                                        {{__(\App\Models\DealTask::
                                                                        $status[$task->status])}}
                                                                    </div>
                                                                @endif
                                                            </h5>
                                                            <small class="text-sm">
                                                                {{__(\App\Models\DealTask::
                                                                $priorities[$task->priority])}}
                                                                 - {{Auth::user()->dateFormat($task->date)}}
                                                                 {{Auth::user()->timeFormat($task->time)}}
                                                            </small>
                                                            <span class="text-muted text-sm">
                                                                @if($task->status)
                                                                    <div class="badge badge-pill badge-success mb-1">
                                                                        {{__(\App\Models\DealTask::
                                                                        $status[$task->status])}}
                                                                    </div>
                                                                @else
                                                                    <div class="badge badge-pill badge-warning mb-1">
                                                                        {{__(\App\Models\DealTask::
                                                                        $status[$task->status])}}
                                                                    </div>
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <span>
                                                        @can('edit task')
                                                                <div class="action-btn bg-info ms-2">
                                                                <a href="#" class="" data-title="{{__('Edit Task')}}"
                                                                   data-url="{{route('deals.tasks.edit',
                                                                   [$deal->id,$task->id])}}"
                                                                   data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                   title="{{__('Edit')}}">
                                                                   <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                            @endcan
                                                            @can('delete task')
                                                                <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open(['method' => 'DELETE',
                                                                 'route' => ['deals.tasks.destroy',
                                                                 $deal->id,$task->id]]) !!}
                                                                <a href="#" class="mx-3 btn btn-sm  align-items
<<<<<<< HEAD
                                                                   -center bs-pass-para white" data-bs-toggle="tooltip"
=======
                                                                   -center bs-pass-para" data-bs-toggle="tooltip"
>>>>>>> 12c4405dedde47bbfd4f0e195d90717b2918140b
                                                                    title="{{__('Delete')}}">
                                                                   <i class="ti ti-trash text-white"></i>
                                                                </a>
                                                                {!! Form::close() !!}
                                                                </div>
                                                            @endcan
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center">
                                    No Tasks Available.!
                                </div>
                            @endif
                        </div>
                    </div>
                    <div id="users_products">
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5>{{__('Users')}}</h5>

                                            <div class="float-end">
                                                <a href="#" data-size="md" data-url="{{ route('deals.users.edit',
                                                   $deal->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                    title="{{__('Add User')}}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="ti ti-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" aria-describedby="deal show">
                                                <thead>
                                                <tr>
                                                    <th>{{__('Name')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($deal->users as $user)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <img  alt=""
                                                                        @if($user->avatar)
                                                                            src="{{asset('/storage/uploads/avatar/
                                                                            '.$user->avatar)}}"
                                                                        @else
                                                                            src="{{asset('/storage/uploads/avatar/
                                                                            avatar.png')}}"
                                                                        @endif
                                                                      class="wid-30 rounded-circle me-3">
                                                                </div>
                                                                <p class="mb-0">{{$user->name}}</p>
                                                            </div>
                                                        </td>
                                                        @can('edit deal')
                                                            <td>
                                                                <div class="action-btn bg-danger ms-2">
                                                                    {!! Form::open(['method' => 'DELETE',
                                                                        'route' => ['deals.users.destroy',
                                                                        $deal->id,$user->id],'id'=>'delete-form-'
                                                                        .$deal->id]) !!}
                                                                        <a  href="#" class="mx-3 btn btn-sm
<<<<<<< HEAD
                                                                            align-items-center bs-pass-para white"
=======
                                                                            align-items-center bs-pass-para"
>>>>>>> 12c4405dedde47bbfd4f0e195d90717b2918140b
                                                                            data-bs-toggle="tooltip"
                                                                            title="{{__('Delete')}}">
                                                                            <i class="ti ti-trash text-white"></i>
                                                                        </a>
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </td>
                                                        @endcan
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5>{{__('Products')}}</h5>

                                            <div class="float-end">
                                                <a href="#" data-size="md"
                                                   data-url="{{ route('deals.products.edit',$deal->id) }}"
                                                   data-ajax-popup="true" data-bs-toggle="tooltip"
                                                   title="{{__('Add Product')}}"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="ti ti-plus"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" aria-describedby="deal">
                                                <thead>
                                                <tr>
                                                    <th>{{__('Name')}}</th>
                                                    <th>{{__('Price')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($deal->products() as $product)
                                                    <tr>
                                                        <td>
                                                            {{$product->name}}
                                                        </td>
                                                        <td>
                                                            {{\Auth::user()->priceFormat($product->sale_price)}}
                                                        </td>
                                                        @can('edit deal')
                                                            <td>
                                                                <div class="action-btn bg-danger ms-2">
                                                                    {!! Form::open(['method' => 'DELETE',
                                                                    'route' => ['deals.products.destroy',
                                                                    $deal->id,$product->id]]) !!}
                                                                    <a href="#" class="mx-3 btn btn-sm  align-items
<<<<<<< HEAD
                                                                        -center bs-pass-para white"
                                                                        data-bs-toggle="tooltip"
=======
                                                                        -center bs-pass-para"data-bs-toggle="tooltip"
>>>>>>> 12c4405dedde47bbfd4f0e195d90717b2918140b
                                                                        title="{{__('Delete')}}">
                                                                        <i class="ti ti-trash text-white"></i>
                                                                    </a>
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </td>
                                                        @endcan
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="sources_emails">
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5>{{__('Sources')}}</h5>

                                            <div class="float-end">
                                                <a href="#" data-size="md"
                                                   data-url="{{ route('deals.sources.edit',$deal->id) }}"
                                                   data-ajax-popup="true" data-bs-toggle="tooltip"
                                                   title="{{__('Add Source')}}"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="ti ti-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" aria-describedby="sources">
                                                <thead>
                                                <tr>
                                                    <th>{{__('Name')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sources as $source)
                                                    <tr>
                                                        <td>{{$source->name}} </td>
                                                        @can('edit deal')
                                                            <td>
                                                                <div class="action-btn bg-danger ms-2">
                                                                    {!! Form::open(['method' => 'DELETE',
                                                                    'route' => ['deals.sources.destroy',
                                                                    $deal->id,$source->id],
                                                                    'id'=>'delete-form-'.$deal->id])
                                                                    !!}
                                                                    <a href="#" class="mx-3 btn btn-sm  align-items
<<<<<<< HEAD
                                                                       -center bs-pass-para white"
                                                                       data-bs-toggle="tooltip"
=======
                                                                       -center bs-pass-para" data-bs-toggle="tooltip"
>>>>>>> 12c4405dedde47bbfd4f0e195d90717b2918140b
                                                                        title="{{__('Delete')}}">
                                                                        <i class="ti ti-trash text-white"></i>
                                                                    </a>

                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </td>
                                                        @endcan
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5>{{__('Emails')}}</h5>
                                            @can('create deal email')
                                            <div class="float-end">
                                                <a href="#" data-size="lg"
                                                   data-url="{{ route('deals.emails.create',$deal->id) }}"
                                                   data-ajax-popup="true" data-bs-toggle="tooltip"
                                                   title="{{__('Create Email')}}" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-plus"></i>
                                                </a>
                                            </div>
                                        @endcan
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush mt-2">
                                            @if(!$emails->isEmpty())
                                                @foreach($emails as $email)
                                                    <li class="list-group-item px-0">
                                                        <div class="d-block d-sm-flex align-items-start">
                                                            <img src="{{asset('/storage/uploads/avatar/avatar.png')}}"
                                                                 class="img-fluid wid-40 me-3 mb-2 mb-sm-0" alt="image">
                                                            <div class="w-100">
                                                                <div class="d-flex align-items-center justify
                                                                      -content-between">
                                                                    <div class="mb-3 mb-sm-0">
                                                                        <h5 class="mb-0">{{$email->subject}}</h5>
                                                                        <span class="text-muted text-sm">
                                                                            {{$email->to}}
                                                                        </span>
                                                                    </div>
                                                                    <div class="form-check form-switch form-switch
                                                                         -right mb-2">
                                                                        {{$email->created_at->diffForHumans()}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="text-center">
                                                    {{__(' No Emails Available.!')}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="discussion_note">
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5>{{__('Discussion')}}</h5>

                                            <div class="float-end">
                                                <a href="#" data-size="lg"
                                                    data-url="{{ route('deals.discussions.create',$deal->id) }}"
                                                    data-ajax-popup="true" data-bs-toggle="tooltip"
                                                    title="{{__('Add Message')}}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="ti ti-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush mt-2">
                                            @if(!$deal->discussions->isEmpty())
                                                @foreach($deal->discussions as $discussion)
                                                    <li class="list-group-item px-0">
                                                        <div class="d-block d-sm-flex align-items-start">
                                                            <img
                                                                 src="@if($discussion->user->avatar)
                                                                    {{asset('/storage/uploads/avatar/
                                                                '.$discussion->user->avatar)}}
                                                                    @else
                                                                    {{asset('/storage/uploads/avatar/avatar.png')}}
                                                                    @endif"
                                                                 class="img-fluid wid-40 me-3 mb-2 mb-sm-0" alt="image">
                                                            <div class="w-100">
                                                                <div class="d-flex align-items-center
                                                                     justify-content-between">
                                                                    <div class="mb-3 mb-sm-0">
                                                                        <h5 class="mb-0"> {{$discussion->comment}}</h5>
                                                                        <span class="text-muted text-sm">
                                                                            {{$discussion->user->name}}
                                                                        </span>
                                                                    </div>
                                                                    <div class=" form-switch form-switch-right mb-4">
                                                                        {{$discussion->created_at->diffForHumans()}}
                                                                    </div>



                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="text-center">
                                                    {{__(' No Data Available.!')}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{__('Notes')}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <textarea class="summernote-simple">{!! $deal->notes !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="files" class="card">
                        <div class="card-header ">
                            <h5>{{__('Files')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 dropzone top-5-scroll browse-file" id="dropzonewidget"></div>
                        </div>
                    </div>
                    <div id="calls" class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5>{{__('Calls')}}</h5>
                                @can('create deal call')
                                <div class="float-end">
                                    <a href="#" data-size="lg"
                                       data-url="{{ route('deals.calls.create',$deal->id) }}"
                                       data-ajax-popup="true" data-bs-toggle="tooltip"
                                       title="{{__('Add Call')}}"
                                       class="btn btn-sm btn-primary">
                                        <i class="ti ti-plus"></i>
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" aria-describedby="calls">
                                    <thead>
                                    <tr>
                                        <th>{{__('Subject')}}</th>
                                        <th>{{__('Call Type')}}</th>
                                        <th>{{__('Duration')}}</th>
                                        <th>{{__('User')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($calls as $call)
                                        <tr>
                                            <td>{{ $call->subject }}</td>
                                            <td>{{ ucfirst($call->call_type) }}</td>
                                            <td>{{ $call->duration }}</td>
                                            <td>
                                                {{ isset($call->getLeadCallUser) ? $call->getLeadCallUser->name : '-' }}
                                            </td>
                                            <td>
                                                @can('edit deal call')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align
                                                           -items-center" data-url="{{ URL::to('deals/'.$deal->id.'/call
                                                           /'.$call->id.'/edit') }}" data-ajax-popup="true"
                                                           data-size="xl" data-bs-toggle="tooltip"
                                                            title="{{__('Edit')}}" data-title="{{__('Edit Call')}}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan
                                                @can('delete deal call')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE',
                                                         'route' => ['deals.calls.destroy',
                                                         $deal->id,$user->id],'id'=>'delete-form-'.$deal->id])
                                                         !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs
<<<<<<< HEAD
                                                        -pass-para white"
                                                        data-bs-toggle="tooltip" title="{{__('Delete')}}">
=======
                                                        -pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
>>>>>>> 12c4405dedde47bbfd4f0e195d90717b2918140b
                                                        <i class="ti ti-trash text-white"></i>
                                                       </a>

                                                        {!! Form::close() !!}
                                                    </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="activity" class="card">
                        <div class="card-header">
                            <h5>{{__('Activity')}}</h5>
                        </div>
                        <div class="card-body ">

                            <div class="row leads-scroll" >
                                <ul class="event-cards list-group list-group-flush mt-3 w-100">
                                    @if(!$deal->activities->isEmpty())
                                        @foreach($deal->activities as $activity)
                                            <li class="list-group-item card mb-3">
                                                <div class="row align-items-center justify-content-between">
                                                    <div class="col-auto mb-3 mb-sm-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="theme-avtar bg-primary">
                                                                <i class="ti {{ $activity->logIcon() }}"></i>
                                                            </div>
                                                            <div class="ms-3">
                                                                <span class="text-dark text-sm">
                                                                    {{ __($activity->log_type) }}
                                                                </span>
                                                                <h6 class="m-0">{!! $activity->getRemark() !!}</h6>
                                                                <small class="text-muted">
                                                                    {{$activity->created_at->diffForHumans()}}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">

                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        No activity found yet.
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('new_layouts.footer')
	</div>
	

<script src="{{asset('css/summernote/summernote-lite.js')}}"></script>
<script src="{{asset('assets/js/plugins/dropzone-amd-module.min.js')}}"></script>
<script>
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: '#deal-sidenav',
        offset: 300
    })
    Dropzone.autoDiscover = false;
    Dropzone.autoDiscover = false;
    myDropzone = new Dropzone("#dropzonewidget", {
        maxFiles: 20,
        // maxFilesize: 20,
        parallelUploads: 1,
        filename: false,
        // acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.txt",
        url: "{{route('deals.file.upload',$deal->id)}}",
        success: function (file, response) {
            if (response.is_success) {
                dropzoneBtn(file, response);
            } else {
                myDropzone.removeFile(file);
                show_toastr('Error', response.error, 'error');
            }
        },
        error: function (file, response) {
            myDropzone.removeFile(file);
            if (response.error) {
                show_toastr('Error', response.error, 'error');
            } else {
                show_toastr('Error', response, 'error');
            }
        }
    });
    myDropzone.on("sending", function (file, xhr, formData) {
        formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
        formData.append("deal_id", {{$deal->id}});
    });

    function dropzoneBtn(file, response) {
        var download = document.createElement('a');
        download.setAttribute('href', response.download);
        download.setAttribute('class', "badge bg-info mx-1");
        download.setAttribute('data-toggle', "tooltip");
        download.setAttribute('data-original-title', "{{__('Download')}}");
        download.innerHTML = "<i class='ti ti-download'></i>";

        var del = document.createElement('a');
        del.setAttribute('href', response.delete);
        del.setAttribute('class', "badge bg-danger mx-1");
        del.setAttribute('data-toggle', "tooltip");
        del.setAttribute('data-original-title', "{{__('Delete')}}");
        del.innerHTML = "<i class='ti ti-trash'></i>";

        del.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (confirm("Are you sure ?")) {
                var btn = $(this);
                $.ajax({
                    url: btn.attr('href'),
                    data: {_token: $('meta[name="csrf-token"]').attr('content')},
                    type: 'DELETE',
                    success: function (response) {
                        if (response.is_success) {
                            btn.closest('.dz-image-preview').remove();
                        } else {
                            show_toastr('Error', response.error, 'error');
                        }
                    },
                    error: function (response) {
                        response = response.responseJSON;
                        if (response.is_success) {
                            show_toastr('Error', response.error, 'error');
                        } else {
                            show_toastr('Error', response, 'error');
                        }
                    }
                })
            }
        });

        var html = document.createElement('div');
        html.appendChild(download);
        @if(Auth::user()->type != 'client')
        @can('edit deal')
        html.appendChild(del);
        @endcan
        @endif

        file.previewTemplate.appendChild(html);
    }

    @foreach($deal->files as $file)
    @if (file_exists(storage_path('deal_files/'.$file->file_path)))
    // Create the mock file:
    var mockFile = {name: "{{$file->file_name}}", size: {{\File::size(storage_path('deal_files/'.$file->file_path))}}};
    // Call the default addedfile event handler
    myDropzone.emit("addedfile", mockFile);
    // And optionally show the thumbnail of the file:
    myDropzone.emit("thumbnail", mockFile, "{{asset(Storage::url('deal_files/'.$file->file_path))}}");
    myDropzone.emit("complete", mockFile);

    dropzoneBtn(mockFile, {download: "{{route('deals.file.download',[$deal->id,$file->id])}}",
                           delete: "{{route('deals.file.delete',[$deal->id,$file->id])}}"});
    @endif
    @endforeach

    @can('edit deal')
    $('.summernote-simple').on('summernote.blur', function () {

        $.ajax({
            url: "{{route('deals.note.store',$deal->id)}}",
            data: {_token: $('meta[name="csrf-token"]').attr('content'), notes: $(this).val()},
            type: 'POST',
            success: function (response) {
                if (response.is_success) {
                    // show_toastr('Success', response.success,'success');
                } else {
                    show_toastr('Error', response.error, 'error');
                }
            },
            error: function (response) {
                response = response.responseJSON;
                if (response.is_success) {
                    show_toastr('Error', response.error, 'error');
                } else {
                    show_toastr('Error', response, 'error');
                }
            }
        })
    });
    @else
    $('.summernote-simple').summernote('disable');
    @endcan

    @can('edit task')
    $(document).on("click", ".task-checkbox", function () {
        var chbox = $(this);
        var lbl = chbox.parent().parent().find('label');

        $.ajax({
            url: chbox.attr('data-url'),
            data: {_token: $('meta[name="csrf-token"]').attr('content'), status: chbox.val()},
            type: 'PUT',
            success: function (response) {
                if (response.is_success) {
                    chbox.val(response.status);
                    if (response.status) {
                        lbl.addClass('strike');
                        lbl.find('.badge').removeClass('badge-warning').addClass('badge-success');
                    } else {
                        lbl.removeClass('strike');
                        lbl.find('.badge').removeClass('badge-success').addClass('badge-warning');
                    }
                    lbl.find('.badge').html(response.status_label);

                    show_toastr('success', response.success);
                } else {
                    show_toastr('error', response.error);
                }
            },
            error: function (response) {
                response = response.responseJSON;
                if (response.is_success) {
                    show_toastr('success', response.success);
                } else {
                    show_toastr('error', response.error);
                }
            }
        })
    });
    @endcan
</script>