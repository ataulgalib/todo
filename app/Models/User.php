<?php

namespace App\Models;

use App\Models\Core\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Awobaz\Compoships\Compoships;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\Core\Permission;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Compoships, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *  DELETED AT FOR CascadeSoftDeletes
     */
    protected $dates = ['deleted_at'];

    public function create($insert_data = []){

        if(!empty($insert_data)){
            $this->fill($insert_data);
            $this->save();
            return $this;
        }

        return internal_fail_response();
    }

    public function getData($params = [], $paginate = DATA_TABLES_PAGINATION_LIMIT){


        $query = $this->query()->where('id' ,'>', 1);

        if(isset($params['relations']) && !empty($params['relations'])){
            $query = $query->with($params['relations']);
        }

        if(isset($params['email']) && !empty($params['email'])){
            $query = $query->where('email',$params['email']);
        }

        if(isset($params['name']) && !empty($params['name'])){
            $query = $query->where('name',$params['name']);
        }

        if(isset($params['search_key']) && !empty($params['search_key'])){
            $query = $query->where('name','like','%'.$params['search_key'].'%')
                            ->orWhere('email','like','%'.$params['search_key'].'%');
        }

        $query = $query->orderBy('updated_at', 'desc');

        if(isset($params['select']) && !empty($params['select'])){
            $query = $query->select($params['select']);
        }

        if(isset($params['page_limit']) && !empty($params['page_limit'])){
            $query = $query->paginate($params['page_limit']);
        }else{
            $query = $query->get();
        }

        return $query;
    }

    public function user(){
        return $this->hasOne(Self::class, 'id', 'created_by');
    }

    public function role(){
        return $this->belongsTo(Role::class)->withdefault([
            'name' => __('Not Found'),
        ]);
    }

    public function getUserDetailsById($id = ''){
        return $this->findOrFail($id);
    }

    public function updateDataById($params = [], $id = ''){
        $user = $this->findOrFail($id);
        $user->fill($params);
        $user->save();
        return $user;
    }

    public function deleteDataById($id = ''){
        return $this->findOrFail($id)->delete();
    }

    public function permissions(){
        return $this->hasMany(Permission::class, 'role_id', 'id');
    }

    public function getUsersByRoleId($role_id = '', $is_update = false){
        if(empty($role_id)){
            return config('configuration.server_exception_code.validation_fail');
        }

        $query = $this->where('role_id', $role_id)->get();
        if(!empty($is_update)){
            $query->map(function($items){
                $items->permission_version = $items->permission_version + 1;
                $items->save();
            });
        }

        return $query;

    }


}
