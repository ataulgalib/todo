
@php
    if(empty($breadCrumList)){
        $breadCrumList = getBreadCrumbList();
    }
@endphp

<h1>
    {{ isset($breadCrumList['parent_menu_display_name']) && !empty($breadCrumList['parent_menu_display_name']) ? __($breadCrumList['parent_menu_display_name']) : '' }}    
    <small>
        {{ isset($breadCrumList['app_version']) && !empty($breadCrumList['app_version']) ? __($breadCrumList['app_version']) : '' }}   
    </small>
</h1>

<ol class="breadcrumb">
    <li>
        @php
            $route_name = '#';
            try{
                if(isset($breadCrumList['parent_menu_route_name']) && !empty($breadCrumList['parent_menu_route_name'])){
                    $route_name = strContains($breadCrumList['parent_menu_route_name'], ['#','',null]) ? '#' : route($breadCrumList['parent_menu_route_name']);
                }
            }catch(\Exception $e){
                $route_name = '#';
            }
        @endphp
        <a href="{{ $route_name  }}">
            @if(isset($breadCrumList['parent_menu_icon_class_name']) && !empty($breadCrumList['parent_menu_icon_class_name']))
                <i class="{{ $breadCrumList['parent_menu_icon_class_name'] }}"></i>
            @endif
            {{ $breadCrumList['parent_menu_display_name'] }}
        </a>
    </li>

    @if(isset($breadCrumList['child_menu_display_name']) && !empty($breadCrumList['child_menu_display_name']))

        @php
            $route_name = '#';
            try{
                if(isset($breadCrumList['child_menu_route_name']) && !empty($breadCrumList['child_menu_route_name'])){
                    $route_name = strContains($breadCrumList['child_menu_route_name'], ['#','',null]) ? '#' : route($breadCrumList['child_menu_route_name']);
                }
            }catch(\Exception $e){
                $route_name = '#';
            }
        @endphp

        <li class="{{ active_menu([ $breadCrumList['child_menu_route_name'] ]) }}">
            <a href="{{ $route_name  }}">
                @if(isset($breadCrumList['child_menu_icon_class_name']) && !empty($breadCrumList['child_menu_icon_class_name']))
                    <i class="{{ $breadCrumList['child_menu_icon_class_name'] }}"></i>
                @endif

                {{ $breadCrumList['child_menu_display_name'] }}
            </a>
        </li>
    @endif

    @if(isset($breadCrumList['page_display_name']) && !empty($breadCrumList['page_display_name']))

        @php
            $route_name = '#';
            try{
                if(isset($breadCrumList['page_route_name']) && !empty($breadCrumList['page_route_name'])){
                    $route_name = strContains($breadCrumList['page_route_name'], ['#','',null]) ? '#' : route($breadCrumList['page_route_name']);
                }
            }catch(\Exception $e){
                $route_name = '#';
            }
        @endphp

        <li class="{{ active_menu([ $breadCrumList['child_menu_route_name'] ]) }}">
            <a href="{{ $route_name }}">
                {{-- @if(isset($breadCrumList['parent_menu_icon_class_name']) && !empty($breadCrumList['parent_menu_icon_class_name']))
                    <i class="{{ $breadCrumList['parent_menu_icon_class_name'] }}"></i>
                @endif --}}

                {{ $breadCrumList['page_display_name'] }}
            </a>
          
        </li>
    @endif

</ol>