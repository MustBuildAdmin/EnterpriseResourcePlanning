@include('new_layouts.header')
@include('accounting.side-menu')



<div class="row">
  <div class="col-md-6">
     <h2>Revenue</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create transfer')
        <a class="floatrght mb-3 btn btn-sm btn-primary"  href="#" data-size="lg" data-url="{{ route('transfer.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Transfer')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
    </a>
    @endcan

  </div>
</div>


    <div class="row">
   
        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Invoice')}}</th>
                                <th>{{__('Issue Date')}}</th>
                                <th>{{__('Due Amount')}}</th>
                                <th>{{__('Status')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                           
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      <div class="ms-2" style="display:flex;gap:10px;">
                                        <a href="http://localhost/musterpnew/public/employee/eyJpdiI6IkJ3dGYxOW1rUnhsV1ZKdjhFOUdscUE9PSIsInZhbHVlIjoiSUNVZUtYQitNTzZaZDVIRmp3SzlHZz09IiwibWFjIjoiMzliNmIwODM5NTdhYjEwMzk3YWIzZWE5ZjFhYWY4ODk4YWFkNDgxZmZmZmQxODUxNjFlNTI2YjkzM2YyMDg5NSIsInRhZyI6IiJ9/edit" class="btn btn-md bg-primary" data-bs-toggle="tooltip" data-original-title="Edit" aria-label="Edit" data-bs-original-title="Edit">
                                          <i class="ti ti-pencil text-white"></i>
                                        </a>
                                        <form method="POST" action="http://localhost/musterpnew/public/employee/129" accept-charset="UTF-8" id="delete-form-129">
                                          <input name="_method" type="hidden" value="DELETE">
                                          <input name="_token" type="hidden" value="tETQcqzxpcfwciWVlZTuvTuLhj9IEudc3K08xH5Z">
                                          <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" data-original-title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-129').submit();" aria-label="Delete" data-bs-original-title="Delete">
                                            <i class="ti ti-trash text-white"></i>
                                          </a>
                                        </form>
                                      </div>
                                    </td>
                                </tr>
                           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





@include('new_layouts.footer')
