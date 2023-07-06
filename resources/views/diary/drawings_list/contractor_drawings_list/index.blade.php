<div class="container" id="content_id">
    <div class="col-md-6">
       <h2>{{__('Contractor As-Built Drawings List')}}</h2>
    </div>
    @can('create directions')
    <div class="col-auto ms-auto d-print-none">
       <div class="input-group-btn">
          <a href="#" data-size="xl" data-url="{{ route('add_project_specification',["project_id"=>$project_id]) }}"  data-ajax-popup="true" data-title="{{__('Create Project Specifications Summary')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-primary">
          <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
          </a>
          <a href="{{ route('projects.show', $project_id) }}"  class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Back') }}">
          <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
          </a>
       </div>
    </div>
    @endcan
    <div class="col-xl-12 mt-3">
       <div class="card table-card">
          <div class="container-fluid">
             @can('manage project specification')
             <div class="table">
                <table class="table" id="example2">
                   <thead class="">
                      <tr>
                         <th>{{__('S.No')}}</th>
                         <th>{{__('Reference No')}}</th>
                         <th>{{__('Description')}}</th>
                         <th>{{__('Location')}}</th>
                         <th>{{__('Drawing References (if any)')}}</th>
                         <th>{{__('Remarks/ Notes')}}</th>
                         <th>{{__('Attachments')}}</th>
                         @if(Gate::check('edit project specification') || Gate::check('delete project specification'))
                         <th>{{__('Action')}}</th>
                         @endif
                      </tr>
                   </thead>
                   <tbody>
                   </tbody>
                </table>
             </div>
             @endcan
          </div>
       </div>
    </div>
 </div>