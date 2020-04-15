<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/editProduct.php

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
		// 		p_Imagelook: filename,
		// 		p_name: p_name.value,
		// 		p_caption: p_caption.value,
		// 		p_price: p_price.value,
		// 		p_description: p_description.value,
		// 		pct_id: pct_id.value
		// 	}
		// }

	$encrypt = new Encryption();
	$useriv = $encrypt->ivData();

	$product->image = $encrypt->encryptData($raw->adminInput->p_Imagelook, $useriv);
	$product->name = $encrypt->encryptData($raw->adminInput->p_name, $useriv);
	$product->caption = $encrypt->encryptData($raw->adminInput->p_caption, $useriv);
	$product->price = $encrypt->encryptData($raw->adminInput->p_price, $useriv);
	$product->dateCreated = date('y-m-d');
	$product->dateModified = date('y-m-d');
	$product->description = $encrypt->encryptData($raw->adminInput->p_description, $useriv);
	$product->categoryId = $raw->adminInput->pct_id;
	$product->salt = base64_encode($useriv);
	$product->reference = $raw->adminInput->reference;

	$bindata = 	$raw->adminInput->p_Imagelook . 
				$raw->adminInput->p_name . 
				$raw->adminInput->p_caption . 
				$raw->adminInput->p_price . 
				date('y-m-d') . 
				date('y-m-d') . 
				$raw->adminInput->p_description . 
				$raw->adminInput->pct_id;

	$datahash = $encrypt->dataHashing($bindata, $useriv);
	$product->hash = $datahash;
	$product->reference = $raw->adminInput->reference;

	if(!$product->editProduct()){

		$reason = $datahash;
		$status = 400;
		$error = 'post';
		$message = 'cannot create';
		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;
	}

	$product->hash = $datahash;

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
	
	$reason = 'success';
	$status = 200;
	$error = null;
	$result = array(
		'productLink' => $datahash
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






