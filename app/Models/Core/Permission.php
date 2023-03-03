<?php

namespace App\Models\Core;

use App\Models\Core\Model;
use App\Services\Interfaces\Models\PermissionInterface;

class Permission extends Model implements PermissionInterface
{
    /*
    *    GIVE THE TABLE NAME
    */
    protected $table = 'permissions';


    /*
    *   FETCH THE DATA FROM DATABASE
    */
    public function getData($search = [], $pagination = DATA_TABLES_PAGINATION_LIMIT)
    {

    }

    /*
    *   STORE THE DATA FROM DATABASE
    */

    public function storeData($data = []){
        if(empty($data)){
            return config('configuration.server_exception_code.validation_fail');
        }

        return $this->insert($data);

    }

    /*
    *   FETCH THE DATA FROM DATABASE BY ID
    */

    public function getDataById($id = ''){
        if(empty($id)){
            return config('configuration.server_exception_code.validation_fail');
        }
        

    }

    /*
    *   UPDATE THE DATA ON DATABASE BY ID
    */

    public function updateDataById($data = [], $id = ''){
        if(empty($data) || empty($id)){
            return config('configuration.server_exception_code.validation_fail');
        }
        

    }

    /*
    *   DELETE THE DATA FROM DATABASE BY ID
    */

    public function deleteDataById($id = ''){
        if(empty($id)){
            return config('configuration.server_exception_code.validation_fail');
        }
        

    }


    public function getDataByRoleId($role_id = ''){
        if(empty($role_id)){
            return config('configuration.server_exception_code.validation_fail');
        }
        
        return $this->where('role_id', $role_id)->get();
    }

    public function deleteDataByRoleId($role_id = ''){
        if(empty($role_id)){
            return config('configuration.server_exception_code.validation_fail');
        }

        $previous_data = $this->getDataByRoleId($role_id);

        if(!empty($previous_data)){
            $ids = $previous_data->pluck('id')->toArray();

            if(is_array($ids)){
                $this->destroy($ids);
            }else{
                $this->where('id', $ids)->delete();
            }
        }

    }

    public function getPermissionListByRoleId($role_id = ''){
        if(empty($role_id)){
            return config('configuration.server_exception_code.validation_fail');
        }
        
        return $this->where('role_id', $role_id)->get();
    }
}
