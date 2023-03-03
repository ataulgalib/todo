<?php

namespace App\Services\Interfaces;

interface LoginProcessInterface{
    
    /**
     * login method to login the user
     */
    public function loginProcess($params);

    /**
     * logout method to logout the user
     */

    public function logoutProcess($params);

    /**
     * session store the permission version
     */

}