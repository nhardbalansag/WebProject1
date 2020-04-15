<?php

// localhost/my_projects/YAMAHA/api/creator/support/readCustomerAccounts.php

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

	if(!($stmt = $adminUser->readAllCustomerAccounts())){

		goto errorReporting;

	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorReporting;

	}

	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

		$personalInfoKey = base64_decode($data['info_salt']);

		$result = array(
			
			"accountID" => $data['accountId'],
			"datecreated" => $data['accountdateCreated'],
			"ci_id" => $data['info_id'],
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
			"ci_bday" => $data['info_bday'],
			"account_computed_hash" => $data['account_computed_hash']
				
		);

		array_push($res, $result);

	}

	$error = 'none';
	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = 'you have ' . $count . ' customer accounts';

	array_push($mes, $message);
	array_push($errors, $error);

	goto endResult;


	errorReporting:
	
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