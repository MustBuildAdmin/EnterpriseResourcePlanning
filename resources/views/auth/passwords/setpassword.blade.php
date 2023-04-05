@extends('layouts.auth')
@php
  //  $logo=asset(Storage::url('uploads/logo/'));
    $logo=\App\Models\Utility::get_file('uploads/logo');
 $company_logo=Utility::getValByName('company_logo');
@endphp
@section('page-title')
    {{__('Forgot Password')}}
@endsection
@section('auth-topbar')

@endsection
@section('content')
<div class="page page-center">
  <div class="container container-tight py-4">
   
    {{Form::open(array('route'=>'passwordupdate','method'=>'post','id'=>'loginForm','class'=>"card card-md"))}}
    <div class="card-body">
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <h2 class="card-title text-center mb-4">{{__('Set Password')}}</h2>
        <a href="/" class="navbar-brand navbar-brand-autodark"><img src="https://mustbuilderp.s3.ap-southeast-1.amazonaws.com/uploads/logo/logo-dark.png" height="60" class="backgroundimge" alt=""></a>
    
        <div class="form-group mb-3">
            {{Form::label('email',__('E-Mail Address'),['class'=>'form-label'])}}
            {{Form::text('email',null,array('class'=>'form-control'))}}
            @error('email')
            <span class="invalid-email text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group mb-3">
            {{Form::label('password',__('Password'),['class'=>'form-label'])}}
            {{Form::password('password',array('class'=>'form-control'))}}
            @error('password')
            <span class="invalid-password text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group mb-3">
            {{Form::label('password_confirmation',__('Password Confirmation'),['class'=>'form-label'])}}
            {{Form::password('password_confirmation',array('class'=>'form-control'))}}
            @error('password_confirmation')
            <span class="invalid-password_confirmation text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="d-grid">
            {{Form::submit(__('Set'),array('class'=>'btn btn-primary btn-block mt-2','id'=>'resetBtn'))}}
        </div>

    </div>

    {{Form::close()}}
</div>
</div>
@endsection
