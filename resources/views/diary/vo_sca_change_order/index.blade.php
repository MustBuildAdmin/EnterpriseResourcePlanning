@include('new_layouts.header')
@include('construction_project.side-menu')
<div class="row">
  <div class="col-md-6">
     <h2>{{__('VO or Change Order or Scope Change Authorization Summary')}}</h2> 
  </div>
<style>
   /* pagination */
   .pagination {
        height: 36px;
        margin: 18px 0;
        color: #6c58bF;
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
.action-btn {
    display: inline-grid !important;
}
h3, .h3 {
    font-size: 1rem !important;
}

</style>

    <div class="col-xl-12 mt-3">
      <div class="card table-card">
        <div class="col-auto float-end ms-4 mt-4">
          @can('create vochange')
          <a href="#" data-size="xl" data-url="{{ route('add_variation_scope_change',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
          </a>
          @endcan
        </div>
        <div class="card-header card-body table-border-style">
          @can('manage vochange')
          <div class="table-responsive">
            <table class="table datatable" id="example1">
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
                  <th>{{__('Net Amount')}}</th>
                  <th>{{__('Impact/Lead Time')}}</th>
                  <th>{{__('Granted EOT(in days)')}}</th>
                  <th>{{__(' Remarks')}}</th>
                  <th>{{__('Action')}}</th>
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
                            <td>{{$bulk_data->approved_net_cost}}</td>
                            <td>{{$bulk_data->impact_time}}</td>
                            <td>{{$bulk_data->granted_eot}}</td>
                            <td>{{$bulk_data->remarks}}</td>
                            <td>
                              @can('edit vochange')
                              <div class="action-btn bg-primary ms-2">
                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('edit_variation_scope_change',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                                  <i class="ti ti-pencil text-white"></i>
                                </a>
                              </div>
                              @endcan
                             
                              @can('delete vochange')
                              <div class="action-btn bg-danger ms-2"> 
                                {!! Form::open(['method' => 'POST', 'route' => ['delete_variation_scope_change', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                                @csrf
                                {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                                {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                                  <i class="ti ti-trash text-white mt-1"></i>
                                </a> 
                                {!! Form::close() !!} 
                              </div>
                              @endcan
                              
                            </td> 
                          </tr>
                          {{-- @empty 
                          <tr>
                              <td  colspan="15" class="text-center">No VO or Change Order or Scope Change Authorization Summary Data Found</td>
                          </tr>  --}}
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

