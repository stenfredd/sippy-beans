@extends('layouts.auth')

@section('content')

<div class="content-body  min-vh-100 entrance">

    <div class=" p-0   login-poster">
    </div>

    <div class="p-0 pb-5 d-flex flex-column justify-content-start align-content-center login-form  ">


        <div class="row d-flex align-content-center flex-grow-1">

            <div class="col-lg-3 col-2  d-none d-sm-block"></div>
            <div class="col-lg-6 col-sm-8 col-12 px-2 px-md-0 pt-5">

                <div class="entrance-text pb-2 text-center text-md-left">
                    <h1>Create a new password</h1>
                </div>


                <div>

                    <form class="form form-vertical form-confirm" action=""
                          method="post">
                        <div class="form-body">
                            <div class="row">

                               <div class="col-12">
                                    <div class="form-group d-flex flex-column">
                                        <div class="pass-wrap order-1">
                                            <input name="password" id="password"
                                                   type="password"
                                                   class="form-control  "
                                                   required autocomplete="off">
                                            <img class="pass-view" src="{{ asset('assets/dist/assets/img/svg/pass.svg') }}" alt="pass">
                                        </div>
                                        <label for="password">Password</label>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group d-flex flex-column">
                                        <div class="pass-wrap order-1">
                                            <input name="password-confirm" id="password-confirm"
                                                   type="password"
                                                   class="form-control order-1 "
                                                   required autocomplete="off">
                                            <img class="pass-view" src="{{ asset('assets/dist/assets/img/svg/pass.svg') }}" alt="pass">
                                        </div>
                                        <label for="password-confirm">Confirm password</label>

                                        <span class="invalid-feedback pass-invalid-feedback order-2" role="alert"></span>
                                    </div>
                                </div>


                                <div class="col-12 pt-3 text-center text-md-left">
                                    <button type="submit"
                                            class="btn btn-orange btn-inline btn-lg">Save</button>

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
