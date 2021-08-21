@extends('layouts.step-form_layout')
@section('content')
  <div class="content-body  min-vh-100 stepper">

    <!--основная часть-->
    <div class="pb-4 d-flex flex-column justify-content-start login-form container ">

        <!--логотип-->
        <div class="row  pt-4  pt-md-5  pt-lg-5 pb-lg-2  pb-0 ">
            <div class="col-12">
                <a href="#">
                    <img src="{{ asset('assets/dist/assets/img/svg/logo.svg') }}" alt="branding logo"
                         class="logo">
                </a>
            </div>
        </div>

        <!--мобильная кнопка назад-->
        <div class="prevBtn-mobile-wrap">
            <button type="button" class="back " id="prevBtn-mobile"></button>
        </div>

        <!--заголовок-->
        <div class="entrance-text pb-1 text-center ">
            <h1>Welcome!</h1>
            <p>Please, enter information </p>
        </div>

        <!--хлебные крошки формы-->
        <div class="row">
            <div class=" col-1  d-none d-lg-block">
                <!--десктопная кнопка назад-->
                <button type="button" class="back" id="prevBtn"></button>
            </div>
            <div class="col-lg-10 col-12 px-2 px-md-0">
                <div class="d-flex justify-content-center align-items-center flex-wrap mb-4">
                    <span class="step active">personal</span>
                    <span class="step">company</span>
                    <span class="step">bank details</span>
                    <span class="step">VAT</span>
                    <span class="step">shipping</span>
                    <span class="step">contract</span>
                </div>
            </div>
            <div class=" col-1  d-none d-lg-block"></div>
        </div>

        <!--форма-->
        <div class="row d-flex align-content-start flex-grow-1">

            <div class=" col-2  d-none d-sm-block"></div>

            <div class="col-sm-8 col-12 px-2 px-md- h-100">
                <div class="h-100">
                    <form class="form form-vertical form-confirm d-flex justify-content-center h-100 " action=""
                          method="get" id="regForm">
                        <div class="form-body d-flex align-items-end">
                            <div class="row">

                                <!--шаг 1-->
                                <div class="col-12 tab">

                                    <div class="form-group d-flex flex-column">
                                        <input name="name" id="name"
                                               type="text"
                                               class="form-control order-1" required
                                        >
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="name">Name</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="add-email" id="add-email"
                                               type="email"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="add-email">Additional email</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="tel" id="tel"
                                               type="tel"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2 " role="alert"></span>
                                        <label for="tel">Phone number</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="surname" id="surname"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="surname">Surname</label>
                                    </div>

                                </div>

                                <!--шаг 2-->
                                <div class="col-12 tab">

                                    <div class="form-group d-flex flex-column">
                                        <div class="photo-wrap order-1">
                                            <div class="photo-img">
                                                <img src="{{ asset('assets/dist/assets/img/svg/photo.svg') }}" alt="photo" id="image">
                                            </div>

                                            <div class="d-flex flex-column photo-text">
                                                <input name="photo" id="photo"
                                                       accept="image/png, image/jpeg"
                                                       type="file"
                                                       class="order-1">
                                                <label for="photo">CHOOSE PHOTO</label>
                                                <span>The size is from 500px to 500px in the format .jpg or .png</span>
                                            </div>
                                        </div>
                                        <span class="photo-label">Add a logo image (no background/white)</span>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="address" id="address"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="address">Address</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <textarea name="about" id="about" class="order-1"
                                                  placeholder="Short describe (maximum of 280 characters)" rows="5"
                                                  maxlength="280"></textarea>
                                        <div class="d-flex justify-content-between"><label for="about">A few words about
                                            your roastery</label><span class="about-num"><span
                                                class="about-count">0</span>/280</span></div>
                                    </div>


                                </div>

                                <!--шаг 3-->
                                <div class="col-12 tab">

                                    <div class="form-group d-flex flex-column">
                                        <input name="bank-name" id="bank-name"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="bank-name">Bank name</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="bank-address" id="bank-address"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="bank-address">Bank address</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="account-name" id="account-name"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="account-name">Account name <span
                                                style="font-family: 'Inter-Medium';">(as registered with bank)</span></label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="account-number" id="account-number"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="account-number">Account number</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="iban" id="iban"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="iban">IBAN</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="bic" id="bic"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="bic">SWIFT / BIC</label>
                                    </div>


                                </div>

                                <!--шаг 4-->
                                <div class="col-12 tab">
                                    <div class="form-group d-flex flex-column">
                                        <label >Please upload VAT certificate</label>
                                        <div class="upload" id="VAT"></div>
                                    </div>
                                    <div class="form-group d-flex flex-column">
                                        <label >Please upload Trade licence</label>
                                        <div class="upload" id="licence"></div>
                                    </div>
                                </div>

                                <!--шаг 5-->
                                <div class="col-12 tab">

                                    <div class="entrance-text pb-1 text-center ">
                                        <p>Enter the place where you can pick up the ordered goods and the
                                            contact
                                            details of the responsible person</p>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="address-step-5" id="address-step-5"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="address-step-5">Address</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="contact-name" id="contact-name"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="contact-name">Contact name</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="phone-number-step-5" id="phone-number-step-5"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="phone-number-step-5">Phone number</label>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <input name="backup-phone" id="backup-phone"
                                               type="text"
                                               class="form-control order-1"
                                               required>
                                        <span class="invalid-feedback order-2" role="alert"></span>
                                        <label for="backup-phone">Backup phone number</label>
                                    </div>
                                </div>

                                <!--шаг 6-->
                                <div class="col-12 tab"></div>

                                <!--кнопка вперед она же отправить-->
                                <div class="col-12 pt-3 text-center text-md-left">
                                    <button class="btn btn-orange btn-inline btn-lg" type="button" id="nextBtn"
                                    >Continue</button>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-2 d-none d-sm-block"></div>
        </div>

        <!--подвал-->
        <div class="row pt-lg-4 pt-3">
            <div class="col-xl-12 col-12 d-flex justify-content-end  w-100">
                <a href="#" class="footer-label text-orange">CONTACT US</a>
                <span class="footer-sublabel pl-2">if you have questions</span>
            </div>
        </div>


    </div>

    <!--постер-->
    <div class=" p-0  login-poster">
    </div>

</div>






@endsection
