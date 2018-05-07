<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('page_title') | Trade exchange</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {'families': ['Poppins:300,400,500,600,700', 'Roboto:300,400,500,600,700']},
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <link href="{{ asset('backend/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend/jquery-ui.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

    <style>
        .gm-css__div-image--responsive {
            padding: 5px;
            border: solid 1px silver;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            position: relative;
        }

        .gm-js__btn--remove-image {
            position: absolute;
            right: -15px;
            top: -15px;
        }

        .gm-image {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .form-control {
            border: solid 1px silver !important;
        }
    </style>
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    <header class="m-grid__item    m-header " data-minimize-offset="200" data-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- BEGIN: Brand -->
                <div class="m-stack__item m-brand  m-brand--skin-dark" style="background:white">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="/" class="m-brand__logo-wrapper">
                                <img style="width:150px" alt="" src="{{ asset('images/trade-exchange-mini-logo.png') }}"/>
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            <!-- BEGIN: Left Aside Minimize Toggle -->
                            <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                                <span></span>
                            </a>
                            <!-- END -->
                            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                            <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>
                            <!-- END -->
                            <!-- BEGIN: Topbar Toggler -->
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>
                            <!-- BEGIN: Topbar Toggler -->
                        </div>
                    </div>
                </div>
                <!-- END: Brand -->
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                    <!-- BEGIN: Horizontal Menu -->
                    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                        <i class="la la-close"></i>
                    </button>
                    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                        <ul class="m-menu__nav  m-menu__nav--submenu-arrow">
                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"><h3 id="mainTitle" class="m-subheader__title">@yield('page_title')</h3></li>
                        </ul>
                    </div>
                    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                            <ul class="m-topbar__nav m-nav m-nav--inline">
                                <li data-dropdown-toggle="click" class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" aria-expanded="true">
                                    <a href="#" class="m-nav__link m-dropdown__toggle m--font-brand">
                                        <div class="m-topbar__userpic">
                                            <i class="fa fa-user-circle" style="font-size:3rem" aria-hidden="true"></i>
                                        </div>
                                        <span class="m-topbar__username m--hide">admin@gmail.com</span>
                                    </a>
                                    <div class="m-dropdown__wrapper"><span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 12.5px;"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center" style="background: url('{{ asset('/backend/img/misc/user_profile_bg.jpg') }}') 0% 0% / cover;">
                                                <div class="m-card-user m-card-user--skin-dark">
                                                    <div class="m-card-user__pic">
                                                        <img src="{{ asset('backend/img/users/user-none.jpg') }}" alt="" class="m--img-rounded m--marginless">
                                                    </div>
                                                    <div class="m-card-user__details">
                                                        <span class="m-card-user__name m--font-weight-500">Gấu mập</span>
                                                        <a class="m-card-user__email m--font-weight-300 m-link" style="color:white">
                                                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;admin@gmail.com
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__item">
                                                            <a href="{{ route('gmGetLogout') }}" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-logout"></i> <span class="m-nav__link-text">{{ __('Logout') }}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>
        <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
            <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">
                <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                    <li class="m-menu__item" aria-haspopup="true">
                        <a href="/" class="m-menu__link">
                            <i class="m-menu__link-icon flaticon-line-graph"></i>
                            <span class="m-menu__link-title">
                                <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">{{ __('Dashboard') }}</span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item" aria-haspopup="true">
                        <a href="{{ route('employee.index') }}" class="m-menu__link">
                            <i class="m-menu__link-icon flaticon-squares-4"></i>
                            <span class="m-menu__link-title">
                                <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">Employee</span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item" aria-haspopup="true">
                        <a href="/" class="m-menu__link">
                            <i class="m-menu__link-icon fas fa-user"></i>
                            <span class="m-menu__link-title">
                                <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">user management</span>
                                </span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-content">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- end:: Body -->
    <!-- begin::Footer -->
    <footer class="m-grid__item	m-footer ">
        <div class="m-container m-container--fluid m-container--full-height m-page__container">
            <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                    <span class="m-footer__copyright">
                        2017 &copy; by <a target="_blank" href="https://gaumapdev.com" class="m-link">Gấu mập</a>. All rights reserved.
                    </span>
                </div>
                <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                    <ul class="m-footer__nav m-nav m-nav--inline m--pull-right"></ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- end::Footer -->
</div>
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<script src="{{ asset('backend/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/jquery-ui.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset("plugins/fancybox/jquery.fancybox.js") }}" type="text/javascript"></script>
<script src="{{ asset("plugins/tinymce/tinymce.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("plugins/filemanager/plugin.min.js") }}" type="text/javascript"></script>
<script src="//www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<script src="{{ asset("backend/app.js") }}" type="text/javascript"></script>
@yield('scripts')
</body>
</html>