<?php

namespace App\Http\Requests;

use App\Http\Requests\Core\Request;

class UserLoginRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'password' => 'required',
        ];
    }
}
