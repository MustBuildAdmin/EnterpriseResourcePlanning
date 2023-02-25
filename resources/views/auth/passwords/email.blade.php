@extends('layouts.auth')
@section('page-title')
    {{__('Forgot Password')}}
@endsection
@php
  //  $logo=asset(Storage::url('uploads/logo/'));
    $logo=\App\Models\Utility::get_file('uploads/logo');
 $company_logo=Utility::getValByName('company_logo');
@endphp
@section('auth-topbar')
    <li class="nav-item ">
        <select class="btn btn-primary my-1 me-2 " onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
            @foreach(Utility::languages() as $language)
                <option class="" @if($lang == $language) selected @endif value="{{ route('login',$language) }}">{{Str::upper($language)}}</option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600">{{__('Forgot Password')}}</h2>
        <p class="mb-4 text-muted">
            {{__('We will send a link to reset your password.')}}
        </p>
        @if (session('status'))
            <p class="mb-4 text-muted">
                {{ session('status') }}
            </p>
        @endif
    </div>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="">
            <div class="form-group mb-3">
                <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-block mt-2">{{__('Send Password Reset Link')}}</button>
            </div>
        </div>
        <p class="my-4">
            {{__('OR')}}
            <a href="{{ route('login') }}" class="f-w-400 text-primary">{{__('Signin')}}</a>
        </p>
    </form>
@endsection
