@include('new_layouts.header')
@include('hrm.hrm_main')


<div class="row">
  <div class="col-md-6">
     <h2>Document Setup</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create document')
        <a class="floatrght btn btn-primary mb-3" href="#" data-url="{{ route('hrm_doc_setup.create') }}" data-ajax-popup="true" data-title="{{__('Create New Document Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan
  </div>
</div>


    <div class="table-responsive hrmdoc">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Document')}}</th>
                    <th>{{__('Role')}}</th>
                    <th>{{__('Description')}}</th>
                    @if(Gate::check('edit document') || Gate::check('delete document'))
                        <th>{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($documents as $document)
                    @php
                        $documentPath=\App\Models\Utility::get_file('uploads/documentUpload');
                        $roles = \Spatie\Permission\Models\Role::find($document->role);
                    @endphp
                    <tr>
                        <td>{{ $document->name }}</td>
                        <td>
                            @if (!empty($document->document))
                                <div class="action-btn bg-primary ms-2">
                                    <a class="mx-3 btn btn-sm align-items-center down" download
                                        href="{{ $documentPath . '/' . $document->document }}" >
                                        <i class="ti ti-download text-white"></i>
                                    </a>
                                </div>
                                <div class="action-btn bg-secondary ms-2">
                                    <a class="mx-3 btn btn-sm align-items-center" href="{{ $documentPath . '/' . $document->document }}" target="_blank"  >
                                        <i class="ti ti-crosshair text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Preview') }}"></i>
                                    </a>
                                </div>
                            @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>{{ !empty($roles)?$roles->name:'All' }}</td>
                        <td>{{ $document->description }}</td>
                        @if(Gate::check('edit document') || Gate::check('delete document'))
                            <td>
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit document')
                                        <a href="#" data-url="{{ route('hrm_doc_setup.edit',$document->id)}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Document')}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                    @endcan
                                    @can('delete document')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['hrm_doc_setup.destroy', $document->id],'id'=>'delete-form-'.$document->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$document->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                        {!! Form::close() !!}
                                    @endcan
                                    </div>
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

<script>
    $(document).on('keypress', function (e) {
        if (e.which == 13) {
            swal.closeModal();
        }
    });

    $('.download_file').click(function(e) {
        e.preventDefault();  //stop the browser from following
        file_path = $(this).data('url_download');
        window.location.href = 'uploads/file.doc';
    });
</script>

{{-- <div class="ms-2" style="display:flex;gap:10px;">

btn btn-md bg-primary 

btn btn-md btn-danger bs-pass-para --}}