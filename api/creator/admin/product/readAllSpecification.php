<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/readAllSpecification.php

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

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		//failed
		$reason = 'failed';
		$status = 400;
		$error = 'none';
		array_push($errors, $error);
	}

	$raw = json_decode($userData);

	// adminInput:{
	// 	reference: computed_hash,
	// 	category: category
	// }


	$product->hash = $raw->adminInput->reference;

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

	$stmtdata = $stmt->fetch(PDO::FETCH_ASSOC);

	$data = json_decode(
				json_encode(
					array(
						'p_id' => $stmtdata['p_id']
					)
				)
			);

	$product->s_category = $raw->adminInput->category;
	$product->p_id = $data->p_id;

	if(!($stmt = $product->readAllSpecification())){

		$reason = 'failed';
		$status = 200;
		goto endResult;
		
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		$reason = 'no added data';
		$status = 200;
		goto endResult;
	}

	$encrypt = new Encryption();

	while($stmtdata = $stmt->fetch(PDO::FETCH_ASSOC)){

		$key = base64_decode($stmtdata['specs_salt']);

		$data = array(
			'specs_s_id' => $stmtdata['specs_s_id'],
			'specs_s_specification_type' => $encrypt->decryptData($stmtdata['specs_s_specification_type'], $key),
			'specs_s_description' => $encrypt->decryptData($stmtdata['specs_s_description'], $key),
			'specs_s_category' => $stmtdata['specs_s_category'],
			'specs_p_id' => $stmtdata['specs_p_id'],
			'specs_computed_hash' => $stmtdata['specs_computed_hash']
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






