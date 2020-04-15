<?php

// localhost/my_projects/YAMAHA/api/creator/support/viewAllCustomerAccountMessages.php

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

	$customer_user = new User($connection);

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	$raw = json_decode($userData);

	$customer_user->computed_hash = $raw->referenceInput->reference;

	if(!($stmt = $customer_user->getAllAccountMessage())){
		goto errorReport;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$personalInfoKey = base64_decode($data['info_key']);
		$messageInfoKey = base64_decode($data['message_key']);

		$result = array(

			'personalInformation' => array(

				"ci_id" => $data['info_ID'],
				"ci_email" => $data['info_email'],
				"ci_firstname" =>$encryption->decryptData($data['info_firstname'], $personalInfoKey),
				"ci_lastname" => $encryption->decryptData($data['info_lastname'], $personalInfoKey),
				"ci_middlename" => $encryption->decryptData($data['info_middlename'], $personalInfoKey),
				"ci_street" => $encryption->decryptData($data['info_street'], $personalInfoKey),
				"ci_city_municipality" => $encryption->decryptData($data['info_city'], $personalInfoKey),
				"ci_province" => $encryption->decryptData($data['info_provice'], $personalInfoKey),
				"ci_zipcode" => $encryption->decryptData($data['info_zipcode'], $personalInfoKey),
				"ci_phonenumber" => $encryption->decryptData($data['info_phonenumber'], $personalInfoKey),
				"ci_telephonenumber" => $encryption->decryptData($data['info_telnumber'], $personalInfoKey),
				"ci_bday" => $data['info_bday']
			),
			'message' => array(

				"m_id" => $data['messageID'],
				"m_message" => $encryption->decryptData($data['message'], $messageInfoKey),
				"messageType" =>$data['messageType'],
				"message_computed_hash" =>$data['message_computed_hash']

			),
			'createdMessage' => array(

				"dateCreated" => $data['createdCustomerMessageDate'],
				"messageStatus" => $data['createdCustomerMessageStatus'],					
				"messageId" => $data['createdCustomerMessageId']						

			)

		);

		array_push($res, $result);

	}// end of while

	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = $result['personalInformation']['ci_firstname'] . ' messages';

	array_push($errors, $error);

	array_push($mes, $message);

	goto endResult;

		

	

	errorReport:
		//error
		$reason = 'failed';
		$status = 400;
		$error = 'query';
		$message = 'failed';

		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;

	endResult:

	$result_array = array($mes, $reason, $status, $errors);

	for ($i = 0; $i < count($result_array); $i++) { 
		# code...
		if(empty($result_array[$i])){

			$result_array[$i] = null;

		}

	}

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