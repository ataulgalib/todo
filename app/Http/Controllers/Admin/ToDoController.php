<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\Controller;
use App\Http\Requests\Admin\TodoRequest;
use App\Services\Admin\ToDoService;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    private ToDoService $service;

    public function __construct(ToDoService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){

        $params = $request->all();
        $params['page_limit'] = DATA_TABLES_PAGINATION_LIMIT;
        $response = $this->service->getData($params);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        $response['params'] = $params;
        return view('admin.todo.index',$response);

    }

    public function store(TodoRequest $request)
    {

        $params = $this->service->dataFormat($request->all());
        $response = $this->service->storeData($params);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        $flash_message = __('messages.exception_message');
        if($response[STATUS_CODE_KEY] == config('configuration.software_exception_code.success')){
            $flash_message = __('messages.data_store_success');
        }
        flashMessage('info',$flash_message);
        return $response;

    }

    public function update(TodoRequest $request, $id){
        $params = $this->service->dataFormat($request->all());
        $response = $this->service->updateData($params, $id);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        $flash_message = __('messages.exception_message');
        if($response[STATUS_CODE_KEY] == config('configuration.software_exception_code.success')){
            $flash_message = __('messages.data_store_success');
        }
        flashMessage('info',$flash_message);
        return $response;
    }

    public function destroy($id){

        $response = $this->service->deleteData($id);
        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));
        $flash_message = __('messages.exception_message');
        if($response[STATUS_CODE_KEY] == config('configuration.software_exception_code.success')){
            $flash_message = __('messages.data_store_success');
        }
        flashMessage('info',$flash_message);
        return $response;
    }

    public function show($id){

    }

}
