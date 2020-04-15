<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/api/branchInformation/readEmails.php
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

	if($countRef < 0){

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

	//success
	$reason = 'link reports';

	$status = 200;

	$error = 'none';

	array_push($errors, $error);

	if(!($linkstmt = $branch->displayAllEmails())){

		$reason = 'no added email';
		$status = 200;
		goto endResult;
		
	}

	$count = $linkstmt->rowCount();

	if($count <= 0){

		$reason = 'no added email';
		$status = 200;
		goto endResult;
	}

	$encrypt = new Encryption();

	while($linkdata = $linkstmt->fetch(PDO::FETCH_ASSOC)){

		$emailKey = base64_decode($linkdata['salt']);

		$emailDataResult = array(

			'e_address' => $encrypt->decryptData($linkdata['e_address'], $emailKey),
			'e_description' => $encrypt->decryptData($linkdata['e_description'], $emailKey)

		);

		array_push($mes, $emailDataResult);

	}

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






