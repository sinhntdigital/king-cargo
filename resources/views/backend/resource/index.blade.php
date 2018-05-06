@extends('layouts.bo-layout')

@section('page_title', 'Resource management')

@section('content')
    <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--head-sm">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-list"></i>
                    </span>
                    <h3 class="m-portlet__head-text">{{ __('List all resources') }}</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row m--margin-bottom-15">
                <div class="col-12 text-right">
                    <a href="{{ route('users.create') }}" class="btn btn-brand m-btn m-btn--icon">
                        <span><i class="fa fa-plus-circle"></i><span>{{ __("Create new") }}</span></span>
                    </a>
                </div>
            </div>
            <table id="gm-table--investment_packages" class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>{{ __('No') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Country') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Ballance') }}</th>
                    <th>{{ __('Date register') }}</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                @php($no = 1)
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->getCountryName() }}</td>
                        <td>{{ $user->getPhone() }}</td>
                        <td>{{ Helpers::formatUSD($user->usd) }}</td>
                        <td>{{ Helpers::formatDateTime($user->created_at) }}</td>
                        <td>
                            <a href="{{ route('investment-packages.edit', $user->id) }}"
                               class="btn btn-success m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:;" data-url="{{ route('users.destroy', $user->id) }}"
                               class="m--margin-left-5 btn btn-danger m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill gm-investment_package__btn--delete_package">
                                <i class="la la-remove"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $('#gm-table--investment_packages').mDatatable({

        });
    </script>
@stop