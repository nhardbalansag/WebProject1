<?php

// localhost/my_projects/yamaha_elective/api/creator/createUserRole.php

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

		goto errorResult;
	}

	$userData_raw = json_decode($userData);

	$customer_user = new User($connection);

	$customer_user->accountId = $userData_raw->userRoleInfo->Admin->adminId;

	if($stmt = $customer_user->verifyAdmin()){

		goto errorResult;
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorResult;
	}

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$adminId = $row['a_id'];

	if($adminId !== $userData_raw->userRoleInfo->Admin->adminId){

		goto errorResult;
	}

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	// get the inputs

	$userRoleInput = $encrypt->encryptData($userData_raw->userRoleInfo->userRoleTittle, $useriv);

	$useriv = base64_encode($useriv);

	$computedhash = $encrypt->dataHashing($userRoleInput, base64_decode($useriv));

	$mesage_rawData = json_decode(
		json_encode(
			array(
				'userRole' => $userRoleInput,
				'useriv' => $useriv,
				'computedhash' => $computedhash
	)));

	if(empty($mesage_rawData->userRole) || empty($mesage_rawData->useriv) || empty($mesage_rawData->computedhash)){

		goto errorResult;

	}

	// get the message
	$customer_user->userRole = $mesage_rawData->userRole;

	// get the message iv
	$customer_user->salt = $mesage_rawData->useriv;

	// get the user iv
	$customer_user->hash = $mesage_rawData->computedhash;
	
	//execute the query
	if(!($customer_user->createUserRole())){

		goto errorResult;

	}

	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = 'User Role Succesfully added';

	array_push($errors, $error);

	array_push($mes, $message);

	goto endResult;

	errorResult:

		$reason = 'failed';

		$status = 400;

		$error = 'incomplete';

		$message = 'unable create';

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