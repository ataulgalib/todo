@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-6">
                    <h3 class="box-title"></h3>
                    <div class="btn-group">
                        {{-- <a href="{{ route('permission.create') }}" class="btn btn-info" data-tooltip="tooltip" title="Add New {{ $tab_info['title'] }}" ><i class="fa fa-fw fa-plus-square"></i></a> --}}
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <form action="" method="get">
                        <div class="col-md-2" id="date_range_show">
                            <input type="text" value="" id="datepicker1" class="selectpicker form-control" name="daterange" autocomplete="off" placeholder="{{__('Date Range')}}" readonly/>
                        </div>
                        <div class="col-md-4" id="date_range_show">
                            <input type="text" name="search_key" class="form-control" placeholder="{{ __('Search...') }}" value="{{ $search['search_key'] ?? null }}">
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
                            <th class="text-center" width="10%">{{ __('Date Time') }}</th>
                            <th class="text-center" >{{ __('Logs') }}</th>
                            <th class="text-center" width="10%">{{ __('File') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(sizeof($data) > 0)
                            @foreach($data as $key => $log)
                                <tr>
                                    <td class="text-center">{{ $data->firstItem()+ $loop->index }}</td>
                                    <td class="text-center">{{ @$log['log_date'] }}</td>
                                    <td class="text-left">{{ @$log['log_data'] }}</td>
                                    <td class="text-center">{{ @$log['log_file_name'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="box-body">
                <div class="col-md-6 clearfix">
                    <form method="get" action="">
                        <input type="hidden" id="hidden_search" name="date_from" value="{{ $search['date_from'] ?? null }}">
                        <input type="hidden" id="hidden_search" name="date_to" value="{{ $search['date_to'] ?? null }}">
                        <input type="hidden" id="hidden_search" name="search_key" value="{{ $search['search_key'] ?? null }}">

                        {{ __(DATA_TABLES_PER_PAGE) }}

                        @include('core.table.per_page',[
                            'page_limit' => $search['page_limit'],
                        ])

                    </form>
                </div>
                <div class="col-md-6 clearfix">
                    {{
                        $data->appends([
                            'date_from' => $search['date_from'] ?? '',
                            'date_to' => $search['date_to'] ?? '',
                            'search_key' => $search['search_key'] ?? '',
                        ])->links('core.table.pagination')
                    }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $('document').ready(function(){
            $('#datepicker1').daterangepicker({
                maxDate: new Date(),
                "autoApply": false,
                locale: {
                    format: 'YYYY/MM/DD',
                    separator: "{{ __(DATE_RANGE_SEPARATOR) }}",
                    customRangeLabel: "{{__('Custom Range')}}",
                    applyLabel: "{{__('Apply')}}",
                    cancelLabel: "{{__('Cancel')}}"
                },
                ranges: {
                    "{{__('Today')}}": [moment(), moment()],
                    "{{__('Yesterday')}}": [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    "{{__('Last 7 Days')}}": [moment().subtract(6, 'days'), moment()],
                    "{{__('Last 30 Days')}}": [moment().subtract(29, 'days'), moment()],
                    "{{__('This Month')}}": [moment().startOf('month'), moment().endOf('month')],
                    "{{__('Last Month')}}": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "alwaysShowCalendars": true,
                "startDate": "{{isset($search['date_from']) ? $search['date_from'] : ""}}",
                "endDate": "{{isset($search['date_to']) ? $search['date_to'] : ""}}"
            });
        });
    </script>
@endpush
