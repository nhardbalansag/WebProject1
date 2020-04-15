<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/documents/readUserDocuments.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	include_once ('../../obj/documents.php');

	$des = array();
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

	$documentCategory->accountId = $userData_raw->userInput->reference;

	if(!($stmt = $documentCategory->readDocumentOfUser())){
		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorResult;	
	}

	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$IV = base64_decode($data['documentIv']);

		$result = array(
			"documentId" => $data['d_id'],
			"image" => $data['d_image'],
			"status" =>$data['d_status'],
			"documentCategoryID" => $data['dc_id'],
			"customerAccount" => $data['ca_id'],
			"dateCreated" => $data['d_datecreated'],
			"hash" => $data['documentHash'],
			"docsnote" => $encryption->decryptData($data['notetodocs'], $IV)
		);
		array_push($res, $result);
	}

	$documentCategory->docsId = $userData_raw->userInput->reference;

	if(!($stmt = $documentCategory->readDocumentOfUser_information())){
		goto errorResult;
	}
	//data
	$count = $stmt->rowCount();

	if($count < 0){
		goto errorResult;
	}
	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		$result = array(
			"description" => $encryption->decryptData($data['dc_document_category_description'], base64_decode($data['salt'])),
			"categoryTittle" => $encryption->decryptData($data['dc_document_category_name'], base64_decode($data['salt']))
		);

		array_push($des, $result);
	}

	// success
	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = 'categories';

	array_push($errors, $error);
	array_push($mes, $message);

	goto endResult;
		
	errorResult:
		//error
		$reason = 'failed';
		$status = 400;
		$error = 'error';
		$message = 'unable to read documents';

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
					'documentInformation' => $res,
					'categoryInformation' => $des
				)
			)
		)
	);

	echo  $apiResult;