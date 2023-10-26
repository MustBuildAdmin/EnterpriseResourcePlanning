@include('new_layouts.header')
@include('construction_project.side-menu')

<link rel="stylesheet" href="{{ asset('WizardSteps/css/wizard.css') }}">
<style>
    .chosen-container{
        width: 100%!important;
        height: fit-content;
    }
    .backbtn{
        position: relative;
        justify-content: flex-end;
        display: flex;
        left: 98%;
    }
    .revisioncard{
        margin:10px;
    }
</style>

<div class="page-wrapper">
   
        <div class="col-md-6">
           <h2 class="revisioncard">{{ __('Revision Create') }}</h2>
        </div>

        <div class="col-md-6">
          <div class="col-auto ms-auto d-print-none float-end backbtn">
              <div class="input-group-btn">
                  <a href="{{ route('construction_main') }}" class="btn btn-danger"
                   data-bs-toggle="tooltip" title="{{ __('Back') }}">
                    <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
                  </a>
              </div>
          </div>
        </div>
   
  
    <div class="col-xl-12 mt-3">
        <div class="card table-card revisioncard">
            <div class="container-fluid mt-5">
                {{ Form::open(['url' => 'revision_store', 'method' => 'post',
                'enctype' => 'multipart/form-data', 'id' => 'create_revision_form',
                'class' => 'create_revision_form']) }}
                    <div>
                        <h3>{{ __('Non Working Days') }}</h3>
                        <section>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {{Form::label('non_working_days',__('non_working_days'),
                                        ['class'=>'form-label'])}}
                                        @php
                                            $non_working_days = array(
                                                '1' => 'Monday',
                                                '2' => 'Tuesday',
                                                '3' => 'Wednesday',
                                                '4' => 'Thursday',
                                                '5' => 'Friday',
                                                '6' => 'Saturday',
                                                '0' => 'Sunday'
                                            );
                                        @endphp
                                        {!! Form::select('non_working_days[]', $non_working_days, $setNonWorkingDays,
                                            array('id' => 'non_working_days',
                                            'class' => 'form-control chosen-select get_non_working_days',
                                            'multiple'=>'true'))
                                        !!}
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>{{ __('Holidays') }}</h3>
                        <section>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('holidays', __('Holidays'), ['class' => 'form-label']) }}

                                        <div class="table-responsive holiday_table" id="holiday_table">
                                            <table class="table" id="example2" style="width: 100%"> <!-- Revision -->
                                                <thead>
                                                    <tr>
                                                        <th><input class='check_all' type='checkbox'
                                                            onclick="select_all_key()"/></th>
                                                        <th>{{__('Date')}}</th>
                                                        <th>{{__('Description')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $inc = 1;
                                                    @endphp
                                                    @forelse ($projectHolidays as $setHolidays)
                                                        <tr id="{{$inc}}">
                                                            <td><input type='checkbox' class="case"/></td>
                                                            <td style="width: 30%;">
                                                                <input type="date" data-date_id='{{$inc}}'
                                                                value="{{$setHolidays->date}}"
                                                                class="form-control holiday_date get_date"
                                                                id="holiday_date{{$inc}}" name="holiday_date[]">
                                                                <label style='display:none;color:red;'
                                                                class='holiday_date_label{{$inc}}'>This Field is Required </label>
                                                            </td>
                                                            <td style="width: 70%;">
                                                                <input type="text" data-desc_id='{{$inc}}'
                                                                class="form-control holiday_description"
                                                                value="{{$setHolidays->description}}"
                                                                id="holiday_description{{$inc}}"
                                                                name="holiday_description[]">
                                                                <label style='display:none;color:red;'
                                                                class='holiday_description_label{{$inc}}'>
                                                                This Field is Required </label>
                                                            </td>
                                                        </tr>
                                                        @php $inc++; @endphp
                                                    @empty
                                                        
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>

                                        <button type="button" class='btn btn-danger delete_key'>
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;Delete Table Row
                                        </button>
                                        <button type="button" class='btn btn-primary addmore'>
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;Add More Table Row
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

@include('new_layouts.footer')
<script src="{{ asset('WizardSteps/js/jquery.steps.js') }}"></script>
<script>

    function getKeyId(){
        getKeyI = $("#example2 tbody tr").length;
     
        if(getKeyI != 0){
            return getKeyI;
        }
        else{
            return 1;
        }
    }

    var key_i = getKeyId();
    
    var check_validation = 0;
    $(document).on("click", '.addmore', function () {
        
        holidayValidation();

        if(check_validation == 0){
            var data="<tr id='"+key_i+"' class='duplicate_tr'>"+
                "<td><input type='checkbox' class='case'/></td>";
                data +="<td><input class='form-control holiday_date get_date' type='date' data-date_id='"+key_i+"' id='holiday_date"+key_i+"' name='holiday_date[]'/> <label style='display:none;color:red;' class='holiday_date_label"+key_i+"'>This Field Is Required </label></td>"+
                "<td><input class='form-control holiday_description' type='text' data-desc_id='"+key_i+"' id='holiday_description"+key_i+"' name='holiday_description[]'/> <label style='display:none;color:red;' class='holiday_description_label"+key_i+"'>This Field Is Required </label></td>"+
            "</tr>";

            $('.holiday_table tbody').append(data);
            key_i++;
        }
    });

    $(document).on("click", '.delete_key', function () {
        case_count = $('.case:checkbox:checked').length;
        if(case_count != 0){
            $('.case:checkbox:checked').parents("tr").remove();
            $('.check_all').prop("checked", false);
            check_key();
        }
        else{
            toastr.error("please Check One Row!");
        }
    });

    function check_key(){
        obj = $('.holiday_table tr');
        $.each( obj, function( key, value ) {
            id = value.id;
            $('#'+id).html(key+1);
        });
	}

    function select_all_key() {
        $('input[class=case]:checkbox').each(function(){
            if($('input[class=check_all]:checkbox:checked').length == 0){
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
    }

    $(document).on('change', '.holiday_date', function () {
        holiday_array   = [];
        holiday_date    = $(this).val();
        holiday_date_id = $(this).attr('id');
       
        $('.holiday_table tr').each(function(){
            pre_holiday = $(this).find(".get_date").val();
            pre_holiday_id = $(this).find(".get_date").attr('id');
            if(pre_holiday_id != holiday_date_id && pre_holiday != undefined && pre_holiday != ""){
                holiday_array.push(pre_holiday);
            }
        });

        if(holiday_array.indexOf(holiday_date) !== -1)
        {
            toastr.error("This Date Is Already Exist!");
            $(this).val("");
        }
    });

    $(function ()
    {
        var form = $("#create_revision_form");

        form.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            labels: {
                finish: 'Finish <i class="fa fa-chevron-right"></i>',
                next: 'Next <i class="fa fa-chevron-right"></i>',
                previous: '<i class="fa fa-chevron-left"></i> Previous'
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                holidayValidation();

                if(check_validation == 0){
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "Do You Want Create Revision for a New Instance?",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) {
                        }
                    });
                }
                else{
                    $(".last").attr('aria-disabled','true');
                    $(".last").addClass('error');
                    return false;
                }
                
            }
        });
    });

    $(document).ready(function() {
        $('.chosen-select').chosen();
    });

    function holidayValidation(){
        $( ".holiday_date" ).each(function(index) {
            get_inc_id = $(this).data('date_id');

            get_date_val = $("#holiday_date"+get_inc_id).val();
            get_desc_val = $("#holiday_description"+get_inc_id).val();

            if(get_date_val == ""){
                $(".holiday_date_label"+get_inc_id).show();
                check_validation = 1;
            }
            else if(get_desc_val == ""){
                $(".holiday_description_label"+get_inc_id).show();
                check_validation = 1;
            }
            else{
                $(".holiday_date_label"+get_inc_id).hide();
                $(".holiday_description_label"+get_inc_id).hide();
                check_validation = 0;
            }
        });
    }
   
</script>