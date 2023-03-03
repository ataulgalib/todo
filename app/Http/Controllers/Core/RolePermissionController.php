<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Core\Controller;
use Illuminate\Http\Request;
use App\Services\Core\RolePermissionService;
use App\Http\Requests\Core\RolePermissionRequest;

class RolePermissionController extends Controller
{

    private $service;

    public function __construct(RolePermissionService $service)
    {
        $this->service = $service;
    }

    public function create(){
        $response = $this->service->create();
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        return view('core.role_permission.create', $response);
    }
    public function getRolePermissionRoleWise(Request $request){
        $response = $this->service->getRolePermissionRoleWise($request->all());
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));        
        return $response;
    }

    public function store(RolePermissionRequest $request){
        $response = $this->service->storeData($request->all());
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        return redirect()->back()->with('success', __('messages.data_store_success'))->withInput();
    }
}
