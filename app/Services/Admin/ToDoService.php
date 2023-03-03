<?php

namespace App\Services\Admin;

use App\Services\Interfaces\ToDoServiceInterface;
use App\Services\BaseService;
use App\Models\Todo;
use App\Models\User;
use App\Utils\CarbonCore;

class ToDoService extends BaseService implements ToDoServiceInterface
{
    /*
    *  Initialized a __construct to assign main model name to the services
    *  It is used by $this->model name
    */
    public function __construct(Todo $todo)
    {
        $this->model = $todo;
    }

    public function getData($params = [])
    {

        $response = [
            LOG_ACTION_KEY => 'TODO_SERVICE_INDEX',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.reponse_fail'),
            'model_name' => get_class($this->model),
            'models_name' => $this->models,
            'dataList' => [],
            'user_lists' => (new User())->getData([
                'select' => [
                    'id','name'
                ]
            ]),
        ];

        $params['relations'] = ['user:id,name','createdByUser:id,name'];
        $params['assignee_users'] = checkAdminAuthUserId();

        $data = $this->model->getData($params);

        if(!empty($data)){
            $response[STATUS_CODE_KEY] = config('configuration.software_exception_code.success');
            $response[MESSAGE_CODE_KEY] = __('messages.reponse_success');
            $response['dataList'] = $data;
        }

        return $response;

    }


    public function dataFormat($params):array
    {
        return [
            'title' => strip_tags(@$params['title']),
            'user_id' => @$params['user_id'],
            'date_of_end_task' => CarbonCore::parse($params['date_of_end_task'])->format('Y-m-d'),
            'description' => @$params['description'],
        ];
    }


}

