<div class="box-header with-border col-md-12">
    <h3 class="box-title">{{ __('Permission List') }}</h3>
</div>
<div class="box-body">
    @if(!empty($menu_list))
    <table class="table table-bordered dt-responsive nowrap table-striped"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th class="text-center" width="5%">{{__('SL')}}</th>
                <th class="text-center" width="20%">{{__('Menu')}}</th>
                <th class="text-center" width="20%">{{__('Sub Menu')}}</th>
                <th class="text-center" width="20%">{{__('Pages')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menu_list as $parent_menus)
            <tr class="section_{{$parent_menus->get('parent_menu')}} section">
                <td style="vertical-align:top" class="text-center">{{ $loop->iteration }}</td>
                <td style="vertical-align:top" class="text-left">

                    <label class="checkbox checkbox-ebony" style="margin-left: 5pc">
                        @php
                            $parent_menu_checker = '';
                            $parent_route_name = $parent_menus->get('route_name') != '#' ? $parent_menus->get('route_name') : $parent_menus->get('parent_menu');

                            if(in_array($parent_route_name,$role_wise_route_list)){
                                $parent_menu_checker = 'checked';
                            }

                        @endphp
                        <input name="route_name[]" value="{{ $parent_menus->get('route_name') != '#' ? $parent_menus->get('route_name') : $parent_menus->get('parent_menu') }}" class="form-check-input" type="checkbox" main-menu ="{{ $parent_menus->get('parent_menu') }}" id="{{ $parent_menus->get('parent_menu') }}"
                        input-type="main_menu" {{ $parent_menu_checker }} style="cursor: pointer" >

                        <label class="form-check-label input-span" for="{{ $parent_menus->get('parent_menu') }}">
                            <strong>{{ __($parent_menus->get('parent_menu')) }}</strong>
                        </label>

                    </label>
                </td>
                <td colspan="3" class="text-left">
                    <table class="table" style="width:100%;">
                        @if(!empty($parent_menus->get('child_menu')))
                            @foreach($parent_menus->get('child_menu') as $child_menus)
                            <tr>
                                <td style="width:60%;" class="border-remove" class="text-left">

                                    @php
                                        $child_menu_checker = '';
                                        if(in_array($child_menus->get('route_name'), $role_wise_route_list)){
                                            $child_menu_checker = 'checked';
                                        }
                                    @endphp

                                    <input name="route_name[]" value="{{ $child_menus->get('route_name') }}" class="form-check-input" type="checkbox" sub-menu ="{{ $child_menus->get('parent_menu') }}" main-menu ="{{ $parent_menus->get('parent_menu') }}" id="{{ $parent_menus->get('parent_menu') }}_{{ $child_menus->get('parent_menu') }}" input-type="sub_menu" {{ $child_menu_checker }} style="cursor: pointer">

                                    <label class="form-check-label" for="{{ $parent_menus->get('parent_menu') }}_{{ $child_menus->get('parent_menu') }}" style="cursor: pointer">
                                        <strong>{{ __($child_menus->get('parent_menu')) }}</strong>
                                    </label>

                                </td>
                                <td style="width:50%;" class="border-remove" class="text-left">
                                    @if(!empty($child_menus->get('permission_route')))
                                    <table class="table" style="width:100%;">
                                        @foreach($child_menus->get('permission_route') as $key => $pages)
                                        <tr>
                                            <td style="width:50%;" class="border-remove" class="text-left">
                                                <label class="checkbox checkbox-ebony" style="cursor: pointer !important" style="margin-left: 5pc">

                                                    @php
                                                        $page_menu_checker = '';
                                                        if(in_array($pages->get('route_name'), $role_wise_route_list)){
                                                            $page_menu_checker = 'checked';
                                                        }
                                                    @endphp

                                                    <input name="route_name[]" value="{{ $pages->get('route_name')}}" class="form-check-input" type="checkbox" main-menu = "{{ $parent_menus->get('parent_menu') }}" sub-menu = "{{ $child_menus->get('parent_menu') }}" route="{{ $pages->get('route_name')}}"  input-type="action" {{ $page_menu_checker }} style="cursor: pointer">

                                                    {{__($pages->get('display_name'))}}
                                                </label>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else

                        @endif
                    </table>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
<div class="box-footer">
    <button type="button" class="btn btn-primary pull-right form-submit-btn">{{ __('Submit') }}</button>
</div>

@include('admin.partials.access_control_js')
@include('admin.partials.js')
