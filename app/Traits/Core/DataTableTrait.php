<?php

namespace App\Traits\Core;

use Illuminate\Support\Collection;
use App\Http\Requests\Core\Request;

trait DataTableTrait
{
	/**
	 * Every method will be describe here properly.
	 *
	 * 
	 */

	public function paginationRenderGenerate($collection, $pagination = true, $dropdown = true, $defult_search = true){
		dd(request()->all(),$collection);
		// NEED TO DESIGN THE DATALIST WITH PAGINATION, DEFULT SEARCH, DROPDOWN
	}
}
