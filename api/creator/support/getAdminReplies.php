<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/support/getAdminReplies.php

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
	$adminAccountMessage = array();
	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$adminUser = new User($connection);

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	$dataAdminRaw = json_decode($userData);

	$adminUser->customerCreatedMessageId = $dataAdminRaw->AdminMessageData->customerAccountId;

	if(!($stmt = $adminUser->getcustomerAccountCreatedId())){

		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorResult;
	}

	$data = $stmt->fetch(PDO::FETCH_ASSOC);

	$adminUser->customerCreatedMessageId = $dataAdminRaw->AdminMessageData->customerAccountId;

	if(!($get = $adminUser->getAdminReplies())){

		goto errorResult;
	}

	$numberOFdata = $get->rowCount();

	if($numberOFdata <= 0){

		goto errorResult;
	}

	while($getReply = $get->fetch(PDO::FETCH_ASSOC)){

		$adminMessageReplyKey = base64_decode($getReply['adminMessageReplyKey']);

		$reply = array(

			'adminMessageReply' => $encryption->decryptData($getReply['adminMessageReply'], $adminMessageReplyKey),
			'adminMessageDate' => $getReply['adminMessageDate'],
			'adminMessagetime' => $getReply['adminMessagetime'],
			'adminMessageReplyId' => $getReply['adminMessageReplyId']
		);

		array_push($adminAccountMessage, $reply);
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
		$error = 'failed';
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
						'message' => $mes,
						'result' => array(
							'adminReply' => $adminAccountMessage
						)
					)
				)
			)
		);

		echo  $apiResult;