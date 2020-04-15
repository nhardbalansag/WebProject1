<?php

// localhost/my_projects/yamaha_elective/api/creator/createCustomerSupportMessage.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../config/database.php');

	include_once ('../obj/encryption.php');

	include_once ('../obj/users.php');

	$errors = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		$reason = 'null';

		$status = 400;

		$error = 'no data';

		$message = 'incomplete data!';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$userData_raw = json_decode($userData);

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	$messagedata = $encrypt->encryptData($userData_raw->MessageInformation->m_message, $useriv);
	$messageType = $userData_raw->MessageInformation->m_type;
	$Accountid = $userData_raw->MessageInformation->customerSupportAccountInformation->customerSupportAccountId;

	$useriv = base64_encode($useriv);

	$binddata = $messagedata . $messageType;

	$computedhash = $encrypt->dataHashing($binddata, base64_decode($useriv));

	// create a new object for customer
	$customer_user = new User($connection);

	$mesage_rawData = json_decode(
		json_encode(
			array(
				'message' => $messagedata,
				'messageType' => $messageType,
				'useriv' => $useriv,
				'computedhash' => $computedhash,
				'Accountid' => $Accountid,
				'CustomerAccountId' => $userData_raw->MessageInformation->customerAccountInformation->customerAccountId,
				'CustomerMessageId' => $userData_raw->MessageInformation->customerAccountInformation->message->CreatedCustomerMessageID
			)
		)
	);

	// get the message
	$customer_user->inquiryMessage = $mesage_rawData->message;

	// get the message type
	$customer_user->messageType = $mesage_rawData->messageType;

	// get the user iv
	$customer_user->salt = $mesage_rawData->useriv;
	
	// get the cmputed hash
	$customer_user->hash = $mesage_rawData->computedhash;

	//execute the query
	if(!($customer_user->createdMessage())){

		$reason = 'cannot create message';

		$status = 400;

		$error = 'query';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	//execute query to message
	if(!($stmt = $customer_user->getMessageInformationId())){

		$reason = 'no message information';

		$status = 400;

		$error = 'query';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$count = $stmt->rowCount();

	if($count <= 0){

		$reason = 'no data';

		$status = 400;

		$error = 'no data';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$createdMessage_raw = json_decode(
		json_encode(
			array(

				'messageId' => $row['m_id'],
				'AccountId' => $mesage_rawData->Accountid,
				'status' => 'sent',
				'dateCreated' => date('Y-m-d H:i:s')
			)
		)
	);

	// pass the message id 
	$customer_user->messageID = $createdMessage_raw->messageId;

	//pass the customer support account id
	$customer_user->accountId = $createdMessage_raw->AccountId;

	// pass the status
	$customer_user->status = $createdMessage_raw->status;

	// pass the date
	$customer_user->date = $createdMessage_raw->dateCreated;

	//pass the customer created message id
	$customer_user->customerCreatedMessageId = $mesage_rawData->CustomerMessageId;

	//pass the customer account id
	$customer_user->customerAccountId = $mesage_rawData->CustomerAccountId;

	// execute query
	if(!($customer_user->createCustomerSupportMessage())){

		$reason = 'query failed';

		$status = 400;

		$error = 'query';

		$message = 'message not sent';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = 'message sent succesfully';

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