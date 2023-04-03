@extends('layouts.auth')
<style>
    .error{
        color:red;
    }
    .page{
        min-height:auto !important;
    }
    .topheader {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        align-items:center;
    }
    li.nav-item {
        list-style: none;
    }
    .font_size{
        font-size: 11px !important;
    }
    .backgroundimge{
        width: 150px;
        height: 80;
        object-fit: contain;
    }
    .navbar-brand-autodark,img.backgroundimge{
        display:flex !important;
        margin-left:auto !important;
        margin-right:auto !important;
    }
    li.nav-item {
        display: flex;
        position: absolute;
        right: 10px;
    }
    .form-control.is-invalid, .was-validated .form-control:invalid {
        background-image: unset !important;
    }
</style>
@php
  //  $logo=asset(Storage::url('uploads/logo/'));
       $logo=\App\Models\Utility::get_file('uploads/logo');

    $company_logo=Utility::getValByName('company_logo');
    $settings = Utility::settings();

@endphp
@push('custom-scripts')
    @if(env('RECAPTCHA_MODULE') == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('page-title')
    {{__('Login')}}
@endsection

@section('content')
<div class="page page-center">
  <div class="container container-tight py-4">
  <div class="topheader">
        <div class="">
        </div>
        <li class="nav-item ">
        <select class="btn btn-primary my-1 me-2 font_size" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
            @foreach(Utility::languages() as $language)
                <option class="font_size" @if($lang == $language) selected @endif value="{{ route('login',$language) }}">{{Str::upper($language)}}</option>
            @endforeach
        </select>
    </li>
    </div>
    <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark"><img src="https://mustbuilderp.s3.ap-southeast-1.amazonaws.com/uploads/logo/logo-dark.png" height="60" class="backgroundimge" alt=""></a>
    </div>
    {{Form::open(array('route'=>'login','method'=>'post',"class"=>"card card-md",'id'=>'loginForm' ))}}
    @csrf
  
    <div class="card-body">
        <h2 class="h2 text-center mb-4">{{__('Login to your account')}}</h2>
   


        <div class="form-group mb-3">
            <label for="email" class="form-label">{{__('Email')}}</label>
            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" placeholder="your@email.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">{{__('Password')}}</label>
            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Your password" required autocomplete="current-password">
            @error('password')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror

        </div>

        @if(env('RECAPTCHA_MODULE') == 'on')
            <div class="form-group mb-3">
                {!! NoCaptcha::display() !!}
                @error('g-recaptcha-response')
                <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        @endif
        <div class="form-group mb-4">

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs">{{ __('Forgot Your Password?') }}</a>
                @endif

        </div>
        <div class="d-grid">
            <button type="submit" class="btn-login btn btn-primary btn-block mt-2" id="login_button">{{__('Login')}}</button>
        </div>
        @if($settings['enable_signup'] == 'on')

        <p class="my-4 text-center">{{__("Don't have an account?")}} <a href="{{ route('register',!empty(\Auth::user()->lang)?\Auth::user()->lang:'en') }}" class="text-primary">{{__('Register')}}</a></p>
        @endif

    </div>
    {{Form::close()}}
    </div>

</div>
@endsection

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#form_data").submit(function (e) {
            $("#login_button").attr("disabled", true);
            return true;
        });
    });
   
    $(".is-invalid").click(function(){
        alert("button");
    });  
</script>

