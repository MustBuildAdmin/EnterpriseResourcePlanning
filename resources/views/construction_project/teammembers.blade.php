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
<div class="container-fluid">
      <div class="card mt-5 p-4">
        <div class="card-header">
          <h3>Members of the Project</h3>
          <div class="card-actions">
            <div class="row">
              <div class="col-12">
              @can('edit project') <div class="float-end">
                  <a href="#" data-size="lg" data-url="{{ route('invite.project.member.view', $project->id) }}"
                  data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn  btn-primary"
                   >
                    {{__(' Invite a Member')}}
                  </a>
                </div> @endcan
              </div>
            </div>
          </div>
        </div>
      
        <div class="row row-cards" id="project_users">
         
        </div>
      </div>
     
    </div>


<section class="statis  text-center main2">
  <div class="row">
    <div class="col-md-6 col-lg-6 mb-6 mb-lg-0">
    </div>
  </div>
</section>

@include('new_layouts.footer')

    <script>
      function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        copy_email = $(element).data('copy_email');
        $temp.val(copy_email).select();
        document.execCommand("copy");
        $temp.remove();
        toastr.info("Copying to clipboard was successful!");
      }
      function copyToClipboardphone(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        copy_phone = $(element).data('copy_phone');
        $temp.val(copy_phone).select();
        document.execCommand("copy");
        $temp.remove();
        toastr.success("Copying to clipboard was successful!");
      }

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
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'
integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
