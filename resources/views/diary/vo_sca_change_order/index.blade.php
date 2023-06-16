@include('new_layouts.header')
@include('construction_project.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    background: #fff;
    max-width: 1072px !important;
   
}

.dataTables_wrapper .dataTables_paginate {
	float: right;
	text-align: right;
	padding-top: 0.25em;
}

.table-responsive .bg-primary {
	background: #206bc4 !important;
}

div.dt-buttons .dt-button {
	background-color: #ffa21d;
	color: #fff;
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
	color: #fff;
	width: 29px;
	height: 28px;
	border-radius: 4px;
	color: #fff;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	font-size: 20px;
}

h3, .h3 {
	font-size: 1rem !important;
}

.table-responsive .bg-primary {
	background: unset !important;
}
</style>
<div class="row">
  <div class="col-md-8">
     <h2>{{__('VO or Change Order or Scope Change Authorization Summary')}}</h2> 
  </div>
    @can('create vochange')
    <div class="col-md-4 float-end floatrght">
        <a href="#" data-size="xl" data-url="{{ route('add_variation_scope_change',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create Vo/Change Order')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="floatrght btn btn-primary mb-3">
        <i class="ti ti-plus"></i>
        </a>
    </div>
    @endcan
    <div class="col-xl-12 mt-3">
      <div class="card table-card">
        <div class="card-header card-body table-border-style">
          @can('manage vochange')
          <div class="table-responsive">
            <table class="table" id="example2">
              <thead class="">
                <tr>
                  <th>{{__('Sno')}}</th>
                  <th>{{__('Issued By')}}</th>
                  <th>{{__('Issued Date')}}</th>
                  <th>{{__('VO/SCA Reference')}}</th>
                  <th>{{__('VO Description')}}</th>
                  <th>{{__('Reference')}}</th>
                  <th>{{__('Date')}}</th>
                  <th>{{__('Omission Cost')}}</th>
                  <th>{{__('Addition Cost')}}</th>
                  <th>{{__('Net Amount')}}</th>
                  <th>{{__('Omission Cost')}}</th>
                  <th>{{__('Addition Cost')}}</th>
                  {{-- <th>{{__('Net Amount')}}
                  </th>  --}}
                  {{-- <th>{{__('Impact/Lead Time')}}</th>
                  <th>{{__('Granted EOT(in days)')}}</th>
                  <th>{{__(' Remarks')}}</th> --}}
                  @if(Gate::check('edit vochange') || Gate::check('delete vochange'))
                  <th>{{__('Action')}}</th>
                  @endif
                </tr>
              </thead>
              <tbody> 
                @foreach ($dairy_data as $key=>$data) 
                @php $check=$data->data; @endphp 
                @if($check != null) 
                @php $bulk_data = json_decode($check); @endphp 
                @else 
                @php $bulk_data = array(); @endphp 
                @endif
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$bulk_data->issued_by}}</td>
                  <td>{{ Utility::site_date_format($bulk_data->issued_date,\Auth::user()->id) }}</td>
                  <td>{{$bulk_data->sca_reference}}</td>
                  <td>{{$bulk_data->vo_reference}}</td>
                  <td>{{$bulk_data->reference}}</td>
                  <td>{{ Utility::site_date_format($bulk_data->vo_date,\Auth::user()->id) }}</td>
                  <td>{{$bulk_data->claimed_omission_cost}}</td>
                  <td>{{$bulk_data->claimed_addition_cost}}</td>
                  <td>{{$bulk_data->claimed_net_amount}}</td>
                  <td>{{$bulk_data->approved_omission_cost}}</td>
                  <td>{{$bulk_data->approved_addition_cost}}</td>
                  {{-- <td>{{$bulk_data->approved_net_cost}}
                  </td> --}}
                  {{-- <td>{{$bulk_data->impact_time}}</td>
                  <td>{{$bulk_data->granted_eot}}</td>
                  <td>{{$bulk_data->remarks}}</td> --}}
                  @if(Gate::check('edit vochange') || Gate::check('delete vochange'))
                  <td>
                    <div class="ms-2" style="display:flex;gap:10px;">
                      @can('edit vochange')
                      <a href="#"  class="btn btn-md bg-primary backgroundnone" data-url="{{ route('edit_variation_scope_change',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit VO or Change Order')}}">
                        <i class="ti ti-pencil text-white">
                        </i>
                      </a>
                      @endcan
                      @can('delete vochange')
                      {!! Form::open(['method' => 'POST', 'route' => ['delete_variation_scope_change', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                      {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                      {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                      <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                        <i class="ti ti-trash text-white mt-1">
                        </i>
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
          @endcan
        </div>
      </div>
    </div>    
</div>
@include('new_layouts.footer')
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script>
  $(document).on('keypress', function (e) {
    if (e.which == 13) {
        swal.closeModal();
    }
});

  $(document).ready(function() {
          $('#example2').DataTable({
              dom: 'Bfrtip',
              searching: true,
              info: true,
              paging: true,
              buttons: [
                  {
                      extend: 'excelHtml5',
                      title: 'VO or Change Order or Scope Change Authorization Summary',
                      titleAttr: 'Excel',
                      text: '<i class="fa fa-file-excel-o"></i>',
      
                      exportOptions: {
                          modifier: {
                              order: 'index', // 'current', 'applied','index', 'original'
                              page: 'all', // 'all', 'current'
                              search: 'none' // 'none', 'applied', 'removed'
                          },
                          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      title: 'VO or Change Order or Scope Change Authorization Summary',
                      titleAttr: 'PDF',
                      text: '<i class="fa fa-file-pdf-o"></i>',
                      customize: function(doc) {
                        // doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split(''); 
                        doc.styles.tableBodyEven.alignment = 'center';
                        doc.styles.tableBodyEven.noWrap = true;
                        doc.styles.tableBodyOdd.alignment = 'center';
                        doc.styles.tableBodyOdd.noWrap = true;
                        doc.styles.tableHeader.fontSize = 9;  
                        doc.defaultStyle.fontSize = 9;
                        doc.defaultStyle.alignment = 'center';
                        doc.styles.tableHeader.alignment = 'center';
                        },
                      exportOptions: {
                          modifier: {
                              order: 'index', // 'current', 'applied','index', 'original'
                              page: 'all', // 'all', 'current'
                              search: 'none' // 'none', 'applied', 'removed'
                          },
                          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                      }
                  },
                  {
                      extend: 'print',
                      title: 'VO or Change Order or Scope Change Authorization Summary',
                      titleAttr: 'Print',
                      text: '<i class="fa fa-print"></i>',
      
                      exportOptions: {
                          modifier: {
                              order: 'index', // 'current', 'applied','index', 'original'
                              page: 'all', // 'all', 'current'
                              search: 'none' // 'none', 'applied', 'removed'
                          },
                          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                      }
                  },
                  'colvis'
              ]
          });
        
      

          $(document).on("keyup", '.claimed_omission_cost', function (e) {
           
           var u1 = $('.claimed_omission_cost').val();

           if(u1.indexOf('-') !== -1){
             var s  = "(" + '' + ")";
             $('.claimed_omission_cost').val(s);
           

             
           }
         });

        

        $(document).on("keyup", '.approved_omission_cost', function (e) {
           
            var v1 = $('.approved_omission_cost').val();

            if(v1.indexOf('-') !== -1){
              var p  = "(" + '' + ")";
              $('.approved_omission_cost').val(p);
            }

         });

         $(document).on("keyup", '.claimed_addition_cost', function (e) {
           
           var additional_cost = $('.claimed_addition_cost').val();
           var omission_cost = $('.claimed_omission_cost').val();

           if(additional_cost.indexOf('-') !== -1){
               var add_bracket  = "(" + '' + ")";
               $('.claimed_addition_cost').val(add_bracket);
           }

           if (additional_cost.indexOf('(') !== -1) {
               additional_cost_minus = 'minus';
               additional_cost_remove_bracket = additional_cost.slice(1,-1);
           }
           else{
               additional_cost_minus = 'plus';
               var additional_cost_remove_bracket = additional_cost;
           }

           if (omission_cost.indexOf('(') !== -1) {
               omission_cost_minus = 'minus';
               omission_cost_remove_bracket   = omission_cost.slice(1,-1);
           }
           else{
               omission_cost_minus = 'plus';
               omission_cost_remove_bracket   = omission_cost;
           }

           if(additional_cost_minus == 'minus' && omission_cost_minus == 'minus'){
               var get_value = parseInt(additional_cost_remove_bracket) + parseInt(omission_cost_remove_bracket);
               var value = "-"+get_value;
           }
           else if(omission_cost_minus == "minus"){
               var value = -omission_cost_remove_bracket + parseInt(additional_cost_remove_bracket);
           }
           else if(additional_cost_minus == "minus"){
               var value = omission_cost_remove_bracket - additional_cost_remove_bracket;
           }
           else{
               var value = parseInt(additional_cost_remove_bracket) + parseInt(omission_cost_remove_bracket);
           }

           if(isNaN(value)){
               console.log("Nan");
           }else{
               if(String(value).indexOf('-') !== -1){
                   add_bracket_value_get = value.toString().replace('-','');
                   var add_bracket_value  = "(" + add_bracket_value_get + ")";
               }
               else{
                   var add_bracket_value = value;
               }
           }

           $('.claimed_net_amount').val(add_bracket_value);
       });

       $(document).on("keyup", '.approved_addition_cost', function (e) {
           
           var app_additional_cost = $('.approved_addition_cost').val();
           var app_omission_cost = $('.approved_omission_cost').val();

           if(app_additional_cost.indexOf('-') !== -1){
               var app_add_bracket  = "(" + '' + ")";
               $('.approved_addition_cost').val(app_add_bracket);
           }

           if (app_additional_cost.indexOf('(') !== -1) {
               app_additional_cost_minus = 'minus';
               app_additional_cost_remove_bracket = app_additional_cost.slice(1,-1);
           }
           else{
                app_additional_cost_minus = 'plus';
                var app_additional_cost_remove_bracket = app_additional_cost;
           }

           if (app_omission_cost.indexOf('(') !== -1) {
               app_omission_cost_minus = 'minus';
               app_omission_cost_remove_bracket   = app_omission_cost.slice(1,-1);
           }
           else{
               app_omission_cost_minus = 'plus';
               app_omission_cost_remove_bracket   = app_omission_cost;
           }

           if(app_additional_cost_minus == 'minus' && app_omission_cost_minus == 'minus'){
               var app_get_value = parseInt(app_additional_cost_remove_bracket) + parseInt(app_omission_cost_remove_bracket);
               var app_value = "-"+app_get_value;
           }
           else if(app_omission_cost_minus == "minus"){
               var app_value = -app_omission_cost_remove_bracket + parseInt(app_additional_cost_remove_bracket);
           }
           else if(app_additional_cost_minus == "minus"){
               var app_value = app_omission_cost_remove_bracket - app_additional_cost_remove_bracket;
           }
           else{
               var app_value = parseInt(app_additional_cost_remove_bracket) + parseInt(app_omission_cost_remove_bracket);
           }

           if(isNaN(app_value)){
               console.log("Nan");
           }else{
               if(String(app_value).indexOf('-') !== -1){
                   app_add_bracket_value_get = app_value.toString().replace('-','');
                   var app_add_bracket_value  = "(" + app_add_bracket_value_get + ")";
               }
               else{
                   var app_add_bracket_value = app_value;
               }
           }

           $('.approved_net_cost').val(app_add_bracket_value);
       });

       $(document).on("paste", '.impact_time', function (event) {
            if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
                event.preventDefault();
            }
        });

        $(document).on("keypress", '.impact_time', function (event) {
            if(event.which < 48 || event.which >58){
                return false;
            }
        });

        $(document).on("paste", '.granted_eot', function (event) {
            if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
                event.preventDefault();
            }
        });

        $(document).on("keypress", '.granted_eot', function (event) {
            if(event.which < 48 || event.which >58){
                return false;
            }
        });

});
      
</script>
