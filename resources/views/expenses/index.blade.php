{{-- @extends('layouts.admin') --}}
@include('new_layouts.header')
{{-- @section('page-title')
    {{ucwords($project->project_name).__("'s Expenses")}}
@endsection --}}
<style>
.table-responsive {
    max-width: none !important;
}
</style>

{{-- @section('breadcrumb')

    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.show',$project->id)}}">    {{ucwords($project->project_name)}}</a></li>
    <li class="breadcrumb-item">{{ucwords($project->project_name).__("'s Expenses")}}</li>

@endsection --}}
@include('construction_project.side-menu')


<div class="row divmainrow">
     <div class="col-md-6">
         <h2>Expenses</h2>
     </div>
     <div class="col-md-6">

     <div class="float-right float-end iconsexp">
        @can('create expense')
            <a href="#" class="btn btn-outline-primary w-20" data-url="{{ route('projects.expenses.create',$project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-size="lg" data-title="{{__('Create Expense')}}">
                <span class="btn-inner--icon"><i class="ti ti-plus"></i></span>
            </a>
        @endcan
        <a href="{{ route('projects.show',$project->id) }}" class="btn btn-outline-primary w-20" data-bs-toggle="tooltip" title="{{__('Back')}}">
            <span class="btn-inner--icon"><i class="ti ti-arrow-left"></i></span>
        </a>
    </div>


     </div>
</div>

<div class="col d-flex flex-column">



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Attachment')}}</th>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Date')}}</th>
                            <th scope="col">{{__('Amount')}}</th>
                            @if(Gate::check('edit expense') || Gate::check('delete expense'))
                                <th scope="col"></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="list">
                            @if(isset($project->expense) && !empty($project->expense) && count($project->expense) > 0)
                                @foreach($project->expense as $expense)
                                    <tr>
                                        <th scope="row">
                                            @if(!empty($expense->attachment))
                                                <a href="{{ asset(Storage::url($expense->attachment)) }}" class="btn btn-sm btn-primary btn-icon rounded-pill" data-bs-toggle="tooltip" title="{{__('Download')}}" download>
                                                    <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-sm btn-secondary btn-icon rounded-pill">
                                                    <span class="btn-inner--icon"><i class="ti ti-times-circle"></i></span>
                                                </a>
                                            @endif
                                        </th>
                                        <td>
                                            <span class="h6 text-sm font-weight-bold mb-0">{{ $expense->name }}</span>
                                            @if(!empty($expense->task))<span class="d-block text-sm text-muted">{{ $expense->task->name }}</span>@endif
                                        </td>
                                        <td>{{ (!empty($expense->date)) ? Utility::getDateFormated($expense->date) : '-' }}</td>
                                        <td>{{ \Auth::user()->priceFormat($expense->amount) }}</td>
                                        @if(Gate::check('edit expense') || Gate::check('delete expense'))
                                            <td class="text-end w-15">
                                                <div class="actions">
                                                      {!! Form::open(['method' => 'DELETE', 'route' => ['projects.expenses.destroy',$expense->id],'id'=>'delete-expense-'.$expense->id]) !!}
                                                   
                                                    <div class="col-md-6 floatleft">

                                                    @can('edit expense')
                                                        <div class="action-btn ms-2">
                                                        <a href="#" class="" data-url="{{ route('projects.expenses.edit',[$project->id,$expense->id]) }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Edit ').$expense->name}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="Edit">
                                                            <span class="btn-inner--icon"><i class="ti ti-pencil text-white backgroundnone"></i></span>
                                                        </a>
                                                        </div>
                                                    @endcan

                                                    </div>

                                                  <div class="col-md-4 floatleft">
                                                    @can('delete expense')
                                                            <div class="action-btn  ms-2">
                                                                

                                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?')}}|{{__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-expense-{{$expense->id}}').submit();">
                                                                    <i class="ti ti-trash text-white"></i>
                                                                </a>
                                                            </div>
                                                    @endcan
                                                  </div>

                                                </div>
                                                {!! Form::close() !!}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th scope="col" colspan="5"><h6 class="text-center">{{__('No Expense Found.')}}</h6></th>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('new_layouts.footer')