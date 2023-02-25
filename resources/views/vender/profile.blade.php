@extends('layouts.admin')
@php
  //  $profile=asset(Storage::url('uploads/avatar/'));
$profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Profile Account')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12">
            <div class="card profile-card">
                <div class="icon-user avatar rounded-circle">
                    <img alt="" src="{{(!empty($userDetail->avatar))? $profile.'/'.$userDetail->avatar : $profile.'/avatar.png'}}" class="">
                </div>
                <h4 class="h4 mb-0 mt-2"> {{$userDetail->name}}</h4>
                <div class="sal-right-card">
                    <span class="badge badge-pill badge-blue">{{$userDetail->type}}</span>
                </div>
                <h6 class="office-time mb-0 mt-4">{{$userDetail->email}}</h6>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
            <section class="col-lg-12 pricing-plan card">
                <div class="our-system password-card p-3">
                    <div class="row">
                        <ul class="nav nav-tabs my-4">
                            <li>
                                <a data-toggle="tab" href="#personal-info" class="active">{{__('Personal Info')}}</a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#billing-info" class="">{{__('Billing Info')}}</span> </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#shipping-info" class="">{{__('Shipping Info')}}</span> </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#change-password" class="">{{__('Change Password')}}</span> </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="personal-info" class="tab-pane in active">
                                {{Form::model($userDetail,array('route' => array('vender.update.profile'), 'method' => 'post', 'enctype' => "multipart/form-data"))}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('name',__('Name'),array('class'=>'form-label'))}}
                                            {{Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter User Name')))}}
                                            @error('name')
                                            <span class="invalid-name" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{Form::label('email',__('Email'),array('class'=>'form-label'))}}
                                        {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email')))}}
                                        @error('email')
                                        <span class="invalid-email" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        {{Form::label('contact',__('Contact'),array('class'=>'form-label'))}}
                                        {{Form::text('contact',null,array('class'=>'form-control','placeholder'=>__('Enter User Contact')))}}
                                        @error('contact')
                                        <span class="invalid-contact" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                        @enderror
                                    </div>
                                    @if(!$customFields->isEmpty())
                                        <div class="col-md-6">
                                            <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                                @include('customFields.formBuilder')
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <div class="choose-file">
                                                <label for="avatar">
                                                    <div>{{__('Choose file here')}}</div>
                                                    <input type="file" class="form-control" id="avatar" name="profile" data-filename="profiles">
                                                </label>
                                                <p class="profiles"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        <input type="submit" value="{{__('Save Changes')}}" class="btn-create badge-blue">
                                    </div>
                                </div>
                                {{Form::close()}}
                            </div>
                            <div id="billing-info" class="tab-pane">
                                {{Form::model($userDetail,array('route' => array('vender.update.billing.info'), 'method' => 'post'))}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('billing_name',__('Billing Name'),array('class'=>'form-label'))}}
                                            {{Form::text('billing_name',null,array('class'=>'form-control','placeholder'=>__('Enter Billing Name')))}}
                                            @error('billing_name')
                                            <span class="invalid-billing_name" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('billing_phone',__('Billing Phone'),array('class'=>'form-label'))}}
                                            {{Form::text('billing_phone',null,array('class'=>'form-control','placeholder'=>__('Enter Billing Phone')))}}
                                            @error('billing_phone')
                                            <span class="invalid-billing_phone" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('billing_zip',__('Billing Zip'),array('class'=>'form-label'))}}
                                            {{Form::text('billing_zip',null,array('class'=>'form-control','placeholder'=>__('Enter Billing Zip')))}}
                                            @error('billing_zip')
                                            <span class="invalid-billing_zip" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('billing_country',__('Billing Country'),array('class'=>'form-label'))}}
                                            {{Form::text('billing_country',null,array('class'=>'form-control','placeholder'=>__('Enter Billing Country')))}}
                                            @error('billing_country')
                                            <span class="invalid-billing_country" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('billing_state',__('Billing State'),array('class'=>'form-label'))}}
                                            {{Form::text('billing_state',null,array('class'=>'form-control','placeholder'=>__('Enter Billing State')))}}
                                            @error('billing_state')
                                            <span class="invalid-billing_state" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('billing_city',__('Billing City'),array('class'=>'form-label'))}}
                                            {{Form::text('billing_city',null,array('class'=>'form-control','placeholder'=>__('Enter Billing City')))}}
                                            @error('billing_city')
                                            <span class="invalid-billing_city" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('billing_address',__('Billing Address'),array('class'=>'form-label'))}}
                                            {{Form::textarea('billing_address',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Enter Billing Address')))}}
                                            @error('billing_address')
                                            <span class="invalid-billing_address" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        <input type="submit" value="{{__('Save Changes')}}" class="btn-create badge-blue">
                                    </div>
                                </div>
                                {{Form::close()}}
                            </div>
                            <div id="shipping-info" class="tab-pane">
                                {{Form::model($userDetail,array('route' => array('vender.update.shipping.info'), 'method' => 'post'))}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('shipping_name',__('Shipping Name'),array('class'=>'form-label'))}}
                                            {{Form::text('shipping_name',null,array('class'=>'form-control','placeholder'=>__('Enter Shipping Name')))}}
                                            @error('shipping_name')
                                            <span class="invalid-shipping_name" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('shipping_phone',__('Shipping Phone'),array('class'=>'form-label'))}}
                                            {{Form::text('shipping_phone',null,array('class'=>'form-control','placeholder'=>__('Enter Shipping Phone')))}}
                                            @error('shipping_phone')
                                            <span class="invalid-shipping_phone" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('shipping_zip',__('Shipping Zip'),array('class'=>'form-label'))}}
                                            {{Form::text('shipping_zip',null,array('class'=>'form-control','placeholder'=>__('Enter Shipping Zip')))}}
                                            @error('shipping_zip')
                                            <span class="invalid-shipping_zip" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('shipping_country',__('Shipping Country'),array('class'=>'form-label'))}}
                                            {{Form::text('shipping_country',null,array('class'=>'form-control','placeholder'=>__('Enter Shipping Country')))}}
                                            @error('shipping_country')
                                            <span class="invalid-shipping_country" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('shipping_state',__('Shipping State'),array('class'=>'form-label'))}}
                                            {{Form::text('shipping_state',null,array('class'=>'form-control','placeholder'=>__('Enter Shipping State')))}}
                                            @error('shipping_state')
                                            <span class="invalid-shipping_state" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{Form::label('shipping_city',__('Shipping City'),array('class'=>'form-label'))}}
                                            {{Form::text('shipping_city',null,array('class'=>'form-control','placeholder'=>__('Enter Shipping City')))}}
                                            @error('shipping_city')
                                            <span class="invalid-shipping_city" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('shipping_address',__('Shipping Address'),array('class'=>'form-label'))}}
                                            {{Form::textarea('shipping_address',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Enter Shipping Address')))}}
                                            @error('shipping_address')
                                            <span class="invalid-billing_address" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        <input type="submit" value="{{__('Save Changes')}}" class="btn-create badge-blue">
                                    </div>
                                </div>
                                {{Form::close()}}
                            </div>
                            <div id="change-password" class="tab-pane">
                                {{Form::model($userDetail,array('route' => array('vender.update.password',$userDetail->id), 'method' => 'post'))}}
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            {{Form::label('current_password',__('Current Password'),array('class'=>'form-label'))}}
                                            {{Form::password('current_password',array('class'=>'form-control','placeholder'=>__('Enter Current Password')))}}
                                            @error('current_password')
                                            <span class="invalid-current_password" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            {{Form::label('new_password',__('New Password'),array('class'=>'form-label'))}}
                                            {{Form::password('new_password',array('class'=>'form-control','placeholder'=>__('Enter New Password')))}}
                                            @error('new_password')
                                            <span class="invalid-new_password" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{Form::label('confirm_password',__('Re-type New Password'),array('class'=>'form-label'))}}
                                            {{Form::password('confirm_password',array('class'=>'form-control','placeholder'=>__('Enter Re-type New Password')))}}
                                            @error('confirm_password')
                                            <span class="invalid-confirm_password" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <input type="submit" value="{{__('Save Changes')}}" class="btn-create badge-blue">
                                    </div>
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
