<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Core\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $roleModelObj;

    public function __construct(Role $roleModelObj)
    {
        $this->roleModelObj = $roleModelObj;
    }

    public function run()
    {
        $super_admin_roles = config('configuration.super_admin_roles');
        $insert_data = [
            'name' => $super_admin_roles['name'],
            'created_by' => 1,  // ADMIN CREATE IT SELF
        ];
        $this->roleModelObj->storeData($insert_data);
    }
}
