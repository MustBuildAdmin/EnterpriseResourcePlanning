@include('new_layouts.header')
<style>
.green {
    background-color: #206bc4 !important;
}
.activity-scroll{
  height:700px !important;
}
.mt-5 {
  margin-top : 0px !important
}
.upload {
    padding-left: 60%;
    padding-right: 15px;
    width: auto !important;
    position: inherit;
}
.preview-btn {
    padding-right: 0px;
    padding-left: 5px;
    margin-left: 6px;
}
</style>
@php $setting  = Utility::settings(\Auth::user()->creatorId()); 
if($drawing_type == 3 & count($uploadedDrawings))
{
    $disable = 'disabled';
} else{
    $disable = '';
}
@endphp
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>

<div class="page-wrapper dashboard">

@include('construction_project.side_menu_dairy')
<section>
<head>
<title>{{__('Add Drawings')}}</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
</head>
<div class="container-fluid">
<div class="modal modal-blur fade" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Create Drawings Record</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <!-- <img id="imagePreview" src="" alt="Image Preview" style="max-width: 100%;"> -->
                <!-- <img id="image" class="mt-3" style="width:25%;"/> -->
                <div id="pdf-viewer"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
      <div class="card">
        
           <div class="card-body">
             
              <div class="mt-5 card">
              
              <form class="upload_form" id="upload_form" action="{{ route('add.drawings',[$drawing_type,$ref_number]) }}" enctype="multipart/form-data" method="POST">
                @csrf  
                <div class="card-header">
                   <h3>{{$ref_number}}</h3>
                   
                        <div class="col-md-3 form-group upload">
                            {{Form::label('drawing_file',__('Upload Drawing'),['class'=>'form-label'])}}
                            <div class="choose-file ">
                            <label for="drawing_file" class="form-label"><span style="font-size: 2m;font-size: 11px;color: #c71616;"></span>
                            <span id="image-label"></span>
                                <input type="file" class="form-control" name="drawing_file" id="drawing_file" data-filename="drawing_file_create" required accept="application/pdf">
                            </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary {{ $disable }}">Submit</button>
                </div>
                </form>
                </div>
                   <div class="card-body">
                    <div class="card-body">
                                    
                      <div class="row">
                      
                       <div class="col-md-12">
                           <div class="table-responsive card p-4">
                               <table class="table table-vcenter card-table" id="task-table">
                               <caption>Lists all drawings associated with drawing type</caption>
                                   <thead>
                                       <tr>
                                         <th>Revision</th>
                                         <th>Drawing Status</th>
                                         <th>Drawing Link</th>
                                         <th>Drawing upload at</th>
                                         <th>Drawing uploaded by</th>
                                         @if($drawing_type == 3)
                                         <th>Action</th>
                                         @endif
                                       </tr>
                                     </thead>
                                     @foreach ($uploadedDrawings as $drawing)
                                     <tbody>
                                       <tr>
                                           <td>Revision_{{$drawing->revisions}}</td>
                                           <td>@if($drawing->status == 'Active')<span class="badge bg-success me-1"> @else <span class="badge bg-warning me-1"> @endif{{$drawing->status}}</td>
                                           <td data-filepath="{{$drawing->drawing_path}}">
                                                {{$drawing->file_name}}
                                                <button type="button" id="file_path" class="btn preview-btn" onclick="getFilepath(this)" data-bs-toggle="modal"  data-bs-target="#modal-large">
                                                    <i class="far fa-eye me-2"></i>
                                                </button>
                                           </td>
                                           <td>{{$drawing->created_at}}</td>
                                           <td>{{$drawing->creator}}</td>
                                           @if($drawing_type == 3)
                                           <td>
                                           {!! Form::open(['method' => 'DELETE', 'route' => ['uploaded.drawing.destroy', [$drawing->id, $drawing_type, $ref_number, $drawing->created_by]],'id'=>'delete-form-'.$drawing->id]) !!}
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                            {!! Form::close() !!}
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
                   <a href="{{route('drawings.index')}}">
                   <button type="submit" class="btn btn-primary float-end">Back</button>
                   </a>
                   </div>
              </div>
          </div>
      </div>
  </div>
   
</section>
@include('new_layouts.footer')

<script>
    function getFilepath(button) {
        var closestRow = $(button).closest('tr');
        var filepathElement = closestRow.find('td[data-filepath]');
        var filePath = filepathElement.data('filepath');
        // $('#imagePreview').attr('src', "{{ asset('') }}" + filePath);
        var pdfPath = "{{ asset('') }}" + filePath;
        alert(pdfPath);

    // Asynchronously download the PDF and render it
    pdfjsLib.getDocument(pdfPath).promise.then(function(pdfDoc) {
        // Fetch the first page
        pdfDoc.getPage(1).then(function(page) {
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');

            // Set the canvas size to the PDF page size
            canvas.height = page.view[3];
            canvas.width = page.view[2];

            // Append the canvas to the PDF container
            document.getElementById('pdf-viewer').appendChild(canvas);

            // Render the PDF page on the canvas
            page.render({ canvasContext: context, viewport: page.view });
        });
    });
    }
</script>
