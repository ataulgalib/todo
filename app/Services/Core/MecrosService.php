<?php

namespace App\Services\Core;

use App\Services\Interfaces\MecrosInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Traits\Macroable;

class MecrosService implements MecrosInterface
{

    public function arrayToCollection()
    {

        /**
        * @var $relation Collection
        *
        */

        return function () {

            return $this->map(function ($value) {
                return is_array($value) || is_object($value)
                    ? (new static($value))->arrayToCollection()
                    : $value;
            });
        };
    }

    /**
    * @var $relation Collection
    * need to check properly it is worked or not
    *
    */
    
    public function forgetByRelationsLast()
    {
        return function ($relations){

            $relationsCollection = arrayToCollection($relations);
            return $relationsCollection->map(function ($relation) {
                return $this->forget($relation);;
            });
            
        };
    }


    /**
    * @var $relation Collection
    * collection paginate
    *
    */

    public function collectionPaginate(){
        
        return function ($perPage, $total = null, $page = null, $pageName = 'page'){
            
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        };

    }

    /**
    * @var AssociativeArrayMap Convert into object
    * collection paginate
    *
    */

   public function collectionToObject(){
        return function (){
            $take_first_element_of_collection = $this->first();
            return arrayToObjectConvertion($take_first_element_of_collection);
        };

    }

}
