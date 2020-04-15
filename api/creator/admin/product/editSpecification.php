<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/editSpecification.php

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

	$product->tittle = $encrypt->encryptData($raw->adminInput->s_specification_type_field, $useriv);
	$product->description = $encrypt->encryptData($raw->adminInput->s_description_field, $useriv);
	$product->specificationCategory = $raw->adminInput->s_category_field;
	$product->salt = base64_encode($useriv);

	$bindata = 	$raw->adminInput->s_specification_type_field . 
				$raw->adminInput->s_description_field . 
				$raw->adminInput->s_category_field;

	$datahash = $encrypt->dataHashing($bindata, $useriv);

	$product->hash = $datahash;
	$product->reference = $raw->adminInput->reference;

	if(!$product->editSpecification()){

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
		's_tittle' => $raw->adminInput->s_specification_type_field,
		's_description' => $raw->adminInput->s_description_field,
		's_category' => $raw->adminInput->s_category_field,
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






