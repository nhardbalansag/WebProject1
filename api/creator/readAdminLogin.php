
<?php

	// localhost/my_projects/YAMAHA/api/creator/readAdminLogin.php

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

	$admin_user = new User($connection);

	$userData = file_get_contents('php://input');

	$MA_role = base64_encode('MADNA');
	$S_role = base64_encode('SADNA');

	if(empty($userData)){

		goto errorResult;
	}

	$userData_raw = json_decode($userData);

	if(empty($userData_raw->adminLoginInput->email) || empty($userData_raw->adminLoginInput->password)){

		goto errorResult;
	}

	// pass the email
	$admin_user->email = $userData_raw->adminLoginInput->email;

	if(!($stmt = $admin_user->searchAdminAccount())){

		goto errorResult;
	}

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$adminraw = json_decode(json_encode(
		array(
			'adminAccount' => array(

				"account_id" => $row['account_id'],
				"account_email" => $row['account_email'],
				"account_currentpassword" => $row['account_currentpassword'],
				"account_prevpassword" => $row['account_prevpassword'],
				"account_datecreated" => $row['account_datecreated'],
				"account_dateupdated" => $row['account_dateupdated'],
				"account_role" => $row['account_role'],
				"account_key" => $row['account_key'],
				"account_hash" => $row['account_hash'],
				"account_linked_adminInfo" => $row['account_linked_adminInfo']
			),
			'adminPersonalInfo' => array(

				"adminInfo_admin_id" => $row['adminInfo_admin_id'],
				"adminInfo_firstname" => $row['adminInfo_firstname'],
				"adminInfo_lastname" => $row['adminInfo_lastname'],
				"adminInfo_middlename" => $row['adminInfo_middlename'],
				"adminInfo_key" => $row['adminInfo_key']
			)
		)
	));

	if($adminraw->adminAccount->account_email !== $userData_raw->adminLoginInput->email){

		goto errorResult;
	}

	// verify the password
	$encrypt = new Encryption();

	$account_key = base64_decode($adminraw->adminAccount->account_key);

	$account_currentpassword = $encrypt->decryptData($adminraw->adminAccount->account_currentpassword, $account_key);

	if($account_currentpassword !== $userData_raw->adminLoginInput->password){

		goto errorResult;
	}

	$adminInfo_key = base64_decode($adminraw->adminPersonalInfo->adminInfo_key);

	$adminInfo_firstname = $encrypt->decryptData($adminraw->adminPersonalInfo->adminInfo_firstname, $adminInfo_key);
	$adminInfo_middlename = $encrypt->decryptData($adminraw->adminPersonalInfo->adminInfo_middlename, $adminInfo_key);
	$adminInfo_lastname = $encrypt->decryptData($adminraw->adminPersonalInfo->adminInfo_lastname, $adminInfo_key);
	$adminInfo_admin_id = $adminraw->adminPersonalInfo->adminInfo_admin_id;
	$account_id = $adminraw->adminAccount->account_id;
	$account_role = $encrypt->decryptData($adminraw->adminAccount->account_role, $account_key);
	$account_hash = $adminraw->adminAccount->account_hash;
	$account_datecreated = $adminraw->adminAccount->account_datecreated;

	if(strtoupper($account_role) === strtoupper($MA_role)){

		$_SESSION['MAIN_adminInfo_firstname'] = $adminInfo_firstname;
		$_SESSION['MAIN_adminInfo_middlename'] = $adminInfo_middlename;
		$_SESSION['MAIN_adminInfo_lastname'] = $adminInfo_lastname;
		$_SESSION['MAIN_account_id'] = $account_id;
		$_SESSION['MAIN_adminInfo_admin_id'] = $adminInfo_admin_id;
		$_SESSION['MAIN_account_role'] = $account_role;
		$_SESSION['MAIN_account_hash'] = $account_hash;
		$_SESSION['MAIN_account_datecreated'] = $account_datecreated;
		$_SESSION['MAIN_adminsessionID'] = session_id();

		$message = '../../../../formData/page/adminMain/index.php';

	}else if(strtoupper($account_role) === strtoupper($S_role)){

		$_SESSION['adminInfo_firstname'] = $adminInfo_firstname;
		$_SESSION['adminInfo_middlename'] = $adminInfo_middlename;
		$_SESSION['adminInfo_lastname'] = $adminInfo_lastname;
		$_SESSION['account_id'] = $account_id;
		$_SESSION['adminInfo_admin_id'] = $adminInfo_admin_id;
		$_SESSION['account_role'] = $account_role;
		$_SESSION['adminsessionID'] = session_id();

		$message = '../../../../formData/page/support_account/support_controlPage.php';

	}

	//success
	$reason = 'success';

	$status = 200;

	$error = 'none';

	array_push($errors, $error);

	array_push($mes, $message);
	
	goto endResult;


	errorResult:

		$reason = 'failed';

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



