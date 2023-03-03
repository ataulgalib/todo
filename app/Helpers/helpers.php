<?php

use App\Services\Core\ResourceContainerService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Services\Core\LoginProcessService;


/*
    SOFTWARE INTERNAL RESPONSE
*/
if (!function_exists('internal_sucess_response')) {
    function internal_sucess_response()
    {
        return config('configuration.software_exception_code.success');
    }
}

if (!function_exists('internal_fail_response')) {
    function internal_fail_response()
    {
        return config('configuration.software_exception_code.fail');
    }
}

if (!function_exists('internal_error_response')) {
    function internal_error_response()
    {
        return config('configuration.software_exception_code.error');
    }
}

if (!function_exists('internal_server_error_response')) {
    function internal_server_error_response()
    {
        return config('configuration.software_exception_code.server_error');
    }
}

/*
    SERVER EXCEPTION RESPONSE
*/

if (!function_exists('server_validation_fail_response')) {
    function server_validation_fail_response()
    {
        return config('configuration.server_exception_code.validation_fail');
    }
}

/*
    PHP OWN FUNCTION
*/

if (!function_exists('string_replace')) {
    function string_replace($pattern, $replacement, $string)
    {
        return \App\Utils\StringCore::replaceString($pattern, $replacement, $string);
    }
}

if (!function_exists('strContains')) {
    function strContains($string, $search_array = [], $oparator = '|')
    {

        $search_strings = '(';

        if (!empty($oparator) && is_array($search_array)) {
            foreach ($search_array as $key => $search) {

                if (is_null($search) || $search == '' || empty($search)) {
                    $search_strings .= "''";
                }

                if ($key + 1 != count($search_array)) {
                    $search_strings .= $search . $oparator;
                } else {
                    $search_strings .= "$search)";
                }
            }
        } else {
            $search_strings .= $search_array;
        }

        return preg_match($search_strings, $string) === 1;
    }
}

if (!function_exists('strContainsPartial')) {
    function strContainsPartial($string = '', $niddle = '')
    {
        return \App\Utils\StringCore::niddleContainsString($string, $niddle);
    }
}


if (!function_exists('arrayMerge')) {
    function arrayMerge($first_array = [], $second_array = [])
    {
        return array_merge($first_array, $second_array);
    }

}

if (!function_exists('setValueOnFirstPositionOfArray')) {
    function setValueOnFirstPositionOfArray($array = [], $value = '')
    {
        array_unshift($array, $value);
    }

}




/*
    ARRAY TO COLLECTIONS
*/

if (!function_exists('arrayToCollection')) {
    function arrayToCollection($array = [])
    {
        return collect($array)->arrayToCollection();
    }
}

/*
    ARRAY TO COLLECTIONS
*/

if (!function_exists('collectionPaginate')) {
    function collectionPaginate($collection = [], $per_page = false)
    {
        if(!$per_page){
            $per_page = DATA_TABLES_PAGINATION_LIMIT;
        }

        return collect($collection)->collectionPaginate($per_page);
    }
}

/*
    CORE MENU GENERATE
*/

if (!function_exists('core_genarated_menu')) {
    function core_genarated_menu($array = [])
    {
        return arrayToCollection(config('core_menus'));
    }
}


/*
    MENU ACTIVE
*/

if (!function_exists('active_menu')) {
    function active_menu($route_names = [])
    {
        $status = '';
        foreach ($route_names as $key => $route_name) {

            if (\Request::is(\Request::segment(1) . '/' . $route_name . '/*') || \Request::is(\Request::segment(1) . '/' . $route_name) || \Request::is(\Request::segment(1) . '*/' . $route_name . '*/') ||  \Request::is($route_name) || $route_name == \Request::route()->getName()) {
                $status = 'active';
                break;
            }
        }

        if(is_array($route_names)){
            if(in_array(\Request::route()->getName(), $route_names)){
                $status = 'active';
            }
        }
        return $status;

        // if(is_array($route_names)){
        //     if(in_array(\Request::route()->getName(), $route_names)){
        //         $status = 'active';
        //     }
        // }
        // return $status;
    }
}

/*
    MENU PERMISSION DETAILS FOR PARENT MENU, CHILD MENU NAD IF NEED ROUTE NAME
*/

if (!function_exists('permission_details')) {
    function permission_details($parent_menu_name = '', $child_menu_name = '',  $only_route_list = true)
    {
        $core_menus = core_genarated_menu();

        if (!empty($parent_menu_name)) {
            $core_menus = $core_menus->where('parent_menu', $parent_menu_name);
        }

        $permission_details = [];
        if ($core_menus->isNotEmpty()) {

            $permission_details = $core_menus->map(function ($items) use ($child_menu_name,  $only_route_list) {
                $permission_details = [];
                if ($items->has('permission_route')) {

                    $permission_details = $items->get('permission_route')->map(function ($item) use ($only_route_list) {
                        return menu_data_formation($item, $only_route_list);
                    });
                }

                if ($items->has('child_menu') && $items->get('child_menu')->isNotEmpty()) {

                    $items = $items->get('child_menu');

                    if (!empty($child_menu_name)) {
                        $items = $items->where('parent_menu', $child_menu_name);
                    }

                    $permission_details = $items->map(function ($item) use ($only_route_list) {

                        if ($item->has('permission_route')) {
                            $permission_details = $item->get('permission_route')->map(function ($item) use ($only_route_list) {
                                return menu_data_formation($item, $only_route_list);
                            });

                            return $permission_details;
                        }

                        return $permission_details;
                    })->flatten($only_route_list ? null : 1);
                }

                return $permission_details;
            })->flatten($only_route_list ? null : 1);
        }

        return $permission_details;
    }
}

/*
    SINGLE COLLECTION OF MENU DATA FORMATION
*/

if (!function_exists('menu_data_formation')) {
    function menu_data_formation($collection_of_menus, $only_route_list = true)
    {
        $parent_menu_permission = [];

        if ($only_route_list) {
            $parent_menu_permission = $collection_of_menus->has('route_name') ? $collection_of_menus->get('route_name') : '#';
        } else {
            $parent_menu_permission = [
                'display_name' => $collection_of_menus->has('display_name') ? $collection_of_menus->get('display_name') : __('Display Name Not Set'),
                'route_name' => $collection_of_menus->has('route_name') ? $collection_of_menus->get('route_name') : '#',
            ];
        }

        return $parent_menu_permission;
    }
}

/*
    GET BREADCRUM DATA
*/

if (!function_exists('getBreadCrumbList')) {
    function getBreadCrumbList()
    {
        return app()->BreadCrumInfoService->breadCrumInfoGenerate();
    }
}

/*
    SET RESOURCE ON LARAVEL APP SERVICE
*/

if (!function_exists('setResource')) {
    function setResource($key, $resource)
    {
        app()->instance($key, new ResourceContainerService($resource));
        return $resource;
    }
}

/*
    GET RESOURCE FROM LARAVEL APP SERVICE
*/

if (!function_exists('getResource')) {
    function getResource($key)
    {
        try {
            return app($key)->getResource();
        } catch (\Exception $e) {
            app()->LogManageService($e);
        }
        return null;
    }
}

/*
    SAFELY JSON ENCODE
*/

if (!function_exists('safe_json_encode')) {

    function safe_json_encode($value, $options = 0, $depth = 512, $utfErrorFlag = false)
    {
        $encoded = json_encode($value, $options, $depth);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_UTF8:
                $clean = utf8ize($value);
                if ($utfErrorFlag) {
                    return 'UTF8 encoding error'; // or trigger_error() or throw new Exception()
                }
                return safe_json_encode($clean, $options, $depth, true);
            default:
                return 'Unknown error'; // or trigger_error() or throw new Exception()

        }
    }
}

/*
    UTF8 STRING FORMATION
*/

if (!function_exists('utf8ize')) {

    function utf8ize($mixed)
    {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = utf8ize($value);
            }
        } else if (is_string($mixed)) {
            return utf8_encode($mixed);
        }
        return $mixed;
    }
}

/*
    GET LOG LEVEL TO GENERATE LOG
*/

if (!function_exists('getLogTypeName')) {

    function getLogTypeName($error_type)
    {
        $software_exception_code = config('configuration.software_exception_code');

        if(sizeof($software_exception_code) > 0) {
            foreach($software_exception_code as $key => $value) {
                if($value == $error_type) {
                    return $key;
                }
            }
        }
        return LOG_DEBUG_KEY;
    }

}


/*
    EXCEPTION LOG GENERATE
*/

if(!function_exists('exceptionLogWrite')){
    function exceptionLogWrite($logData = [], $action = CATCH_EXCEPTION_LOG_NAME)
    {
        app()->LogManageService->exceptionHandle($logData, $action);
    }
}

/*
    GENAREL LOG GENERATE
*/

if(!function_exists('logCreate')){
    function logCreate($logData = [], $action = LOG_INFO_KEY)
    {
        app()->LogManageService->logCreate($logData, $action);
    }
}

/*
    QUERY LOG GENERATE
*/

if(!function_exists('enableGlobalQueryLog')){
    function enableGlobalQueryLog($previous_log_delete = true)
    {
        app()->LogManageService->enableGlobalQueryLog();
    }
}

/*
    SESSION FUNCTION
*/

if(!function_exists('setSession')){
    function setSession($key = null, $value = null)
    {
        return app()->SessionService::set($key, $value);
    }
}

if(!function_exists('getSession')){
    function getSession($key = null)
    {
        return app()->SessionService::get($key);
    }
}

if(!function_exists('hasSession')){
    function hasSession($key = null)
    {
        return app()->SessionService::has($key);
    }
}

if(!function_exists('forgetSession')){
    function forgetSession($key = null)
    {
        return app()->SessionService::forget($key);
    }
}

/*
    CACHE FUNCTION
*/

if(!function_exists('setCache')){
    function setCache($key, $value, $minutes)
    {
        return app()->CacheService::set($key, $value, $minutes);
    }
}

if(!function_exists('rememberCache')){
    function rememberCache($key, $minutes, $callback)
    {
        return app()->CacheService::remember($key, $minutes, $callback);
    }
}

if(!function_exists('rememberForeverCache')){
    function rememberForeverCache($key, $callback)
    {
        return app()->CacheService::rememberForever($key, $callback);
    }
}

if(!function_exists('getCache')){
    function getCache($key, $callback)
    {
        return app()->CacheService::get($key);
    }
}

if(!function_exists('hasCache')){
    function hasCache($key)
    {
        return app()->CacheService::has($key);
    }
}

if(!function_exists('flushCache')){
    function flushCache()
    {
        return app()->CacheService::flush();
    }
}

/*
    ASSET URL CUSTOMIZED
*/

if(!function_exists('asset')){
    function asset($path, $secure = 1)
    {
        // if(request()->is(config('configuration.APP_ADMIN_URL_PREFIX').'/*')) {
        //     config()->set('app.asset_url','../public');
        // }elseif(request()->is(config('configuration.APP_CORE_URL_PREFIX').'/*')){
        //     // config()->set('app.asset_url','/../../public');
        // }
        return app('url')->asset($path, $secure);
    }
}

if(!function_exists('checkUrl')){
    function checkUrl($url_key ='')
    {
        if(request()->is($url_key.'/*') or request()->is(config('configuration.APP_ADMIN_URL_PREFIX').'/*')){
            return true;
        }
        return false;
    }
}

/*
    arrayPagination
*/
if(!function_exists('arrayPagination')){
    function arrayPagination($items, $page_limit = DATA_TABLES_PAGINATION_LIMIT)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage() ?: 1;
        $startIndex = ($currentPage * $page_limit) - $page_limit;
        $paginatedClients = Collection::make($items)->slice($startIndex, $page_limit);

        /*
         * Eager load orders for each client, but we don't want those cached.
         */
        // if (!$paginatedClients->isEmpty()) {
        //     $query = $paginatedClients->first()->newQuery()->with('orders');
        //     $paginatedClients = Collection::make($query->eagerLoadRelations($paginatedClients->all()));
        // }
        return new LengthAwarePaginator(
            $paginatedClients,
            $items instanceof Collection ? $items->count() : count($items),
            $page_limit,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]
        );
    }
}

// FLASH MESSAGE

if(!function_exists('flashMessage')){
    function flashMessage($level = 'info', $message = '')
    {
        return app()->SessionService->flash($level, $message);
    }
}

// HAS ROUTE permission_details

if(!function_exists('hasRoutePermission')){
    function hasRoutePermission($current_route = '')
    {
        $status = checkAdminAuthUserId() == null ? true : false;

        if(empty($route_name) && !auth()->check()) {
            return $status;
        }

        $permitted_route_list = getSession(LoginProcessService::PERMISSION_ROUTE_SESSION_KEY.auth()->user()->id);


        if(!empty($permitted_route_list) && \App\Utils\ArrayCore::InArray($current_route, $permitted_route_list)){
            $status = true;
        }

        return $status;
    }
}

//  ASSOCIATIVE ARRAY TO OBJECT
if(!function_exists('arrayToObjectConvertion')){

    function arrayToObjectConvertion($array = [])
    {
        if(!empty($array)){
            foreach ($array as $index => $arrayItem) {

                if ( \App\Utils\ArrayCore::isArray($arrayItem)) {
                    if(empty($arrayItem)){
                        $array[$index] = null;
                    }else{
                        $array[$index] = arrayToObjectConvertion($arrayItem);
                    }

                }
            }
        }

        return (object) $array;

    }
}

if(!function_exists('collectionToObjectConvertion')){
    function collectionToObjectConvertion($collection = [])
    {
        return collect($collection)->collectionToObject();
    }

}

// CHECK ADMIN USER USER AND AUTH USERS
if(!function_exists('checkAdminAuthUserId')){
    function checkAdminAuthUserId()
    {
        if(auth()->check()){
            $authUser = auth()->user();
            if($authUser->role_id != config('configuration.super_admin_roles.role_id')){
                $id = $authUser->id;
            }elseif($authUser->role_id == config('configuration.super_admin_roles.role_id')) {
                $id = null;
            }
        }else{
            $id = 0;
        }

        return $id;
    }

}











