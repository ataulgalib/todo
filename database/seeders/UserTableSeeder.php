<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $userModelObj;

    public function __construct(User $userModelObj)
    {
        $this->userModelObj = $userModelObj;
    }

    public function run()
    {   
        $super_admin_credentials = config('configuration.super_admin_credentials');
        $insert_data = [
            'name' => $super_admin_credentials['name'],
            'email' => $super_admin_credentials['email'],
            'password' => bcrypt($super_admin_credentials['password']),
            'created_by' => 1,  // ADMIN CREATE IT SELF
            'role_id' => 1,
        ];

        $this->userModelObj->create($insert_data);
    }
}
