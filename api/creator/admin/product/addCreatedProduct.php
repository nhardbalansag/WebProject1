<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/addCreatedProduct.php

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
	// 		cp_status: cp_status,
			// reference: computed_hash
	// 	}
	// }

	if(empty($raw->adminInput->reference)){
		$reason = $raw->adminInput->reference;
		$status = 200;
		goto endResult;
	}

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

	$encrypt = new Encryption();

	$stmtdata = $stmt->fetch(PDO::FETCH_ASSOC);

	$inputDb = json_decode(
		json_encode(
			array(
				'p_id' => $stmtdata['p_id'],
				'cp_status' => $raw->adminInput->cp_status
			)
		)
	);

	$product->cp_status = $inputDb->cp_status;
	$product->p_id = $inputDb->p_id;
	
	if(!($stmt = $product->updateCreatedProductStatus())){

		$reason = 'failed';
		$status = 400;
		$error = 'post';
		$message = 'cannot update';
		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;
	}

	$reason = 'success';
	$status = 200;
	$error = null;
	$message = $inputDb->cp_status;
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
						'result' => $message

					)

				)

			)

		);

		echo  $apiResult;






