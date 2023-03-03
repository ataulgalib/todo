<?php

namespace App\Services\Core;

use App\Services\Interfaces\LoginProcessInterface;
use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Models\Core\Permission;


class LoginProcessService extends BaseService implements LoginProcessInterface
{

    const PERMISSION_ROUTE_SESSION_KEY = 'PERMITTED_ROUTE_LISTS_';
    const PERMISSION_VERSION_SESSION_KEY = 'PERMITTED_VERSION_';

    public function loginProcess($params = [])
    {
        $response = [
            LOG_ACTION_KEY => 'LOGIN_PROCESS_FAILED',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.login_fail'),
        ];

        if(!empty($params['credentials'])){
            if (auth()->attempt($params['credentials'], $params['remember_me'], 'deleted_at')) {

                $permitted_route_list = (new Permission())->getPermissionListByRoleId(auth()->user()->role_id);
                if(empty($permitted_route_list)){

                    $response[LOG_ACTION_KEY] = 'PERMITTED_ROUTE_LIST_EMPTY'; 
                    $response[STATUS_CODE_KEY] = config('configuration.software_exception_code.success');
                    $response[MESSAGE_CODE_KEY] = __('messages.login_fail');
                    
                }else{

                    $permitted_route_list = $permitted_route_list->pluck('route_name')->toArray();

                    setSession(Self::PERMISSION_VERSION_SESSION_KEY.auth()->user()->id, auth()->user()->permission_version);
                    setSession(Self::PERMISSION_ROUTE_SESSION_KEY.auth()->user()->id, $permitted_route_list);

                    $response = [
                        LOG_ACTION_KEY => 'LOGIN_PROCESS_SUCCESS',
                        STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                        MESSAGE_CODE_KEY => __('messages.login_success'),
                        'auth_user' => auth()->user(),
                        'permitted_route_list' => $permitted_route_list,
                    ];
                }

            }

        }

        return $response;
    }

    public function logoutProcess($request)
    {
        $response = [
            LOG_ACTION_KEY => 'LOGOUT_PROCESS_FAILED',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.login_fail'),
        ];

        if(auth()->check()){

            $response = [
                LOG_ACTION_KEY => 'LOGOUT_PROCESS_SUCCESS',
                STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                MESSAGE_CODE_KEY => __('messages.logout_success'),
                'auth_user' => [
                    'user_id' => auth()->user()->id, 
                    'user_name' => auth()->user()->name 
                ],
            ];

            forgetSession(Self::PERMISSION_ROUTE_SESSION_KEY.auth()->user()->id);
            forgetSession(Self::PERMISSION_VERSION_SESSION_KEY.auth()->user()->id);

            auth()->logout();
            $request->session()->invalidate();
            
        }

        return $response;
 
    }


    protected function sessionStorePermissionVersion()
    {
        if(auth()->check()){
            setSession(Self::PERMISSION_VERSION_SESSION_KEY.auth()->user()->id, auth()->user()->permission_version);
        }
    }

    protected function sessionStorePermittedRouteList()
    {
        if(auth()->check()){
            $permitted_route_list = auth()->user()->permissions();
            if(empty($permitted_route_list)){
                setSession(Self::PERMISSION_ROUTE_SESSION_KEY.auth()->user()->id, []);
            }else{
                $permitted_route_list = $permitted_route_list->pluck('route_name')->toArray();
                setSession(Self::PERMISSION_ROUTE_SESSION_KEY.auth()->user()->id, $permitted_route_list);
            }
        }
    }
}
