<?php

namespace App\Services\Core;

use App\Services\Interfaces\RolePermissionServiceInterface;
use App\Services\BaseService;
use App\Models\Core\Role;
use App\Models\Core\Permission;
use App\Models\User;

class RolePermissionService extends BaseService implements RolePermissionServiceInterface
{
    /*
    *  Initialized a __construct to assign main model name to the services
    *  It is used by $this->model name
    */
    public function __construct(Role $role, Permission $permission)
    {
        $this->models =[
            'role' => $role,
            'permission' => $permission,
        ];
    }

    public function create(){
        $response = [
            LOG_ACTION_KEY => 'ROLE_PERMISSION_CREATE',
            STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
            MESSAGE_CODE_KEY => __('messages.reponse_success'),
            'roles' => $this->models['role']->getData(),
        ];

        return $response;
    }

    public function getRolePermissionRoleWise($params = []){
        $response = [
            LOG_ACTION_KEY => 'ROLE_PERMISSION_GET_ROLE_WISE',
            STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
            MESSAGE_CODE_KEY => __('messages.reponse_success'),
        ];

        $menu_list = core_genarated_menu();


        $role_wise_route_list = $this->models['permission']->getDataByRoleId($params['role_id'])->isNotEmpty() ? $this->models['permission']->getDataByRoleId($params['role_id'])->pluck('route_name')->toArray() : [];
        


        $role_page_view =  view('core.partials.role_permission', compact('menu_list', 'role_wise_route_list'))->render();
        $response['role_page_view'] = $role_page_view;

        return $response;
    }

    public function storeData($params = []){
        $response = [
            LOG_ACTION_KEY => 'ROLE_PERMISSION_STORED_FAILED',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.login_fail'),
        ];
   
        $this->models['permission']->deleteDataByRoleId($params['role_id']);
        
        $insert_data = [];

        foreach($params['route_name'] as $route_name){
            $insert_data[] = [
                'role_id' => $params['role_id'],
                'route_name' => $route_name,
                'created_by' => $params['created_by'],
            ];
        }

        $data = $this->models['permission']->storeData($insert_data);

        // PERMISSION VERSION UPDATED 
        $users = (new User())->getUsersByRoleId($params['role_id'], $is_update = true);            

        if(!empty($data)){
            $response = [
                LOG_ACTION_KEY => 'ROLE_PERMISSION_STORED_SUCCESS',
                STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                MESSAGE_CODE_KEY => __('messages.login_success'),
                'data_list' => $data,
                'users' => $users,
            ];
        }

        return $response;
    }


}

