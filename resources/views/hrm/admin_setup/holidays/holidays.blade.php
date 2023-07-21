@include('new_layouts.header')
@include('hrm.hrm_main')

<div class="row">
  <div class="col-md-6">
     <h2>Holiday</h2>
  </div>
  <div class="col-md-6 float-end">

  
    @can('create holiday')
        <a class="floatrght mb-3 btn  btn-primary calendarrght" href="{{ route('holiday.calender') }}"  data-bs-toggle="tooltip" title="{{__('Calender View')}}" data-original-title="{{__('Calender View')}}">
            <i class="ti ti-calendar" style="font-size: 18px;"></i>
        </a>
        <a class="floatrght mb-3 btn  btn-primary" href="#" data-size="lg" data-url="{{ route('holiday.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Holiday')}}">
            {{__('Create')}} &nbsp; <i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>



    @can('create holiday')
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class=" mt-2 " id="multiCollapseExample1">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(array('route' => array('holiday.calender'),'method'=>'get','id'=>'holiday_filter')) }}
                            <div class="row align-items-center justify-content-end">
                                <div class="col-xl-10">
                                    <div class="row">

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="btn-box">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="btn-box">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="btn-box">
                                                {{Form::label('start_date',__('Start Date'),['class'=>'form-label'])}}
                                                {{Form::date('start_date',isset($_GET['start_date'])?$_GET['start_date']:'',array('class'=>'month-btn form-control'))}}
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="btn-box">
                                                {{Form::label('end_date',__('End Date'),['class'=>'form-label'])}}
                                                {{Form::date('end_date',isset($_GET['end_date'])?$_GET['end_date']:'',array('class'=>'month-btn form-control '))}}                                        </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="row">
                                        <div class="col-auto mt-4">

                                            <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('holiday_filter').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                            </a>

                                            <a href="{{route('holiday.calender')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
                                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                            </a>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    @endcan
    
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Occasion')}}</th>
                    <th>{{__('Start Date')}}</th>
                    <th>{{__('End Date')}}</th>
                    @if(Gate::check('edit holiday') || Gate::check('delete holiday'))
                        <th>{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($holidays as $holiday)
                    <tr>
                        <td>{{ $holiday->occasion }}</td>
                        <td>{{ \Auth::user()->dateFormat($holiday->date) }}</td>
                        <td>{{ \Auth::user()->dateFormat($holiday->end_date) }}</td>
                        @if(Gate::check('edit holiday') || Gate::check('delete holiday'))
                            <td class="Action">
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit holiday')
                                        <a href="#" class="btn btn-md bg-primary" data-url="{{ route('holiday.edit',$holiday->id) }}" data-ajax-popup="true" data-title="{{__('Edit Holiday')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    @endcan
                                    @can('delete holiday')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['holiday.destroy', $holiday->id],'id'=>'delete-form-'.$holiday->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip"  title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$holiday->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                        {!! Form::close() !!}
                                    @endcan
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
@include('new_layouts.footer')