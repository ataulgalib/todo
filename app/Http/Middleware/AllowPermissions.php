<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Core\LoginProcessService;
use Illuminate\Support\Facades\Route;
use App\Models\Core\Permission;

class AllowPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        
        if(auth()->check()){

            // SUPER ADMIN SHOULD GET ALL PERMISSION
            if(auth()->user()->role_id == config('configuration.super_admin_roles.role_id')){
                return $next($request);
            }

            $session_permissions_version = getSession(LoginProcessService::PERMISSION_VERSION_SESSION_KEY.auth()->user()->id);
            $permitted_route_list = getSession(LoginProcessService::PERMISSION_ROUTE_SESSION_KEY.auth()->user()->id);
            $current_route = Route::currentRouteName();

            if($session_permissions_version == auth()->user()->permission_version && in_array($current_route, $permitted_route_list)){
                return $next($request);

            }else{
                
                $permitted_route_list = (new Permission())->getPermissionListByRoleId(auth()->user()->role_id);
               
                if(!empty($permitted_route_list)){
                    
                    $permitted_route_list = $permitted_route_list->pluck('route_name')->toArray();

                    setSession(LoginProcessService::PERMISSION_ROUTE_SESSION_KEY.auth()->user()->id, $permitted_route_list);
    
                    if(in_array($current_route, $permitted_route_list)){
                        return $next($request);
                    }
                }


            }
        }

        return redirect()->route('admin.dashboard')->with('error', __('messages.permission_denied'));

    }
}
