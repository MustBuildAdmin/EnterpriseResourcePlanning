@include('new_layouts.header')
@include('accounting.side-menu')



<div class="row">
  <div class="col-md-6">
     <h2>Customer</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

        <a class="floatrght btn btn-sm btn-primary" href="{{route('customer.export')}}" data-bs-toggle="tooltip" title="{{__('Export')}}">
            <i class="ti ti-file-export"></i>
        </a>

        <a class="floatrght btn btn-sm btn-primary gapbtn" href="#" data-size="lg" data-url="{{ route('customer.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Customer')}}">
            <i class="ti ti-plus"></i>
        </a>

  </div>
</div>


<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style
table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th> {{__('Name')}}</th>
                                <th> {{__('Contact')}}</th>
                                <th> {{__('Email')}}</th>
                                <th> {{__('Balance')}}</th>
                                <th> {{__('Last Login')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($customers as $k=>$customer)
                                <tr class="cust_tr" id="cust_detail" data-url="{{route('customer.show',$customer['id'])}}" data-id="{{$customer['id']}}">
                                    <td class="Id">
                                        @can('show customer')
                                            <a href="{{ route('customer.show',\Crypt::encrypt($customer['id'])) }}" class="btn btn-outline-primary">
                                                {{ AUth::user()->customerNumberFormat($customer['customer_id']) }}
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-outline-primary">
                                                {{ AUth::user()->customerNumberFormat($customer['customer_id']) }}
                                            </a>
                                        @endcan
                                    </td>
                                    <td class="font-style">{{$customer['name']}}</td>
                                    <td>{{$customer['contact']}}</td>
                                    <td>{{$customer['email']}}</td>
                                    <td>{{\Auth::user()->priceFormat($customer['balance'])}}</td>
                                    <td>
                                        {{ (!empty($customer->last_login_at)) ? $customer->last_login_at : '-' }}
                                    </td>


                                    <td class="Action text-end">
                                        <div class="ms-2" style="display:flex;">
                                        @if($customer['is_active']==0)
                                                <i class="ti ti-lock" title="Inactive"></i>
                                            @else
                                                @can('show customer')
                                                <div class="action-btn ms-2">
                                                    <a href="{{ route('customer.show',\Crypt::encrypt($customer['id'])) }}" class="backgroundnone mx-3 btn btn-sm align-items-center"
                                                       data-bs-toggle="tooltip" title="{{__('View')}}">
                                                        <i class="ti ti-eye text-white text-white"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                @can('edit customer')
                                                    <div class="action-btn ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="{{ route('customer.edit',$customer['id']) }}" data-ajax-popup="true"  data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit Customer')}}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>

                                                @endcan



                                                @can('delete customer')
                                                    <div class="action-btn ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['customer.destroy', $customer['id']],'id'=>'delete-form-'.$customer['id']]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endcan

                                            @endif
                                        </div>
                                    </td>

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
