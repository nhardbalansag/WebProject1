<?php

// localhost/my_projects/YAMAHA/api/creator/readCustomerinformation.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../config/database.php');

	include_once ('../obj/encryption.php');

	include_once ('../obj/users.php');

	$des = array();

	$errors = array();

	$res = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$customer_user = new User($connection);

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		goto errorResult;
	}

	$userData_raw = json_decode($userData);

	$customer_user->computed_hash = $userData_raw->UserInformation->reference;

	if(!($stmt = $customer_user->searchCustomerInformationSpecific())){

		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorResult;
	}

	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$ivUser = base64_decode($data['customer_IformationIv']);

		$result = array(
			"ci_id" => $data['customer_ci_id'],
			"ci_email" => $data['customer_ci_email'],
			"ci_firstname" =>$encryption->decryptData($data['customer_ci_firstname'], $ivUser),
			"ci_lastname" => $encryption->decryptData($data['customer_ci_lastname'], $ivUser),
			"ci_middlename" => $encryption->decryptData($data['customer_ci_middlename'], $ivUser),
			"ci_street" => $encryption->decryptData($data['customer_ci_street'], $ivUser),
			"ci_city_municipality" => $encryption->decryptData($data['customer_ci_city_municipality'], $ivUser),
			"ci_province" => $encryption->decryptData($data['customer_ci_province'], $ivUser),
			"ci_zipcode" => $encryption->decryptData($data['customer_ci_zipcode'], $ivUser),
			"ci_phonenumber" => $encryption->decryptData($data['customer_ci_phonenumber'], $ivUser),
			"ci_telephonenumber" => $encryption->decryptData($data['customer_ci_telephonenumber'], $ivUser),
			"ci_bday" => $data['customer_ci_bday'],
			"computed_hash" => $data['customer_computed_hash']
		);

		array_push($res, $result);
	}

	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = 'here is your information';

	array_push($errors, $error);

	array_push($mes, $message);

	goto endResult;
		
	errorResult:

		$reason = 'failed';
		$status = 400;
		$error = 'incomplete';
		$message = 'unable to load data';

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