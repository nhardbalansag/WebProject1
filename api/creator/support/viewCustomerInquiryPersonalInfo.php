<?php

// localhost/my_projects/YAMAHA/api/creator/support/viewCustomerInquiryPersonalInfo.php

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

	$customer_user->customerInfoId = $raw->inquiryInformationID->id;

	if(!($stmt = $customer_user->getInquiryPersonalInformation())){
		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorResult;
	}

	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$ivUser = base64_decode($data['salt']);
		$MessageIv = base64_decode($data['m_salt']);

		$result = array(
			"ci_id" => $data['ci_id'],
			"m_message" => $encryption->decryptData($data['m_message'], $MessageIv),
			"ci_email" => $data['ci_email'],
			"ci_firstname" =>$encryption->decryptData($data['ci_firstname'], $ivUser),
			"ci_lastname" => $encryption->decryptData($data['ci_lastname'], $ivUser),
			"ci_middlename" => $encryption->decryptData($data['ci_middlename'], $ivUser),
			"ci_street" => $encryption->decryptData($data['ci_street'], $ivUser),
			"ci_city_municipality" => $encryption->decryptData($data['ci_city_municipality'], $ivUser),
			"ci_province" => $encryption->decryptData($data['ci_province'], $ivUser),
			"ci_zipcode" => $encryption->decryptData($data['ci_zipcode'], $ivUser),
			"ci_phonenumber" => $encryption->decryptData($data['ci_phonenumber'], $ivUser),
			"ci_telephonenumber" => $encryption->decryptData($data['ci_telephonenumber'], $ivUser),
			"ci_bday" => $data['ci_bday'],
			"computed_hash" => $data['computed_hash']
		);
		array_push($res, $result);
	}
	

	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = $result['ci_firstname'] . ' personal information';

	array_push($errors, $error);
	array_push($mes, $message);

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
					'message' => $mes

				),
				'result' => array(
					'documentInformation' => $res
				)
			)
		)
	);

	echo  $apiResult;