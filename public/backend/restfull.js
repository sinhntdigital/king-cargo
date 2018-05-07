export default {
    dataTable      : $('#dataTable'),
    btnCreate      : '.btnCreate',
    btnSubmitCreate: '.btnSubmitCreate',
    modalCreate    : $('#modalCreate'),
    formCreate     : $('#formCreate'),
    btnEdit        : '.btnEdit',
    btnSubmitEdit  : '.btnSubmitEdit',
    modalEdit      : $('#modalEdit'),
    formEdit       : $('#formEdit'),
    btnSubmitDelete: '.btnSubmitDelete',
    searchField    : $('#searchField'),
    routeIndex     : '',
    columns        : [],
    rules          : [],
    gmInit         : function () {
        let thisComponent = this;

        // Define data table
        let mtable = thisComponent.dataTable.mDatatable({
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
                        url    : thisComponent.routeIndex,
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
                input  : thisComponent.searchField,
                delay  : 400,
            },
            columns    : thisComponent.columns,
        });

        // Button create new click
        $(document).on('click', thisComponent.btnCreate, function () {
            thisComponent.formCreate.clearForm();
            thisComponent.modalCreate.modal('show');
        });

        // Button submit create new click
        $(document).on('click', thisComponent.btnSubmitCreate, function () {
            thisComponent.formCreate.validate({
                rules: thisComponent.rules
            });
            if (thisComponent.formCreate.valid()) {
                $(thisComponent.btnSubmitCreate).addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
                thisComponent.formCreate.ajaxSubmit({
                    success: function (response, i, a, l) {
                        if (response.hasOwnProperty('success')) {
                            thisComponent.formCreate.clearForm();
                            thisComponent.formCreate.validate().resetForm();
                            thisComponent.dataTable.reload();
                            thisComponent.modalCreate.modal('hide');
                            toastr.success(response.success, 'Success');
                        } else if (response.hasOwnProperty('error')) {
                            toastr.error(response.error, 'Error');
                        }
                        $(thisComponent.btnSubmitCreate).removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    }
                });
            }
        });

        // Button edit click
        $(document).on('click', thisComponent.btnEdit, function () {
            thisComponent.formEdit.clearForm();
            thisComponent.formEdit.attr('action', $(this).data('url'));
            axios.get($(this).data('url')).then(function (response) {
                if (response.data.hasOwnProperty('success')) {
                    let data = response.data.success;
                    Object.keys(data).forEach(function (key) {
                        thisComponent.formEdit.find('[name=' + key + ']').val(data[key]);
                    });
                }
            }).catch(function (response) {
                console.log(response);
            });
            thisComponent.modalEdit.modal('show');
        });

        // Button submit edit click
        $(document).on('click', thisComponent.btnSubmitEdit, function () {
            thisComponent.formEdit.validate({
                rules: thisComponent.rules
            });
            if (thisComponent.formEdit.valid()) {
                $(thisComponent.btnSubmitCreate).addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
                thisComponent.formEdit.ajaxSubmit({
                    success: function (response, i, a, l) {
                        if (response.hasOwnProperty('success')) {
                            thisComponent.formEdit.clearForm();
                            thisComponent.formEdit.validate().resetForm();
                            thisComponent.dataTable.reload();
                            thisComponent.modalEdit.modal('hide');
                            toastr.success(response.success, 'Success');
                        } else if (response.hasOwnProperty('error')) {
                            toastr.error(response.error, 'Error');
                        }
                        $(thisComponent.btnSubmitCreate).removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    }
                });
            }
        });

        // Button delete click
        $(document).on('click', thisComponent.btnSubmitDelete, function () {
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
                    axios.delete(thisComponent.formEdit.attr('action')).then(response => {
                        if (response.data.hasOwnProperty('success')) {
                            let data = response.data.success;
                            thisComponent.formEdit.clearForm();
                            thisComponent.formEdit.validate().resetForm();
                            thisComponent.dataTable.reload();
                            thisComponent.modalEdit.modal('hide');
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
    }
}