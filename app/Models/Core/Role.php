<?php

namespace App\Models\Core;

use App\Models\Core\Model;
use App\Services\Interfaces\Models\RoleInterface;
use App\Models\User;

class Role extends Model implements RoleInterface
{

    protected $cascadeDeletes = ['users'];
    
    const ROLE_CACHE_KEY = 'GET_ROLES_CACHES';

    /*
    *    GIVE THE TABLE NAME
    */
    protected $table = 'roles';


    /*
    *   FETCH THE DATA FROM DATABASE
    */

    public function cacheQuery(){

        $realtions = [
            'user' => fn($query) => $query->select('id', 'name'),
        ];

        $query = $this->with($realtions)->where('id' ,'>', 1);

        return rememberForeverCache(Self::ROLE_CACHE_KEY, function() use($query){
            return $query->get();
        });

    }

    public function getData($search = [], $pagination = DATA_TABLES_PAGINATION_LIMIT)
    {

        $query = $this->cacheQuery();

        if (isset($search['search_key']) && !empty($search['search_key'])) {

            $query = $query->filter(function($q) use($search){
                return false !== stripos($q['name'], $search['search_key']);
            });

        }

        if (isset($search['page_limit']) && !empty($search['page_limit'])) {

            $query = arrayPagination($query, $search['page_limit']);

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
        
        // IF THE ROLE IS EXITS ON ANOTHER TABLE WE DONT ABLE TO DELETE IT HERE IS THE CONDITION

        return $this->findOrFail($id)->delete();

    }

    // MODEL RELATIONS

    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function users(){
        return $this->hasMany(User::class,'role_id','id');
    }

}
