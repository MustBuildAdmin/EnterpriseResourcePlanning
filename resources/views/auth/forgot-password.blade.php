    @extends('layouts.auth')

@section('page-title')
    {{ __('Reset Password') }}
@endsection

@push('custom-scripts')
    @if(env('RECAPTCHA_MODULE') == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('auth-topbar')

@endsection
@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600">{{__('Reset Password')}}</h2>
        @if(session('status'))
            <p class="mb-4 text-muted">
                {{ session('status') }}
            </p>
        @endif
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="">
            <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('E-Mail') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
@endsection




