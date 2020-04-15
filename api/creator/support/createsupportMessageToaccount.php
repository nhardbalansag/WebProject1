<?php

// localhost/my_projects/YAMAHA/api/creator/support/createsupportMessageToaccount.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	session_start();

	$des = array();

	$errors = array();

	$res = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$admin = new User($connection);

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	$raw = json_decode($userData);

	$useriv = $encryption->ivData();

	//////////////////////////////////////////////inputs
	/*
	customerAccount:{
        "customerCreatedMessageId":
        "AdminAccountId": 
        "adminReply":
        "messageType": 
      }
	*/
     ///////////////////////////////////////////////end



	////////////////////////////////////////////create the message
	$message = $encryption->encryptData($raw->customerAccount->adminReply, $useriv);
	$status = $raw->customerAccount->messageType;
	$binddata = $raw->customerAccount->adminReply . $raw->customerAccount->messageType;
	$salt = base64_encode($useriv);
	$computedHash = $encryption->dataHashing($binddata, $useriv);

	$admin->inquiryMessage = $message;
	$admin->messageType = $status;
	$admin->salt = $salt;
	$admin->hash = $computedHash;
	
	if(!($admin->createdMessage())){
		goto errorResult;
	}

	////////////////////////////////////////////end the message

	$admin->hash_data = $computedHash;

	if(!($stmt = $admin->getMessageInformationId())){
		goto errorResult;
	}

	//success
	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorResult;
	}
								
	$messageData = $stmt->fetch(PDO::FETCH_ASSOC);

	$admin->createdDate = date('y-m-d');
	$admin->timeCreated = date('h:i:s');
	$admin->messageID = $messageData['m_id'];
	$admin->adminId = $raw->customerAccount->AdminAccountId;
	$admin->customerCreatedMessageId = $raw->customerAccount->customerCreatedMessageId;

	if(!($admin->supportSendReplyToCustomerAccountMessage())){

		goto errorResult;
	}

	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = 'message successfully sent';

	array_push($errors, $error);
	array_push($mes, $message);

	goto endResult;
		
	errorResult:

		$reason = 'failed';
		$status = 400;
		$error = 'null';
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

				)
			)
		)
	);

	echo  $apiResult;