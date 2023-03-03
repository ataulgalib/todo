@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-6">
                    @if(hasRoutePermission('core.user.create'))
                        <h3 class="box-title">{{ __('Create User') }}</h3>
                        <div class="btn-group">
                            <a href="{{ route('core.user.create') }}" class="btn btn-info btn-xs" data-tooltip="tooltip" title="{{ __('Add New User') }}"><i class="fa fa-fw fa-plus-square"></i></a>
                        </div>
                    @endif
                </div>
            </div>
            <hr>
            <div class="box-body">
                <div class="col-md-12">
                    <form action="" method="get">
                        <div class="col-md-4" id="date_range_show">
                            <input type="text" name="search_key" class="form-control" placeholder="{{ __('Search...') }}" value="{{ $params['search_key'] ?? null }}">
                        </div>
                        <div class="col-md-3 float-right">
                            <button class="btn btn-primary btn-std-padding" type="submit">{{ __('Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-body scrolable-table">
                <table class="table table-bordered" width="100">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">{{ __('SL') }}</th>
                            <th class="text-center">{{ __('Name') }}</th>
                            <th class="text-center">{{ __('Email') }}</th>
                            <th class="text-center">{{ __('Role') }}</th>
                            <th class="text-center" width="10%">{{ __('Created By') }}</th>
                            <th class="text-center" width="10%">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(sizeof($users) > 0)
                            @foreach($users as $key => $data)
                                <tr>
                                    <td class="text-center">{{  $users->firstItem()+$loop->index }}</td>
                                    <td class="text-left">{{ __($data->name) }}</td>
                                    <td class="text-left">{{ __($data->email) }}</td>
                                    <td class="text-left">{{ __(@$data->role->name) }}</td>
                                    <td class="text-left">{{ __(@$data->user->name) }}</td>
                                    <td class="text-center">

                                        @if(hasRoutePermission('core.user.edit'))
                                            <a href="{{ route('core.user.edit', $data->id) }}" class="btn btn-info btn-xs" data-tooltip="tooltip" title="{{ __('Edit') }}">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                        @endif

                                        @if(hasRoutePermission('core.user.destroy'))
                                            <a class="btn btn-danger btn-xs item-delete-btn" href="{{ route('core.user.destroy',$data->id) }}" data-tooltip="tooltip" title="{{ __('Delete') }}">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="box-body">
                <div class="col-md-6 clearfix">
                    <form method="get" action="">
                        <input type="hidden" id="hidden_search" name="search_key" value="{{ $params['search_key'] ?? null }}">
                        <input type="hidden" id="hidden_search" name="page_limit" value="{{ $params['page_limit'] ?? null }}">
                        {{ __(DATA_TABLES_PER_PAGE) }}

                        @include('core.table.per_page',[
                            'page_limit' => $params['page_limit'],
                        ])

                    </form>
                </div>
                <div class="col-md-6 clearfix">
                    @if(sizeof($users) > 0)
                        {{
                            $users->appends([
                                'page_limit' => $params['page_limit'] ?? '',
                                'search_key' => $params['search_key'] ?? '',
                            ])->links('core.table.pagination')
                        }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
