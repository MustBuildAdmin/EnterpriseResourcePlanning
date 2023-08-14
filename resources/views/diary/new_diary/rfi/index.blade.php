@include('new_layouts.header')
@include('consultants.dashboard.side_bar',['hrm_header' => 'Dashboard'])
<div class="row">
    <div class="col-md-6">
       <h2>{{__('RFI')}}</h2>
    </div>
    <div class="col-xl-12 mt-3">
        <div class="card table-card">
          <div class="container-fluid">
            <p class="text-center">Content</p>
          </div>
        </div>
    </div>
</div>
@include('new_layouts.footer')
