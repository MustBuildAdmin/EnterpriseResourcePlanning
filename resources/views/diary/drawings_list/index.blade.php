
@include('new_layouts.header')
@include('construction_project.side-menu')

<div class="sitereportmain">
<div class="row">
  <div class="col-md-6">
      <h2>{{__('Drawings Reports')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">
        <a href="{{ route('drawing_listcreate') }}" data-size="lg" data-url="{{ route('drawing_listcreate') }}" class="gapbtn floatrght btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
  </div>
</div>


<div class="row">

    
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable bill dailyreport">
                            <thead>
                            <tr>
                                <th>{{__('Issued by')}}</th>
                                <th>{{__('Drawing No')}}</th>
                                <th>{{__('Drawing Views')}}</th>
                                <th>{{__('Drawing Description')}}</th>
                                <th>{{__('Issue Date')}}</th>
                                <th>{{__('Scale')}}</th>
                                <th>{{__('Size')}}</th>
                                <th>{{__('Remarks')}}</th>
                                <th style="width:25%;">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                          
                                <tr class="font-style">
                                    <td>Maincontractor</td>
                                    <td>A/xx-001</td>
                                    <td>Site Plan</td>
                                    <td>Excavation Plan</td>
                                    <td>20/5/2023</td>
                                    <td>NTS</td>
                                    <td>A1</td>
                                    <td>4</td>
                                        <td>
                                              <div class="ms-2">
                                                    <a href="{{ route('drawing_listedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
                                                </div>
                                            
                                        </td>
                                  
                                </tr>
                      
                                

                                <tr class="font-style">
                                    <td>Structural Co Pte Ltd</td>
                                    <td>S-001/xxx</td>
                                    <td>Site Plan</td>
                                    <td>Excavation Plan</td>
                                    <td>20/5/2023</td>
                                    <td>NTS</td>
                                    <td>A1</td>
                                    <td>9</td>
           
                                        <td>
                                               <div class="ms-2">
                                                    <a href="{{ route('drawing_listedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
                                                </div>
                                            
                                        </td>
                                  
                                </tr>



                                <tr class="font-style">
                                    <td>Maincontractor</td>
                                    <td>S-003/xxx</td>
                                    <td>Site Plan</td>
                                    <td>Sectional Views</td>
                                    <td>20/5/2023</td>
                                    <td>NTS</td>
                                    <td>A1</td>
                                    <td>4</td>
      
                                        <td>
                                    
                                           
                                                <div class="ms-2">
                                                    <a href="{{ route('drawing_listedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
                                                </div>
                                            
                                        </td>
                                  
                                </tr>



                                <tr class="font-style">
                                    <td>Structural Co Pte Ltd</td>
                                    <td>A/xx-001</td>
                                    <td>Site Plan</td>
                                    <td>Excavation Plan</td>
                                    <td>20/5/2023</td>
                                    <td>NTS</td>
                                    <td>A1</td>
                                    <td>5</td>
  
                                        <td>                                               
                                                <div class="ms-2">
                                                    <a href="{{ route('drawing_listedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
                                                </div>
                                            
                                        </td>
                                  
                                </tr>



                                <tr class="font-style">
                                    <td>Maincontractor</td>
                                    <td>A/xx-001</td>
                                    <td>Site Plan</td>
                                    <td>Floor Plans</td>
                                    <td>20/5/2023</td>
                                    <td>NTS</td>
                                    <td>A1</td>
                                    <td>7</td>
  
                                        <td>
                                                <div class="ms-2">
                                                    <a href="{{ route('drawing_listedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
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
</div>
@include('new_layouts.footer')
</div>

