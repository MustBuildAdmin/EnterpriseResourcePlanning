@extends('layouts.auth')
@section('page-title')
    {{__('Verify Email')}}
@endsection
@php
  //  $logo=asset(Storage::url('uploads/logo/'));
    $logo=\App\Models\Utility::get_file('uploads/logo');
 $company_logo=Utility::getValByName('company_logo');
@endphp
@section('auth-topbar')

@endsection
@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600">{{__('Verify Your Email Address')}}</h2>
        @if (session('resent'))
            <p class="mb-4 text-muted">
                {{__('A fresh verification link has been sent to your email address.')}}
            </p>
        @endif
        <small class="text-muted">{{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
        </small>
        <small>
            <a href="{{ route('verification.resend') }}" class="text-primary">{{ __('click here to request another.') }}</a>
        </small>
    </div>
@endsection
