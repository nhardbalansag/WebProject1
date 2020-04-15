<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/createProductCategorytype.php

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

	// adminInput:{
	// 	pct_tittle: pct_tittle.value,
	// 	pct_description: pct_description.value
	// }

	$encrypt = new Encryption();
	$useriv = $encrypt->ivData();

	$product->pct_tittle = $encrypt->encryptData($raw->adminInput->pct_tittle, $useriv);
	$product->pct_description = $encrypt->encryptData($raw->adminInput->pct_description, $useriv);
	$product->salt = base64_encode($useriv);

	$bindata = 	$raw->adminInput->pct_tittle . 
				$raw->adminInput->pct_description;

	$product->computed_hash = $encrypt->dataHashing($bindata, $useriv);

	if(!($linkstmt = $product->createProductCategoryType())){

		$reason = 'failed';
		$status = 400;
		$error = 'post';
		$message = 'cannot create';
		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;
	}

	$reason = 'success';
	$status = 200;
	$error = null;
	$result = array(
		'pct_tittle' => $raw->adminInput->pct_tittle,
		'pct_description' => $raw->adminInput->pct_description
	);
	array_push($errors, $error);
	array_push($mes, $result);

	goto endResult;

	goto endResult;

	endResult:

		$apiResult = json_encode(

			array(

				'response' => array(

					'reason' => $reason,
					'http_response_code' => $status,
					'errors' => $errors,
					'display' => array(
						'result' => $mes

					)

				)

			)

		);

		echo  $apiResult;






