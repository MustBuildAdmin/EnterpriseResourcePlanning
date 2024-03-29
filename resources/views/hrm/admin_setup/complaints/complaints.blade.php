@include('new_layouts.header')
@include('hrm.hrm_main')



<div class="row">
  <div class="col-md-6">
     <h2>Complain</h2>
  </div>
  <div class="col-md-6 float-end">

    @can('create complaint')
        <a class="floatrght mb-3 btn  btn-primary" href="#" data-url="{{ route('complaint.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Complaint')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>



    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Complaint From')}}</th>
                    <th>{{__('Complaint Against')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Complaint Date')}}</th>
                    <th>{{__('Description')}}</th>
                    @if(Gate::check('edit complaint') || Gate::check('delete complaint'))
                        <th>{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($complaints as $complaint)
                    <tr>
                        <td>{{!empty( $complaint->complaintFrom($complaint->complaint_from))? $complaint->complaintFrom($complaint->complaint_from)->name:'' }}</td>
                        <td>{{ !empty($complaint->complaintAgainst($complaint->complaint_against))?$complaint->complaintAgainst($complaint->complaint_against)->name:'' }}</td>
                        <td>{{ $complaint->title }}</td>
                        <td>{{ \Auth::user()->dateFormat( $complaint->complaint_date) }}</td>
                        <td>{{ $complaint->description }}</td>
                        @if(Gate::check('edit complaint') || Gate::check('delete complaint'))
                            <td>
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit complaint')
                                        <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('complaint/'.$complaint->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Complaint')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    @endcan
                                    @can('delete complaint')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['complaint.destroy', $complaint->id],'id'=>'delete-form-'.$complaint->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$complaint->id}}').submit();">
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