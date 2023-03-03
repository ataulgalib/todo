<?php

namespace App\Services;


interface BaseInterface
{

    /**
     * getData() method for retive the data from the database.  
     */

    public function getData($params = []);

    /**
     * storeData() method for store the data from the database.  
     */

    public function storeData($params = []);

    /**
     * showData() method for fetch the data from the database by id.  
     */

    public function showData($id = null);

    /**
     * updateData() method for update the data from the database by id.  
     */

    public function updateData($params = [], $id = null);

    /**
     * deleteData() method for delete the data from the database by .  
     */

    public function deleteData($id = null);

    /**
     * getData() method for retive the data from the database.  
     */

    public function paginationRender($collection);

}