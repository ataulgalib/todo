@extends('admin.layouts.master')

@push('styles')

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.min.css">
    <style>
        #date_of_end_task{
            z-index: 1100 !important;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-6">
                    @if(hasRoutePermission('admin.todo.store'))
                        <h3 class="box-title">{{ __('Create To Do') }}</h3>
                        <div class="btn-group">
                            <a href="#" class="btn btn-info btn-xs" data-tooltip="tooltip" title="{{ __('Add New To Do') }}" data-toggle="modal" data-target="#modal-store"><i class="fa fa-fw fa-plus-square"></i></a>
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
                            <th class="text-center">{{ __('Assignee name') }}</th>
                            <th class="text-center">{{ __('Title') }}</th>
                            <th class="text-center">{{ __('Date of End') }}</th>
                            <th class="text-center" width="20%">{{ __('Created By') }}</th>
                            <th class="text-center" width="10%">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(sizeof($dataList) > 0)
                            @foreach($dataList as $key => $data)
                                <tr>
                                    <td class="text-center">{{  $dataList->firstItem()+$loop->index }}</td>
                                    <td class="text-left">{{ __(@$data->user->name) }}</td>
                                    <td class="text-left">{{ __(@$data->title) }}</td>
                                    <td class="text-left">{{ \App\Utils\CarbonCore::parse($data->date_of_end_task)->format('Y-m-d')  }}</td>
                                    <td class="text-left">{{ __(@$data->createdByUser->name) }}</td>


                                    <td class="text-center">
                                        @if(hasRoutePermission('admin.todo.show'))
                                            <a class="btn btn-success btn-xs" data-tooltip="tooltip" title="{{ __('Edit') }}"  data-toggle="modal"
                                               data-target="#modal-show"
                                               data-form-href="{{ route('admin.todo.show', $data->id) }}"
                                               data-form-method = "PUT"
                                               data-target-id = "{{$data->id}}"
                                               data-title = "{{ __($data->title) }}"
                                               data-user_id = "{{ $data->user_id }}"
                                               data-date_of_end_task = "{{ \App\Utils\CarbonCore::parse($data->date_of_end_task)->format('Y-m-d') }}"
                                               data-description = "{{ $data->description }}"
                                               data-created_by = "{{ @$data->createdByUser->name }}"
                                            >

                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        @endif

                                        @if(hasRoutePermission('admin.todo.update'))
                                            <a class="btn btn-info btn-xs" data-tooltip="tooltip" title="{{ __('Edit') }}"  data-toggle="modal"
                                                data-target="#modal-update"
                                                data-form-href="{{ route('admin.todo.update', $data->id) }}"
                                                data-form-method = "PUT"
                                                data-target-id = "{{$data->id}}"
                                                data-title = "{{ $data->title }}"
                                                data-user_name = "{{ $data->user_id }}"
                                               data-date_of_end_task = "{{ \App\Utils\CarbonCore::parse($data->date_of_end_task)->format('Y-m-d') }}"
                                               data-description = "{{ $data->description }}"
                                            >

                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                        @endif

                                        @if(hasRoutePermission('admin.todo.destroy'))
                                            <a class="btn btn-danger btn-xs item-delete-btn" href="{{ route('admin.todo.destroy',$data->id) }}" data-tooltip="tooltip" title="{{ __('Delete') }}">
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

@if(hasRoutePermission('admin.todo.store'))
    <div class="modal fade" id="modal-store">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ __('Create New Todo') }}</h4>
                </div>
                <form action="{{ route('admin.todo.store') }}" method="post" id="store-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('Title') }}</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="{{ __('Title') }}" required>
                            <span class="error-text d-none"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Assign User') }}</label>

                            <select class="form-control selectpicker" name="user_id" id="user_id" data-live-search="true" required>
                                @foreach($user_lists as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach

                            </select>

                            <span class="error-text d-none"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Date Of End Task') }}</label>
                            <input type="date" class="form-control" id="date_of_end_task" name="date_of_end_task" placeholder="{{ __('Date Of End Task') }}" required data-toggle="datepicker">
                            <span class="error-text d-none"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('To do') }}</label>
                            <textarea class="summernote" id="description" name="description"></textarea>
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
@if(hasRoutePermission('admin.todo.destroy'))
    <div class="modal fade" id="modal-update">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ __('Edit Todo') }}</h4>
                </div>
                <form action="" method="post" id="update-form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('Title') }}</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="{{ __('Title') }}" required tag_name="text">
                            <span class="error-text d-none"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Assign User') }}</label>

                            <select class="form-control selectpicker" name="user_id" id="user_id" data-live-search="true" required tag_name="select-picker">
                                @foreach($user_lists as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach

                            </select>

                            <span class="error-text d-none"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Date Of End Task') }}</label>
                            <input type="date" class="form-control" id="date_of_end_task" name="date_of_end_task" placeholder="{{ __('Date Of End Task') }}" required data-toggle="datepicker" tag_name="date">
                            <span class="error-text d-none"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('To do') }}</label>
                            <textarea tag_name="textarea_summernote" class="summernote" id="description" name="description"></textarea>
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

@if(hasRoutePermission('admin.todo.show'))
    <div class="modal fade" id="modal-show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ __('') }}</h4>
                </div>
                <div class="modal-body">
    {{--                <div class="form-group">--}}
    {{--                    <label for="name">{{ __('Title') }}--}}
    {{--                        <p id="title"></p>--}}
    {{--                    </label>--}}
    {{--                </div>--}}

    {{--                <div class="form-group">--}}
    {{--                    <label for="name">{{ __('Assign User') }}--}}
    {{--                        <p id="user_name"></p>--}}
    {{--                    </label>--}}
    {{--                </div>--}}

                    <div class="form-group">
                        <label for="name">{{ __('Created By') }}
                            <p id="created_by"></p>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Date Of End Task') }}
                            <p id="date_of_end_task"></p>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('To do') }}</label>
                        <textarea tag_name="textarea_summernote" class="summernote" id="description" name="description"></textarea>
                        <span class="error-text d-none"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function(){

        $('.summernote').summernote();

        $('#modal-show').on('show.bs.modal', function (event) {
            var modal_name = "#modal-show";
            var title = $(event.relatedTarget).data('title');
            var user_name = $(event.relatedTarget).data('user_name');
            var date_of_end_task = $(event.relatedTarget).data('date_of_end_task');
            var description = $(event.relatedTarget).data('description');
            var created_by = $(event.relatedTarget).data('created_by');

            console.log(title, description, created_by);
            $(modal_name+' .modal-title').text(title);
            $(modal_name+' #created_by').text(created_by);
            $(modal_name+' #date_of_end_task').text(date_of_end_task);
            $(modal_name+' #description').summernote('code', description);
        });

    });
</script>
@endpush
