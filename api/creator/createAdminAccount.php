<?php

	// localhost/my_projects/YAMAHA/api/creator/createAdminAccount.php

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

	$AdminUser = new User($connection);

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

	$MA_role = base64_encode('MADNA');
	$S_role = base64_encode('SADNA');

	$userData_raw = json_decode($userData);

	$explodedCode = array();

	$explodedCode = explode('.', $userData_raw->supportInput->referenceCode);

	if(array_key_exists('1', $explodedCode)){

		//go to main admin create account
		if(strtolower($explodedCode[1]) === strtolower($MA_role)){
			//main admin key
			$userAdminRole = strtoupper($MA_role);

		}else if(strtolower($explodedCode[1]) === strtolower($S_role)){
			// support admin account
			$userAdminRole = strtoupper($S_role);

		}else{

			// go to end create
			$reason = 'invalid';

			$status = 200;

			$error = 'no admin key';

			$message = 'incomplete data!';

			array_push($errors, $error);

			array_push($mes, $message);

			goto endResult;

		}

	}else{

		// go to end create
		$reason = 'invalid';

		$status = 200;

		$error = 'no admin key';

		$message = 'incomplete data!';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	// pass the reference code 
	$AdminUser->hash = $explodedCode[0];

	if(!($stmt = $AdminUser->accessEmailedAdminHash())){

		$reason = 'failed';

		$status = 400;

		$error = 'query';

		$message = 'failed, please register to receive reference code';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;
	}

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$adminRawData = json_decode(
		json_encode(
			array(
				"adminPersonalInformationID" => $row['admin_id'],
				"adminEmail" => $row['admin_email'],
				"admincomputedHash" => $row['admin_computed_hash']
			)
		)	
	);

	// if admin input submit is equal to database existing information
	if($adminRawData->admincomputedHash !== $explodedCode[0]){

		$reason = 'invalid';

		$status = 400;

		$error = 'no data';

		$message = 'please register';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$AdminUser->adminInformationId = $adminRawData->adminPersonalInformationID;

	if(!($stmt = $AdminUser->verifyAdminAccountExistence())){

		$reason = 'invalid';

		$status = 400;

		$error = 'query';

		$message = 'please register';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	//data
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($row['admin_id'] === $adminRawData->adminPersonalInformationID){

		// existing account
		$reason = 'existing';

		$status = 200;

		$error = 'none';

		$message = 'there is an existing account created please login';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$encrypt = new Encryption();

	//salt
	$useriv = $encrypt->ivData();

	//set up the date
	$dateCreated = date("Y-m-d");

	// set up the email
	$email = $adminRawData->adminEmail;

	// get the password
	$password = $encrypt->encryptData($userData_raw->supportInput->support_password, $useriv);

	// get the admin information id
	$adminInformationID = $adminRawData->adminPersonalInformationID;

	// get the user role id
	$userRole = $encrypt->encryptData($userAdminRole, $useriv);

	$useriv = base64_encode($useriv);

	$dataToHash = $email . $password . $adminInformationID . $userRole . $dateCreated . $dateCreated;

	$computedhash = $encrypt->dataHashing($dataToHash, base64_decode($useriv));

	$inputData = json_decode(json_encode(

		array(

			'dateCreated' => $dateCreated,
			'email' => $email,
			'password' => $password,
			'userRole' => $userRole,
			'PersonalInformationID' => (int)$adminInformationID,
			'iv' => $useriv,
			'hash' => $computedhash

		)

	));

	$AdminUser->email = $inputData->email;
	$AdminUser->currentPassword = $inputData->password;
	$AdminUser->PrevPassword = $inputData->password;
	$AdminUser->date = $inputData->dateCreated;
	$AdminUser->dateUpdated = $inputData->dateCreated;
	$AdminUser->userRole = $inputData->userRole;
	$AdminUser->customerInfoId = $inputData->PersonalInformationID;
	$AdminUser->salt = $inputData->iv;
	$AdminUser->hash = $inputData->hash;

	if(!($AdminUser->createAdminAccount())){

		$reason = 'failed';

		$status = 400;

		$error = 'query';

		$message = 'cannot create your account';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	//success
	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = 'you have have successfully created an account, please Login now!';

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
						'message' => $message

					)

				)

			)

		);

		echo  $apiResult;