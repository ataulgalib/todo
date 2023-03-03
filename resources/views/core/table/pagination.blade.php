@if ($paginator->hasPages())

    {{-- WHEN YOU NEED POST METHOD FOR PAGINATION  --}}
    {{-- @if(isset($data['method']) && $data['method'] == 'POST')
    <form action="{{ route(Config::get('constants.defines.APP_ALL_TRANSACTION_INDEX')) }}" method="post" id="search_form">
        @csrf

        <input type="hidden" name="page">
        <input type="hidden" name="page_limit">
        @foreach ($data['search_parameter'] as $key => $parameter )
            @if(is_array($parameter))
                @foreach ($parameter as $value)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $value }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $parameter }}">
            @endif
        @endforeach

    </form>
    @endif --}}

    <div class="scrollable-sm float-end" style="float: right">
        <ul class="pagination force-center-sm" role="navigation" style="padding-left: 20px">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link mr-4" aria-hidden="true">{{__('Previous')}}</span>
                </li>
            @else

                 @if(isset($data['method']) && $data['method'] == 'POST')
                        <li class="page-item">
                            <a class="page-link mr-4 prev-btn" href="#!" data-pageUrl = "{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">{{__('Previous')}}</a>
                            {{-- <button type="button" class="prev-btn mr-4" data-pageUrl = "{{ $paginator->previousPageUrl() }}">{{__('Previous')}}</button> --}}
                            </li>
                 @else
                    <li class="page-item">
                        <a class="page-link mr-4" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">{{__('Previous')}}</a>
                    </li>
                 @endif
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            @if(isset($data['method']) && $data['method'] == 'POST')
                                <li class="page-item">
                                    <a class="page-link number-btn" href="#!">{{ $page }}</a>
                                    {{-- <button type="button" class="number-btn">{{ $page }}</button> --}}
                                </li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                @if(isset($data['method']) && $data['method'] == 'POST')
                    <li class="page-item">
                        <a class="page-link ml-4 next-btn" href="#!" data-pageUrl = "{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">{{__('Next')}}</a>
                        {{-- <button type="button" class="next-btn ml-4" data-pageUrl = "{{ $paginator->nextPageUrl() }}">{{__('Next')}}</button> --}}
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link ml-4" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">{{__('Next')}}</a>
                    </li>
                @endif
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link ml-4" aria-hidden="true">{{__('Next')}}</span>
                </li>
            @endif
        </ul>
    </div>
@endif
{{-- @push('scripts')
<script>
    $(document).ready(function(){
        $('.number-btn').on('click', function(){
            var page = $(this).text();
            $('input[name="page"]').val(page);
            $('#search_form').submit();
        });
        $('.next-btn, .prev-btn').on('click', function(){
            var pageUrl = $(this).attr('data-pageUrl');
            var url = new URL(pageUrl);
            var page = url.searchParams.get("page");

            $('input[name="page"]').val(page);
            var form=document.getElementById('search_form');
            form.action=pageUrl;

            $('#search_form').submit();
        });
    });
</script>
@endpush --}}