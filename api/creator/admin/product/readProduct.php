<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/readProduct.php
	session_start();

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

		//failed
		$reason = 'failed';
		$status = 400;
		$error = 'none';
		array_push($errors, $error);
	}

	$raw = json_decode($userData);

	// {
	// 	adminInput:{
	// 		computed_hash: computed_hash
	// 	}
	// }

	if(empty($raw->adminInput->computed_hash)){
		$reason = $raw->adminInput->computed_hash;
		$status = 200;
		goto endResult;
	}

	$product->hash = $raw->adminInput->computed_hash;

	if(!($stmt = $product->readOneProduct())){

		$reason = 'failed';
		$status = 200;
		goto endResult;
		
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		$reason = 'no added product';
		$status = 200;
		goto endResult;
	}

	$encrypt = new Encryption();

	$stmtdata = $stmt->fetch(PDO::FETCH_ASSOC);

	$key = base64_decode($stmtdata['salt']);

	$data = array(
		'p_id' => $stmtdata['p_id'],
		'p_Imagelook' => $encrypt->decryptData($stmtdata['p_Imagelook'], $key),
		'p_name' => $encrypt->decryptData($stmtdata['p_name'], $key),
		'p_caption' => $encrypt->decryptData($stmtdata['p_caption'], $key),
		'p_price' => $encrypt->decryptData($stmtdata['p_price'], $key),
		'p_description' => $encrypt->decryptData($stmtdata['p_description'], $key),
		'p_datecreated' => $stmtdata['p_datecreated'],
		'pct_id' => $stmtdata['pct_id']
	);

	array_push($mes, $data);

	//success
	$reason = 'success';
	$status = 200;
	$error = 'none';
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
						'result' => $mes
					)
				)
			)
		);

		echo  $apiResult;






