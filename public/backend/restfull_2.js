export default function () {

    const dataTable = $('#gm-datatable--resource');
    const btnCreate = '.gm-btn--create_employee';
    const btnSubmitCreate = '.gm-btn-submit--create_employee';
    const modalCreate = $('#gm-modal--create_employee');
    const formCreate = $('#gm-form--create_employee');
    const btnEdit = '.gm-datatable--employee__btn-edit';
    const btnSubmitEdit = '.gm-btn-submit--edit_employee';
    const modalEdit = $('#gm-modal--edit_employee');
    const formEdit = $('#gm-form--edit_employee');
    const btnSubmitDelete = '.gm-btn-submit--delete_employee';
    const searchField = $('#gm-input--datatable_search_field');
    const routeIndex = '';
    const rules = {
        full_name   : {
            required: true,
        },
        status      : {
            required: true,
        },
        email       : {
            required: true,
            email   : true,
        },
        phone_number: {
            required: true,
        },
    };
    const columns = [
        {
            field   : 'id',
            title   : '#',
            sortable: false, // disable sort for this column
            width   : 40,
            selector: {class: 'm-checkbox--solid m-checkbox--brand'},
        },
        {
            field   : "full_name",
            title   : "Full name",
            overflow: 'visible',
            // locked: {left: 'md'},
        },
        {
            field   : "email",
            title   : "Email",
            overflow: 'visible',
            template: function (row) {
                return !!row.email ? row.email : 'Not updated';
            }
        },
        {
            field   : "birthday",
            title   : "Birthday",
            width   : 120,
            overflow: 'visible',
            template: function (row) {
                return formatDateFromServer(row.birthday);
            }
        },
        {
            field   : "address",
            title   : "Address",
            overflow: 'visible',
            template: function (row) {
                return !!row.address ? row.address : 'Not updated';
            }
        },
        {
            field   : "phone_number",
            title   : "Phone number",
            overflow: 'visible',
            template: function (row) {
                return !!row.phone_number ? row.phone_number : 'Not updated';
            }
        },
        {
            field   : "status",
            title   : "Status",
            width   : 50,
            overflow: 'visible',
            template: function (row) {
                switch (row.status) {
                    case 'disable':
                        return '<span class="m-badge m-badge--danger m-badge--wide">Disable</span>';
                    default:
                        return '<span class="m-badge m-badge--success m-badge--wide">Enable</span>';
                }
            }
        },
        {
            field     : 'mDataTableAction',
            title     : '',
            sortable  : false,
            filterable: false,
            textAlign : 'right',
            width     : 40,
            template  : row => {
                return '<span style="overflow: visible; width: 110px;">' +
                    '  <button class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill gm-datatable--employee__btn-edit" ' +
                    '          data-url="' + routeIndex + '/' + row.id + '" data-id="' + row.id + '">' +
                    '     <i class="la la-edit"></i>' +
                    '  </button>' +
                    '</span>';
            }
        },
    ];

    function init() {
        // Define data table
        let mtable = dataTable.mDatatable({
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

        // Button create new click
        $(document).on('click', btnCreate, function () {
            formCreate.clearForm();
            modalCreate.modal('show');
        });

        // Button submit create new click
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
                            dataTable.reload();
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

        // Button edit click
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

        // Button submit edit click
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
                            dataTable.reload();
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

        // Button delete click
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
                            dataTable.reload();
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
    }
};