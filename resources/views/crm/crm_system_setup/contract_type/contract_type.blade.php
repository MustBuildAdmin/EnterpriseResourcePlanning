@include('new_layouts.header')
<style>
    .list-group-item:last-child {
        min-height: 52px !important;
    }
</style>
<div class="page-wrapper"> 
    @include('crm.side-menu', ['hrm_header' => 'Manage Contract Type'])
	<div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('contractType.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Contract Type')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
	<br>

    <div class="row">
        <div class="col-3">
            @include('layouts.crm_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th class="text-end ">{{__('Action')}}</th>

                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                    <tr class="font-style">
                                        <td>{{ $type->name }}</td>
                                        @if(\Auth::user()->type=='company')
                                            <td class="action text-end">
                                                <div class="ms-2" style="display:flex;gap:10px;">
                                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ route('contractType.edit',$type->id) }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Type')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['contractType.destroy', $type->id]]) !!}
                                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
                                                    {!! Form::close() !!}
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