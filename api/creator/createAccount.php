<?php

	// localhost/my_projects/yamaha_elective/api/creator/createAccount.php

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

	$customer_user = new User($connection);

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		goto errorResult;
	}

	$userData_raw = json_decode($userData);

	// pass the reference code 
	$customer_user->hash = $userData_raw->customerAccountInput->referenceCode;

	if(!($stmt = $customer_user->accessEmailedcustomerHash())){

		goto errorResult;
	}

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$customerInformationData_raw = json_decode(
				json_encode(
					array(

						"customerID" => $row['ci_id'],
						"customerEmail" => $row['ci_email'],
						"computedHash" => $row['computed_hash']

					)
				)
			);

	if($customerInformationData_raw->computedHash !== $userData_raw->customerAccountInput->referenceCode){

		goto errorResult;
	}

	$customer_user->customerAccountId = $customerInformationData_raw->customerID;

	if(!($stmt = $customer_user->verifyAccountExistence())){

		goto errorResult;
	}

	$count = $stmt->rowCount();

	//data
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($row['ci_id'] === $customerInformationData_raw->customerID){

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
	$date = date("Y-m-d H:i:s");
	
	// set up the email
	$email = $customerInformationData_raw->customerEmail;

	// get the password
	$password = $encrypt->encryptData($userData_raw->customerAccountInput->cal_password, $useriv);

	// get the customer information id
	$custostomerInformationID = $customerInformationData_raw->customerID;

	$useriv = base64_encode($useriv);

	$dataToHash = $email . $password . $custostomerInformationID;

	$computedhash = $encrypt->dataHashing($dataToHash, base64_decode($useriv));

	$inputData = json_decode(json_encode(

		array(

			'date' => $date,
			'email' => $email,
			'password' => $password,
			'iv' => $useriv,
			'customerInformationID' => $custostomerInformationID,
			'hash' => $computedhash

		)

	));

	$customer_user->date = $inputData->date;
	$customer_user->email = $inputData->email;
	$customer_user->password = $inputData->password;
	$customer_user->customerInfoId = $inputData->customerInformationID;
	$customer_user->salt = $inputData->iv;
	$customer_user->hash = $inputData->hash;

	if(!($customer_user->createCustomerAccount())){

		goto errorResult;
	}

	//success
	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = 'you have have successfully created an account, please Login now!';

	array_push($errors, $error);

	array_push($mes, $message);

	goto endResult;


	errorResult:

		$reason = 'failed';

		$status = 400;

		$error = 'incomplete';

		$message = 'unable to create account, please register';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;


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