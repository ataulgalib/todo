<?php

namespace App\Services;

use App\Services\BaseInterface;
use Exception;
use App\Traits\Core\DataTableTrait;
use App\Traits\Core\FileSystemTrait;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginato;

class BaseService implements BaseInterface
{

    use DataTableTrait, FileSystemTrait;

    protected $model;

    protected $models = [];

    public function __set($property, $value)
    {

        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function getData($params = [])
    {

        $response = [
            LOG_ACTION_KEY => 'BASE_SERVICE_INDEX',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.reponse_fail'),
            'model_name' => get_class($this->model),
            'models_name' => $this->models,
            'dataList' => [],
        ];

        $data = $this->model->getData($params);

        if(!empty($data)){
            $response = [
                STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                MESSAGE_CODE_KEY => __('messages.reponse_success'),
                'dataList' => $data,
            ];
        }

        return $response;

    }

    public function storeData($params = [])
    {

        $response = [
            LOG_ACTION_KEY => 'BASE_SERVICE_STORE',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.reponse_fail'),
            'model_name' => get_class($this->model),
            'models_name' => $this->models,
        ];

        if(empty($params['created_by'])){
            $params['created_by'] = auth()->user()->id;
        }

        $data = $this->model->storeData($params);

        if(!empty($data)){
            $response = [
                STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                MESSAGE_CODE_KEY => __('messages.reponse_success'),
                'dataList' => $data,
            ];
        }

        return $response;

    }

    public function showData($id = null)
    {
        return $this->model->where('id', $id)->first();
    }

    public function updateData($params = [], $id = null)
    {

        $response = [
            LOG_ACTION_KEY => 'BASE_SERVICE_STORE',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.reponse_fail'),
            'model_name' => get_class($this->model),
            'models_name' => $this->models,
        ];

        if(empty($params['created_by'])){
            $params['created_by'] = auth()->user()->id;
        }

        $data = $this->model->updateDataById($params, $id);

        if(!empty($data)){
            $response = [
                STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                MESSAGE_CODE_KEY => __('messages.reponse_success'),
                'dataList' => $data,
            ];
        }

        return $response;

    }

    public function deleteData($id = null)
    {
        $response = [
            LOG_ACTION_KEY => 'BASE_SERVICE_DELETE',
            STATUS_CODE_KEY => config('configuration.software_exception_code.fail'),
            MESSAGE_CODE_KEY => __('messages.reponse_fail'),
            'model_name' => get_class($this->model),
            'models_name' => $this->models,
        ];

        $data = $this->model->deleteDataById($id);

        if(!empty($data)){
            $response = [
                STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
                MESSAGE_CODE_KEY => __('messages.reponse_success'),
                'dataList' => $data,
            ];
        }

        return $response;
    }

    /**
     * paginationRender() generate a view page
     */

    public function paginationRender($collection)
    {

        return $this->paginationRenderGenerate($collection);

    }

}
