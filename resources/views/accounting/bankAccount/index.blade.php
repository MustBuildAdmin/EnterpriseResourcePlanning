@include('new_layouts.header')
@include('accounting.side-menu')


<div class="row">
  <div class="col-md-6">
     <h2>{{__('Manage Bank Account')}}</h2> 
  </div>
  <div class="col-md-6 float-end floatrght">
        @can('create bank account')
            <a class="floatrght btn btn-sm btn-primary" href="#" data-url="{{ route('bank-account.create') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Bank Account')}}">
                <i class="ti ti-plus"></i>
            </a>

        @endcan

  </div>
</div>


<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{__('Name')}}</th>
                                <th> {{__('Bank')}}</th>
                                <th> {{__('Account Number')}}</th>
                                <th> {{__('Current Balance')}}</th>
                                <th> {{__('Contact Number')}}</th>
                                <th> {{__('Bank Branch')}}</th>

                                    <th width="10%"> {{__('Action')}}</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($accounts as $account)
                                <tr class="font-style">
                                    <td>{{  $account->holder_name}}</td>
                                    <td>{{  $account->bank_name}}</td>
                                    <td>{{  $account->account_number}}</td>
                                    <td>{{  \Auth::user()->priceFormat($account->opening_balance)}}</td>
                                    <td>{{  $account->contact_number}}</td>
                                    <td>{{  $account->bank_address}}</td>
                                    @if(Gate::check('edit bank account') || Gate::check('delete bank account'))


                                    <td>
                                      <div class="ms-2" style="display:flex;gap:10px;">
                                                @if($account->holder_name!='Cash')
                                                    @can('edit bank account')
                                                        <div class="action-btn  ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-url="{{ route('bank-account.edit',$account->id) }}" data-ajax-popup="true" title="{{__('Edit')}}" data-title="{{__('Edit Bank Account')}}"data-bs-toggle="tooltip"  data-size="lg"  data-original-title="{{__('Edit')}}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('delete bank account')
                                                            <div class="action-btn  ms-2">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['bank-account.destroy', $account->id],'id'=>'delete-form-'.$account->id]) !!}
                                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$account->id}}').submit();">
                                                                    <i class="ti ti-trash text-white text-white"></i>
                                                                </a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                    @endcan
                                                @else
                                                    -
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


@include('new_layouts.footer')
