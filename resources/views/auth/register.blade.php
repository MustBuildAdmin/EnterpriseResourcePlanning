@extends('layouts.auth')
<style>
    .error {
        color: #b72222 ;
    }
    .page {
        min-height: auto !important;
    }
    .topheader {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        align-items: center;
    }
    .form-control.is-invalid, .was-validated .form-control:invalid {
        background-image: unset !important;
    }
    .error_class{
        color:#b72222 ;
        font-weight:bold;
    }
    li.nav-item {
        list-style: none;
    }
    li {
        font-weight: bold;
    }
    .backgroundimge {
        width: 150px;
        height: 80;
        object-fit: contain;
    }
    option {
    text-transform: capitalize;
    }
    .navbar-brand-autodark,
    img.backgroundimge {
        display: flex !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }
    li.nav-item {
        display: flex;
        position: absolute;
        right: 10px;
    }
    .font_size{
        font-size: 11px !important;
    }
</style>
@section('page-title')
    {{ __('Register') }}
@endsection
@php
    //  $logo=asset(Storage::url('uploads/logo/'));
    $logo = \App\Models\Utility::get_file('uploads/logo');
@endphp
@push('custom-scripts')
    @if (env('RECAPTCHA_MODULE') == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
      <div class="topheader">
        <div class=""></div>
        <li class="nav-item ">
          <select class="btn btn-primary my-1 me-2 font_size"
           onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
           @foreach (Utility::languages() as $language)
           <option class="" @if ($lang==$language) selected @endif value="{{ route('register', $language) }}">
            {{ Str::upper($language) }}
          </option>
           @endforeach
          </select>
        </li>
      </div>
      <a href="/" class="navbar-brand navbar-brand-autodark">
        <img src="https://mustbuilderp.s3.ap-southeast-1.amazonaws.com/uploads/logo/logo-dark.png"
        height="60" class="backgroundimge" alt="">
      </a>
      <form class="card card-md" id="registration" method="POST" action="{{ route('register') }}">
        <div class="card-body"> @csrf <h2 class="card-title text-center mb-4">{{ __('Sign Up') }}</h2>
          <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}
              <span class="error_class">*</span>
            </label>
            <input id="name" type="text" class="form-control
             @error('name') is-invalid @enderror"
             name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}
              <span class="error_class">*</span>
            </label>
            <input class="form-control @error('email') is-invalid @enderror" id="email"
             type="email" name="email" value="{{ old('email') }}" required
              autocomplete="email" autofocus> @error('email')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          {{-- <input type="hidden" name="password" value="{{Utility::randomPassword()}}"> --}}
          <div class="mb-3">
            <label for="company_name" class="form-label">{{ __('Company Name') }}
              <span class="error_class">*</span>
            </label>
            <input id="company_name" type="text" data-indicator="company_name"
             class="form-control pwstrength @error('company_name') is-invalid @enderror"
              name="company_name" required autocomplete="new-password" value="{{ old('company_name') }}">
              @error('company_name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
              @enderror
            <div id="company_name" class="pwindicator">
              <div class="bar"></div>
              <div class="label"></div>
            </div>
          </div>
          <div class="mb-3">
            <label for="company_type" class="form-label">{{ __('Company_type') }}
              <span class="error_class">*</span>
            </label>
            <select class="form-control pwstrength @error('company_type') is-invalid @enderror"
             name="company_type" required name='company_type'>
              <option value=''>{{ __('Select_Company_type') }}</option>
              @foreach ($companytype as $key => $value)
              <option value='{{ $value->id }}' {{ old('company_type') == $value->id  ? 'selected' : '' }}>
                {{__($value->name)}}
              </option>
              @endforeach
            </select>
            @error('company_type')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
             <div id="company_type" class="pwindicator">
              <div class="bar"></div>
              <div class="label"></div>
            </div>
          </div>
          <div class="mb-3">
            <label for="company_type" class="form-label">{{ __('Type') }}
              <span class="error_class">*</span>
            </label>
            <select class="form-control pwstrength @error('company_type') is-invalid @enderror" name="type" required>
              <option value=''>{{ __('Select Type') }}</option>
              <option value="company">{{ __('Company') }}</option>
              <option value="consultant">{{ __('Consultant') }}</option>
              <option value="sub_contractor">{{ __('Sub Contractor') }}</option>
            </select>
          </div> @if (env('RECAPTCHA_MODULE') == 'on')
          <div class="mb-3">
            {!! NoCaptcha::display() !!}
             @error('g-recaptcha-response')
             <span class="small text-danger" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          @endif
          <div class="mb-3">
            <label class="form-check">
              <input type="checkbox" class="form-check-input">
              <span class="form-check-label">Agree the <a href="#" tabindex="-1">terms and policy</a>.</span>
            </label>
          </div>
          <div class="d-grid">
            <button type="submit" id='submit' class="btn btn-primary btn-block mt-2">{{ __('Register') }}</button>
          </div>
        </div>
      </form>
      <div class="text-center text-muted mt-3">
        {{ __("Already have an account?") }}
        <a href="{{ route('login', !empty(\Auth::user()->lang) ? \Auth::user()->lang : 'en') }}"
           tabindex="-1">{{ __('Login') }}
        </a>
      </div>
    </div>
  </div>
@endsection
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/avatarImageGenrator.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/jscolor.js') }}"></script>
<!-- script of the validator  -->
<script src="{{ asset('js/jquery.validate.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#registration").validate({
            onfocusout: false,
            onkeyup: false,
            rules: {
                // simple rule, converted to {required:true}
                name: {
                    required: true,
                    minlength: 3
                },
                // compound rule
                email: {
                    required: true,
                    email: true
                }
            }
        });
    });
    //     jQuery.validator.addMethod("validate_email", function(value, element) {
    //         if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     }, "Please enter a valid Email.");
    //     jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    //         phone_number = phone_number.replace(/\s+/g, "");
    //         return this.optional(element) || phone_number.length > 9 ;
    //     }, "Please specify a valid phone number");
    //     $(document).on("click", '#submit', function () {
    //         $(this).closest('form').validate({
    //         rules: {
    //             email: {
    //                 validate_email: true
    //             },
    //             company_email: {
    //                 validate_email: true
    //             },
    //             contact: {
    //                     phoneUS: true
    //             },
    //             phone: {
    //                     phoneUS: true
    //             },
    //         }
    //         });
    //     });
    // $(document).on('keyup', function () {
    // if ($("#name").val().length <= 2) {
    //   $(".name_error").show();
    //   $(".message_display").hide();
    //   $("#submit").prop('disabled', true);
    // }else{
    //    $(".name_error").hide();
    //    $(".message_display").show();
    //    $("#submit").prop('disabled', false);
    // }
    // });
</script>
