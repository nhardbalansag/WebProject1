<?php

// localhost/my_projects/YAMAHA/api/creator/support/getAdminMessages.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	$des = array();

	$errors = array();

	$res = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$customer_user = new User($connection);

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	$raw = json_decode($userData);

	$customer_user->adminCreatedMessage = $raw->infoId->id;
	// $customer_user->messageID = 3;

	if(!($stmt = $customer_user->getAdminOneSelectedMessage())){

		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorResult;
	}

	$data = $stmt->fetch(PDO::FETCH_ASSOC);

	$adminMessageKey = base64_decode($data['adminMessageKey']);

	$result = array(

			"adminMessage" => $encryption->decryptData($data['adminMessage'], $adminMessageKey),
			"adminMessageDate" =>$data['adminMessageDate'],
			"adminMessageTime" =>$data['adminMessageTime']

	);

	array_push($res, $result);

	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = 'yamaha';

	array_push($errors, $error);

	array_push($mes, $message);

	goto endResult;

	errorResult:

		//error
		$reason = 'failed';

		$status = 400;

		$error = 'internal';

		$message = 'unable to load messages';

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