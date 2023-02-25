<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{!empty($companySettings['title_text']) ? $companySettings['title_text']->value : config('app.name', 'ERPGO')}} - {{$job->title}}</title>

    <link rel="icon" href="{{asset(Storage::url('uploads/logo/')).'/'.(isset($companySettings['company_favicon']) && !empty($companySettings['company_favicon'])?$companySettings['company_favicon']->value:'favicon.png')}}" type="image" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/site.css') }}" id="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
.error{
    color: red;
}
</style>
<body>
<header class="header header-transparent" id="header-main">

    <nav class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light bg-white" id="navbar-main">
        <div class="container px-lg-0">
            <a class="navbar-brand mr-lg-5" href="#">
                <img class="hweb" alt="Image placeholder" src="{{asset(Storage::url('uploads/logo/')).'/'.(isset($companySettings['company_logo']) && !empty($companySettings['company_logo'])?$companySettings['company_logo']->value:'logo-dark.png')}}" id="navbar-logo" style="height: 50px;">
            </a>
            <button class="navbar-toggler pr-0" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-main-collapse">

                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <li class="nav-item">
                        <div class="dropdown global-icon" data-toggle="tooltip" data-original-titla="{{__('Choose Language')}}">
                            <a class="nav-link px-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0,10">
                                <i class="ti ti-globe-europe"></i>
                                <span class="d-none d-lg-inline-block">{{\Str::upper($currantLang)}}</span>
                            </a>

                            <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                @foreach($languages as $language)
                                    <a class="dropdown-item @if($language == $currantLang) text-danger @endif" href="{{route('job.apply',[$job->code,$language])}}">{{\Str::upper($language)}}</a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="main-content">
    <!-- Spotlight -->
    <section class="slice  bg-secondary" data-offset-top="#header-main">
        <div class="container pt-5">
            <div class="row row-grid justify-content-center">
                <div class="col-lg-10">
                    <h2 class="h1 mb-4">{{$job->title}}</h2>
                    <p class="lead lh-180 text-muted">
                        @foreach(explode(',',$job->skill) as $skill)
                            <span class="badge bg-primary p-2 px-3 rounded text-white"> {{$skill}}</span>
                        @endforeach
                    </p>
                    <p class="lead text-center"><i class="ti ti-map-pin"></i> {{!empty($job->branches)?$job->branches->name:''}} </p>

                </div>
            </div>
        </div>
    </section>

    <section class="slice">
        <div class="container">
            <div class="mb-5 text-center">
                <h3 class="mt-2">{{__('Apply for this job')}}</h3>
            </div>


            <div class="row justify-content-center">
                <div class="col-lg-8 justify-content-center">
                    <div class="card">
                        <div class="card-body">
                            {{Form::open(array('route'=>array('job.apply.data',$job->code),'method'=>'post', 'enctype' => "multipart/form-data"))}}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('name',__('Name*'),['class'=>'form-label'])}}
                                    {{Form::text('name',null,array('class'=>'form-control name','required'=>'required'))}}
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('email',__('Email*'),['class'=>'form-label'])}}
                                    {{Form::email('email',null,array('class'=>'form-control','required'=>'required'))}}
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('phone',__('Phone*'),['class'=>'form-label'])}}
                                    {{Form::number('phone',null,array('class'=>'form-control','required'=>'required'))}}
                                </div>
                                @if(!empty($job->applicant) && in_array('dob',explode(',',$job->applicant)))
                                    <div class="form-group col-md-6 ">
                                        {!! Form::label('dob', __('Date of Birth*'),['class'=>'form-label']) !!}
                                        {!! Form::date('dob', old('dob'), ['class' => 'form-control datepicker','max'=>'2999-12-25','required'=>'required']) !!}
                                    </div>
                                @endif
                                @if(!empty($job->applicant) && in_array('gender',explode(',',$job->applicant)))
                                    <div class="form-group col-md-6 ">
                                        {!! Form::label('gender', __('Gender'),['class'=>'form-label']) !!}
                                        <div class="d-flex radio-check">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="g_male" value="Male" name="gender" class="custom-control-input" >
                                                <label class="custom-control-label" for="g_male">{{__('Male')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="g_female" value="Female" name="gender" class="custom-control-input">
                                                <label class="custom-control-label" for="g_female">{{__('Female')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($job->applicant) && in_array('country',explode(',',$job->applicant)))
                                    <div class="form-group col-md-6 ">
                                        {{Form::label('country',__('Country*'),['class'=>'form-label'])}}
                                        <select class="form-control country" name="country" id='country' placeholder="Select Country" required>
                                            <option value="">{{ __('Select Country ...') }}</option>
                                            @foreach($country as $key => $value)
                                                <option value="{{$value->iso2}}">{{$value->name}}</option>
                                            @endforeach
                                         </select>
                                    </div>
                                    <div class="form-group col-md-6 country">
                                        {{Form::label('state',__('State*'),['class'=>'form-label'])}}
                                        <select class="form-control " name="state" id='state' placeholder="Select State" required>
                                            <option value="">{{ __('Select State ...') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 country">
                                        {{Form::label('city',__('City'),['class'=>'form-label'])}}
                                        {{Form::text('city',null,array('class'=>'form-control','required'=>'required'))}}
                                    </div>
                                @endif
                                @if(!empty($job->visibility) && in_array('profile',explode(',',$job->visibility)))
                                    <div class="form-group col-md-6 ">
                                        {{Form::label('profile',__('Profile'),['class'=>'col-form-label'])}}
                                        {{--                                                <label for="profile" class="form-label">--}}
                                        <input type="file" class="form-control" name="profile" id="profile" data-filename="profile_create" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                        {{--                                                </label>--}}
                                        <img id="blah" src="" class="mt-3" width="25%"/>
                                        <p class="profile_create"></p>
                                    </div>

                                @endif
                                @if(!empty($job->visibility) && in_array('resume',explode(',',$job->visibility)))
                                    <div class="form-group col-md-6 ">
                                        {{Form::label('resume',__('CV / Resume'),['class'=>'col-form-label'])}}

                                        {{--                                                <label for="resume" class="form-label">--}}
                                        <input type="file" class="form-control" name="resume" id="resume" data-filename="resume_create" onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])" required>
                                        {{--                                                </label>--}}
                                        <img id="blah1" class="mt-3" src="" width="25%"/>
                                        <p class="resume_create"></p>

                                    </div>
                                @endif
                                @if(!empty($job->visibility) && in_array('letter',explode(',',$job->visibility)))
                                    <div class="form-group col-md-12 ">
                                        {{Form::label('cover_letter',__('Cover Letter'),['class'=>'form-label'])}}
                                        {{Form::textarea('cover_letter',null,array('class'=>'form-control','rows'=>'3'))}}
                                    </div>
                                @endif
                                @foreach($questions as $question)
                                    <div class="form-group col-md-12  question question_{{$question->id}}">
                                        {{Form::label($question->question,$question->question,['class'=>'form-label'])}}
                                        <input type="text" class="form-control" name="question[{{$question->question}}]" {{($question->is_required=='yes')?'required':''}}>
                                    </div>
                                @endforeach
                                <div class="col-12">
                                    <div class="text-center mt-4">
                                        <button type="submit" id='save' class="btn btn-primary">{{__('Submit your application')}}</button>
                                    </div>
                                </div>
                            </div>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>

<footer id="footer-main">
    <div class="footer-dark">
        <div class="container">
            <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                <div class="col-md-6">
                    <div class="copyright text-sm font-weight-bold text-center text-md-left">
                        {{ !empty($companySettings['footer_text']) ? $companySettings['footer_text']->value : 'ERPGo SaaS' }}
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="ti ti-brand-dribbble"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="ti ti-brand-instagram"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="ti ti-brand-github"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="ti ti-brand-facebook"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/dash.js') }}"></script> --}}
<script src="{{ asset('js/moment.min.js') }}"></script>


<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/jscolor.js') }}"></script>

<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
@if($message = Session::get('success'))
    <script>
        show_toastr('success', '{!! $message !!}');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('error', '{!! $message !!}');
    </script>
@endif
</body>

</html>
<script>

$(document).on("change", '#country', function () {
            var name=$(this).val();
            var settings = {
                    "url": "https://api.countrystatecity.in/v1/countries/"+name+"/states",
                    "method": "GET",
                    "headers": {
                        "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
                    },
                    };
            
                    $.ajax(settings).done(function (response) {
                            $('#state').empty();
                            $('#state').append('<option value="">{{__('Select State ...')}}</option>');
                                $.each(response, function (key, value) {
                                    $('#state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
                                });
            });
    });

jQuery.validator.addMethod("validate_email", function(value, element) {

    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
    
}, "Please enter a valid Email.");

jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 ;
}, "Please specify a valid phone number");

$(document).on("click", '#save', function () {
    $(this).closest('form').validate({
    rules: {
        email: {
            validate_email: true
        },
        company_email: {
            validate_email: true
        },
        contact: {
                phoneUS: true
        },
        phone: {
                phoneUS: true
        },
    }
    });
});
</script>
