<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/readProductCategory.php
	session_start();

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET");
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

	if(!($stmt = $product->readAllProductCategory())){

		$reason = 'failed';
		$status = 200;
		goto endResult;
		
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		$reason = 'no added category';
		$status = 200;
		goto endResult;
	}

	$encrypt = new Encryption();

	while($stmtdata = $stmt->fetch(PDO::FETCH_ASSOC)){

		$key = base64_decode($stmtdata['salt']);

		$data = array(
			'pct_id' => $stmtdata['pct_id'],
			'pct_tittle' => $encrypt->decryptData($stmtdata['pct_tittle'], $key),
			'pct_description' => $encrypt->decryptData($stmtdata['pct_description'], $key)
		);
		array_push($mes, $data);
	}

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






