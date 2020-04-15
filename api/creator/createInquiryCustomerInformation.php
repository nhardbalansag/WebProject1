<?php

	// localhost/my_projects/yamaha_elective/api/creator/createInquiryCustomerInformation.php

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

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	$ci_email = $userData_raw->UserInformation->ci_email;
	$ci_firstname = $encrypt->encryptData($userData_raw->UserInformation->ci_firstname, $useriv);
	$ci_lastname = $encrypt->encryptData($userData_raw->UserInformation->ci_lastname, $useriv);
	$ci_middlename = $encrypt->encryptData($userData_raw->UserInformation->ci_middlename, $useriv);
	$ci_street = $encrypt->encryptData($userData_raw->UserInformation->ci_street, $useriv);
	$ci_city_municipality = $encrypt->encryptData($userData_raw->UserInformation->ci_city_municipality, $useriv);
	$ci_province = $encrypt->encryptData($userData_raw->UserInformation->ci_province, $useriv);
	$ci_zipcode = $encrypt->encryptData($userData_raw->UserInformation->ci_zipcode, $useriv);
	$ci_phonenumber = $encrypt->encryptData($userData_raw->UserInformation->ci_phonenumber, $useriv);
	$ci_telephonenumber = $encrypt->encryptData($userData_raw->UserInformation->ci_telephonenumber, $useriv);
	$ci_categorytype = $userData_raw->UserInformation->ci_categorytype;
	$ci_inquiremessage = $encrypt->encryptData($userData_raw->UserInformation->ci_inquiremessage, $useriv);
	$ci_date = date('y-m-d');
	$ci_bday = $userData_raw->UserInformation->ci_bday;


	$binddata = $ci_email . $ci_firstname . $ci_lastname . $ci_middlename . $ci_street . $ci_city_municipality . $ci_province . $ci_zipcode . $ci_phonenumber . $ci_telephonenumber . $ci_date . $ci_bday;

	$computedhash = $encrypt->dataHashing($binddata, $useriv);

	$user_iv_res = base64_encode($useriv);

	
	$customer_user = new User($connection);

	$customer_user->email = $ci_email;
	$customer_user->firstname = $ci_firstname;
	$customer_user->lastname = $ci_lastname;
	$customer_user->middlename = $ci_middlename;
	$customer_user->street = $ci_street;
	$customer_user->city = $ci_city_municipality;
	$customer_user->province = $ci_province;
	$customer_user->zipcode = $ci_zipcode;
	$customer_user->phonenumber = $ci_phonenumber;
	$customer_user->telephone = $ci_telephonenumber;
	$customer_user->categorytype = $ci_categorytype;
	$customer_user->inquirymessage = $ci_inquiremessage;
	$customer_user->date = $ci_date;
	$customer_user->bday = $ci_bday;
	$customer_user->salt = $user_iv_res;
	$customer_user->hash = $computedhash;

	if(!($customer_user->create_userInformation())){

		goto errorResult;

	}

	// get the message
	$customer_user->inquiryMessage = $ci_inquiremessage;

	// get the message type
	$customer_user->messageType = $ci_categorytype;

	// get the user iv
	$customer_user->salt = $user_iv_res;

	// get the cmputed hash
	$binddata = $ci_inquiremessage . 
				$ci_categorytype;

	$computedhash = $encrypt->dataHashing($binddata, $useriv);

	$customer_user->hash = $computedhash;

	//execute the query
	if(!($customer_user->createdMessage())){

		goto errorResult;

	}

	//get the message id
	if(!($stmt = $customer_user->getMessageInformationId())){

		goto errorResult;

	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorResult;
	}

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    $messageId = $row['m_id'];

	$customer_user->hash = $computedhash;

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

	//get the customer information id								
	$customer_user->customerInfoId = $row['ci_id'];

	// message id
	$customer_user->messageID = $messageId;

	// date
	$customer_user->createdDate =date('y-m-d');

	// time
	$customer_user->timeCreated = date('h:i:s');
	
	if(!($customer_user->createdInquiries())){

		goto errorResult;

	}

	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = 'inquiry sent';

	array_push($errors, $error);

	array_push($mes, $message);

	goto endResult;

	 errorResult:

		$reason = 'no data';

		$status = 400;

		$error = 'no data';

		$message = 'unable to get message';

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



