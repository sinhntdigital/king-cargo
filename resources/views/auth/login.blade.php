<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Trade exchange | Login</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google : {'families' : ['Poppins:300,400,500,600,700', 'Roboto:300,400,500,600,700']},
            active : function () {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <link href="{{ asset('backend/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src='https://www.google.com/recaptcha/api.js'></script>


    <!-- Start Alexa Certify Javascript -->
    <script type="text/javascript">
        _atrk_opts = {atrk_acct : 'Nsq6q1SZw320l9', domain : 'travelcoin.site', dynamic : true};
        (function () {
            var as = document.createElement('script');
            as.type = 'text/javascript';
            as.async = true;
            as.src = 'https://certify-js.alexametrics.com/atrk.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(as, s);
        })();
    </script>
    <noscript><img src="https://certify.alexametrics.com/atrk.gif?account=Nsq6q1SZw320l9" style="display:none" height="1" width="1" alt=""/></noscript>
    <!-- End Alexa Certify Javascript -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106174662-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-106174662-3');
    </script>
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 {{ $formName }}" id="m_login">
        <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
            <div class="m-stack m-stack--hor m-stack--desktop">
                <div class="m-stack__item m-stack__item--fluid">
                    <div class="m-login__wrapper">
                        <div class="m-login__logo">
                            <a href="{{ route('gmGetDashboardPage') }}">
                                <img src="{{ asset('images/trade-exchange-logo.jpg') }}" class="mx-auto" style="width:70%">
                            </a>
                        </div>
                        <div class="m-login__signin">
                            <form class="m-login__form m-form" action="{{ route('gmGetLogin') }}" method="post">
                                @if (Session::has('confirm_success'))
                                    <div class="m-alert m-alert--outline alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                        <span>{{ Session::get('confirm_success') }}</span>
                                    </div>
                                @endif

                                <div id="form-info">
                                    <div class="m-login__head">
                                        <h3 class="m-login__title">{{ __('User login') }}</h3>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <input id="email" type="email" class="form-control m-input {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                               value="{{ old('email') }}" placeholder="{{ __('Your email') }}" required autofocus/>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <input id="password" type="password" class="form-control m-input m-login__form-input--last {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               name="password" placeholder="{{ __('Your password') }}" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="row m-login__form-sub">
                                        <div class="col m--align-left">
                                            <label class="m-checkbox m-checkbox--air m-checkbox--solid m-checkbox--state-brand">
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col m--align-right">
                                            <a href="javascript:;" id="m_login_forget_password" class="m-link">{{ __('Forget Password ?') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="form-security" style="display:none">
                                    <div class="m-login__head">
                                        <h3 class="m-login__title">{{ __('Login Authentication') }}</h3>
                                    </div>
                                    <div id="form-security__body" class="m--margin-top-30">

                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    @csrf
                                    <button type="submit" id="m_login_signin_submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air">{{ __('Sign In') }}</button>
                                </div>
                                <div class="m-login__head m--margin-bottom-30">
                                    <h3 class="m-login__title">{{ __('Or') }}</h3>
                                </div>
                                <p class="text-center">
                                    <a href="{{ route('gmSocialLoginRedirect', 'facebook') }}" class="btn btn-outline-info m-btn m-btn--custom m-btn--icon m-btn--outline-2x m-btn--pill m-btn--air m--margin-bottom-15">
                                        <span>
                                            <i class="fa fa-facebook fa-3x"></i>
                                            <span>Facebook</span>
                                        </span>
                                    </a>
                                    <a href="{{ route('gmSocialLoginRedirect', 'google') }}" class="btn btn-outline-danger m-btn m-btn--custom m-btn--icon m-btn--outline-2x m-btn--pill m-btn--air m--margin-bottom-15">
                                        <span>
                                            <i class="fa fa-google-plus fa-3x"></i>
                                            <span>Google</span>
                                        </span>
                                    </a>
                                </p>
                            </form>
                        </div>
                        <div class="m-login__signup">
                            <div class="m-login__head">
                                <h3 class="m-login__title">{{ __('Sign Up') }}</h3>
                                <div class="m-login__desc">{{ __('Enter your details to create your accoun') }}t:</div>
                            </div>
                            <form class="m-login__form m-form" action="{{ route('gmPostRegister') }}" method="post">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="Nick name" name="name">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="password" placeholder="Password" name="password">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="password_confirmation">
                                </div>
                                <div class="form-group m-form__group" style="display:none">
                                    <input class="form-control m-input m-login__form-input--last" type="text"
                                           placeholder="Presenter code" name="presenter_code" value="{{ $referId }}">
                                </div>
                                @if (!empty($userName))
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input m-login__form-input--last" value="Refer user: {{ $userName }}" readonly disabled>
                                    </div>
                                @endif
                                <div class="row form-group m-form__group m-login__form-sub">
                                    <div class="col m--align-left">
                                        <label class="m-checkbox m-checkbox--focus">
                                            <input type="checkbox" name="agree">
                                            I Agree the <a href="#" class="m-link m-link--brand">terms and conditions</a>.
                                            <span></span>
                                        </label>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    @csrf
                                    <button id="m_login_signup_submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air">Sign Up</button>
                                    <button id="m_login_signup_cancel" class="btn btn-outline-brand m-btn m-btn--pill m-btn--custom">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <div class="m-login__forget-password">
                            <div class="m-login__head">
                                <h3 class="m-login__title">{{ __('Forgotten Password ?') }}</h3>
                                <div class="m-login__desc">{{ __('Enter your email to reset your password') }}:</div>
                            </div>
                            <form class="m-login__form m-form" action="{{ route('gmPostLostPassword') }}" method="post">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                                </div>
                                <div class="m-login__form-action">
                                    @csrf
                                    <button id="m_login_forget_password_submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air">{{ __('Request') }}</button>
                                    <button id="m_login_forget_password_cancel" class="btn btn-outline-brand m-btn m-btn--pill m-btn--custom">{{ __('Cancel') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="m-stack__item m-stack__item--center">
                    <div class="m-login__account">
                        <span class="m-login__account-msg">{{ __("Don't have an account yet ?") }}</span>&nbsp;&nbsp;
                        <a href="javascript:;" id="m_login_signup" class="m-link m-link--focus m-login__account-link m--font-brand">{{ __('Sign Up') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content"
             style="background-image:url({{ asset('backend/img/bg/bg-login.jpg') }});background-size:auto 100%;background-position:right">
            <div class="m-grid__item m-grid__item--middle">
                <h3 class="m-login__welcome">{{ __('Join Our Community') }}</h3>
                <p class="m-login__msg">{{ __('We are TradeExchange - The security and responsive trading exchange. Our innovative platform will help you to make a trade faster and easier anywhere in the world.') }}</p>
                <p class="m-login__msg text-center">
                    <a class="btn btn-outline-secondary m-btn m-btn--custom m-btn--icon m-btn--outline-2x m-btn--pill m-btn--air m--margin-left-15"
                       target="_blank" href="{{ asset('profit-sharing.pdf') }}">{{ __('Profit sharing') }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{ asset('backend/login.js') }}" type="text/javascript"></script>
</body>
</html>