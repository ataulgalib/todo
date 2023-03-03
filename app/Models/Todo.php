<?php

namespace App\Models;

use App\Models\Core\Model;
use App\Services\Interfaces\Models\TodoInterface;
use App\Utils\ArrayCore;

class Todo extends Model implements TodoInterface
{

    protected $cascadeDeletes = ['user'];
    /*
    *    GIVE THE TABLE NAME
    */
    protected $table = 'todos';

    protected $fillable = [
        'title', 'user_id', 'date_of_end_task', 'description', 'created_by'
    ];

    /*
    *   FETCH THE DATA FROM DATABASE
    */
    public function getData($search = [], $pagination = DATA_TABLES_PAGINATION_LIMIT)
    {

        $query = $this->query();

        if(isset($search['assignee_users'])){
            if(ArrayCore::isArray($search['assignee_users'])){
                $query->whereIn('user_id', $search['assignee_users']);
            }else{
                $query->where('user_id', $search['assignee_users']);
            }
        }

        if(isset($search['relations']) && !empty($search['relations'])){
            $query->with($search['relations']);
        }

        if(isset($search['title'])){
            $query->where('title', $search['title']);
        }

        if(isset($search['user_id'])){
            $query->where('user_id', $search['user_id']);
        }

        if(isset($search['date_of_end_task'])){
            $query->where('date_of_end_task', $search['date_of_end_task']);
        }

        if(isset($search['description'])){
            $query->where('description','like', '%'.$search['description'].'%');
        }

        if(isset($search['search_key'])){
            $query->where('title','like', '%'.$search['search_key'].'%')
                ->orwhere('user_id','like', '%'.$search['search_key'].'%')
                ->orWhere('date_of_end_task','like', '%'.$search['search_key'].'%')
                ->orWhere('description','like', '%'.$search['search_key'].'%');

        }

        $query->orderBy('id', 'desc');


        if(isset($search['page_limit']) && !empty($search['page_limit'])){
            $query = $query->paginate($search['page_limit']);
        }else{
            $query =$query->get();
        }


        return $query;
    }

    /*
    *   STORE THE DATA FROM DATABASE
    */

    public function storeData($data = []){
        if(empty($data)){
            return config('configuration.server_exception_code.validation_fail');
        }

        return $this->create($data);

    }

    /*
    *   FETCH THE DATA FROM DATABASE BY ID
    */

    public function getDataById($id = ''){
        if(empty($id)){
            return config('configuration.server_exception_code.validation_fail');
        }


    }

    /*
    *   UPDATE THE DATA ON DATABASE BY ID
    */

    public function updateDataById($data = [], $id = ''){
        if(empty($data) || empty($id)){
            return config('configuration.server_exception_code.validation_fail');
        }

        return $this->where('id', $id)->update($data);

    }

    /*
    *   DELETE THE DATA FROM DATABASE BY ID
    */

    public function deleteDataById($id = ''){
        if(empty($id)){
            return config('configuration.server_exception_code.validation_fail');
        }

        return $this->where('id', $id)
            ->delete();

    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
