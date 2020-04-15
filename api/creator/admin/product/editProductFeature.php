<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/editProductFeature.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/product.php');

	$errors = array();

	$mes = array();

	$db = new Database();
	$connection = $db->connection();
	$product = new Products($connection);

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		$reason = 'failed';
		$status = 400;
		$error = 'null';
		$message = 'incomplete';
		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;
	}

	$raw = json_decode($userData);

		// 	adminInput:{
				// f_image_field: filename,
				// f_tittle_field: f_tittle_field.value,
				// f_description_field: f_description_field.value,
				// Reference: computed_hash
		// 	}
		// }

	$encrypt = new Encryption();
	$useriv = $encrypt->ivData();

	$product->image = $encrypt->encryptData($raw->adminInput->f_image_field, $useriv);
	$product->tittle = $encrypt->encryptData($raw->adminInput->f_tittle_field, $useriv);
	$product->description = $encrypt->encryptData($raw->adminInput->f_description_field, $useriv);
	$product->dateModified = date('y-m-d');
	$product->salt = base64_encode($useriv);

	$bindata = 	$raw->adminInput->f_image_field . 
				$raw->adminInput->f_tittle_field . 
				$raw->adminInput->f_description_field . 
				date('y-m-d');

	$datahash = $encrypt->dataHashing($bindata, $useriv);
	$product->hash = $datahash;
	$product->reference = $raw->adminInput->Reference;

	if(!$product->editProductFeature()){

		$reason = $datahash;
		$status = 400;
		$error = 'post';
		$message = 'cannot create';
		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;
	}

	$reason = 'success';
	$status = 200;
	$error = 'null';
	$result = array(
		'f_tittle' => $raw->adminInput->f_tittle_field,
		'f_description' => $raw->adminInput->f_description_field,
		'reference' => $datahash
	);
	array_push($errors, $error);

	goto endResult;

	endResult:

		$apiResult = json_encode(

			array(

				'response' => array(

					'reason' => $reason,
					'http_response_code' => $status,
					'errors' => $errors,
					'display' => array(
						'result' => $result

					)

				)

			)

		);

		echo  $apiResult;






