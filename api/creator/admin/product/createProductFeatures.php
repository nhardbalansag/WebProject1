<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/createProductFeatures.php

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
				// f_image: filename,
				// f_tittle: f_tittle.value,
				// f_description: f_description.value
				// productReference
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

	$product->image = $encrypt->encryptData($raw->adminInput->f_image, $useriv);
	$product->tittle = $encrypt->encryptData($raw->adminInput->f_tittle, $useriv);
	$product->description = $encrypt->encryptData($raw->adminInput->f_description, $useriv);
	$product->dateCreated = date('y-m-d');
	$product->dateModified = date('y-m-d');
	$product->productId = $inputDb->p_id;
	$product->salt = base64_encode($useriv);

	$bindata = 	$raw->adminInput->f_image . 
				$raw->adminInput->f_tittle . 
				$raw->adminInput->f_description . 
				date('y-m-d') . 
				date('y-m-d') . 
				$inputDb->p_id; 

	$datahash = $encrypt->dataHashing($bindata, $useriv);
	$product->hash = $datahash;

	if(!($stmt = $product->createProductFeatures())){

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
		'f_tittle' => $raw->adminInput->f_tittle,
		'f_description' => $raw->adminInput->f_description
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






