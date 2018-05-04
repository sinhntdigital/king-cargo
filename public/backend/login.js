var SnippetLogin = function () {
    var s = $('#m_login');
    var n = function (e, i, a) {
        var l = $('<div class="m-alert m-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
        e.find('.alert').remove(), l.prependTo(e), l.find('span').html(a);
    };
    var o = function () {
        s.removeClass('m-login--forget-password'), s.removeClass('m-login--signup'), s.addClass('m-login--signin');
    };
    var e = function () {
        $('#m_login_forget_password').click(function (e) {
            e.preventDefault(), s.removeClass('m-login--signin'), s.removeClass('m-login--signup'), s.addClass('m-login--forget-password');
        }), $('#m_login_forget_password_cancel').click(function (e) {
            e.preventDefault(), o();
        }), $('#m_login_signup').click(function (e) {
            e.preventDefault(), s.removeClass('m-login--forget-password'), s.removeClass('m-login--signin'), s.addClass('m-login--signup');
        }), $('#m_login_signup_cancel').click(function (e) {
            e.preventDefault(), o();
        });
    };
    return {
        init: function () {
            e(),
                $('#m_login_signin_submit').click(function (e) {
                    e.preventDefault();
                    var t = $(this), form = $(this).closest('form');
                    form.validate({
                        rules: {
                            email   : {
                                required : !0,
                                email    : !0,
                                maxlength: 65,
                            },
                            password: {
                                required : !0,
                                maxlength: 65,
                            },
                        },
                    });

                    if (form.valid()) {
                        t.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

                        form.ajaxSubmit({
                            success: function (e, i, a, l) {
                                if (e.hasOwnProperty('success')) {
                                    n(form, 'success', e.success);
                                    if (e.hasOwnProperty('redirect_url')) window.location.href = e.redirect_url;
                                } else if (e.hasOwnProperty('robot')) {
                                    t.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                                    n(form, 'danger', e.robot);
                                } else if (e.hasOwnProperty('form')) {
                                    t.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false).html('Verify');
                                    form.find('#form-security__body').html(e.form);
                                    form.find('#form-security').show();
                                    form.find('#form-info').hide();
                                    form.find('.alert').remove();
                                } else {
                                    n(form, 'danger', e.error);
                                    t.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                                }
                            },
                        });
                    }
                }),

                $('#m_login_signup_submit').click(function (e) {
                    e.preventDefault();
                    var t = $(this);
                    var r = $(this).closest('form');

                    r.validate({
                        rules: {
                            name                 : {required: !0},
                            email                : {
                                required: !0,
                                email   : !0,
                            },
                            password             : {required: !0},
                            password_confirmation: {required: !0},
                            agree                : {required: !0},
                        },
                    }), r.valid() && (t.addClass('m-loader m-loader--right m-loader--light').attr('disabled', !0), r.ajaxSubmit({
                        success: function (e, i, a, l) {
                            t.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                            if (e.hasOwnProperty('success')) {
                                r.clearForm();
                                r.validate().resetForm();
                                o();
                                var form = s.find('.m-login__signin form');
                                form.clearForm();
                                form.validate().resetForm();
                                n(form, 'success', e.success);
                            }
                            else if (e.hasOwnProperty('invalid')) {
                                let list = e.invalid;
                                let str = '';

                                Object.keys(list).forEach(key => {
                                    for (let item of list[key]) str += `- ${item}<br/>`;
                                });

                                n(r, 'danger', str);
                            }
                            else {
                                n(r, 'danger', e.error);
                            }
                            // setTimeout(function () {
                            //     t.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', !1), r.clearForm(), r.validate().resetForm(), o();
                            //     var e = s.find('.m-login__signin form');
                            //     e.clearForm(), e.validate().resetForm(), n(e, 'success', 'Thank you. To complete your registration please check your email.');
                            // }, 2e3);
                        },
                    }));
                }),

                $('#m_login_forget_password_submit').click(function (e) {
                    e.preventDefault();
                    var t = $(this), r = $(this).closest('form');
                    r.validate({rules: {email: {required: !0, email: !0}}}), r.valid() && (t.addClass('m-loader m-loader--right m-loader--light').attr('disabled', !0), r.ajaxSubmit({
                        success: function (e, i, a, l) {
                            if (e.hasOwnProperty('success')) {
                                setTimeout(function () {
                                    t.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', !1), r.clearForm(), r.validate().resetForm(), o();
                                    var e = s.find('.m-login__signin form');
                                    e.clearForm(), e.validate().resetForm(), n(e, 'success', 'Cool! Password recovery instruction has been sent to your email.');
                                }, 2e3);
                            } else {
                                n(r, 'danger', e.error);
                                t.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                            }
                        },
                    }));
                });
        },
    };
}();
jQuery(document).ready(function () {
    SnippetLogin.init();
});