
@include('new_layouts.header')
@include('accounting.side-menu')

<div class="row">
  <div class="col-md-6">
      <h2>{{__('Manage Custom Field')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

        @can('create constant custom field')
            <a class="btn btn-sm btn-primary floatrght" href="#" data-url="{{ route('custom-field.create') }}" data-bs-toggle="tooltip" title="{{__('Create')}}" data-ajax-popup="true" data-title="{{__('Create New Custom Field')}}">
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
                                <th> {{__('Custom Field')}}</th>
                                <th> {{__('Type')}}</th>
                                <th> {{__('Module')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($custom_fields as $field)
                                <tr>
                                    <td>{{ $field->name}}</td>
                                    <td>{{ $field->type}}</td>
                                    <td>{{ $field->module}}</td>
                                    @if(Gate::check('edit constant custom field') || Gate::check('delete constant custom field'))
                                        <td class="Action">


                                        <div class="col-md-6 floatleft ">

                                               @can('edit constant custom field')
                                                    <div class="action-btn ms-2">
                                                <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-url="{{ route('custom-field.edit',$field->id) }}" data-ajax-popup="true" data-title="{{__('Edit Custom Field')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                                    </div>
                                                @endcan

                                            </div>

                                            <div class="col-md-6 floatleft">
                                            @can('delete constant custom field')
                                                    <div class="action-btn  ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['custom-field.destroy', $field->id],'id'=>'delete-form-'.$field->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$field->id}}').submit();">
                                                        <i class="ti ti-trash text-white"></i>
                                                    </a>
                                                        {!! Form::close() !!}
                                                    </div>
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
    </div>

    @include('new_layouts.footer')