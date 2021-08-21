@extends('layouts.auth')

@section('content')
<div class="content-body  min-vh-100 entrance">

    <div class=" p-0   login-poster">
    </div>

    <div class="p-0 pb-5 d-flex flex-column justify-content-start login-form ">

        <div class="row pt-lg-5 pb-lg-2 pt-1 pb-5 ">
            <div class="col-11 d-flex justify-content-end entrance-text ">
                <span class="pr-1 pr-md-2 pr-ld-4 ">Already a member?</span>
                <a href="/sippy-beans/login">Log in</a>
            </div>
            <div class="col-1"></div>
        </div>

        <div class="row d-flex align-content-center flex-grow-1">

            <div class="col-lg-3 col-2  d-none d-sm-block"></div>
            <div class="col-lg-6 col-sm-8 col-12 px-2 px-md-0">

                <div class="entrance-text pb-2 text-center text-md-left">
                    <h1>Create account</h1>
                </div>


                <div>

                    <form method="POST" action="{{ route('register') }}" class="form-confirm">
                        @csrf

                        <div class="form-body">
                            <div class="row">


                                <div class="col-12">
                                    <div class="form-group d-flex flex-column">

                                        <label for="name" >{{ __('Name of your roastery')}}
                                            </label>
                                        <input id="name" type="text"
                                               class="form-control order-1 @error('name') is-invalid @enderror"
                                               name="name" value="{{ old('name') }}" required autocomplete="name"
                                               autofocus>
                                        @error('name')
                                        <span class="invalid-feedback order-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group d-flex flex-column">
                                        <label for="email">{{ __('Email')
                                            }}</label>

                                        <input id="email" type="email"
                                               class="form-control order-1 @error('email') is-invalid @enderror"
                                               name="email" value="{{ old('email') }}" required
                                               autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback order-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group d-flex flex-column">
                                        <div class="pass-wrap order-1">
                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password"
                                                   required autocomplete="new-password">
                                            <img class="pass-view" src="{{ asset('assets/dist/assets/img/svg/pass.svg') }}" alt="pass">
                                        </div>

                                        <label for="password" >{{
                                            __('Password')
                                            }}</label>

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group d-flex flex-column">
                                        <div class="pass-wrap order-1">
                                            <input id="password-confirm" type="password" class="form-control"
                                                   name="password_confirmation" required autocomplete="new-password">
                                            <img class="pass-view" src="{{ asset('assets/dist/assets/img/svg/pass.svg') }}" alt="pass">
                                        </div>

                                        <label for="password-confirm" >{{
                                            __('Confirm
                                            password') }}</label>
                                        <span class="invalid-feedback pass-invalid-feedback order-2"
                                              role="alert"></span>

                                    </div>
                                </div>

                                <div class="col-12 ">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-content-center">
                                            <input type="checkbox" id="login-rember">
                                            <label for="login-rember" class="pl-1">I agree to the <a class="forget-link" href="#">Privacy Policy</a></label>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-12 pt-3 text-center text-md-left">
                                    <button type="submit" class="btn btn-orange btn-inline btn-lg">
                                        {{ __('Continue') }}
                                    </button>
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
