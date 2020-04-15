
<?php

	// localhost/my_projects/YAMAHA/api/creator/readLoginCustomerAccount.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	session_start();
	
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

	if(empty($userData_raw->customerLoginInput->email) || empty($userData_raw->customerLoginInput->password)){

		goto errorResult;
	}

	// pass the email
	$customer_user->email = $userData_raw->customerLoginInput->email;

	if(!($stmt = $customer_user->searchCustomerAccount())){

		goto errorResult;
	}

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$customerInformationData_raw = json_decode(json_encode(
		array(

			"id" => $row['ca_id'],
			"email" => $row['ca_email'],
			"password" => $row['cal_password'],
			"iv" => $row['salt'],
			"hash" => $row['computed_hash'],
			"customerInfoId" => $row['ci_id']

		)
	));

	if($customerInformationData_raw->email !== $userData_raw->customerLoginInput->email){

		goto errorResult;
	}

		// verify the password
	$encrypt = new Encryption();

	$dbpassword = $encrypt->decryptData($customerInformationData_raw->password, base64_decode($customerInformationData_raw->iv));

	if($dbpassword !== $userData_raw->customerLoginInput->password){

		goto errorResult;
	}

	$customer_user->accountId = $customerInformationData_raw->id;
	
	if(!($stmt = $customer_user->searchCustomerInformation())){

		goto errorResult;
	}

	$countAccount = $stmt->rowCount();

	if($countAccount <= 0){

		goto errorResult;
	}

	// there is an account information
	$accountRow = $stmt->fetch(PDO::FETCH_ASSOC);

	$accountKey = base64_decode($accountRow['customer_account_salt']);
	$personalInfoKey = base64_decode($accountRow['customer_IformationIv']);

	$data = array(
		'account' => array(
			'customer_account_ca_id' =>$accountRow['customer_account_ca_id'],
			'customer_account_ca_date_created' =>$accountRow['customer_account_ca_date_created'],
			'customer_account_ca_email' =>$accountRow['customer_account_ca_email'],
			'customer_account_cal_password' =>$encrypt->decryptData($accountRow['customer_account_cal_password'], $accountKey),
			'customer_account_ci_id' =>$accountRow['customer_account_ci_id'],
			'customer_account_computed_hash' =>$accountRow['customer_account_computed_hash']
		),
		'personalInfo' => array(
			'customer_ci_id' =>$accountRow['customer_ci_id'],
			'customer_ci_email' =>$accountRow['customer_ci_email'],
			'customer_ci_firstname' =>$encrypt->decryptData($accountRow['customer_ci_firstname'], $personalInfoKey),
			'customer_ci_lastname' =>$encrypt->decryptData($accountRow['customer_ci_lastname'], $personalInfoKey),
			'customer_ci_middlename' =>$encrypt->decryptData($accountRow['customer_ci_middlename'], $personalInfoKey),
			'customer_ci_street' =>$encrypt->decryptData($accountRow['customer_ci_street'], $personalInfoKey),
			'customer_ci_city_municipality' =>$encrypt->decryptData($accountRow['customer_ci_city_municipality'], $personalInfoKey),
			'customer_ci_province' =>$encrypt->decryptData($accountRow['customer_ci_province'], $personalInfoKey),
			'customer_ci_zipcode' =>$encrypt->decryptData($accountRow['customer_ci_zipcode'], $personalInfoKey),
			'customer_ci_phonenumber' =>$encrypt->decryptData($accountRow['customer_ci_phonenumber'], $personalInfoKey),
			'customer_ci_telephonenumber' =>$encrypt->decryptData($accountRow['customer_ci_telephonenumber'], $personalInfoKey),
			'customer_ci_bday' =>$accountRow['customer_ci_bday'],
			'customer_computed_hash' =>$accountRow['customer_computed_hash']
		)
		
	);

	$dataDecode = json_decode(
		json_encode($data)
	);

	$fname =  $dataDecode->personalInfo->customer_ci_firstname;
	$mname = $dataDecode->personalInfo->customer_ci_lastname;
	$lname =  $dataDecode->personalInfo->customer_ci_middlename;
	$id = $dataDecode->personalInfo->customer_ci_id;
	$accountID = $dataDecode->account->customer_account_ca_id;
	$accountHash =  $dataDecode->account->customer_account_computed_hash;

	//success
	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = '../../formData/page/customer_account/customerControlPage.php';

	array_push($errors, $error);

	array_push($mes, $message);

	$_SESSION['firstname'] = $fname;
	$_SESSION['middlename'] = $mname;
	$_SESSION['lastname'] = $lname;
	$_SESSION['accountID'] = $accountID;
	$_SESSION['accountHash'] = $accountHash;
	$_SESSION['informationID'] = $id;
	$_SESSION['sessionID'] = session_id();
	
	goto endResult;

	errorResult:

		$reason = 'faild';
		$status = 400;
		$error = 'incomplete';
		$message = 'unable to login';

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



