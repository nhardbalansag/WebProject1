<?php

/**
 * 
 */
class Encryption
{

	private $result;

	private $method = 'AES-128-CBC';

	private $secretkey = '1234secretkey';

	private $data_result;

	


	function encryptData($data, $iv){

		try {

			$key = base64_encode($this->secretkey);

			$encrypted = openssl_encrypt($data, $this->method, $key, $options = OPENSSL_RAW_DATA, $iv);

			$result = base64_encode($encrypted);
			
		} catch (Exception $e) {
			
		}

		return $result;

	}// end of the encryption


	function decryptData($data, $iv){

		try {

			$key = base64_encode($this->secretkey);

			$d1 = base64_decode($data);

			$decrypted = openssl_decrypt($d1, $this->method, $key, $options = OPENSSL_RAW_DATA, $iv);
			
		} catch (Exception $e) {
			
		}

		return $decrypted;

	}// end of the decryption


	function ivData(){

		$iv_length = openssl_cipher_iv_length($this->method);

		$iv = openssl_random_pseudo_bytes($iv_length);

		return $iv;

	}// end of the function


	function dataHashing($data, $iv){

		$key = base64_encode($this->secretkey);

		try {

			$encrypted_data = openssl_encrypt($data, $this->method, $key, $options = OPENSSL_RAW_DATA, $iv);

			// hash_hmac(algo, data, key)

			$hash_data = hash_hmac('sha256', $encrypted_data, $key);

			$result = base64_encode($hash_data);
			
		} catch (Exception $e) {
			
		}

		return $result;

	}// end of the function
	
	
}// end of the class

// $sample = new Encryption;

// $iv = $sample->ivData(); 
// echo "data = " . $data = "magreresign na ako <br>";

// $e = $sample->encryptData($data, $iv);
// echo "encrypted data = " . $e . "<br>";


// $d = $sample->decryptData($e, $iv);
// echo "decrypted data = " . $d . "<br>";

// $h = $sample->dataHashing($d, $iv);
// echo "computed hash data = " . $h . "<br>";
