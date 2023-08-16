@include('new_layouts.header')
@include('hrm.hrm_main')


<div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{__('Award')}}</h3>
                    @can('create award')
                        <a class="pull-right" href="#" data-size="lg" data-url="{{ route('award.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Award')}}" class="">
                            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
                        </a>
                    @endcan
                  </div>
                  <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                      <div class="text-secondary">
                        Show
                        <div class="mx-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                        </div>
                        entries
                      </div>
                      <div class="ms-auto text-secondary">
                        Search:
                        <div class="ms-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                <tr>
                    @role('company')
                    <th>{{__('Employee')}}</th>
                    @endrole
                    <th>{{__('Award Type')}}</th>
                    <th>{{__('Date')}}</th>
                    <th>{{__('Gift')}}</th>
                    <th>{{__('Description')}}</th>
                    @if(Gate::check('edit award') || Gate::check('delete award'))
                        <th width="200px">{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($awards as $award)
                    <tr>
                        @role('company')
                            <td>{{!empty( $award->employee())? $award->employee()->name:'' }}</td>
                        @endrole
                        <td>{{ !empty($award->awardType())?$award->awardType()->name:'' }}</td>
                        <td>{{  \Auth::user()->dateFormat($award->date )}}</td>
                        <td>{{ $award->gift }}</td>
                        <td>{{ $award->description }}</td>

                        @if(Gate::check('edit award') || Gate::check('delete award'))
                            <td class="Action">
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit award')
                                        <a href="#" data-url="{{ URL::to('award/'.$award->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Award')}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    @endcan
                                    @can('delete award')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['award.destroy', $award->id],'id'=>'delete-form-'.$award->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$award->id}}').submit();">
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
    </div>
@include('new_layouts.footer')