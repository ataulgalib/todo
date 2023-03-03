@php
    $total_page_count = DATA_TABLES_PER_PAGE_SHOW;
    $page_limit = $page_limit ?? DATA_TABLES_PER_PAGE_DEFAULT;
@endphp


<select name="page_limit" class="form-control form-control-sm d-inline"
        @if (empty($from))
            onchange="this.form.submit()"
        @endif
    style="width: auto;">

    @foreach($total_page_count as $key => $page_value)
        <option value="{{ $page_value }}" @if($page_value == $page_limit) selected @endif>{{ $page_value }}</option>        
    @endforeach

</select>


{{-- @if (!empty($from) && $from == 'alltransaction')
    @push('scripts')
        <script>
            $(document).ready(function(){
                $('select[name="page_limit"]').on('change', function(){
                    var page_limit = $(this).val();
                    $('input[name="page_limit"]').val(page_limit);
                    $('#search_form').submit();
                });
            });
        </script>
    @endpush
@endif --}}
