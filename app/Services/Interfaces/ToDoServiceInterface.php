<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Core\Request;

interface ToDoServiceInterface{

    /*
    * You need to describ your method properly here if possible use return type also.
    */

    /*
     * REQUEST DATA SHOULD BE FORMAT
     * */
    public function dataFormat(Request $request): array;
}
