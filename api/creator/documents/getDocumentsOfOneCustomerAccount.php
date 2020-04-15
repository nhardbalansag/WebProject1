<?php

// localhost/my_projects/YAMAHA/api/creator/documents/getDocumentsOfOneCustomerAccount.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/documents.php');

	$des = array();

	$errors = array();

	$res = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$Documents = new Documents($connection);

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	$raw = json_decode($userData);

	$Documents->computed_hash = $raw->customerAccount->customerAccountReference;

	if(!($stmt = $Documents->getDocumentsOfOneCustomerAccount())){
		goto errorReport;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$documentCategoryNameKey = base64_decode($data['documentCategoryNameKey']);

		$result = array(

			"documentCategoryName" => $encryption->decryptData($data['documentCategoryName'], $documentCategoryNameKey),
			"documentDateCreated" => $data['documentDateCreated'],					
			"documentImage" => $data['documentImage'],						
			"documentId" => $data['documentId'],					
			"customerAccountId" => $data['customerAccountId']						

		);

		array_push($res, $result);

	}// end of while

	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = 'document results of customer';

	array_push($errors, $error);
	array_push($mes, $message);

	goto endResult;


	errorReport:

		$reason = 'failed';
		$status = 400;
		$error = 'query';
		$message = 'failed';

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
					'data' => $res
				)

			)

		)

	);

	echo  $apiResult;