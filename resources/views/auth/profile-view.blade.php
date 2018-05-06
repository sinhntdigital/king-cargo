@extends('layouts.bo-layout')

@section('page_title', 'Account Settings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-profile"></i>
                                </span>
                            <h3 class="m-portlet__head-text">{{ __('Account Settings') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form id="gm-form--view_profile" action="{{ route('gmPutUpdateProfile') }}" method="POST" role="form">
                        @csrf
                        @method('put')
                        {{--m-input--air--}}
                        <div class="form-group m-form__group row">
                            <label for="gm-form--view_profile__input-name">{{ __('Nick name') }}</label>
                            <input type="text" id="gm-form--view_profile__input-name" class="form-control m-input" value="{{ $user->name }}" readonly disabled/>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--view_profile__input-email">{{ __('Email') }}</label>
                            <input type="text" id="gm-form--view_profile__input-email" class="form-control m-input" value="{{ $user->email }}" readonly disabled/>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--view_profile__input-email">{{ __('Presenter code') }}</label>
                            <input type="text" id="gm-form--view_profile__input-email" class="form-control m-input" value="{{ $user->id }}" readonly disabled/>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--view_profile__input-first_name">{{ __('First name') }}</label>
                            <input type="text" id="gm-form--view_profile__input-first_name" maxlength="50" name="first_name" class="form-control m-input gm-input--text" value="{{ $user->first_name }}" disabled/>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--view_profile__input-last_name">{{ __('Last name') }}</label>
                            <input type="text" id="gm-form--view_profile__input-last_name" maxlength="50" name="last_name" class="form-control m-input gm-input--text" value="{{ $user->last_name }}" disabled/>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--view_profile__input-birthday">{{ __('Date of birth') }}</label>
                            <input type="text" id="gm-form--view_profile__input-birthday" name="birthday" class="form-control m-input gm-input--date" value="{{ !empty($user->birthday) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->birthday)->format('d/m/Y') : null }}" disabled/>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--view_profile__input-country">{{ __('Country') }}</label>
                            <select id="gm-form--view_profile__input-country" maxlength="35" name="country" class="form-control m-input gm-input--text" disabled>
                                @php($countries = \App\Models\Country::orderBy('nicename', 'ASC')->get())
                                @foreach($countries as $country)
                                    <option data-phone-code="+{{ $country->phonecode }}" value="{{ $country->id }}" {{ (int)$user->country === (int)$country->id ? 'selected' : null }}>{{ $country->nicename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--view_profile__input-phone">{{ __('Phone number') }}</label>
                            <div class="input-group m-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text gm-form--view_profile__input-phone_prefix">+84</span>
                                </div>
                                <input type="text" id="gm-form--view_profile__input-phone" maxlength="25" name="phone" class="form-control m-input gm-input--text" value="{{ $user->phone }}" disabled/>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label>{{ __('Security mode') }}</label>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12 col-md-3 offset-md-2">
                                <img src="{{ asset(SUBFOLDER . 'backend/images/security-review-lg.png') }}" alt="Security image" class="w-100">
                            </div>
                            <div class="col-sm-12 col-md-6 d-flex align-items-center">
                                <div class="m-radio-list">
                                    <label class="m-radio m-radio--brand">
                                        <input type="radio" name="security_mode" value="" {{ empty($user->security_mode) ? 'checked' : null }} disabled/>
                                        No Authenticate
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--brand">
                                        <input type="radio" name="security_mode" value="google_2fa" {{ $user->security_mode === 'google_2fa' ? 'checked' : null }} disabled/>
                                        Google Authenticate
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--brand">
                                        <input type="radio" name="security_mode" value="email_confirm" {{ $user->security_mode === 'email_confirm' ? 'checked' : null }} disabled/>
                                        Email Authenticate
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--brand">
                                        <input type="radio" name="security_mode" value="sms_confirm" {{ $user->security_mode === 'sms_confirm' ? 'checked' : null }} disabled/>
                                        SMS Authenticate
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--brand">
                                        <input type="radio" name="security_mode" value="secrect_question" {{ $user->security_mode === 'secrect_question' ? 'checked' : null }} disabled/>
                                        Secrect question Authenticate
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="gm-form--security_confirm">

                        </div>
                        <div class="m-form__group form-group row">
                            <label class="col-10 col-form-label">{{ __('Enable second factor authentication on login') }}</label>
                            <div class="col-2 text-right">
                        <span class="m-switch m-switch--icon m-switch--brand">
                        <label><input type="checkbox" name="enable_login2fa" {{ (int)$user->enable_login2fa === 1 ? 'checked' : null }} disabled/><span></span></label>
                        </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="m-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-sm-12 text-right">
                            <div id="gm--view_profile--btn_group">
                                <button id="gm-form--view_profile__btn-edit_profile" class="btn btn-brand m-btn m-btn--icon">
                                    <span><i class="fa fa-edit"></i><span>{{ __('Edit') }}</span></span>
                                </button>
                                <a href="{{ route('gmGetChangePassword') }}" id="gm-form--view_profile__btn-change_password" class="btn btn-success m-btn m-btn--icon">
                                    <span><i class="fa fa-lock"></i><span>{{ __('Change password') }}</span></span>
                                </a>
                            </div>
                            <div id="gm--update_profile--btn_group" style="display:none">
                                <button id="gm-form--view_profile__btn-submit_profile" class="btn btn-brand m-btn m-btn--icon">
                                    <span><i class="fa fa-check"></i><span>{{ __('Submit') }}</span></span>
                                </button>
                                <button id="gm-form--view_profile__btn-cancel_profile" class="btn btn-secondary m-btn m-btn--icon">
                                    <span><i class="fa fa-remove"></i><span>{{ __('Cancel') }}</span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#gm-form--view_profile__input-country').change();
        });
    </script>
@stop