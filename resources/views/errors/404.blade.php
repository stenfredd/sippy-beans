@extends('layouts.home_layout')
@section('content')
   <div class="wrapper d-flex flex-column min-vh-100">
        <header class="header pt-4  pt-md-5  pb-4  ">
            <div class="container">
                <section class="row ">
                    <div class="col-xl-12 col-12 d-flex justify-content-center  w-100">
                        <div class="w-100">
                            <div class="row m-0  d-flex h-100 ">


                                <div class="col-6   align-self-center px-0 py-0 h-100">
                                    <a href="#" class="p-reletive d-flex h-100 align-items-center ">
                                        <img src="{{ asset('assets/dist/assets/img/svg/logo.svg') }}" alt="branding logo"
                                             class="logo">
                                    </a>
                                </div>


                                <div class="col-6  p-0">
                                    <div class="h-100 ">
                                        <div class="h-100 d-flex align-items-center justify-content-end">
                                                    <a href="/sippy-beans/login" class="pr-md-5 pr-3 header-link">Log in</a>
                                                    <a href="/sippy-beans/register" class="header-link">Sign up</a>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </header>


       <div class="container pt-xl-4 pt-md-5 pt-5 pb-5 pl-xl-5 flex-grow-1 d-flex align-items-center  ">
            <div class="text-center w-100">
              <img style="max-width: 100%; height: auto;" src="{{ asset('assets/dist/assets/img/svg/404.svg') }}" alt="404">
              <p>Sorry, the content you’re looking for doesn’t exist or has been moved</p>
              <a href="/sippy-beans/" class="btn btn-orange btn-inline btn-lg mt-5">Go to homepage</a>
            </div>
        </div>




        <footer class="header py-5 ">
        <div class="container">
            <section class="row">
                <div class="col-xl-12 col-12 d-flex justify-content-center  w-100">
                    <div class="w-100">
                        <div class="row m-0  d-flex h-100 ">


                            <div class="col-7 d-none d-md-block align-self-center px-0 py-0">
                                    <div class="d-flex ">
                                        <span class="footer-label pr-ld-5 pr-3">Location:<span class="footer-sublabel pl-2">Abu Dhabi, UAE</span></span>
                                        <span class="footer-label">Email:<a href="mailto:info@sippyme.com"
                                                                            class="pl-2 footer-sublabel">info@sippyme.com</a></span>
                                    </div>
                            </div>


                            <div class="col-12 col-md-5  p-0">
                                <div class="d-flex align-items-center justify-content-end">
                                    <a href="#" class="footer-label text-orange">CONTACT US</a>
                                    <span class="footer-sublabel pl-2">if you have questions</span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </section>
        </div>
        </footer>
    </div>
@endsection
