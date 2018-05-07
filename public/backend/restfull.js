let mtable = datatTable.mDatatable({
    sortable   : true,
    pagination : true,
    searchDelay: 500,
    layout     : dataTableLayout,
    toolbar    : dataTableToolbar,
    translate  : dataTableTranslate,
    data       : {
        type           : 'remote',
        serverPaging   : false,
        serverFiltering: false,
        serverSorting  : false,
        pageSize       : 20,
        saveState      : {
            cookie    : false,
            webstorage: false
        },
        source         : {
            read: {
                url    : routeIndex,
                method : 'get',
                headers: {
                    // 'Api-Token' : $('meta[name=api-token]').attr('content')
                },
                params : {
                    query: {}
                }
            }
        },
    },
    search     : {
        onEnter: false,
        input  : searchField,
        delay  : 400,
    },
    columns    : columns,
});

$(document).on('click', btnCreate, function () {
    formCreate.clearForm();
    modalCreate.modal('show');
});

$(document).on('click', btnSubmitCreate, function () {
    formCreate.validate({
        rules: rules
    });
    if (formCreate.valid()) {
        $(btnSubmitCreate).addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
        formCreate.ajaxSubmit({
            success: function (response, i, a, l) {
                if (response.hasOwnProperty('success')) {
                    formCreate.clearForm();
                    formCreate.validate().resetForm();
                    datatTable.reload();
                    modalCreate.modal('hide');
                    toastr.success(response.success, 'Success');
                } else if (response.hasOwnProperty('error')) {
                    toastr.error(response.error, 'Error');
                }
                $(btnSubmitCreate).removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            }
        });
    }
});

$(document).on('click', btnEdit, function () {
    formEdit.clearForm();
    formEdit.attr('action', $(this).data('url'));
    axios.get($(this).data('url')).then(function (response) {
        if (response.data.hasOwnProperty('success')) {
            let data = response.data.success;
            Object.keys(data).forEach(function (key) {
                formEdit.find('[name=' + key + ']').val(data[key]);
            });
        }
    }).catch(function (response) {
        console.log(response);
    });
    modalEdit.modal('show');
});

$(document).on('click', btnSubmitEdit, function () {
    formEdit.validate({
        rules: rules
    });
    if (formEdit.valid()) {
        $(btnSubmitCreate).addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
        formEdit.ajaxSubmit({
            success: function (response, i, a, l) {
                if (response.hasOwnProperty('success')) {
                    formEdit.clearForm();
                    formEdit.validate().resetForm();
                    datatTable.reload();
                    modalEdit.modal('hide');
                    toastr.success(response.success, 'Success');
                } else if (response.hasOwnProperty('error')) {
                    toastr.error(response.error, 'Error');
                }
                $(btnSubmitCreate).removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
            }
        });
    }
});

$(document).on('click', btnSubmitDelete, function () {
    swal({
        title             : 'Warning!',
        type              : 'warning',
        position          : 'center',
        html              : 'Your data will be deleted and cannot restore. Are you sure you want to do this?',
        confirmButtonText : '<i class="fa fa-check"></i> Yes, do it !',
        showCancelButton  : true,
        cancelButtonText  : '<i class="fa fa-remove"></i> Think again ?',
        focusConfirm      : false,
        confirmButtonClass: "btn btn-outline-success m-btn m-btn--pill m-btn--air",
        cancelButtonClass : "btn btn-outline-danger m-btn m-btn--pill m-btn--air",
    }).then((result) => {
        if (result.value) {
            axios.delete(formEdit.attr('action')).then(response => {
                if (response.data.hasOwnProperty('success')) {
                    let data = response.data.success;
                    formEdit.clearForm();
                    formEdit.validate().resetForm();
                    datatTable.reload();
                    modalEdit.modal('hide');
                    toastr.success(data, 'Success');
                } else {
                    console.log(response);
                }
            }).catch(error => {
                console.log(error);
            });
        }
    }).catch(swal.noop());
});