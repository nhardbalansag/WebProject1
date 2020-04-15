<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/documents/readAllDocumentCategory.php

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

	if(!($stmt = $documentCategory->readDocumentCategory())){
		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorResult;
	}

	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$key = base64_decode($data['salt']);

		$result = array(
			"categoryName" => $encryption->decryptData($data['dc_document_category_name'], $key),
			"description" => $encryption->decryptData($data['dc_document_category_description'], $key),
			"dateCreated" => $data['dc_date_created'],
			"hash" => $data['computed_hash'],
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
		$message = 'cannot create, try again';

		array_push($errors, $error);
		array_push($mes, $message);

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