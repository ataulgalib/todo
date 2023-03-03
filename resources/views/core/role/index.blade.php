@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-6">
                    @if(hasRoutePermission('core.role.store'))
                        <h3 class="box-title">{{ __('Create Role') }}</h3>
                        <div class="btn-group">
                            <a href="#" class="btn btn-info btn-xs" data-tooltip="tooltip" title="{{ __('Add New Role') }}" data-toggle="modal" data-target="#modal-store"><i class="fa fa-fw fa-plus-square"></i></a>
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
                            <th class="text-center" width="20%">{{ __('Created By') }}</th>
                            <th class="text-center" width="10%">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(sizeof($dataList) > 0)
                            @foreach($dataList as $key => $data)
                                <tr>
                                    <td class="text-center">{{  $dataList->firstItem()+$loop->index }}</td>
                                    <td class="text-center">{{ __($data->name) }}</td>
                                    <td class="text-left">{{ __(@$data->user->name) }}</td>
                                    <td class="text-center">
                                        @if(hasRoutePermission('core.role.update'))
                                            <a class="btn btn-info btn-xs" data-tooltip="tooltip" title="{{ __('Edit') }}"  data-toggle="modal"
                                                data-target="#modal-update"
                                                data-form-href="{{ route('core.role.update', $data->id) }}"
                                                data-form-method = "PUT"
                                                data-target-id = "{{$data->id}}"
                                                data-name = "{{ $data->name }}">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                        @endif

                                        @if(hasRoutePermission('core.role.destroy'))
                                            <a class="btn btn-danger btn-xs item-delete-btn" href="{{ route('core.role.destroy',$data->id) }}" data-tooltip="tooltip" title="{{ __('Delete') }}">
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
                    @if(sizeof($dataList) > 0)
                        {{
                            $dataList->appends([
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


{{-- MODAL SECTION --}}
@if(hasRoutePermission('core.role.store'))
    <div class="modal fade" id="modal-store">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ __('Create New Role') }}</h4>
            </div>
            <form action="{{ route('core.role.store') }}" method="post" id="store-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Name') }}" required>
                        <span class="error-text d-none"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('Close')}}</button>
                    <button type="button" class="btn btn-primary" id="modal-store-save-btn">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(hasRoutePermission('core.role.update'))
    <div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ __('Edit Role') }}</h4>
            </div>
            <form action="" method="post" id="update-form" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Name') }}" required>
                        <span class="error-text d-none"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('Close')}}</button>
                    <button type="button" class="btn btn-primary" id="modal-edit-update-btn">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
