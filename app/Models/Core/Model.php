<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Awobaz\Compoships\Compoships;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Model extends BaseModel
{
    /**
     *  Using soft delete to delete a record
     */

    use HasFactory, SoftDeletes, Compoships, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable. it will store the data without checking, and the error thrown by Query Builder Exception.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     *  From retirve the data from model always hide the created at
     */

    protected $hidden = [
        'created_at',
    ];

    /**
     *  DELETED AT FOR CascadeSoftDeletes
     */
    protected $dates = ['deleted_at'];

    public function createdByUser(){
        return $this->belongsTo(User::class,'created_by','id')->withDefault([
            'name' => 'Not Found',
        ]);
    }

}
