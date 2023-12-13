@extends('layouts.auth')
@php
    $logo=\App\Models\Utility::get_file('uploads/logo');
    $company_logo=Utility::getValByName('company_logo');
@endphp
    <style>
        .mainDiv {
            display: flex;
            min-height: 100%;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
            font-family: 'Open Sans', sans-serif;
        }
        .cardStyle {
            width: 500px;
            border-color: white;
            background: #fff;
            padding: 36px 0;
            border-radius: 4px;
            margin: 30px 0;
            box-shadow: 0px 0 2px 0 rgba(0,0,0,0.25);
        }
        #signupLogo {
            max-height: 100px;
            margin: auto;
            display: flex;
            flex-direction: column;
        }
        .formTitle{
            font-weight: 600;
            margin-top: 20px;
            color: #2F2D3B;
            text-align: center;
        }
        .inputLabel {
            font-size: 12px;
            color: #555;
            margin-bottom: 6px;
            margin-top: 24px;
        }
        .inputDiv {
            width: 70%;
            display: flex;
            flex-direction: column;
            margin: auto;
        }
        input {
            height: 40px;
            font-size: 16px;
            border-radius: 4px;
            border: none;
            border: solid 1px #ccc;
            padding: 0 11px;
        }
        input:disabled {
            cursor: not-allowed;
            border: solid 1px #eee;
        }
        .buttonWrapper {
            margin-top: 40px;
        }
        .submitButton {
            width: 70%;
            height: 40px;
            margin: auto;
            display: block;
            color: #fff;
            background-color: #206bc4;
            border-color: #206bc4;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.12);
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.035);
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }
        .submitButton:disabled,
            button[disabled] {
            border: 1px solid #cccccc;
            background-color: #cccccc;
            color: #666666;
        }

        /* Progress Bar */
        #progress {
            height: 20px;
            width: 100%;
            margin-top: 0.6em;
        }
        #progress-bar {
            width: 0%;
            height: 20%;
            transition: width 500ms linear;
        }
        .progress-bar-danger {
            background: #d00;
        }
        .progress-bar-warning {
            background: #f50;
        }
        .progress-bar-success {
            background: #080;
        }

        .Short {
            width: 100%;
            color: #dc3545;
            font-weight: 500;
            font-size: 15px;
        }
        .Weak {
            width: 100%;
            color: #ffc107;
            font-weight: 500;
            font-size: 15px;
        }
        .Good {
            width: 100%;
            color: #28a745;
            font-weight: 500;
            font-size: 15px;
        }
        .Strong {
            width: 100%;
            color: #d39e00;
            font-weight: 500;
            font-size: 15px;
        }
    </style>

    @section('page-title')
        {{__('Forgot Password')}}
    @endsection
    @section('auth-topbar')

    @endsection
@php  $email = $request->query('email'); @endphp
    @section('content')
        <div class="mainDiv">
            <div class="cardStyle">
                {{Form::open(array('route'=>'password.update','method'=>'post','id'=>'loginForm'))}}
                    <h2 class="formTitle">
                        {{__('Reset Password')}}
                    </h2>

                    <div class="inputDiv">
                        {{Form::label('email',__('E-Mail Address'),['class'=>'form-label inputLabel'])}}
                        {{Form::text('email',$email,array('required'=>'required'))}}

                        @error('email')
                            <span class="invalid-email text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="inputDiv">
                        {{Form::label('email',__('New Password'),['class'=>'form-label inputLabel'])}}
                        {{Form::password('password',array('required'=>'required','id'=>'password'))}}

                        <div id="show_progress" style="display: none;">
                            <div id="progress"><div id="progress-bar"></div></div>
                            <div id="strengthMessage"></div>
                        </div>


                        @error('password')
                            <span class="invalid-password text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="inputDiv">
                        {{Form::label('email',__('Confirm Password'),['class'=>'form-label inputLabel'])}}
                        {{Form::password('password_confirmation',array('required'=>'required','id'=>'password_confirmations'))}}
                        <div id="not_match" style="display:none;color:red;">{{ __("Passwords Don't Match") }}</div>

                        @error('password_confirmation')
                            <span class="invalid-password_confirmation text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="buttonWrapper">
                        {{Form::submit(__('Reset'),array('class'=>'submitButton pure-button pure-button-primary','id'=>'resetBtn'))}}
                    </div>
                {{Form::close()}}
            </div>
        </div>
    @endsection

    <script src="{{ asset('assets/dist/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>


    <script>
        $.strength = function( element, password ) {
            var desc = [{'width':'0px'}, {'width':'20%'}, {'width':'40%'}, {'width':'60%'}, {'width':'80%'}, {'width':'100%'}];
            var descClass = ['', 'progress-bar-danger', 'progress-bar-danger', 'progress-bar-warning', 'progress-bar-success', 'progress-bar-success'];
            var score = 0;

            if(!password){
                $('#strengthMessage').html('');
                $("#resetBtn").prop('disabled',true);
            }

            if( password.length < 6 ) {
                score++;
                $('#strengthMessage').removeClass();
                $('#strengthMessage').addClass('Short');
                $('#strengthMessage').html('Short');
                $("#resetBtn").prop('disabled',true);
            }

            if( password.length > 6 ) {
                score++;
                $("#resetBtn").prop('disabled',true);
            }

            if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) {
                score++;
                $('#strengthMessage').removeClass();
                $('#strengthMessage').addClass('Weak');
                $('#strengthMessage').html('Weak');
                $("#resetBtn").prop('disabled',true);
            }

            if ( password.match(/\d+/) ) {
                score++;
                $('#strengthMessage').removeClass();
                $('#strengthMessage').addClass('Good');
                $('#strengthMessage').html('Good');
                $("#resetBtn").prop('disabled',false);
            }

            if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) {
                score++;
                $('#strengthMessage').removeClass();
                $('#strengthMessage').addClass('Strong');
                $('#strengthMessage').html('Strong');
                $("#resetBtn").prop('disabled',false);
            }
            var re = new RegExp('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/');
           console.log( re.test(password));

            if ( password.length > 10 ) {
                score++;
                $("#resetBtn").prop('disabled',false);
            }

            element.removeClass( descClass[score-1] ).addClass( descClass[score] ).css( desc[score] );
        };

        $(function() {
            $("#password").keyup(function() {
                $("#show_progress").css('display','block');
                $.strength( $("#progress-bar"), $(this).val());
            });

            $("#password_confirmations").keyup(function() {
                var password     = $("#password").val();
                confirm_password = $(this).val();

                if(password != confirm_password) {
                    $("#not_match").css('display','block');
                    $("#resetBtn").prop('disabled',true);
                    return false;
                } else {
                    $("#not_match").css('display','none');
                    $("#resetBtn").prop('disabled',false);
                    return true;
                }
            });
        });
    </script>
    <script>
$().ready(function() {
$('#loginForm').validate({
    rules: {
        password:{
                required:true,
                // changepass:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/,
                changepasss:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
                minlength: 8,
                maxlength: 36,
            },
            password_confirmation:{
                required:true,
                minlength: 8,
                maxlength: 36,
                equalTo: "#password"
            },
    },
    messages: {
        password: {
                required: "Please enter password",
                minlength:"Please enter atleast 8characters",
                maxlength:"Please enter below 36 characters."
            },
            password_confirmation: {
                required: "Please enter confirmation password",
                minlength:"Please enter atleast 8characters",
                maxlength:"Please enter below 36 characters.",
                equalTo:"Password and confirm password must be same"
            }

    },
    submitHandler: function(form) {
        form.submit();
    }
});
});

$.validator.addMethod(
        "changepasss",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "The password must be Minimum eight characters, at least one uppercase letter, one lowercase letter and one number and one special character."
);

</script>
<style>
.error {
    color: #bc4949  !important ;
}
</style>
