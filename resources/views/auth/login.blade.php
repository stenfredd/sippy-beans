@extends('layouts.auth')
@section('content')
<div class="content-body  min-vh-100 entrance">

    <div class=" p-0   login-poster">
    </div>

    <div class="p-0 pb-5 d-flex flex-column justify-content-start login-form ">

        <div class="row pt-lg-5 pb-lg-2 pt-1 pb-5 ">
            <div class="col-12 d-flex justify-content-end entrance-text px-lg-5 px-md-5 px-2 mr-0 ">
                <span class="pr-1 pr-md-2 pr-ld-4 ">Don’t have an account?</span>
                <a href="/sippy-beans/register" class="pr-0 pr-lg-3">Sign up</a>
            </div>
        </div>

        <div class="row d-flex align-content-center flex-grow-1">

            <div class="col-lg-3 col-2  d-none d-sm-block"></div>
            <div class="col-lg-6 col-sm-8 col-12 px-2 px-md-0">

                <div class="entrance-text pb-2 text-center text-md-left">
                    <h1>Welcome!</h1>
                    <p>Log in to access your account</p>
                </div>


                <div>
                    <form class="form form-vertical" id="login_form" method="POST"
                          action="{{ route('login') }}">
                        @csrf
                        <div class="form-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group d-flex flex-column">
                                        <input id="email" type="email" name="email"
                                               class="form-control order-1 @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}"
                                               autocomplete="off"
                                               autofocus required/>
                                        <label for="email-id-vertical">Email</label>

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
                                            <input name="password" id="password"
                                                   type="password"
                                                   class="form-control  @error('password') is-invalid @enderror"
                                                   required autocomplete="off">
                                            <img class="pass-view" src="{{ asset('assets/dist/assets/img/svg/pass.svg') }}" alt="pass">
                                        </div>
                                            <label for="password-vertical">Password</label>

                                        @error('password')
                                        <span class="invalid-feedback order-2" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-12 ">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-content-center">
                                            <input type="checkbox" id="login-rember" name="remember">
                                            <label for="login-rember" class="pl-1 pl-md-3">Remember me</label>
                                        </div>
                                        <a class="forget-link" href="{{ url('password/reset') }}">Forgot
                                            Your
                                            Password?</a>
                                    </div>
                                </div>


                                <div class="col-12 pt-3 text-center text-md-left">
                                    <button type="submit"
                                            class="btn btn-orange btn-inline btn-lg ">LOG
                                    IN</button>

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
