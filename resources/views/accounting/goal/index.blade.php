@include('new_layouts.header')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">


<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<style>
.ms-2 {
    background: #fff  !important;
}

.ti.ti-caret-right.text-white {
    color: #000 !important;
    font-size: 18px;
}

</style>

@include('accounting.side-menu')
    <div class="row">
        <div class="col-md-6">
            <h2>{{__('Manage Goals')}}</h2>
        </div>
        <div class="col-md-6 float-end">
            @can('create goal')
              <a href="#" data-url="{{ route('goal.create') }}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Create')}}" data-ajax-popup="true" data-title="{{__('Create New Goal')}}" class="floatrght btn btn-sm btn-primary">
                  <i class="ti ti-plus"></i>
              </a>
            @endcan
        </div>
    </div>

    <div class="table-responsive">
        <table class="table datatable">
            <thead>
            <tr>
                <th> {{__('Name')}}</th>
                <th> {{__('Type')}}</th>
                <th> {{__('From')}}</th>
                <th> {{__('To')}}</th>
                <th> {{__('Amount')}}</th>
                <th> {{__('Is Dashboard Display')}}</th>
                <th width="10%"> {{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($golas as $gola)
                <tr>
                    <td class="font-style">{{ $gola->name }}</td>
                    <td class="font-style"> {{ __(\App\Models\Goal::$goalType[$gola->type]) }} </td>
                    <td class="font-style">{{ $gola->from }}</td>
                    <td class="font-style">{{ $gola->to }}</td>
                    <td class="font-style">{{ \Auth::user()->priceFormat($gola->amount) }}</td>
                    <td class="font-style">{{$gola->is_display==1 ? __('Yes') :__('No')}}</td>

                    <td>
                      <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit goal')
                                    <div class="action-btn ms-2">
                                        <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-url="{{ route('goal.edit',$gola->id) }}" data-ajax-popup="true" data-title="{{__('Edit Goal')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>
                                @endcan
                                @can('delete goal')
                                <div class="action-btn ms-2">
                                {!! Form::open(['method' => 'DELETE', 'route' => ['goal.destroy', $gola->id],'id'=>'delete-form-'.$gola->id]) !!}
                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para backgroundnone" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$gola->id}}').submit();">
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
@include('new_layouts.footer')
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
