@extends('layouts.bo-layout')

@section('page_title', 'Change password')

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xs-12 col-md-8">
            <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--head-sm">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-share"></i>
                                </span>
                            <h3 class="m-portlet__head-text">{{ __('Change password') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form id="gm-form--change_password" action="{{ route('gmPostChangePassword') }}" method="POST" role="form">
                        @csrf
                        <div class="form-group m-form__group row">
                            <label for="gm-form--change_password__input-old_password">{{ __('Old password *') }}</label>
                            <input type="password" class="form-control m-input m-input--air" name="old_password" id="gm-form--change_password__input-old_password"/>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--change_password__input-password">{{ __('New password *') }}</label>
                            <input type="password" class="form-control m-input m-input--air" name="password" id="gm-form--change_password__input-password"/>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="gm-form--change_password__input-password_confirmation">{{ __('Confirm password *') }}</label>
                            <input type="password" class="form-control m-input m-input--air" name="password_confirmation" id="gm-form--change_password__input-password_confirmation"/>
                        </div>
                    </form>
                </div>
                <div class="m-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-sm-12 text-right">
                            <button id="gm-form--change_password-btn--submit" class="btn btn-brand m-btn m-btn--icon">
                                <span><i class="fa fa-check"></i><span>{{ __('Submit') }}</span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop