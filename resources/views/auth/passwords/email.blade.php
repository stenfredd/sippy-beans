{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
@endsection --}}


@extends('layouts.auth')
@section('content')
<div class="content-body  min-vh-100 entrance">

    <div class=" p-0   login-poster">
    </div>

    <div class="p-0 pb-5 d-flex flex-column justify-content-start align-content-center login-form ">

        <div class="row pt-lg-5 pb-lg-2 pt-1 pb-5 pb-5  ">
            <div class="col-12 d-flex justify-content-between align-content-center entrance-text px-lg-5 px-md-5 px-2 mr-0 ">
                <a href="/sippy-beans/login" class="back"></a>
                <div style="line-height: 35px">
                    <span class="pr-1 pr-md-2 pr-lg-4">Don’t have an account?</span>
                    <a href="/sippy-beans/register" class="pr-0 pr-lg-3">Sign up</a>
                </div>
            </div>
        </div>

        <div class="row d-flex align-content-center flex-grow-1">

            <div class="col-lg-3 col-2  d-none d-sm-block"></div>
            <div class="col-lg-6 col-sm-8 col-12 px-2 px-md-0">

                <div class="entrance-text pb-2 text-center text-md-left">
                    <h1>Forgot password?</h1>
                    <p>Enter the email address you used when you joined
                        and we’ll send you instructions to reset your password</p>
                </div>


                <div>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif


                    <form class="form form-vertical" action="{{ route('password.email') }}"
                          method="post">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group d-flex flex-column">
                                        <input type="email"
                                               class="form-control order-1 @error('email') is-invalid @enderror"
                                               placeholder="" name="email">
                                        <label for="email-id-vertical">Email</label>

                                        @error('email')
                                        <span class="invalid-feedback order-2" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 pt-3 text-center text-md-left">
                                    <button type="submit"
                                            class="btn btn-orange btn-inline btn-lg">Send</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="col-lg-3 col-2 d-none d-sm-block"></div>
        </div>

    </div>

</div>
@endsection
