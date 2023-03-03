<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Core\Request;
use App\Rules\FirstLetterCapital;

class RoleRequest extends Request
{

    /**
     * Get the validation rules that apply to the request. To get the request use $this Object
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:10', 'unique:roles,name,'. $this->id.',id,deleted_at,NULL', new FirstLetterCapital() ],
        ];
    }

    /**
    * when you need to give custom message
    * return [
    *   'name.required' => 'name :attribute required',
    * ];
    */

    public function messages()
    {
        return [
            
        ];
    }

    /**
    * when you need to custom message with your rules method()
    *  return [
    *        'required' => ':attribute is required',
    *  ];
    */ 

    public function attributes()
    {
        return [
           
        ];
    }

}
