<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Core\Request;

class TodoRequest extends Request
{

    /**
     * Get the validation rules that apply to the request. To get the request use $this Object
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:254'],
            'user_id' => ['required'],
            'date_of_end_task' => ['required', 'date'],
            'description' => ['required', 'string'],
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
            'description.required' => __('Todo Description is required'),
            'title.max' => __('Please Write less then 254 charecters'),
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
        return [];
    }
}
