<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/createSpecification.php

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
				// s_specification_type_field: s_specification_type_field.value,
				// s_description_field: s_description_field.value,
				// s_category_field: s_category_field.value,
				// productReference: computed_hash
		// 	}
		// }

	if(empty($raw->adminInput->productReference)){
		$reason = 'failed';
		$status = 400;
		goto endResult;
	}

	$product->hash = $raw->adminInput->productReference;

	if(!($stmt = $product->readOneProduct())){

		$reason = 'failed';
		$status = 400;
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
				'p_id' => $stmtdata['p_id']
			)
		)
	);

	$useriv = $encrypt->ivData();

	$product->tittle = $encrypt->encryptData($raw->adminInput->s_specification_type_field, $useriv);
	$product->description = $encrypt->encryptData($raw->adminInput->s_description_field, $useriv);
	$product->specificationCategory = $raw->adminInput->s_category_field;
	$product->productId = $inputDb->p_id;
	$product->salt = base64_encode($useriv);

	$bindata = 	$raw->adminInput->s_specification_type_field . 
				$raw->adminInput->s_description_field . 
				$raw->adminInput->s_category_field . 
				$inputDb->p_id; 

	$datahash = $encrypt->dataHashing($bindata, $useriv);
	$product->hash = $datahash;

	if(!$product->create_specification()){

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
		's_tittle' => $raw->adminInput->s_specification_type_field,
		's_description' => $raw->adminInput->s_description_field,
		's_category' => $raw->adminInput->s_category_field
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






