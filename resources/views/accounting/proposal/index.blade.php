@include('new_layouts.header')
@include('accounting.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<style>
    .btn-box {
        margin-right : 20px;
    }
    .btn-sm {
        border-radius: 6px;
    }
    .mt-4 {
        margin-bottom: 7px;
    }

</style>
<div class="row">
<div class="row">
  <div class="col-md-6">
     <h2>{{__('Manage Proposals')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

              <a class="gapbtn floatrght mb-3 btn  btn-primary" href="{{route('proposal.export')}}"  data-bs-toggle="tooltip" title="{{__('Export')}}">
                  <i class="ti ti-file-export"></i>
              </a>
      
              @can('create proposal')
                  <a class="gapbtn floatrght mb-3 btn  btn-primary" href="{{ route('proposal.create',0) }}"  data-bs-toggle="tooltip" title="{{__('Create')}}">
                      <i class="ti ti-plus"></i>
                  </a>
              @endcan

  </div>
</div>


  <div class="col-md-6">
     
  </div>
    <div class="float-end">
      {{--        <a class="btn btn-sm btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip" title="{{__('Filter')}}">--}}
      {{--            <i class="ti ti-filter"></i>--}}
      {{--        </a>--}}

      </div>

      <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        @if(!\Auth::guard('customer')->check())
                            {{ Form::open(array('route' => array('proposal.index'),'method' => 'GET','id'=>'frm_submit')) }}
                        @else
                            {{ Form::open(array('route' => array('customer.proposal'),'method' => 'GET','id'=>'frm_submit')) }}
                        @endif
                        <div class="d-flex align-items-center">
                            @if(!\Auth::guard('customer')->check())
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 me-2">
                                    <div class="btn-box">
                                        {{ Form::label('customer', __('Client'),['class'=>'form-label']) }}
                                        {{ Form::select('customer',$customer,isset($_GET['customer'])?$_GET['customer']:'', array('class' => 'form-select')) }}
                                    </div>
                                </div>
                            @endif
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 me-2">
                                <div class="btn-box">
                                    {{ Form::label('issue_date', __('Date'),['class'=>'form-label']) }}
                                    {{ Form::text('issue_date', isset($_GET['issue_date'])?$_GET['issue_date']:null, array('class' => 'form-control month-btn','id'=>'pc-daterangepicker-1', 'placeholder' =>'Issue Date')) }}
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 ">
                                <div class="btn-box">
                                    {{ Form::label('status', __('Status'),['class'=>'form-label']) }}
                                    {{ Form::select('status', [ ''=>'Select Status'] + $status,isset($_GET['status'])?$_GET['status']:'', array('class' => 'form-select')) }}
                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">

                                <a href="#" class="gapbtn btn btn-sm btn-primary" onclick="document.getElementById('frm_submit').submit(); return false;" data-bs-toggle="tooltip" data-original-title="{{__('apply')}}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('productservice.index') }}" class="gapbtn btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                   title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white "></i></span>
                                </a>
                            </div>

                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable proposal">
                            <thead>
                            <tr>
                                <th> {{__('Proposal')}}</th>
                                @if(!\Auth::guard('customer')->check())
                                    <th> {{__('Client')}}</th>
                                @endif
                                <th> {{__('Category')}}</th>
                                <th> {{__('Issue Date')}}</th>
                                <th> {{__('Status')}}</th>
                                @if(Gate::check('edit proposal') || Gate::check('delete proposal') || Gate::check('show proposal'))
                                    <th width="20%"> {{__('Action')}}</th>
                                @endif
                                {{-- <th>
                                    <td class="barcode">
                                        {!! DNS1D::getBarcodeHTML($invoice->sku, "C128",1.4,22) !!}
                                        <p class="pid">{{$invoice->sku}}</p>
                                    </td>
                                </th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($proposals as $proposal)
                                <tr class="font-style">
                                    <td class="Id">
                                        @if(\Auth::guard('customer')->check())
                                            <a href="{{ route('customer.proposal.show',\Crypt::encrypt($proposal->id)) }}" class="btn btn-outline-primary">{{ AUth::user()->proposalNumberFormat($proposal->proposal_id) }}
                                            </a>
                                        @else
                                            <a href="{{ route('proposal.show',\Crypt::encrypt($proposal->id)) }}" class="btn btn-outline-primary">{{ AUth::user()->proposalNumberFormat($proposal->proposal_id) }}
                                            </a>
                                        @endif
                                    </td>
                                    @if(!\Auth::guard('customer')->check())
                                        <td> {{!empty($proposal->customer)? $proposal->customer->name:'' }} </td>
                                    @endif
                                    <td>{{ !empty($proposal->category)?$proposal->category->name:''}}</td>
                                    <td>{{ Auth::user()->dateFormat($proposal->issue_date) }}</td>
                                    <td>
                                        @if($proposal->status == 0)
                                            <span class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                        @elseif($proposal->status == 1)
                                            <span class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                        @elseif($proposal->status == 2)
                                            <span class="status_badge badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                        @elseif($proposal->status == 3)
                                            <span class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                        @elseif($proposal->status == 4)
                                            <span class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                        @endif
                                    </td>
                                    @if(Gate::check('edit proposal') || Gate::check('delete proposal') || Gate::check('show proposal'))
                                        <td>
                                            @if($proposal->is_convert==0)
                                                @can('convert invoice')
                                                    <div class="ms-2">
                                                        {!! Form::open(['method' => 'get', 'route' => ['proposal.convert', $proposal->id],'id'=>'proposal-form-'.$proposal->id]) !!}

                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para backgroundnone" data-bs-toggle="tooltip"
                                                           title="{{__('Convert Invoice')}}" data-original-title="{{__('Convert to Invoice')}}" data-original-title="{{__('Convert to Invoice')}}" data-confirm="{{__('You want to confirm convert to invoice. Press Yes to continue or Cancel to go back')}}" data-confirm-yes="document.getElementById('proposal-form-{{$proposal->id}}').submit();">
                                                            <i class="ti ti-exchange"></i>
                                                          {!! Form::close() !!}
                                                        </a>
                                                    </div>
                                                @endcan
                                            @else
                                                @can('show invoice')
                                                    <div class="ms-2">
                                                        <a href="{{ route('invoice.show',\Crypt::encrypt($proposal->converted_invoice_id)) }}"
                                                           class="mx-3 btn btn-sm  align-items-center backgroundnone" data-bs-toggle="tooltip" title="{{__('Already convert to Invoice')}}" data-original-title="{{__('Already convert to Invoice')}}" >
                                                            <i class="ti ti-file"></i>
                                                        </a>
                                                    </div>
                                                @endcan
                                            @endif
                                            @can('duplicate proposal')
                                                <div class="ms-2">
                                                    {!! Form::open(['method' => 'get', 'route' => ['proposal.duplicate', $proposal->id],'id'=>'duplicate-form-'.$proposal->id]) !!}

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para-dup backgroundnone colorblack" data-bs-toggle="tooltip" title="{{__('Duplicate')}}" data-original-title="{{__('Duplicate')}}" data-original-title="{{__('Duplicate')}}" data-confirm="{{__('You want to confirm duplicate this invoice. Press Yes to continue or Cancel to go back')}}" data-confirm-yes="document.getElementById('duplicate-form-{{$proposal->id}}').submit();">
                                                        <i class="ti ti-copy "></i>
                                                        {!! Form::close() !!}
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('show proposal')
                                                @if(\Auth::guard('customer')->check())
                                                    <div class="ms-2">
                                                        <a href="{{ route('customer.proposal.show',\Crypt::encrypt($proposal->id)) }}" class="backgroundnone mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Show')}}" data-original-title="{{__('Detail')}}">
                                                            <i class="ti ti-eye text-white text-white"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="ms-2">
                                                        <a href="{{ route('proposal.show',\Crypt::encrypt($proposal->id)) }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-bs-toggle="tooltip" title="{{__('Show')}}" data-original-title="{{__('Detail')}}">
                                                            <i class="ti ti-eye text-white text-white"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endcan
                                            @can('edit proposal')
                                                <div class="ms-2">
                                                    <a href="{{ route('proposal.edit',\Crypt::encrypt($proposal->id)) }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('delete proposal')
                                                <div class="ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['proposal.destroy', $proposal->id],'id'=>'delete-form-'.$proposal->id]) !!}

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para backgroundnone " data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$proposal->id}}').submit();">
                                                        <i class="ti ti-trash text-white text-white"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan
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
    
</div>
@include('new_layouts.footer')
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
