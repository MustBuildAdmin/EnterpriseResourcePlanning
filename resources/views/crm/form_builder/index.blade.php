@include('new_layouts.header')
@include('crm.side-menu')
<style>
	i.ti.ti-plus {
		color: #FFF !important;
	}
	#link,#convert,#copy,#form_field,#view_response,#edit_builder{
    background: unset !important;
}
 </style>

<div class="row">
	<div class="col-md-6">
	   <h2>{{__('Manage Form Builder')}}</h2>
	</div>
	<div class="col-md-6 float-end ">
	   <a href="#" data-size="md" data-url="{{ route('form_builder.create') }}"
		  data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Form')}}"
		  class="floatrght btn btn-sm btn-primary">
	   <i class="ti ti-plus"></i>
	   </a>
	</div>
 </div>
 <div class="table-responsive">
	<table class="table card-table table-vcenter text-nowrap datatable">
	   <thead>
		  <tr>
			 <th>{{__('Name')}}</th>
			 <th>{{__('Response')}}</th>
			 @if(\Auth::user()->type=='company')
			 <th>{{__('Action')}}</th>
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
				   <a href="#" id="link" class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link"
					  data-link="<iframe src='{{url('/form/'.$form->code)}}' title='{{ $form->name }}'></iframe>"
					  data-bs-toggle="tooltip" title="{{__('Click to copy iframe link')}}">
				   <i class="ti ti-frame text-black"></i>
				   </a>
				   <a href="#" id="convert" class="mx-3 btn btn-sm d-inline-flex align-items-center"
					  data-url="{{ route('form.field.bind',$form->id) }}" data-ajax-popup="true"
					  data-size="md" data-bs-toggle="tooltip" title="{{__('Convert into Lead Setting')}}"
					  data-title="{{__('Convert into Lead Setting')}}">
				   <i class="ti ti-exchange text-black"></i>
				   </a>
				   <a href="#" id="copy" class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link"
					  data-link="{{url('/form/'.$form->code)}}" data-bs-toggle="tooltip"
					  title="{{__('Click to copy link')}}">
				   <i class="ti ti-copy text-black"></i>
				   </a>
				   @can('manage form field')
				   <a id="form_field" href="{{route('form_builder.show',$form->id)}}"
					  class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"
					  title="{{__('Form field')}}">
				   <i class="ti ti-table text-black"></i>
				   </a>
				   @endcan
				   @can('view form response')
				   <a id="view_response" href="{{route('form.response',$form->id)}}"
					  class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"
					  title="{{__('View Response')}}"><i class="ti ti-eye text-white"></i>
				   </a>
				   @endcan
				   @can('edit form builder')
				   <a id="edit_builder" href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
					  data-url="{{ route('form_builder.edit',$form->id) }}" data-ajax-popup="true"
					  data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}"
					  data-title="{{__('Form Builder Edit')}}">
				   <i class="ti ti-pencil text-black"></i>
				   </a>
				   @endcan
				   @can('delete form builder')
				   {!! Form::open(['method' => 'DELETE',
				   'route' => ['form_builder.destroy', $form->id],'id'=>'delete-form-'.$form->id]) !!}
				   <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
					  data-bs-toggle="tooltip" title="{{__('Delete')}}">
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