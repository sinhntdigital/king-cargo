@extends('layouts.bo-layout')

@section('page_title', 'Employee management')

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
                <div class="col-12 text-right">
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
                    <h4 class="modal-title" id="modelTitleId">Create new employee</h4>
                </div>
                <div class="modal-body">
                    <form id="gm-form--create_employee" action="{{ route('employee.store') }}" method="post">

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-brand m-btn btn-sm m-btn--icon m-btn--pill">
                        <span><i class="fa fa-save"></i><span>Save</span></span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-outline-danger m-btn btn-sm m-btn--icon m-btn--pill">
                        <span><i class="fa fa-remove"></i><span>Close</span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        let mtable = $('#gm-datatable--resource').mDatatable({
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
                input: $('#inputTimKiemDataTables'),
            },
            columns    : [
                {
                    field    : 'id',
                    title    : '#',
                    sortable : false, // disable sort for this column
                    width    : 40,
                    selector : {class : 'm-checkbox--solid m-checkbox--brand'},
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
                    // locked: {left: 'md'},
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
                },
                {
                    field   : "phone_number",
                    title   : "Phone number",
                    overflow: 'visible',
                },
                {
                    field   : "type",
                    title   : "Type",
                    width   : 80,
                    overflow: 'visible',
                    template: function (row) {
                        switch (row.type) {
                            case 'company':
                                return '<span class="m-badge m-badge--primary m-badge--dot"></span> <span class="m--font-bold m--font-primary">Company</span>';
                            default:
                                return '<span class="m-badge m-badge--success m-badge--dot"></span> <span class="m--font-bold m--font-success">Personal</span>';
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
                                return '<span class="m-badge m-badge--danger m-badge--wide">Disable</span>';
                            default:
                                return '<span class="m-badge m-badge--success m-badge--wide">Enable</span>';
                        }
                    }
                },
                {
                    field      : 'mDataTableAction',
                    title      : '',
                    sortable   : false,
                    filterable : false,
                    textAlign  : 'right',
                    width      : 40,
                    template   : row => {
                        return '' +
                            '<span style="overflow: visible; width: 110px;">' +
                            '  <button class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill btnEditRow" data-id="' + row.id + '">' +
                            '     <i class="la la-edit"></i>' +
                            '  </button>' +
                            '</span>';
                    }
                },
            ],
        });

        $(document).on('click', '.gm-btn--create_employee', function () {
            $('#gm-modal--create_employee').modal('show');
        });
    </script>
@stop