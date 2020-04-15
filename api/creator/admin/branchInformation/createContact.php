<?php

// localhost/my_projects/YAMAHA_PROJECT/admin/api/branchInformation/createLinks.php
	session_start();

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/branchInformation.php');


	$errors = array();

	$mes = array();

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

	if(!isset($_SESSION['MAIN_account_hash'])){


		$reason = 'not login to account';

		$status = 400;

		$error = 'security';

		$message = 'not login to account';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}


	$db = new Database();
	$connection = $db->connection();
	$branch = new branchInformation($connection);

	if(
		!(isset($_SESSION['MAIN_adminInfo_firstname'])) &&
		!(isset($_SESSION['MAIN_adminInfo_middlename'])) &&
		!(isset($_SESSION['MAIN_adminInfo_lastname'])) &&
		!(isset($_SESSION['MAIN_account_id'])) &&
		!(isset($_SESSION['MAIN_adminInfo_admin_id']))&&
		!(isset($_SESSION['MAIN_adminsessionID']))&&
		!(isset($_SESSION['MAIN_account_hash']))&&
		!(isset($_SESSION['MAIN_account_datecreated']))&&
		!(isset($_SESSION['MAIN_account_role']))
	){

		$reason = 'not login';

		$status = 400;

		$error = 'security';

		$message = 'forbidden';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$branch->computed_hash = $_SESSION['MAIN_account_hash'];
	$branch->a_datecreated = $_SESSION['MAIN_account_datecreated'];
	$branch->a_id = $_SESSION['MAIN_account_id'];

	if(!($ref = $branch->CheckAdminAccount())){

		$reason = 'no account';

		$status = 400;

		$error = 'security';

		$message = 'forbidden';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$countRef = $ref->rowCount();

	if($countRef <= 0){

		$reason = 'no account';

		$status = 400;

		$error = 'security';

		$message = 'forbidden';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	if(!($refData = $ref->fetch(PDO::FETCH_ASSOC))){

		$reason = 'no account';

		$status = 400;

		$error = 'security';

		$message = 'forbidden';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	if(	($refData['computed_hash'] != $_SESSION['MAIN_account_hash']) ||
		($refData['a_id'] != $_SESSION['MAIN_account_id']) ||
		($refData['a_datecreated'] != $_SESSION['MAIN_account_datecreated'])){

		$reason = 'no account';

		$status = 400;

		$error = 'security';

		$message = 'forbidden';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;
	}

	$adminRaw = json_decode($userData);

	$encrypt = new Encryption();

	$adminiv = $encrypt->ivData();

	if(empty($adminRaw->adminInput->c_number) || empty($adminRaw->adminInput->c_category)){

		$reason = 'incomplete';

		$status = 400;

		$error = 'null';

		$message = 'incomplete data';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;
	}
	// {
	// 	adminInput:{
	// 		c_number: 'c_number'
	// 		c_category: 'c_category'
	// 	}
	// }

	$branch->c_number = $encrypt->encryptData($adminRaw->adminInput->c_number, $adminiv);
	$branch->c_category = $encrypt->encryptData($adminRaw->adminInput->c_category, $adminiv);
	$branch->salt = base64_encode($adminiv);
	$bindData = $adminRaw->adminInput->c_number . $adminRaw->adminInput->c_category;
	$branch->computed_hash = $encrypt->dataHashing($bindData, $adminiv);

	if(!($stmt = $branch->createContact())){

		$reason = 'forbidden';

		$status = 400;

		$error = 'query';

		$message = 'forbidden';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;
	}

	//success
	$reason = 'success';

	$status = 200;

	$error = 'none';

	$message = 'Succesfully added';

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






