@extends('layouts.bo-layout')

@section('page_title', __('User management'))

@section('content')
    <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--head-sm">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-list"></i>
                    </span>
                    <h3 class="m-portlet__head-text">{{ __('List all User') }}</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row m--margin-bottom-15">
                <div class="col-sx-12 col-sm-8">
                    {!! Inputs::text('datatable_search_field', '', 500) !!}
                </div>
                <div class="col-xs-12 col-sm-4 text-right">
                    <button class="btn btn-brand m-btn m-btn--icon gm-btn--create_user">
                        <span><i class="fa fa-plus-circle"></i><span>{{ __("Create new") }}</span></span>
                    </button>
                </div>
            </div>
            <div id="gm-datatable--user"></div>
        </div>
    </div>

    <div class="modal fade" id="gm-modal--create_user" data-backdrop="static" data-keyboard="false" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Create new user') }}</h4>
                </div>
                <div class="modal-body">
                    <form id="gm-form--create_user" action="{{ route('user.store') }}" method="post">
                        @include('backend.user.form')
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-brand m-btn btn-sm m-btn--icon m-btn--pill gm-btn-submit--create_user">
                        <span><i class="fa fa-save"></i><span>{{ __('Save') }}</span></span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-outline-warning m-btn btn-sm m-btn--icon m-btn--pill">
                        <span><i class="fa fa-remove"></i><span>{{ __('Close') }}</span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="gm-modal--edit_user" data-backdrop="static" data-keyboard="false" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Edit user') }}</h4>
                </div>
                <div class="modal-body">
                    <form id="gm-form--edit_user" action="" method="post">
                        @method('put')
                        @include('backend.user.form')
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <button class="float-left btn btn-outline-danger m-btn btn-sm m-btn--icon m-btn--pill gm-btn-submit--delete_user">
                            <span><i class="fa fa-recycle"></i><span>{{ __('Delete') }}</span></span>
                        </button>
                        <button data-dismiss="modal" class="float-right m--margin-left-5 btn btn-outline-warning m-btn btn-sm m-btn--icon m-btn--pill">
                            <span><i class="fa fa-remove"></i><span>{{ __('Close') }}</span></span>
                        </button>
                        <button class="float-right btn btn-outline-brand m-btn btn-sm m-btn--icon m-btn--pill gm-btn-submit--edit_user">
                            <span><i class="fa fa-save"></i><span>{{ __('Save') }}</span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="module">
        import restFullScripts from "{{ asset('backend/restfull.js') }}";
        restFullScripts.dataTable = $('#gm-datatable--user');
        restFullScripts.routeIndex = "{{ route('user.index') }}";
        restFullScripts.btnCreate = '.gm-btn--create_user';
        restFullScripts.btnSubmitCreate = '.gm-btn-submit--create_user';
        restFullScripts.modalCreate = $('#gm-modal--create_user');
        restFullScripts.formCreate = $('#gm-form--create_user');
        restFullScripts.btnEdit = '.gm-datatable--user__btn-edit';
        restFullScripts.btnSubmitEdit = '.gm-btn-submit--edit_user';
        restFullScripts.modalEdit = $('#gm-modal--edit_user');
        restFullScripts.formEdit = $('#gm-form--edit_user');
        restFullScripts.btnSubmitDelete = '.gm-btn-submit--delete_user';
        restFullScripts.searchField = $('#gm-input--datatable_search_field');
        restFullScripts.rules = {
            name   : {
                required: true,
            },
            status      : {
                required: true,
            },
            email       : {
                required: true,
                email   : true,
            },
        };
        restFullScripts.columns = [
            {
                field   : 'id',
                title   : '#',
                sortable: false, // disable sort for this column
                width   : 40,
                selector: {class: 'm-checkbox--solid m-checkbox--brand'},
            },
            {
                field   : "name",
                title   : "Name",
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
                    return '<span style="overflow: visible; width: 110px;">' +
                        '  <button class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill gm-datatable--user__btn-edit" ' +
                        '          data-url="{{ route('user.index') }}/' + row.id + '" data-id="' + row.id + '">' +
                        '     <i class="la la-edit"></i>' +
                        '  </button>' +
                        '</span>';
                }
            },
        ];
        setTimeout(function () {
            restFullScripts.gmInit();
        }, 500);
    </script>
@stop