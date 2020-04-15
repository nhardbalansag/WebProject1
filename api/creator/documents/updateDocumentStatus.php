<?php

// localhost/my_projects/YAMAHA/api/creator/documents/getOneDocumentInformationOfCustomerAccount.php

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

	$useriv = $encryption->ivData();

	$Documents->accountId = $raw->update->customerId;
	$Documents->note = $encryption->encryptData($raw->update->note, $useriv);
	$Documents->status = $raw->update->status;
	$Documents->docsId = $raw->update->documentId;
	$Documents->salt = base64_encode($useriv);

	if($Documents->updateDocumentStatus()){

		$reason = 'success';

		$status = 200;

		$error = 'none';

		$message = 'you have replied to this status';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;


	}else{

		//error
		$reason = 'no data';

		$status = 200;

		$error = 'query';

		$message = 'no data';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

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