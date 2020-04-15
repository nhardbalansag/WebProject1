<?php

// localhost/my_projects/yamaha_elective/api/creator/documents/readCategoryType.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	include_once ('../../obj/documents.php');

	$errors = array();
	$res = array();
	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$documentCategory = new Documents($connection);	

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		goto errorResult;
	}

	$userData_raw = json_decode($userData);

	$referenceArray = explode(".", $userData_raw->adminInput->documentReference);

	$documentCategory->reference = $referenceArray[0];

	if(!($stmt = $documentCategory->readOneDocumentCategory())){
		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		$message = 'no data';
		array_push($mes, $message);
		goto errorResult;
	}

	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$key = base64_decode($data['salt']);

		$result = array(
			"categoryName" => $encryption->decryptData($data['dc_document_category_name'], $key),
			"description" => $encryption->decryptData($data['dc_document_category_description'], $key),
			"categoryId" => $data['dc_id']

		);

		array_push($mes, $result);

	}

	// success
	$reason = 'success';
	$status = 200;
	$error = 'none';

	array_push($errors, $error);

	goto endResult;

	errorResult:

		$reason = 'failed';
		$status = 400;
		$error = 'failed';
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
					'message' => $mes

				),
				'result' => array(
					'category' => $res
				)


			)

		)

	);

	echo  $apiResult;