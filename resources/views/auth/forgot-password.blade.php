    @extends('layouts.auth')

@section('page-title')
    {{ __('Reset Password') }}
@endsection

@push('custom-scripts')
    @if(env('RECAPTCHA_MODULE') == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
<style>
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
    .backgroundimge {
        width: 413px;
        height: 100px;
        object-fit: contain;
    }
    span.invalid-feedback {
    font-size: 14px;
}
</style>
@if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li style="text-align: center;list-style: none;font-weight:bold;">{{ Session::get('success') }}</li>
        </ul>
    </div>
@endif
@if (Session::has('smpterrors'))
    <div class="alert alert-danger">
        <ul>
            <li style="text-align: center;list-style: none;font-weight:bold;">{{ Session::get('smpterrors') }}</li>
        </ul>
    </div>
@endif

@section('content')
@php
    $logo=\App\Models\Utility::get_file('uploads/logo');
    $logo_dark = \App\Models\Utility::getValByName('logo_dark');
@endphp
<div class="page page-center">
  <div class="container container-tight py-4">
  <div class="topheader">
        <div class="">
        </div>
        <li class="nav-item ">
        <select class="btn btn-primary my-1 me-2 font_size" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
            @foreach(Utility::languages() as $language)
                <option class="font_size" @if($lang == $language) selected @endif value="{{ route('password.request',$language) }}">{{Str::upper($language)}}</option>
            @endforeach
        </select>
    </li>
    </div>
    <div class="text-center mb-4">
    </div>
    <div class="">
        @if(session('status'))
            <p class="mb-4 text-muted">
                {{ session('status') }}
            </p>
        @endif
    </div>
    <form method="POST" class="card card-md" action="{{ route('password.email') }}">
        @csrf
        <div class="card-body">
     <h2 class="card-title text-center mb-4">{{__('Reset Password')}}</h2>
     <p class="text-muted">{{__('Reset Password Subheader')}}</p>
     <a href="/" class="navbar-brand navbar-brand-autodark">
        <img src="{{$logo.'/'.(isset($logo_dark) && !empty($logo_dark)?$logo_dark:'logo-dark.png')}}"
         height="36"  class="backgroundimge" alt=""></a>

            <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('E-Mail') }}</label>
                <input id="email" type="email" class="form-control
                @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <small>{{ $message }}</small>
                </span>
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

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-block mt-2">{{ __('Send Password Reset Link') }}</button>
            </div>
            <p class="my-4 text-center">{{__("Back to")}} <a href="{{ route('login') }}" class="text-primary">{{__('Sign In')}}</a></p>

        </div>
    </form>
    </div>

</div>
@endsection




