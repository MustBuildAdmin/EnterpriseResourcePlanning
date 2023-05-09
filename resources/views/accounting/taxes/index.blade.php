@include('new_layouts.header')
@include('accounting.side-menu')


<div class="row">
  <div class="col-md-6">
      <h2>{{__('Manage Tax Rate')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

      @can('create constant tax')
          <a class="btn btn-sm btn-primary floatrght"  href="#" data-url="{{ route('taxes.create') }}" data-ajax-popup="true" data-title="{{__('Create Tax Rate')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
              <i class="ti ti-plus"></i>
          </a>
      @endcan

  </div>
</div>



  <div class="row">
      <div class="col-3">
          @include('layouts.account_setup')
      </div>
      <div class="col-9">
          <div class="card">
              <div class="card-body table-border-style">
                  <div class="table-responsive">
                      <table class="table datatable">
                          <thead>
                          <tr>
                              <th> {{__('Tax Name')}}</th>
                              <th> {{__('Rate %')}}</th>
                              <th width="10%"> {{__('Action')}}</th>
                          </tr>
                          </thead>

                          <tbody>
                          @foreach ($taxes as $taxe)
                              <tr class="font-style">
                                  <td>{{ $taxe->name }}</td>
                                  <td>{{ $taxe->rate }}</td>
                                  <td class="Action">


                                      <div class="col-md-6 floatleft ">

                                            @can('edit constant tax')
                                                <div class="action-btn ms-2">
                                                <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-url="{{ route('taxes.edit',$taxe->id) }}" data-ajax-popup="true" data-title="{{__('Edit Tax Rate')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <span class="btn-inner--icon"><i class="ti ti-pencil text-white "></i></span>
                                                </a>
                                                </div>
                                            @endcan

                                            </div>

                                            <div class="col-md-6 floatleft">
                                            @can('delete constant tax')
                                                    <div class="action-btn  ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['taxes.destroy', $taxe->id],'id'=>'delete-form-'.$taxe->id]) !!}
                                                          <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$taxe->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                            @endcan
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
