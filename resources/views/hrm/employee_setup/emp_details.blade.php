@include('new_layouts.header')
@include('hrm.hrm_main')

<style>
.employee-detail-bod .fulls-card {
    min-height: 233px !important; 
}

.card {
  box-shadow: 0 6px 30px rgba(182, 186, 203, 0.3);
  margin-bottom: 24px;
  transition: box-shadow 0.2s ease-in-out;
  min-height: 270px;
}


</style>

    @if(!empty($employee))
        <div class="float-end m-2 mb-3 employeebtn">
            @can('edit employee')
                <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" data-bs-toggle="tooltip" title="{{__('Edit')}}"class="btn btn-sm btn-primary">
                    <i class="ti ti-pencil"></i>
                </a>
            @endcan
        </div>

        <div class="text-end ">
            <div class="d-flex justify-content-end drp-languages mb-3">
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a style="text-decoration: none;" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('Joining Letter')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="{{route('joiningletter.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>

                            <a href="{{route('joininglatter.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a style="text-decoration: none;" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('Experience Certificate')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="{{route('exp.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>

                            <a href="{{route('exp.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a style="text-decoration: none;" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('NOC')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="{{route('noc.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>
                            <a href="{{route('noc.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    @endif

    @if(!empty($employee))
        <div class="">
            <div class="col-xl-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{__('Personal Detail')}}</h3>
              </div>
              <div class="card-body">
                <div class="datagrid">
                  <div class="datagrid-item">
                    <div class="datagrid-title">{{__('EmployeeId')}}</div>
                    <div class="datagrid-content">{{$employeesId}}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">{{__('Name')}}</div>
                    <div class="datagrid-content">{{!empty($employee)?$employee->name:''}}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">{{__('Email')}}</div>
                    <div class="datagrid-content">{{!empty($employee)?$employee->email:''}}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">{{__('Date of Birth')}}</div>
                    <div class="datagrid-content">{{\Auth::user()->dateFormat(!empty($employee)?$employee->dob:'')}}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">{{__('Phone')}}</div>
                    <div class="datagrid-content">
                    {{!empty($employee)?$employee->phone:''}}
                    </div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">{{__('Address')}}</div>
                    <div class="datagrid-content">{{!empty($employee)?$employee->address:''}}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">{{__('Salary Type')}}</div>
                    <div class="datagrid-content">{{!empty($employee)?$employee->salary:''}}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">{{__('Basic Salary')}}</div>
                    <div class="datagrid-content">{{!empty($employee)?$employee->salary:''}}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title"></div>
                    <div class="datagrid-content">
                      <span class="status status-green">
                        Active
                      </span>
                    </div>
                  </div>         
                </div>
              </div>
            </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Company Detail')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">{{__('Branch')}}</div>
                            <div class="datagrid-content">{{!empty($employee->branch)?$employee->branch->name:''}}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">{{__('Department')}}</div>
                            <div class="datagrid-content">{{!empty($employee->department)?$employee->department->name:''}}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">{{__('Designation')}}</div>
                            <div class="datagrid-content">{{!empty($employee->designation)?$employee->designation->name:''}}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">{{__('Date Of Joining')}}</div>
                            <div class="datagrid-content">{{\Auth::user()->dateFormat(!empty($employee)?$employee->company_doj:'')}}</div>
                        </div>
                        </div>
                    </div>
                </div>
             </div>
             <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Document Detail')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                                  @php

                                        $employeedoc = !empty($employee)?$employee->documents()->pluck('document_value',__('document_id')):[];
                                    @endphp

                                    @if(!$documents->isEmpty())
                                    @foreach($documents as $key=>$document)
                                    <div class="datagrid-item">
                                      <div class="datagrid-title">{{$document->name }}</div>
                                      <div class="datagrid-content"><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></div>
                                    </div>
                                    @endforeach
                                    @else
                                        <div class="text-center">
                                            No document is Added.!
                                        </div>
                                    @endif
                        </div>
                    </div>
                </div>
             </div>
                
        </div>
    @endif

</div>
</div>
@include('new_layouts.footer')