@extends('layouts.home_layout')
@section('content')
   <div class="wrapper wrapper_main d-flex flex-column min-vh-100">
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
        <div class="container pt-xl-4 pt-md-5 pt-5 pb-5 pl-xl-5 flex-grow-1  ">
        <section class="row">
            <div class="col-xl-12 col-12 d-flex justify-content-center  w-100">
                <div class="b-0 w-100 ">
                    <div class="row m-0  d-flex ">


                        <div class="col-xl-7 col-12 p-0 order-xl-0 order-1 d-flex align-items-center justify-content-end ">
                            <div class=" mb-0 px-2 pb-1">
                                    <div class="row">
                                        <div class="col-12 p-0 text-center text-md-left"><span
                                                class="index-title">Effective cooperation</span></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 col-12 text-center text-md-left"><span
                                                class="index-title">with Sippy </span></div>
                                        <div class="col-md-6 col-12 col-lg-7 pt-md-5 pt-2 text-center text-md-left">
                                             <span
                                                     class="index-subtitle">On our partner portal, you will find materials and tools for effective cooperation and product promotion</span>
                                            <br>
                                            <button class="btn btn-orange  btn-lg mt-5 ">Become a partner</button>
                                        </div>
                                    </div>
                            </div>
                        </div>


                        <div class="col-xl-5 col-12   text-center align-self-center pl-xl-4 pl-0 py-0 pr-0 pb-xl-0 pb-5 mb-xl-0 mb-md-5 mb-4 h-100  ">
                            <div class=" d-flex  align-items-center justify-content-xl-start justify-content-center ">
                                <img src="{{ asset('assets/dist/assets/img/index_img.png') }}" class="index-img" alt="img"
                                     class="login-logo">
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>
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
