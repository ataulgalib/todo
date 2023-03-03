<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Request extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	protected function passedValidation()
	{
		$request = $this->all();
		$rules = array_keys($this->rules());
		$final_data = [];
		if (!empty($rules)) {
			foreach ($rules as $rule) {
				if (isset($request[$rule])) {
					$final_data[$rule] = $request[$rule];
				}
			}
		}
		$this->replace($final_data);
	}

	protected function failedValidation(Validator $validator)
	{
		//    $errors = $validator->errors();
		//    $error = $errors->first();

		//    throw new HttpResponseException(appResponse()->failed(config('status_code.validation_fail'), __('Validation Error'),  $error));   
		throw new ValidationException($validator);
	}

	/**
	 * when you need to give custom message
	 * return [
	 *   'name.required' => 'name :attribute required',
	 * ];
	 */

	// public function messages()
	// {
	//     return [
	//          'name.required' => 'name is required',
	//     ];
	// }

	/**
	 * when you need to custom message with your rules method()
	 *  return [
	 *        'required' => ':attribute is required',
	 *  ];
	 */

	// public function attributes()
	// {
	//      return [];
	// }




}
