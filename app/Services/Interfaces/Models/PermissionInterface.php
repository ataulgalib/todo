<?php

namespace App\Services\Interfaces\Models;

interface PermissionInterface{

    /*
    * You need to describ your method properly here if possible use return type also.
    */

    /*
    *   FETCH THE DATA FROM DATABASE
    */
    public function getData($search = [], $pagination = DATA_TABLES_PAGINATION_LIMIT);

    /*
    *   STORE THE DATA FROM DATABASE
    */

    public function storeData($data = []);


    /*
    *   FETCH THE DATA FROM DATABASE BY ID
    */

    public function getDataById($id = '');


    /*
    *   UPDATE THE DATA ON DATABASE BY ID
    */

    public function updateDataById($data = [], $id = '');

    /*
    *   DELETE THE DATA FROM DATABASE BY ID
    */

    public function deleteDataById($id = '');

    public function getDataByRoleId($role_id = '');

    public function deleteDataByRoleId($role_id = '');

    public function getPermissionListByRoleId($role_id = '');
}
