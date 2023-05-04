@include('new_layouts.header')
@include('hrm.hrm_main')

<style>
.employee-detail-bod .fulls-card {
    min-height: 233px !important; 
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
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card ">
                            <div class="card-body employee-detail-body fulls-card">
                                <h5>{{__('Personal Detail')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('EmployeeId')}} : </strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{$employeesId}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Name')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{!empty($employee)?$employee->name:''}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">


                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Email')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                             <span>{{!empty($employee)?$employee->email:''}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Date of Birth')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{\Auth::user()->dateFormat(!empty($employee)?$employee->dob:'')}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Phone')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{!empty($employee)?$employee->phone:''}}</span>
                                        </div>

>
                                    </div>
                                    <div class="col-md-12">


                                        <div class="col-md-8 floatleft">
                                           <strong class="font-bold">{{__('Address')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                           <span>{{!empty($employee)?$employee->address:''}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Salary Type')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                           <span>{{!empty($employee->salaryType)?$employee->salaryType->name:''}}</span>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Salary Type')}} :</strong> <strong class="font-bold">{{__('Basic Salary')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                             <span>{{!empty($employee)?$employee->salary:''}}</span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="card ">
                            <div class="card-body employee-detail-body fulls-card">
                                <h5>{{__('Company Detail')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Branch')}} : </strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Department')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                        </div>

                                    </div>

                                    <div class="col-md-12">


                                       <div class="col-md-8 floatleft">
                                           <strong class="font-bold">{{__('Designation')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                           <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                        </div>
                                        
                                    </div>

                                    <div class="col-md-12">
                                      
                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Date Of Joining')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{\Auth::user()->dateFormat(!empty($employee)?$employee->company_doj:'')}}</span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card ">
                            <div class="card-body employee-detail-body fulls-card">
                                <h5>{{__('Document Detail')}}</h5>
                                <hr>
                                <div class="row">
                                    @php

                                        $employeedoc = !empty($employee)?$employee->documents()->pluck('document_value',__('document_id')):[];
                                    @endphp
                                    @if(!$documents->isEmpty())
                                        @foreach($documents as $key=>$document)
                                            <div class="col-md-12">
                                                <div class="info text-sm">
                                                    <strong class="font-bold">{{$document->name }} : </strong>
                                                    <span><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center">
                                            No Document Type Added.!
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card ">
                            <div class="card-body employee-detail-body fulls-card">
                                <h5>{{__('Bank Account Detail')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                       <div class="col-md-8 floatleft">
                                           <strong class="font-bold">{{__('Account Holder Name')}} : </strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                           <span>{{!empty($employee)?$employee->account_holder_name:''}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Account Number')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                           <span>{{!empty($employee)?$employee->account_number:''}}</span>
                                        </div>

    
                                    </div>

                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Bank Name')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{!empty($employee)?$employee->bank_name:''}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">


                                       <div class="col-md-8 floatleft">
                                           <strong class="font-bold">{{__('Bank Identifier Code')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{!empty($employee)?$employee->bank_identifier_code:''}}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                            <strong class="font-bold">{{__('Branch Location')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{!empty($employee)?$employee->branch_location:''}}</span>
                                        </div>

   
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-8 floatleft">
                                           <strong class="font-bold">{{__('Tax Payer Id')}} :</strong>
                                        </div>

                                        <div class="col-md-4 floatleft">
                                            <span>{{!empty($employee)?$employee->tax_payer_id:''}}</span>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
</div>
@include('new_layouts.footer')