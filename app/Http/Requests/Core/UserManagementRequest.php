<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Core\Request;

class UserManagementRequest extends Request
{

    /**
     * Get the validation rules that apply to the request. To get the request use $this Object
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','max:255','unique:users,name,'.$this->id.',id,deleted_at,NULL'],
            'email' => ['required','email','max:30','unique:users,email,'.$this->id.',id,deleted_at,NULL'],
            'password' => $this->isMethod('post') ? ['required','min:6'] : ['nullable'],
            'role_id' => ['required','exists:roles,id'],
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
