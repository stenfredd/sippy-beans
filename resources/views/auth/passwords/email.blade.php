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
<div class="content-body">
    <section class="row flexbox-container">
        <div class="col-xl-12 col-12 d-flex justify-content-center  w-100">
            <div class="card bg-authentication rounded-0 mb-0 w-100 full-hight ">
                <div class="row m-0  d-flex h-100">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-0 py-0 h-100 login-left">
                        <div class="p-reletive d-flex h-100 align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/sippy-logo-wite.png')}}" alt="branding logo"
                                class="login-logo">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 p-0 login-right">
                        <div class="card rounded-0 mb-0 px-2 pb-1 h-100">
                            <div class="card-dis d-flex align-items-center h-100">
                                <div class="w-100">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <div class="login-tital">
                                                <h1 class="mb-3 font-large-2 font-bold-900"><span
                                                        class="p-reletive">DASHBOARD</span></h1>
                                            </div>
                                            <h4 class="mb-0 font-large-2 text-bold-700">FORGOT PASSWORD</h4>
                                        </div>
                                    </div>
                                    <p class="px-2 font-medium-5 gray ">Did you forget you password? Enter your email
                                        and we’ll send a reset link over.</p>
                                    <div class="card-content mt-3">
                                        <div class="card-body pt-1">

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
                                                            <div class="form-group">
                                                                <label for="email-id-vertical">EMAIL ADDRESS</label>
                                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                                    placeholder="Email" name="email">

                                                                    @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit"
                                                                class="btn btn-primary float-left btn-inline btn-lg px-5 text-bold-600 font-medium-5 mt-3 float-right">REQUEST</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
