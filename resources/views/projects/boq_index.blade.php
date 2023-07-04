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
                    <form action="{{route('boq_file_upload')}}" enctype="multipart/form-data" method="POST">
                       @csrf
                        <div class="card-body" id="show_search_function">
                            <div class="hide_show_verify_div">
                                <div class="row d-flex align-items-center justify-content-center">
                                    <input type="hidden" name="project_id" id="project_id" value="{{$project_id}}">
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                                        <div class="btn-box">
                                            {{ Form::label('security_code_label', __('Enter Your Security Code'),['class' => 'form-label']) }}
                                            {{ Form::number('security_code', null, ['class' => 'form-control security_code', 'maxlength' => '8']) }}
                                            <span style="color: rgb(189, 49, 49); display:none;" class="show_error">OOPS! Your code is incorrect Please Enter correct Code</span>
                                            <span style="color: rgb(189, 49, 49); display:none;" class="show_error_required">Please Enter the Verify Code</span>
                                        </div>
                                    </div>

                                    <div class="col-auto float-end ms-2 mt-4">
                                        <a href="#" class="btn btn-sm btn-primary check_code" onclick="check_code()">
                                        Verify Code
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="hide_show_boq_div" style="display:none;">
                                <div class="row d-flex align-items-center justify-content-center" >
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
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@include('new_layouts.footer')

<script>
    function check_code(){
        project_id = $("#project_id").val();
        security_code = $(".security_code").val();

        if(security_code != ""){
            $(".show_error_required").hide();
            $(".show_error").hide();
            $.ajax({
                url : '{{ route("boq_code_verify") }}',
                type : 'GET',
                data : {'project_id': project_id, 'security_code': security_code, '_token': "{{ csrf_token() }}"},
                success : function(data_check) {
                    if(data_check == 1){
                        $(".hide_show_boq_div").show();
                        $(".hide_show_verify_div").hide();
                        $(".show_error").hide();
                    }
                    else{
                        $(".hide_show_boq_div").hide();
                        $(".hide_show_verify_div").show();
                        $(".show_error").show();
                    }
                },
                error : function(request,error)
                {
                    alert("Request: "+JSON.stringify(request));
                }
            });
        }
        else{
            $(".show_error").hide();
            $(".show_error_required").show();
        }

        
    }
</script>