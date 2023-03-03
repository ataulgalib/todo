<?php

namespace App\Traits;

trait EncryptionTrait
{
	/**
	 * Every method will be describe here properly.
	 *
	 * 
	 */

	public function customEncryptionDecryption($value, $action, $isURL = false)
	{
		$secret_key = config('configuration.encryption_secret_key');

		if ($action == ENCRYPTION) {

			if (is_array($value)) {
				$value = implode('|', $value);
			}
			$value = $this->encrypt($value, $secret_key);

			if ($isURL) {
				$value = str_replace('/', '__', $value);
			}

			return $value;
		} elseif ($action == DECRYPTION) {

			if ($isURL) {
				$value = str_replace('__', '/', $value);
			}

			return $this->decrypt($value, $secret_key);
		}
		return $value;
	}

	private function encrypt($data, $password)
	{
		if (empty($data)) {
			return $data;
		}
		$iv = config('configuration.encryption_secret_iv');

		$password = sha1($password);

		$salt = config('configuration.encryption_fixed_salt');

		$saltWithPassword = hash('sha256', $password . $salt);

		$encrypted = openssl_encrypt( "$data", config('configuration.encryption_method'), "$saltWithPassword", $option = 0 , $iv);

		$msg_encrypted_bundle = "$iv:$salt:$encrypted";

		return $msg_encrypted_bundle;
	}


	private function decrypt($msg_encrypted_bundle, $password)
	{

		if (empty($msg_encrypted_bundle)) {
			return $msg_encrypted_bundle;
		}
		$password = sha1($password);

		$components = explode(':', $msg_encrypted_bundle);

		if (count($components) < 3) {
			return $msg_encrypted_bundle;
		}

		$iv = $components[0] ?? '';
		$salt = $components[1] ?? '';
		$salt = hash('sha256', $password . $salt);

		$encrypted_msg = $components[2] ?? '';

		$decrypted_msg = openssl_decrypt( $encrypted_msg, config('configuration.encryption_method'), $salt, $option = 0 , $iv );

		if ($decrypted_msg === false) {
			return $msg_encrypted_bundle;
		}
		return $decrypted_msg;
	}
}
