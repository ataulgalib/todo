<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Core\Controller;
use Illuminate\Http\Request;
use App\Services\Core\UserManagementService;
use App\Http\Requests\Core\UserManagementRequest;

class UserManagementController extends Controller
{
    private $user_management_service;
    
    public function __construct(UserManagementService $user_management_service)
    {
        $this->user_management_service = $user_management_service;
    }

    public function index(Request $request){
        $params = $request->all();
        $response = $this->user_management_service->getData($params);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        $response['params'] = $params;
        return view('core.user_management.index', $response);
    }

    public function create(){
        $response = $this->user_management_service->create();
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        return view('core.user_management.create', $response);
    }

    public function store(UserManagementRequest $request){
        $response = $this->user_management_service->storeData($request->all());
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        return redirect()->route('core.user.index')->with('success', __('messages.data_store_success'));
    }

    public function show($id){

    }
    
    public function edit($id){
        $response = $this->user_management_service->showData($id);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        $response['id'] = $id;
        return view('core.user_management.edit', $response);
    }

    public function update(UserManagementRequest $request, $id){
        $response = $this->user_management_service->updateData($request->all(), $id);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        return redirect()->route('core.user.index')->with('success',__('messages.data_update_success'));
    }

    public function destroy($id){
        $response = $this->user_management_service->deleteUser($id);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        flashMessage('success', __('messages.data_delete_success'));
        return $response;
    }


}
