@extends('layouts.admin')
@section('page-title')
    {{__('Manage Dairy')}}
@endsection
<style>
    div.dt-buttons .dt-button {
   background-color: #ffa21d;
    color:#fff;
    width: 29px;
    height: 28px;
    border-radius: 4px;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    
}
div.dt-buttons .dt-button:hover {
    background-color: #ffa21d;
    color:#fff;
    width: 29px;
    height: 28px;
    border-radius: 4px;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
div.dt-buttons {
    float: right;
}
</style>
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Dairy')}}</li>
@endsection
@section('action-btn')

    <div class="float-end">
    <div class="diary_template_select">
        <input type="hidden" id="project_id" value="{{$project_id}}">
        <select id="diary_template_select" class="form-control float-end"><option value="concrete_pouring_record">Concrete Pouring Record</option>
            <option value="consultants_directions_summary">Consultants Directions Summary</option>
            <option value="contract_required_documents">Contract Required Documents Submission Summary</option>
            <option value="daily_report_form1">Daily Report Form 1</option>
            <option value="daily_report_form2">Daily Report Form 2</option>
            <option value="daily_report_form3">Daily Report Form 3</option>
            <option value="procurement_material_supply_log">Procurement Material Supply Log</option>
            <option value="project_drawings_master_list">Project Drawings Master List</option>
            <option value="project_shop_drawings_status">Project Shop Drawings Status</option>
            <option value="project_specifications_summary">Project Specifications Summary</option>
            <option value="rfa_form">RFA-Request For Approval of Material and Technical Submission Status</option>
            <option value="rfi_form">RFI-Request For Information Status</option>
            <option value="vo_change_order">VO or Change Order or Scope Change Authorization Summary</option>
            <option value="custom_file_uploads">Custom File Upload</option>
        </select>
    </div>
   
    </div>
   
    
@endsection


@section('content')
<br><br>
<div class="float-left">
    {{-- @can('create branch') --}}
        <a href="#" data-size="xl" data-url="{{ route('dairy.dairy_create',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    {{-- @endcan --}}
</div>
<div class="col-xl-12 mt-3">
    <div class="card table-card">
        
        <div class="col-auto float-end ms-4 mt-4">
                <a href="#" data-size="xl" data-url="{{ route('dairy.dairy_create',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                    <i class="ti ti-plus"></i>
                </a>
            </div>
       
        <div class="card-header card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable" id="example1">
                    <thead class="">
                        <tr>
                            <th>{{__('Sno')}}</th>
                            <th>{{__('Date of Casting')}}</th>
                            <th>{{__('Casting Element')}}</th>
                            <th>{{__('Concrete Grade')}}</th>
                            <th>{{__('Theoretical')}}</th>
                            <th>{{__('Actual')}}</th>
                            <th>{{__('7 days Test Fall on')}}</th>
                            <th>{{__('28 days Test Fall on')}}</th>
                            <th>{{__('28 days Result')}}</th>
                            <th>{{__('Remarks')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                  @forelse ($dairy_data as $key=>$data)
                        @php
                            $check=$data->diary_data;
                        @endphp
                        @if($check != null)
                            @php $bulk_data = json_decode($check); @endphp
                        @else
                            @php $bulk_data = array(); @endphp
                        @endif
                   
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                  {{$bulk_data->date_of_casting}}
                                </td>
                                <td>{{$bulk_data->element_of_casting}}</td>
                                <td>{{$bulk_data->grade_of_concrete}}</td>
                                <td class="">
                                    {{$bulk_data->theoretical}}
                                </td>
                                <td>{{$bulk_data->actual}}</td>
                              
                                <td class="">
                                    {{$bulk_data->testing_fall ?? '-'}}
                                </td>
                                <td class="">
                                    {{$bulk_data->days_testing_falls ?? '-'}}
                                </td>
                                <td class="">
                                    {{$bulk_data->days_testing_result ?? '-'}}
                                </td>
                                <td class="">
                                    {{$bulk_data->remarks}}
                                </td>
                                <td>
                                    <div class="action-btn bg-primary ms-2">
                                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('dairy.dairy_create',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>

                                    <div class="action-btn bg-danger ms-2 mt-9">
                                        {!! Form::open(['method' => 'POST', 'route' => ['dairy.destroy', $data->id],'id'=>'delete-form-'.$data->id]) !!}
                                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para"  data-bs-toggle="tooltip" title="{{__('Delete')}}">
                                            <i class="ti ti-trash text-white"></i>
                                        </a>
                                        {!! Form::close() !!}
                                        {{-- <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"> --}}
                                    </div>
                                </td>
                               
                                @empty
                               
                                    <td colspan="5">No Data Found</td>
                                
                            </tr>
                    
                            @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')

{{-- 

<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    $('#example1').DataTable({
        dom: 'Bfrtip',
        searching: false,
        info: false,
        paging: false,
        buttons: [

            {

                extend: 'excelHtml5',
                title: 'Task Report',
                titleAttr: 'Excel',
                text: '<i class="fa fa-file-excel-o"></i>',

                exportOptions: {
                    modifier: {
                        order: 'index', // 'current', 'applied','index', 'original'
                        page: 'all', // 'all', 'current'
                        search: 'none' // 'none', 'applied', 'removed'
                    },
                    columns: [0, 1, 2, 3, 4,5,6]
                }
            },

            'colvis'
        ]
    });
});

</script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    $(document).ready(function () {
      $("#actualDate").change(function () {
        var selectedDate = this.value;
        var seventhDate = moment(selectedDate)
          .add(7, "d")
          .format("YYYY-MM-DD");
        var twentyEigthData = moment(selectedDate)
          .add(28, "d")
          .format("YYYY-MM-DD");

        $("#seventhDay").val(seventhDate);
        $("#twentyEighthDay").val(twentyEigthData);
      });

      $("#concreteFile").dropzone({ url: "/file/post" });
    });
  </script> --}}

@endpush