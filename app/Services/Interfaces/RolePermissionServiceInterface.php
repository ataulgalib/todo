<?php

namespace App\Services\Interfaces;

interface RolePermissionServiceInterface{

    /*
    * You need to describ your method properly here if possible use return type also.
    */

    public function create();

    public function getRolePermissionRoleWise($params = []);
}
