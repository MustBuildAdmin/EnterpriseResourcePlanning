@include('new_layouts.header')
<div class="page-wrapper"> 
    @php
        $form_builder_name = $formBuilder->name."'s Form Field";
    @endphp
    @include('crm.side-menu', ['hrm_header' => "$form_builder_name"])

	@can('create form field')
        <div class="float-end">
            <a href="#" data-size="md" data-url="{{ route('form.field.create',$formBuilder->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Filed')}}" class="btn btn-sm btn-primary mt-3">
                <i class="ti ti-plus"></i>
            </a>
        </div>
        <br><br><br>
    @endcan

	<div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Type')}}</th>
                                <th class="text-end" width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($formBuilder->form_field->count())
                                @foreach ($formBuilder->form_field as $field)
                                    <tr>
                                        <td>{{ $field->name }}</td>
                                        <td>{{ ucfirst($field->type) }}</td>
                                        <td class="text-end">
                                            <div class="ms-2" style="display:flex;gap:10px;">
                                                @can('edit form builder')
                                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ route('form.field.edit',[$formBuilder->id,$field->id]) }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Form Builder Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                @endcan
                                                @can('delete form builder')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['form.field.destroy', [$formBuilder->id,$field->id]]]) !!}
                                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
                                                    {!! Form::close() !!}
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	</div>
	
@include('new_layouts.footer')