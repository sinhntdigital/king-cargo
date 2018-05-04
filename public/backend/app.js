var exchange_rate = {}; // BTC exchange rate

$(document).ready(function () {
    new Clipboard('[data-clipboard=true]').on('success', function (e) {
        e.clearSelection();
        // $(this).text('Copied');
    });
});

tinymce.init({
    selector                 : 'textarea.gm-input__textarea--tinyeditor',
    themes                   : 'modern',
    height                   : 300,
    image_advtab             : true,
    plugins                  : [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern responsivefilemanager',
    ],
    toolbar1                 : 'bold italic underline | alignleft aligncenter alignright alignjustify | styleselect | fontselect |  fontsizeselect',
    // toolbar2: "undo redo | responsivefilemanager | bullist numlist outdent indent | link unlink anchor | image media | forecolor backcolor  | print preview code ",
    toolbar2                 : 'undo redo | responsivefilemanager | bullist numlist outdent indent | link unlink anchor | forecolor backcolor  | print preview code ',
    fontsize_formats         : '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
    external_plugins         : {'filemanager': '/public/plugins/filemanager/plugin.min.js'},
    external_filemanager_path: '/public/plugins/filemanager/',
    filemanager_title        : 'File Manager',
    // filemanager_access_key: file_manager_key
    setup                    : function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    }
});

$('.resfile-btn').fancybox({
    'width'    : 900,
    'height'   : 450,
    'type'     : 'iframe',
    'autoScale': false,
    'autoSize' : false,
});

$('.gm-input--date').datepicker({
    format     : 'dd/mm/yyyy',
    startView  : 'years',
    maxViewMode: 'centuries',
    minViewMode: 'days',
    autoclose  : true,
});

$('.gm-input--text').maxlength({
    threshold        : 15,
    warningClass     : 'm-badge m-badge--warning m-badge--rounded m-badge--wide',
    limitReachedClass: 'm-badge m-badge--danger m-badge--rounded m-badge--wide',
});

$('.gm-input--coin').TouchSpin({
    buttonup_class  : 'btn btn-success',
    buttondown_class: 'btn btn-danger',
    min             : 0,
    max             : 1000,
    decimals        : 4,
    step            : .0001,
});

$('.gm-input--usd').TouchSpin({
    buttonup_class  : 'btn btn-success',
    buttondown_class: 'btn btn-danger',
    min             : 0,
    max             : 10000,
    decimals        : 2,
    step            : .01,
    postfix         : '$',
});

$('.gm-input--percent').TouchSpin({
    buttonup_class  : 'btn btn-success',
    buttondown_class: 'btn btn-brand',
    min             : 0,
    max             : 100,
    step            : .01,
    decimals        : 2,
    boostat         : 5,
    maxboostedstep  : 10,
});

$('.gm-js__btn--remove-image').click(function () {
    let field_id = $(this).data('field-id');
    $('button.gm-js__btn--remove-image-' + field_id).hide();
    $('.gm-input__' + field_id).val('/public/images/no-image.jpg');
    $('.gm-image__' + field_id).attr('src', '/public/images/no-image.jpg').show();
});

function copyReferralLink(text) {
    let textArea = document.createElement('textarea');
    textArea.style.position = 'fixed';
    textArea.style.top = 0;
    textArea.style.left = 0;
    textArea.style.width = '2em';
    textArea.style.height = '2em';
    textArea.style.padding = 0;
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';
    textArea.style.background = 'transparent';
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.select();
    document.body.removeChild(textArea);
    try {
        let successful = document.execCommand('copy');
        let msg = successful ? 'successful' : 'unsuccessful';
        console.log('Copying text command was ' + msg);
    } catch (err) {
        console.log('Oops, unable to copy');
    }
}

function hideMessage(e) {
    e.find('.alert').remove();
}

function showMessage(e, i, a) {
    let l = $('<div class="m-alert m-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
    e.find('.alert').remove();
    l.prependTo(e);
    l.find('span').html(a);
}

function responsive_filemanager_callback(field_id) {
    parent.$.fancybox.close();
    var url = $('#' + field_id).val();
    $('.gm-input__' + field_id).val(url);
    $('.gm-image__' + field_id).attr('src', url).show();
    $('.gm-js__btn--remove-image-' + field_id).fadeIn(300);
}

function formatCurrency(number) {
    return $.number(number, 8, '.', ',');
}

function formatUsd(number) {
    return $.number(number, 2, '.', ',');
}

function loadCurrencyExchangeRate(apiUrl) {
    axios.get(apiUrl).then(response => {
        if (response.data.hasOwnProperty('success')) {
            let obj = response.data.success;
            exchange_rate = obj;
            Object.keys(obj).forEach(function (key) {
                $('.gm-view--' + key + '_price').html(formatUsd(obj[key]));
                // console.log(key, obj[key]);
            });
            setTimeout(function () {
                loadCurrencyExchangeRate(apiUrl);
            }, 10000);
        }
        else {
            console.log(response);
        }
    }).catch(error => {
        console.log(error);
    });
}

$(document).on('change', '#gm-wallet_withdraw--input-quality', function () {
    let currency = $(this).data('currency');
    let usd = parseFloat($(this).val());
    let result = {};
    let value = parseFloat($(this).val());
    Object.keys(exchange_rate).forEach(function (key) {
        if (key === currency) {
            let quality = usd / exchange_rate[key];
            console.log(quality);
            console.log(exchange_rate[key]);
            $('#gm-wallet_withdraw--input-amount').val(quality);
        }
        // console.log(key, obj[key]);
    });
});

$('#gm-form--change_password-btn--submit').click(function () {
    let form = $('#gm-form--change_password');
    let btnSubmit = $(this);
    // Set rule validate
    form.validate({
        rules: {
            old_password         : {
                required : true,
                minlength: 6,
            },
            password             : {
                required : true,
                minlength: 6,
            },
            password_confirmation: {
                required : true,
                minlength: 6,
            },
        },
    });

    // Submit form if success
    if (form.valid()) {
        btnSubmit.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
        form.ajaxSubmit({
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    form.clearForm();
                    form.validate().resetForm();
                    showMessage(form, 'success', 'Your password had been changed successfully.');
                } else if (response.hasOwnProperty('invalid')) {
                    let list = response.invalid;
                    let str = '';
                    Object.keys(list).forEach(key => {
                        for (let item of list[key]) str += `- ${item}<br/>`;
                    });
                    showMessage(form, 'danger', str);
                } else {
                    showMessage(form, 'danger', response.error);
                }
                btnSubmit.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            },
            error  : function (response) {
                showMessage(form, 'danger', response.responseJSON.error);
                btnSubmit.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            },
        });
    }

});

$('#gm-form--view_profile__input-country').change(function () {
    let form = $(this).closest('form');
    let option = $(this).find('option:selected');
    let phoneCode = option.data('phone-code');
    form.find('.gm-form--view_profile__input-phone_prefix').html(phoneCode);
});

$('#gm-form--view_profile__btn-edit_profile').click(function () {
    $('#gm--view_profile--btn_group').hide();
    $('#gm--update_profile--btn_group').show();
    $('#gm-form--view_profile').find('input, select').addClass('m-input--air').attr('disabled', false);
});

$('#gm-form--view_profile__btn-cancel_profile').click(function () {
    $('#gm-form--security_confirm').html('');
    $('#gm--view_profile--btn_group').show();
    $('#gm--update_profile--btn_group').hide();
    $('#gm-form--view_profile').find('input, select').removeClass('m-input--air').attr('disabled', true);
});

$('#gm-form--view_profile__btn-submit_profile').click(function () {
    let form = $('#gm-form--view_profile');
    let thisBtn = $(this);

    // Validate form
    form.validate({
        rules: {
            first_name   : {
                required: true,
            },
            last_name    : {
                required: true,
            },
            birthday     : {
                required: true,
            },
            country      : {
                required: true,
            },
            phone        : {
                required: true,
            },
            security_mode: {
                required: true,
            },
        },
    });

    if (form.valid()) {
        thisBtn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
        form.ajaxSubmit({
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    showMessage(form, 'success', 'Your profile had been updated.');
                    $('#gm-form--security_confirm').html('');
                    $('#gm--view_profile--btn_group').show();
                    $('#gm--update_profile--btn_group').hide();
                    $('#gm-form--view_profile').find('input, select').removeClass('m-input--air').attr('disabled', true);
                } else if (response.hasOwnProperty('confirm_security')) {
                    $('#gm-form--security_confirm').html(response.confirm_security);
                    hideMessage(form);
                } else if (response.hasOwnProperty('invalid')) {
                    let list = response.invalid;
                    let str = '';
                    Object.keys(list).forEach(key => {
                        for (let item of list[key]) str += `- ${item}<br/>`;
                    });
                    showMessage(form, 'danger', str);
                } else {
                    showMessage(form, 'danger', response.error);
                }
                thisBtn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            },
            error  : function (response) {
                // showMessage(form, 'danger', response.responseJSON.error);
                thisBtn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            },
        });
    }
});

$('#gm-setting__btn-submit').click(function () {
    let thisBtn = $(this);
    let form = $('#gm-settings--form');


    // Validate form
    form.validate({
        rules: {},
    });

    if (form.valid()) {
        thisBtn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
        form.ajaxSubmit({
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    showMessage(form, 'success', response.success);
                    $('#gm-form--view_profile').find('input, select').removeClass('m-input--air').attr('disabled', true);
                } else {
                    showMessage(form, 'danger', response.error);
                }
                thisBtn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            },
            error  : function (response) {
                // showMessage(form, 'danger', response.responseJSON.error);
                thisBtn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            },
        });
    }
});

$(document).on('click', '.gm-button--copy', function () {
    $(this).html("<i class='fa fa-check'></i> Copied!");
});

$('#gm-investment_package__btn-submit').click(function () {
    let form = $('#gm-form--investment_package');
    let btnSubmit = $(this);
    form.validate({
        rules: {
            name       : {
                required: true,
            },
            // price              : {
            //     required: true,
            // },
            // discount_percentage: {
            //     required: true,
            // },
            description: {
                required: true,
            },
        },
    });
    if (form.valid()) {
        btnSubmit.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
        form.ajaxSubmit({
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    showMessage(form, 'success', response.success);
                } else if (response.hasOwnProperty('invalid')) {
                    let list = response.invalid;
                    let str = '';
                    Object.keys(list).forEach(key => {
                        for (let item of list[key]) str += `- ${item}<br/>`;
                    });
                    showMessage(form, 'danger', str);
                } else {
                    showMessage(form, 'danger', response.error);
                }
                btnSubmit.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            },
            error  : function (response) {
                showMessage(form, 'danger', response.responseJSON.error);
                btnSubmit.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            },
        });
    }
});

$(document).on('click', '.gm-investment_package__btn--delete_package', function () {
    let url = $(this).data('url');
    swal({
        title             : 'Warning!',
        type              : 'warning',
        position          : 'center',
        html              : 'Your data will be deleted and cannot restore. Are you sure you want to do this?',
        confirmButtonText : '<i class="fa fa-check"></i> Yes',
        showCancelButton  : true,
        cancelButtonText  : '<i class="fa fa-remove"></i> Think again ?',
        focusConfirm      : false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor : '#d33',
    }).then((result) => {
        if (result.value) {
            axios.delete(url).then(response => {
                if (response.data.hasOwnProperty('success')) {
                    swal('Success', response.data.success, 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
                else {
                    console.log(response);
                }
            }).catch(error => {
                console.log(error);
            });
        }
    }).catch(swal.noop());
});

$(document).on('click', '#gm-form--user__btn--submit', function () {
    let form = $('#gm-form--investment_package');
    let btnSubmit = $(this);
    form.validate({
        rules: {
            name                 : {
                required: !0
            },
            email                : {
                required: !0,
                email   : !0,
            },
            password             : {
                required: !0
            },
            password_confirmation: {
                required: !0
            },
        },
    });
});

$(document).on('click', '.gm-link--package_detail', function () {
    axios.get($(this).data('url')).then(response => {
        if (response.data.hasOwnProperty('success')) {
            let obj = response.data.success;
            let modal = $('#gm-modal--package_detail');
            modal.find('#gm-modal--package_detail__title').html(obj.name);
            modal.find('#gm-modal--package_detail__banner').attr('src', obj.image);
            modal.find('#mCSB_1_container .package-content').html(obj.content);
            modal.modal('show');

            let formSubmit = $('#gm-form--join_package');
            formSubmit.find('#gm-form--join_package-input--package_id').val(obj.id);
        }
        else {
            console.log(response);
        }
    }).catch(error => {
        console.log(error);
    });
});