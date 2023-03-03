<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Core\Request;

class RolePermissionRequest extends Request
{

    /**
     * Get the validation rules that apply to the request. To get the request use $this Object
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'role_id' => ['required', 'exists:roles,id'],
            'route_name' => ['required'],
            'route_name.*' => ['required','string'],
            'created_by' => ['required','exists:users,id'],
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
        return [];
    }

    /**
    * when you need to custom message with your rules method()
    *  return [
    *        'required' => ':attribute is required',
    *  ];
    */ 

    public function attributes()
    {
        return [];
    }
}
