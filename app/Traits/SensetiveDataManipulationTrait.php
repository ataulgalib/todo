<?php

namespace App\Traits;

trait SensetiveDataManipulationTrait
{
	/**
	 * Every method will be describe here properly.
	 *
	 * 
	 */

	/**
	 * @param array $sensetive_parameters contains the sensitive data parameter on request
	 * @return array
	 */


	private $sensetive_parameters = [];

	/**
	 * @param array $sensetive_parameters contains the sensitive data parameter on request
	 * @return array
	 * Constant check the property exits with the parent class.
	 */
	
	public function __construct()
	{
		if (property_exists($this, 'list_of_sensetive_parameter')) {
			$this->sensetive_parameters = arrayMerge($this->list_of_sensetive_parameter, config('configuration.system_sencetive_request_parameter'));
		} else {
			$this->sensetive_parameters = config('configuration.system_sencetive_request_parameter');
		}
	}

	/**
	 * @param array $data contains the data to be manipulated by sensetive_parameters
	 * @return array
	 */

	public function removeSensitiveData($request_data = [], $assign_log = false): array
	{
		if (empty($request_data) && empty($this->sensetive_parameters)) {
			return [];
		}

		$sensetive_parameters = arrayToCollection($this->sensetive_parameters);
		$data = arrayToCollection($request_data);

		$logData = $data->map(function ($value, $key) use ($sensetive_parameters) {

			if ($sensetive_parameters->contains($key)) {
				return '******';
			}

			return $value;
		})->merge([

			// 'sensetive_request_parameters' =>$this->sensetive_parameters,

		])->toArray();

		if ($assign_log) {
			$logData =  [LOG_ACTION_KEY => 'REQUEST_PARAMETERS'] + $logData;
		}

		return $logData;
	}
}
