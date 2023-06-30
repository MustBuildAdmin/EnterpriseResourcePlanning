@extends('layouts.auth')
<style>
    .error{
        width: 100%;
    margin-top: 0.25rem;
    font-size: 85.714285%;
    color: #d63939;
    }
</style>
@section('page-title')
    {{__('Register')}}
@endsection
@php
  //  $logo=asset(Storage::url('uploads/logo/'));
$logo=\App\Models\Utility::get_file('uploads/logo');
@endphp
@push('custom-scripts')
    @if(env('RECAPTCHA_MODULE') == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('auth-topbar')
    <li class="nav-item ">
        <select class="btn btn-primary my-1 me-2 " onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
            @foreach(Utility::languages() as $language)
                <option class="" @if($lang == $language) selected @endif value="{{ route('register',$language) }}">{{Str::upper($language)}}</option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600">{{__('Register')}}</h2>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="">
            <div class="form-group mb-3">
                <label for="name" class="form-label">{{__('Name')}}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">{{__('Email')}}</label>
                <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
                <div class="invalid-feedback">
                    {{__('Please fill in your email')}}
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">{{__('Password')}}</label>
                <input id="password" type="password" data-indicator="pwindicator" class="form-control pwstrength @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
                <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation" class="form-label">{{__('Password Confirmation')}}</label>
                <input id="password_confirmation" type="password" data-indicator="password_confirmation" class="form-control pwstrength @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
                <div id="password_confirmation" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="company_name" class="form-label">{{__('Company Name')}}</label>
                <input id="company_name" type="text" data-indicator="company_name" class="form-control pwstrength @error('company_name') is-invalid @enderror" name="company_name" required autocomplete="new-password">
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
            <div class="form-group mb-3">
                <label for="company_type" class="form-label">{{__('Company_type')}}</label>
                <select class="form-control pwstrength @error('company_type') is-invalid @enderror" name="company_type" required name='company_type'>
                    <option value=''>{{__('Select_Company_type')}}</option>
                    @foreach($companytype as $key => $value)
                    <option value='{{$value->id}}'>{{$value->name}}</option>
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
                <button type="submit" id='submit' class="btn btn-primary btn-block mt-2">{{__('Register')}}</button>

            </div>

        </div>
        <p class="my-4 text-center">{{__("Already' have an account?")}} <a href="{{ route('login',!empty(\Auth::user()->lang)?\Auth::user()->lang:'en') }}" class="text-primary">{{__('Login')}}</a></p>

    </form>
@endsection
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{asset('js/avatarImageGenrator.js')}}"></script>
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
    
    $(document).on("click", '#submit', function () {
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