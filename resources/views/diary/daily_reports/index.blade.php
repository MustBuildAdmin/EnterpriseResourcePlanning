
@include('new_layouts.header')
@include('construction_project.side-menu')

<div class="sitereportmain">
<div class="row">
  <div class="col-md-6">
      <h2>{{__('Daily Reports')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">
        <a href="{{ route('daily_reportscreate') }}" data-size="lg" data-url="{{ route('daily_reportscreate') }}" class="gapbtn floatrght btn btn-sm btn-primary">
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
                                <th>{{__('Daily Report No')}}</th>
                                <th>{{__('Contractor Name')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Project Name')}}</th>
                                <th>{{__('weather')}}</th>
                                <th>{{__('Site conditions')}}</th>
                                <th>{{__('Day')}}</th>
                                <th>{{__('Temparture')}}</th>
                                <th>{{__('Contractor')}}</th>
                                <th>{{__('Sub Contractor')}}</th>
                                <th >{{__('Major Equipment on project')}}</th>
                                <th style="width:25%;">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                          
                                <tr class="font-style">
                                    <td>1000</td>
                                    <td>Senthil</td>
                                    <td>20/5/2023</td>
                                    <td>VVN Construction</td>
                                    <td>Dusty</td>
                                    <td>Mudy</td>
                                    <td>MOnday</td>
                                    <td>45 F</td>
                                    <td>Kumar</td>
                                    <td>Mohan</td>
                                    <td>Crane</td>  
                                        <td>
                                              <div class="ms-2">
                                                    <a href="{{ route('daily_reportsedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
                                                </div>
                                            
                                        </td>
                                  
                                </tr>
                      
                                

                                <tr class="font-style">
                                    <td>1002</td>
                                    <td>Mohan</td>
                                    <td>20/5/2023</td>
                                    <td>KKn Construction</td>
                                    <td>wet</td>
                                    <td>Mudy</td>
                                    <td>MOnday</td>
                                    <td>45 F</td>
                                    <td>Kumar</td>
                                    <td>Mohan</td>
                                    <td>Crane</td>  
                                        <td>
                                               <div class="ms-2">
                                                    <a href="{{ route('daily_reportsedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
                                                </div>
                                            
                                        </td>
                                  
                                </tr>



                                <tr class="font-style">
                                    <td>1003</td>
                                    <td>Kuumar</td>
                                    <td>20/5/2023</td>
                                    <td>Kvv Construction</td>
                                    <td>Dusty</td>
                                    <td>Mudy</td>
                                    <td>MOnday</td>
                                    <td>45 F</td>
                                    <td>Kumar</td>
                                    <td>Mohan</td>
                                    <td>Crane</td>  
                                        <td>
                                    
                                           
                                                <div class="ms-2">
                                                    <a href="{{ route('daily_reportsedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
                                                </div>
                                            
                                        </td>
                                  
                                </tr>



                                <tr class="font-style">
                                    <td>1004</td>
                                    <td>Santhosh</td>
                                    <td>20/5/2023</td>
                                    <td>VVS Construction</td>
                                    <td>Dusty</td>
                                    <td>Mudy</td>
                                    <td>MOnday</td>
                                    <td>45 F</td>
                                    <td>Kumar</td>
                                    <td>Mohan</td>
                                    <td>Crane</td>  
                                        <td>                                               
                                                <div class="ms-2">
                                                    <a href="{{ route('daily_reportsedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                           
                                                <div class="ms-2">

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                  
                                                </div>
                                            
                                        </td>
                                  
                                </tr>



                                <tr class="font-style">
                                    <td>1005</td>
                                    <td>Vijay</td>
                                    <td>20/5/2023</td>
                                    <td>Vijay Construction</td>
                                    <td>Dusty</td>
                                    <td>Mudy</td>
                                    <td>MOnday</td>
                                    <td>45 F</td>
                                    <td>Kumar</td>
                                    <td>Mohan</td>
                                    <td>Crane</td>  
                                        <td>
                                                <div class="ms-2">
                                                    <a href="{{ route('daily_reportsedit') }}" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
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

