@include('new_layouts.header')
<div class="page-wrapper"> 
    @include('crm.side-menu', ['hrm_header' => 'Manage Form Builder'])

	<div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('form_builder.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Form')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>

	<div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
					<th>{{__('Name')}}</th>
					<th>{{__('Response')}}</th>
					@if(\Auth::user()->type=='company')
						<th class="text-end" width="200px">{{__('Action')}}</th>
					@endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($forms as $form)
					<tr>
						<td>{{ $form->name }}</td>
						<td>
							{{ $form->response->count() }}
						</td>
						@if(\Auth::user()->type=='company')
							<td class="text-end">
								<div class="ms-2" style="display:flex;gap:10px;">
									<a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link" data-link="<iframe src='{{url('/form/'.$form->code)}}' title='{{ $form->name }}'></iframe>" data-bs-toggle="tooltip" title="{{__('Click to copy iframe link')}}"><i class="ti ti-frame text-white"></i></a>
									<a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('form.field.bind',$form->id) }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Convert into Lead Setting')}}" data-title="{{__('Convert into Lead Setting')}}">
										<i class="ti ti-exchange text-white"></i>
									</a>
									<a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link" data-link="{{url('/form/'.$form->code)}}" data-bs-toggle="tooltip" title="{{__('Click to copy link')}}"><i class="ti ti-copy text-white"></i></a>
									@can('manage form field')
										<a href="{{route('form_builder.show',$form->id)}}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Form field')}}"><i class="ti ti-table text-white"></i></a>
									@endcan
									@can('view form response')
										<a href="{{route('form.response',$form->id)}}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('View Response')}}"><i class="ti ti-eye text-white"></i></a>
									@endcan
									@can('edit form builder')
										<a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('form_builder.edit',$form->id) }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Form Builder Edit')}}">
											<i class="ti ti-pencil text-white"></i>
										</a>
									@endcan
									@can('delete form builder')
										{!! Form::open(['method' => 'DELETE', 'route' => ['form_builder.destroy', $form->id],'id'=>'delete-form-'.$form->id]) !!}
											<a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
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
	
@include('new_layouts.footer')

<script>
	$(document).ready(function () {
		$('.cp_link').on('click', function () {
			var value = $(this).attr('data-link');
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val(value).select();
			document.execCommand("copy");
			$temp.remove();
			show_toastr('success', '{{__('Link Copy on Clipboard')}}')
		});
	});

	$(document).ready(function () {
		$('.iframe_link').on('click', function () {
			var value = $(this).attr('data-link');
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val(value).select();
			document.execCommand("copy");
			$temp.remove();
			show_toastr('success', '{{__('Link Copy on Clipboard')}}')
		});
	});
</script>