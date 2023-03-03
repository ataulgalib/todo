<?php

namespace App\Services\Core;

use App\Services\BaseService;
use App\Models\User;
use App\Services\Interfaces\UserManagementInterface;
use App\Models\Core\Role;

class UserManagementService extends BaseService implements UserManagementInterface
{
    public function __construct(User $user, Role $role)
    {
        $this->models = [
            'user' => $user,
            'roles' => $role,
        ];
    }

    public function getData($params = [])
    {
        $params['relations'] = [
            'role:id,name',
        ];

        $response = [
            LOG_ACTION_KEY => 'USER_MANAGEMENT_INDEX',
            STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
            MESSAGE_CODE_KEY => __('messages.reponse_success'),
            'users' => $this->models['user']->getData($params),
        ];

        return $response;
    }

    public function create()
    {
        $response = [
            LOG_ACTION_KEY => 'USER_MANAGEMENT_CREATE',
            STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
            MESSAGE_CODE_KEY => __('messages.reponse_success'),
            'roles' => $this->models['roles']->getData(),
        ];

        return $response;
    }

    public function storeData($params = []){
        $response = [
            LOG_ACTION_KEY => 'ROLE_PERMISSION_STORED_FAILED',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.login_fail'),
        ];

        $insert_data = [
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => bcrypt($params['password']),
            'permission_version' => APPLICAT_DEFALT_PERMISSION_VERSION,
            'role_id' => $params['role_id'],
            'created_by' => $params['created_by'],
        ];

        $user = $this->models['user']->create($insert_data);

        if(!empty($user)){
            $response = [
                LOG_ACTION_KEY => 'ROLE_PERMISSION_STORED_SUCCESS',
                STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                MESSAGE_CODE_KEY => __('messages.login_success'),
                'data_list' => $user,
            ];
        }

        return $response;
    }

    public function showData($id = null)
    {
        $response = [
            LOG_ACTION_KEY => 'USER_MANAGEMENT_INDEX',
            STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
            MESSAGE_CODE_KEY => __('messages.reponse_success'),
            'data' => $this->models['user']->getUserDetailsById($id),
            'roles' => $this->models['roles']->getData(),
        ];

        return $response;
    }

    public function updateData($params = [], $id = null)
    {

        $response = [
            LOG_ACTION_KEY => 'ROLE_STORE',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.reponse_fail'),
        ];

        $insert_data = [
            'name' => $params['name'],
            'email' => $params['email'],
            'role_id' => $params['role_id'],
        ];

        if(isset($params['password']) && !empty($params['password'])){
            $insert_data['password'] = bcrypt($params['password']);
        }

        $data = $this->models['user']->updateDataById($params, $id);

        if(!empty($data)){
            $response = [
                STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                MESSAGE_CODE_KEY => __('messages.reponse_success'),
                'dataList' => $data,
            ];
        }

        return $response;

    }

    public function deleteUser($id = null)
    {
        $this->model = $this->models['user'];
        return $this->deleteData($id);

    }
}
