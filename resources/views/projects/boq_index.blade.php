@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">
<style>
    .wrappers{
        display: flex;
        justify-content: center;
    }
    .cards {
        display: flex;
        padding: 24px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
   
    @keyframes bounce2 {
        0%, 56%, 100% {
            transform: translateY(0px);
        }
        25% {
            transform: translateY(-30px);
        }
    }

    .check_code {
        margin-top: -8px;
    }
</style>
    <div class="page-wrapper">
        @include('construction_project.side-menu')
        <div class="row">
            <div class="row min-750" id="taskboard_view">
                <div class="card">
                    <div class="card-body" id="show_search_function">
                        <div class="row d-flex align-items-center justify-content-center">
                            <input type="hidden" name="project_id" id="project_id" value="{{$project_id}}">
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                                <div class="btn-box">
                                    {{ Form::label('security_code_label', __('Enter Your Security Code'),['class' => 'form-label']) }}
                                    {{ Form::number('security_code', null, ['class' => 'form-control security_code']) }}
                                </div>
                            </div>

                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary check_code" onclick="check_code();">
                                   Verify Code
                                </a>
                            </div>
                        </div>
                        <br>

                        <div class="row d-flex align-items-center justify-content-center hide_show_boq_div">
                            <input type="hidden" name="project_id" id="project_id" value="{{$project_id}}">
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                                <div class="btn-box">
                                    {{ Form::label('boq', __('Upload a BOQ File Here'), ['class' => 'form-label boq_file']) }}
                                    <input type='file' name='boq_file' id='boq_file' accept=".xlsx, .xls, .csv">
                                </div>
                            </div>

                            <div class="col-auto float-end ms-2 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@include('new_layouts.footer')

<script>
    $(document).ready(function() {
        function check_code(){
            project_id = $("#project_id").val();
        }
    });
</script>