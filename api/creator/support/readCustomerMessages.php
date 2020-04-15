<?php

// localhost/my_projects/YAMAHA/api/creator/support/readCustomerMessages.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	// include_once ('../../obj/documents.php');

	session_start();

	$des = array();

	$errors = array();

	$res = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	// $documentCategory = new Documents($connection);	

	$adminUser = new User($connection);

	$encryption = new Encryption();

	$adminUser->messageType = 'INQ';

	if(!($stmt = $adminUser->readAllCustomerMessage())){
		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorResult;
	}

			//data

	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$key = base64_decode($data['m_salt']);

		$result = array(

			"m_message" => $encryption->decryptData($data['m_message'], $key),
			"m_type" => $data['m_type'],
			"m_id" => $data['m_id'],
			"personalInfo" => $data['cinfo_id'],
			"dateCreated" => $data['createdInquiresDate'],
			"timeCreated" => $data['createdInquirestime']
				
		);

		array_push($res, $result);

	}

	$error = 'none';
	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = 'you have ' . $count . ' inquiry messages';

	array_push($mes, $message);
	array_push($errors, $error);

	goto endResult;

		

	errorResult:

		$reason = 'no data';
		$status = 200;
		$error = 'query';
		$message = 'no data';

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
					'message' => $mes,
					'result' => $res

				)
			)

		)

	);

	echo  $apiResult;