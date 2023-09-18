@include('new_layouts.header')
<style>
.green {
    background-color: #206bc4 !important;
}
</style>
@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>

<div class="page-wrapper dashboard">

@include('construction_project.side-menu')
<section class="container">
  <div class="col-lg-12 bgwhite">
    <div class="card">
      <div class="card-header">
        <div class="headingnew align-items-center justify-content-between">
          <h5>{{__('Members')}}</h5> @can('edit project') <div class="float-end">
            <a href="#" data-size="lg" data-url="{{ route('invite.project.member.view', $project->id) }}"
             data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
              data-bs-original-title="{{__('Add Member')}}">
              <i class="ti ti-plus"></i>
            </a>
          </div> @endcan
        </div>
      </div>
      <div class="card-body">
        <ul class="list-group list-group-flush list" id="project_users"></ul>
      </div>
    </div>
  </div>
</section>

<section class="statis  text-center main2">
  <div class="row">
    <div class="col-md-6 col-lg-6 mb-6 mb-lg-0">
    </div>
  </div>
</section>

@include('new_layouts.footer')

    <script>
     

        $(document).ready(function () {
            loadProjectUser();
        });

        function loadProjectUser() {
            var mainEle = $('#project_users');
            var project_id = '{{$project->id}}';

            $.ajax({
                url: '{{ route('project.user') }}',
                data: {project_id: project_id},
                beforeSend: function () {
                    $('#project_users')
                    .html('<tr><th colspan="2" class="h6 text-center pt-5">{{__('Loading...')}}</th></tr>');
                },
                success: function (data) {
                    mainEle.html(data.html);
                    $('[id^=fire-modal]').remove();
                    // loadConfirm();
                }
            });
        }

    </script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
