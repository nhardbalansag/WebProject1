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

	$encrypt = new Encryption();

	if(!($linkstmt = $branch->branch_information())){

		$reason = 'failed loading data';

		$status = 400;

		$message = 'cannot create';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;
		
	}

	$count = $linkstmt->rowCount();

	if($count <= 0){

		$reason = 'null';

		$status = 200;

		$error = 'none';

		$message = 'please add information';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	$reason = 'existing';

	$status = 200;

	$error = 'query';

	$message = 'edit this information';

	array_push($errors, $error);

	array_push($mes, $message);

	$fetchBranchData = $linkstmt->fetch(PDO::FETCH_ASSOC);

	$branchInfoKey = base64_decode($fetchBranchData['salt']);

	$_SESSION['MAIN_computed_hash'] = $fetchBranchData['computed_hash'];

	$info = array(

		'bi_name' => $encrypt->decryptData($fetchBranchData['bi_name'], $branchInfoKey),
		'bi_street' => $encrypt->decryptData($fetchBranchData['bi_street'], $branchInfoKey),
		'bi_city_municipality' => $encrypt->decryptData($fetchBranchData['bi_city_municipality'], $branchInfoKey),
		'bi_buildingNumber' => $encrypt->decryptData($fetchBranchData['bi_buildingNumber'], $branchInfoKey),
		'bi_about' => $encrypt->decryptData($fetchBranchData['bi_about'], $branchInfoKey)
	);

	array_push($mes, $info);

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






