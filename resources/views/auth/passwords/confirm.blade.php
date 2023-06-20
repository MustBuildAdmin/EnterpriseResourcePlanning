@extends('layouts.auth')
@section('page-title')
    {{__('Confirm Password')}}
@endsection
@php
   // $logo=asset(Storage::url('uploads/logo/'));
    $logo=\App\Models\Utility::get_file('uploads/logo');
 $company_logo=Utility::getValByName('company_logo');
@endphp

@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600">{{__('Confirm Password')}}</h2>
        <p class="mb-4 text-muted">
            {{__(' Please confirm your password before continuing.')}}
        </p>
    </div>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="">
            <div class="form-group mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
            <div class="d-grid">
                <button type="submit" class="btn-login btn btn-primary btn-block mt-2">{{ __('Confirm Password') }}</button>
            </div>
            @if (Route::has('password.request'))
                <p class="my-4 text-center">{{__("OR")}} <a href="{{ route('password.request') }}" class="text-primary">{{__('Forgot Your Password?')}}</a></p>
            @endif
        </div>
    </form>
@endsection
