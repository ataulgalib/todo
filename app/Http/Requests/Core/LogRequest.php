<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Core\Request;

class LogRequest extends Request
{

    /**
     * Get the validation rules that apply to the request. To get the request use $this Object
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'daterange' => ['nullable', 'string'],
            'date_from' => ['nullable','date'],
            'date_to' => ['nullable','date'],
            'search_key' => ['nullable','string'],
            'page_limit' => ['nullable','integer'],
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
