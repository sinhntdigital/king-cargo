const dateTimeServerFormat = 'YYYY/MM/DD HH:mm:ss';
const dateTimeLocalFormat = 'DD/MM/YYYY HH:mm:ss';
const dateLocalFormat = 'DD/MM/YYYY';
const dataTableLayout = {
    theme : 'default',
    class : 'm-datatable--brand',
    scroll: true,
    height: 600,
    footer: false,
    header: true,

    smoothScroll: {
        scrollbarShown: true,
    },

    spinner: {
        overlayColor: '#000000',
        opacity     : 0,
        type        : 'loader',
        state       : 'brand',
        message     : true,
    },

    icons: {
        sort      : {asc: 'la la-arrow-up', desc: 'la la-arrow-down'},
        pagination: {
            next : 'la la-angle-right',
            prev : 'la la-angle-left',
            first: 'la la-angle-double-left',
            last : 'la la-angle-double-right',
            more : 'la la-ellipsis-h',
        },
        rowDetail : {expand: 'fa fa-caret-down', collapse: 'fa fa-caret-right'},
    },
};
const dataTableToolbar = {
    layout   : ['pagination', 'info'],
    placement: ['bottom'],  //'top', 'bottom'
    items    : {
        pagination: {
            type          : 'default',
            pages         : {
                desktop: {
                    layout     : 'default',
                    pagesNumber: 6,
                },
                tablet : {
                    layout     : 'default',
                    pagesNumber: 3,
                },
                mobile : {
                    layout: 'compact',
                },
            },
            navigation    : {
                prev : true,
                next : true,
                first: true,
                last : true,
            },
            pageSizeSelect: [20],
        },
        info      : true,
    },
};
const dataTableTranslate = {
    records: {
        processing: 'Xin vui lòng đợi trong giây lát...',
        noRecords : 'Không có dữ liệu',
    },
    toolbar: {
        pagination: {
            items: {
                default: {
                    first : 'Đầu trang',
                    prev  : 'Trang trước',
                    next  : 'Trang kế',
                    last  : 'Trang cuối',
                    more  : 'Thêm trang khác',
                    input : 'Số trang',
                    select: 'Chọn số dòng / trang',
                },
                info   : 'Hiển thị {{start}} - {{end}} / {{total}} dòng',
            },
        },
    },
};

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

$(document).ready(function () {
    new Clipboard('[data-clipboard=true]').on('success', function (e) {
        e.clearSelection();
    });

    $('.gm-js--input_text').maxlength({
        appendToParent   : true,
        alwaysShow       : false,
        threshold        : 15,
        // validate         : true,
        placement        : "bottom",
        warningClass     : 'm-badge m-badge--warning m-badge--rounded m-badge--wide',
        limitReachedClass: 'm-badge m-badge--danger m-badge--rounded m-badge--wide',
    });

    $('.resfile-btn').fancybox({
        'width'    : 900,
        'height'   : 450,
        'type'     : 'iframe',
        'autoScale': false,
        'autoSize' : false,
    });

    $('.gm-js--input_date').datepicker({
        format     : dateLocalFormat.toLowerCase(),
        startView  : 'days',
        maxViewMode: 'centuries',
        minViewMode: 'days',
        autoclose  : true,
    }).on('changeDate', function(e){
        let date = $(this).datepicker('getDate');
        let month = date.getMonth() + 1;
        let day = date.getDate();
        let year = date.getFullYear();
        let formattedDate = year + '/' + month + '/' + day + ' 00:00:00';
        $(this).siblings($(this).data('input')).val(formattedDate);
    });;

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
});

$(document).on('click', '.gm-js__btn--remove-image', function () {
    let field_id = $(this).data('field-id');
    $('button.gm-js__btn--remove-image-' + field_id).hide();
    $('.gm-input__' + field_id).val('/public/images/no-image.jpg');
    $('.gm-image__' + field_id).attr('src', '/public/images/no-image.jpg').show();
});

function responsive_filemanager_callback(field_id) {
    parent.$.fancybox.close();
    let url = $('#' + field_id).val();
    $('.gm-input__' + field_id).val(url);
    $('.gm-image__' + field_id).attr('src', url).show();
    $('.gm-js__btn--remove-image-' + field_id).fadeIn(300);
}

function hideMessage(e) {
    e.find('.alert').remove();
}

function showMessage(e, i, a) {
    let l = $('<div class="m-alert m-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>' +
        '<span></span>' +
        '</div>');
    e.find('.alert').remove();
    l.prependTo(e);
    l.find('span').html(a);
}

function formatDateFromServer(string) {
    if (!!string) return moment(string, dateTimeServerFormat).format(dateLocalFormat);
    else return 'Not updated';
}