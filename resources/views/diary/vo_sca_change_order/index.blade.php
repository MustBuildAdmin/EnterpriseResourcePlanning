@include('new_layouts.header')
@include('construction_project.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  /* pagination */
.pagination {
	height: 36px;
	margin: 18px 0;
	color: #6c58bF;
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    background: #fff;
    max-width: 1072px !important;
   
}

.pagination ul {
	display: inline-block;
	*display: inline;
       /* IE7 inline-block hack */
	*zoom: 1;
	margin-left: 0;
	color: #ffffff;
	margin-bottom: 0;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	-webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
	-moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.pagination li {
	display: inline;
	color: #6c58bF;
}

.pagination a {
	float: left;
	padding: 0 14px;
	line-height: 34px;
	color: #6c58bF;
	text-decoration: none;
	border: 1px solid #ddd;
	border-left-width: 0;
}

.pagination a:hover,
   .pagination .active a {
	background-color: var(--tblr-pagination-active-bg);
	color: #ffffff;
}

.pagination a:focus {
	background-color: #ffffff;
	color: #ffffff;
}

.pagination .active a {
	color: #ffffff;
	cursor: default;
}

.pagination .disabled span,
   .pagination .disabled a,
   .pagination .disabled a:hover {
	color: #999999;
	background-color: transparent;
	cursor: default;
}

.pagination li:first-child a {
	border-left-width: 1px;
	-webkit-border-radius: 3px 0 0 3px;
	-moz-border-radius: 3px 0 0 3px;
	border-radius: 3px 0 0 3px;
}

.pagination li:last-child a {
	-webkit-border-radius: 0 3px 3px 0;
	-moz-border-radius: 0 3px 3px 0;
	border-radius: 0 3px 3px 0;
}

.pagination-centered {
	text-align: center;
}

.pagination-right {
	text-align: right;
}

.pager {
	margin-left: 0;
	margin-bottom: 18px;
	list-style: none;
	text-align: center;
	color: #6c58bF;
	*zoom: 1;
}

.pager:before,
   .pager:after {
	display: table;
	content: "";
}

.pager:after {
	clear: both;
}

.pager li {
	display: inline;
	color: #6c58bF;
}

.pager a {
	display: inline-block;
	padding: 5px 14px;
	color: #6c58bF;
	background-color: #fff;
	border: 1px solid #ddd;
	-webkit-border-radius: 15px;
	-moz-border-radius: 15px;
	border-radius: 15px;
}

.pager a:hover {
	text-decoration: none;
	background-color: #f5f5f5;
}

.pager .next a {
	float: right;
}

.pager .previous a {
	float: left;
}

.pager .disabled a,
   .pager .disabled a:hover {
	color: #999999;
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
                  <td>{{$bulk_data->issued_date}}</td>
                  <td>{{$bulk_data->sca_reference}}</td>
                  <td>{{$bulk_data->vo_reference}}</td>
                  <td>{{$bulk_data->reference}}</td>
                  <td>{{$bulk_data->vo_date}}</td>
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
{{-- <script src="{{ asset('assets/js/jquery.alphanum.js') }}"></script> --}}
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

         $(document).on("keyup", '.claimed_addition_cost', function (e) {
           
           var n1 = $('.claimed_addition_cost').val();
           var n2 = $('.claimed_omission_cost').val();
           var n3 = $('.claimed_net_amount').val();


           if(n1.indexOf('-') !== -1){
             var r  = "(" + '' + ")";
             $('.claimed_addition_cost').val(r);
           }

           if (n1.indexOf('(') !== -1) {
            console.log("n1",n1);
               n1_minus = 'minus';
               var c = n1.slice(1,-1);
           }
           else{
            console.log("n11",n1);
               n1_minus = '+';
               var c = n1;
           }

           if (n2.indexOf('(') !== -1) {
               n2_minus = 'minus';
               var cc   = n2.slice(1,-1);
           }
           else{
               n2_minus = '+';
               var cc   = n2;
           }

           if(n1_minus == 'minus' && n2_minus == 'minus'){
            var r = parseInt(c) + parseInt(cc);
           
            }
           else if(n1_minus == "minus"){
                var r = cc - c;
            }
            else if(n2_minus == "minus"){
                var r = cc - c;
            }
            else{
                var r = parseInt(c) + parseInt(cc);
            }

            
            if(cc>c && n2_minus == 'minus'){
                var r = cc- c;
                var r  ="(" + r + ")" ;
                $('.claimed_net_amount').val(r);
                console.log("1");
            }else if(cc>c && n2_minus == 'minus'){
                var r = cc - c;
                var r  ="(" + r + ")" ;
                $('.claimed_net_amount').val(r);
                console.log("2");
            }else if(cc>c && n1_minus == 'minus'){
                var r = c - cc;
                var r  ="(" + r + ")" ;
                $('.claimed_net_amount').val(r);
                console.log("3");
            }else if(cc<c && n2_minus == 'minus'){
                var r = c - cc;
                var r  =r
                $('.claimed_net_amount').val(r);
                console.log("4");
            }else if(cc<c && n1_minus == 'minus'){
                var r = c - cc;
                var r  ="(" + r + ")" ;
                $('.claimed_net_amount').val(r);
                console.log("5");
            }
            else{
              $('.claimed_net_amount').val(r);
              console.log("6");
            }

        });

        $(document).on("keyup", '.approved_omission_cost', function (e) {
           
            var v1 = $('.approved_omission_cost').val();

            if(v1.indexOf('-') !== -1){
              var p  = "(" + '' + ")";
              $('.approved_omission_cost').val(p);
            }

         });

         $(document).on("keyup", '.approved_net_cost', function (ev) {
           
           var m1 = $('.approved_addition_cost').val();
           var m2 = $('.approved_omission_cost').val();
           var m3 = $('.approved_net_cost').val();


           if(m1.indexOf('-') !== -1){
             var q  = "(" + '' + ")";
             $('.approved_addition_cost').val(q);
           }

           if (m1.indexOf('(') !== -1) {
            
               m1_minus = 'minus';
               var d = m1.slice(1,-1);
           }
           else{
            
              m1_minus = '+';
               var d = m1;
           }

           if (m2.indexOf('(') !== -1) {
               m2_minus = 'minus';
               var dd   = m2.slice(1,-1);
           }
           else{
               m2_minus = '+';
               var dd   = m2;
           }

           if(m1_minus == 'minus' && m2_minus == 'minus'){
            var q = parseInt(d) + parseInt(dd);
           
            }
           else if(m1_minus == "minus"){
                var q = dd - d;
            }
            else if(n2_minus == "minus"){
                var q = dd - d;
            }
            else{
                var q = parseInt(d) + parseInt(dd);
            }

            
            if(dd>d && m2_minus == 'minus'){
                var q = dd- d;
                var q  ="(" + q + ")" ;
                $('.approved_net_cost').val(r);
                console.log("1");
            }else if(dd>d && m2_minus == 'minus'){
                var q = dd - d;
                var q  ="(" + q + ")" ;
                $('.approved_net_cost').val(r);
                console.log("2");
            }else if(dd>d && m1_minus == 'minus'){
                var q = d - dd;
                var q  ="(" + q + ")" ;
                $('.approved_net_cost').val(q);
                console.log("3");
            }else if(dd<d && m2_minus == 'minus'){
                var q = dd - d;
                var q  ="(" + q + ")" ;
                $('.approved_net_cost').val(q);
                console.log("4");
            }else if(dd<d && m1_minus == 'minus'){
                var q = d - dd;
                var q  ="(" + q + ")" ;
                $('.approved_net_cost').val(q);
                console.log("5");
            }else{
              $('.approved_net_cost').val(q);
              console.log("6");
            }

        });

});
      
</script>
