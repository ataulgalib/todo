<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Core\Controller;
use Illuminate\Http\Request;
use App\Services\Core\RoleService;
use App\Http\Requests\Core\RoleRequest;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request){
        $params = $request->all();
        $response = $this->roleService->getData($params);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        $response['params'] = $params;
        return view('core.role.index',$response);
    }

    public function store(RoleRequest $request){
        $params = $request->all();
        $response = $this->roleService->storeData($params);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        flashMessage('success', __('messages.data_store_success'));
        return $response;
    }

    public function update(RoleRequest $request, $id){
        $params = $request->all();
        $response = $this->roleService->updateData($params, $id);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        flashMessage('success', __('messages.data_update_success'));
        return $response;
    }

    public function destroy($id){
        $response = $this->roleService->deleteData($id);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        flashMessage('success', __('messages.data_delete_success'));
        return $response;
    }
}
