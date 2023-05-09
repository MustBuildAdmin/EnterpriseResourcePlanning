@include('new_layouts.header')
@include('accounting.side-menu')


<div class="row">
  <div class="col-md-6">
      <h2>{{__('Manage Product & Service Unit')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">
  @can('create constant unit')
            <a class="btn btn-sm btn-primary floatrght" href="#" data-url="{{ route('product-unit.create') }}" data-ajax-popup="true" data-title="{{__('Create New Unit')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
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
                                <th> {{__('Unit')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($units as $unit)
                                <tr>
                                    <td>{{ $unit->name }}</td>
                                    <td class="Action">


                                    <div class="col-md-6 floatleft ">

                                           @can('edit constant category')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-url="{{ route('product-unit.edit',$unit->id) }}" data-ajax-popup="true" data-title="{{__('Edit Unit')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                       <i class="ti ti-pencil text-white"></i>
                                                     </a>
                                                </div>
                                            @endcan

                                        </div>

                                        <div class="col-md-6 floatleft">
                                                @can('delete constant category')
                                                        <div class="action-btn ms-2">

                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['product-unit.destroy', $unit->id],'id'=>'delete-form-'.$unit->id]) !!}
                                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para backgroundnone" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$unit->id}}').submit();">
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