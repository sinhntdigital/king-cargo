@extends('layouts.bo-layout')

@section('page_title', __('Employee management'))

@section('content')
    <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--head-sm">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-list"></i>
                    </span>
                    <h3 class="m-portlet__head-text">{{ __('List all employees') }}</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row m--margin-bottom-15">
                <div class="col-sx-12 col-sm-8">
                    {!! Inputs::text('datatable_search_field', '', 500) !!}
                </div>
                <div class="col-xs-12 col-sm-4 text-right">
                    <button class="btn btn-brand m-btn m-btn--icon gm-btn--create_employee">
                        <span><i class="fa fa-plus-circle"></i><span>{{ __("Create new") }}</span></span>
                    </button>
                </div>
            </div>
            <div id="gm-datatable--resource"></div>
        </div>
    </div>

    <div class="modal fade" id="gm-modal--create_employee" data-backdrop="static" data-keyboard="false" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelTitleId">{{ __('Create new employee') }}</h4>
                </div>
                <div class="modal-body">
                    <form id="gm-form--create_employee" action="{{ route('employee.store') }}" method="post">
                        @include('backend.employee.form')
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-brand m-btn btn-sm m-btn--icon m-btn--pill gm-btn-submit--create_employee">
                        <span><i class="fa fa-save"></i><span>{{ __('Save') }}</span></span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-outline-danger m-btn btn-sm m-btn--icon m-btn--pill">
                        <span><i class="fa fa-remove"></i><span>){{ __('Close') }}</span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        const datatTable = $('#gm-datatable--resource');
        const btnCreate = '.gm-btn--create_employee';
        const btnSubmitCreate = '.gm-btn-submit--create_employee';
        const modalCreate = $('#gm-modal--create_employee');
        const formCreate = $('#gm-form--create_employee');
        const btnEdit = '.gm-datatable--employee__btn-edit';
        const btnSubmitEdit = '.gm-btn-submit--edit_employee';
        const modalEdit = $('#gm-modal--edit_employee');
        const formEdit = $('#gm-form--edit_employee');

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
                        url    : '{{ route('employee.index') }}',
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
                input  : $('#gm-input--datatable_search_field'),
                delay  : 400,
            },
            columns    : [
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
                        return !!row.email ? row.email : '{{ __('Not updated') }}';
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
                        return !!row.address ? row.address : '{{ __('Not updated') }}';
                    }
                },
                {
                    field   : "phone_number",
                    title   : "Phone number",
                    overflow: 'visible',
                    template: function (row) {
                        return !!row.phone_number ? row.phone_number : '{{ __('Not updated') }}';
                    }
                },
                {
                    field   : "type",
                    title   : "Type",
                    width   : 80,
                    overflow: 'visible',
                    template: function (row) {
                        switch (row.type) {
                            case 'company':
                                return '<span class="m-badge m-badge--primary m-badge--dot"></span> <span class="m--font-bold m--font-primary">{{ __('Company') }}</span>';
                            default:
                                return '<span class="m-badge m-badge--success m-badge--dot"></span> <span class="m--font-bold m--font-success">{{ __('Personal') }}</span>';
                        }
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
                                return '<span class="m-badge m-badge--danger m-badge--wide">{{ __('Disable') }}</span>';
                            default:
                                return '<span class="m-badge m-badge--success m-badge--wide">{{ __('Enable') }}</span>';
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
                        return '' +
                            '<span style="overflow: visible; width: 110px;">' +
                            '  <button class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill gm-datatable--employee__btn-edit" data-id="' + row.id + '">' +
                            '     <i class="la la-edit"></i>' +
                            '  </button>' +
                            '</span>';
                    }
                },
            ],
        });

        $(document).on('click', btnCreate, function () {
            formCreate.clearForm();
            // formCreate.validate().resetForm();
            modalCreate.modal('show');
        });

        $(document).on('click', btnSubmitCreate, function () {
            formCreate.validate({
                rules: {
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
                },
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
    </script>
@stop