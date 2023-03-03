<?php

namespace App\Services\Core;

use App\Services\Interfaces\RoleServiceInterface;
use App\Services\BaseService;
use App\Models\Core\Role;

class RoleService extends BaseService implements RoleServiceInterface
{
    /*
    *  Initialized a __construct to assign main model name to the services
    *  It is used by $this->model name
    */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

}

