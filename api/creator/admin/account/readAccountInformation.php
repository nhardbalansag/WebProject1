<?php

// localhost/my_projects/YAMAHA/api/creator/readCustomerinformation.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/users.php');


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

	$customer_user->accountId = $userData_raw->adminInput->computed_hash;

	if(!($stmt = $customer_user->viewAdminInfo())){

		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorResult;
	}
 
	//data
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$ivUser = base64_decode($data['info_admin_salt']);

		$result = array(
			"info_admin_email" => $data['info_admin_email'],
			"info_admin_firstname" => $encryption->decryptData($data['info_admin_firstname'], $ivUser),
			"info_admin_lastname" =>$encryption->decryptData($data['info_admin_lastname'], $ivUser),
			"info_admin_middlename" => $encryption->decryptData($data['info_admin_middlename'], $ivUser),
			"info_admin_street" => $encryption->decryptData($data['info_admin_street'], $ivUser),
			"info_admin_city_municipality" => $encryption->decryptData($data['info_admin_city_municipality'], $ivUser),
			"info_admin_province" => $encryption->decryptData($data['info_admin_province'], $ivUser),
			"info_admin_zipcode" => $encryption->decryptData($data['info_admin_zipcode'], $ivUser),
			"info_admin_phonenumber" => $encryption->decryptData($data['info_admin_phonenumber'], $ivUser),
			"info_admin_telephonenumber" => $encryption->decryptData($data['info_admin_telephonenumber'], $ivUser),
			"info_admin_dateCreated" => $encryption->decryptData($data['info_admin_dateCreated'], $ivUser),
			"info_admin_bday" => $data['info_admin_bday'],
			"info_admin_computed_hash" => $data['info_admin_computed_hash']
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