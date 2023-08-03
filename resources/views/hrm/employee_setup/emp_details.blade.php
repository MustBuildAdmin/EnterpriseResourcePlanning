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
        <div class="row">
            
            <div class="col-xl-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Base info</h3>
              </div>
              <div class="card-body">
                <div class="datagrid">
                  <div class="datagrid-item">
                    <div class="datagrid-title">Registrar</div>
                    <div class="datagrid-content">Third Party</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Nameservers</div>
                    <div class="datagrid-content">Third Party</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Port number</div>
                    <div class="datagrid-content">3306</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Expiration date</div>
                    <div class="datagrid-content">–</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Creator</div>
                    <div class="datagrid-content">
                      <div class="d-flex align-items-center">
                        <span class="avatar avatar-xs me-2 rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                        Paweł Kuna
                      </div>
                    </div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Age</div>
                    <div class="datagrid-content">15 days</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Edge network</div>
                    <div class="datagrid-content">
                      <span class="status status-green">
                        Active
                      </span>
                    </div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Avatars list</div>
                    <div class="datagrid-content">
                      <div class="avatar-list avatar-list-stacked">
                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                        <span class="avatar avatar-xs rounded">JL</span>
                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/002m.jpg)"></span>
                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/003m.jpg)"></span>
                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000f.jpg)"></span>
                        <span class="avatar avatar-xs rounded">+3</span>
                      </div>
                    </div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Checkbox</div>
                    <div class="datagrid-content">
                      <label class="form-check">
                        <input class="form-check-input" type="checkbox" checked="">
                        <span class="form-check-label">Click me</span>
                      </label>
                    </div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Icon</div>
                    <div class="datagrid-content">
                      <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon text-green" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                      Checked
                    </div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Form control</div>
                    <div class="datagrid-content">
                      <input type="text" class="form-control form-control-flush" placeholder="Input placeholder">
                    </div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Longer description</div>
                    <div class="datagrid-content">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit.
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