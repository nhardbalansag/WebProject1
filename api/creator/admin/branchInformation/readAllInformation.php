<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/api/branchInformation/readAllInformation.php
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

	$contactArray = array();
	$linkArray = array();
	$emailArray = array();
	$branchArray = array();

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
	$reason = 'success';

	$status = 200;

	if(!($contact = $branch->displayAllContacts())){

		$reason = 'no added Contacts';
		$status = 200;

		$error = 'contact';
		array_push($errors, $error);
		
	}

	$count = $contact->rowCount();

	if($count <= 0){

		$reason = 'no added Contacts';
		$status = 200;

		$error = 'null';
		array_push($errors, $error);
	}

	if(!($email = $branch->displayAllEmails())){

		$reason = 'no added email';
		$status = 200;
		$error = 'email';
		array_push($errors, $error);
		
	}

	$count = $email->rowCount();

	if($count <= 0){

		$reason = 'no added email';
		$status = 200;
		$error = 'null';
		array_push($errors, $error);
	}

	if(!($linkstmt = $branch->displayAllLinks())){

		$reason = 'no added link';
		$status = 200;
		$error = 'link';
		array_push($errors, $error);
		
	}

	$count = $linkstmt->rowCount();

	if($count <= 0){

		$reason = 'no added link';
		$status = 200;
		$error = 'null';
		array_push($errors, $error);

	}

	if(!($branchInfo = $branch->branch_information())){

		$reason = 'no added branch information';
		$status = 200;
		$error = 'null';
		array_push($errors, $error);
		
	}

	$count = $branchInfo->rowCount();

	if($count <= 0){

		$reason = 'no added branch information';
		$status = 200;
		$error = 'null';
		array_push($errors, $error);
	}

	$encrypt = new Encryption();

	while($contactData = $contact->fetch(PDO::FETCH_ASSOC)){

		$contactKey = base64_decode($contactData['salt']);

		$contactDataResult = array(

			'c_number' => $encrypt->decryptData($contactData['c_number'], $contactKey),
			'c_category' => $encrypt->decryptData($contactData['c_category'], $contactKey)

		);

		array_push($contactArray, $contactDataResult);

	}

	while($emailData = $email->fetch(PDO::FETCH_ASSOC)){

		$emailKey = base64_decode($emailData['salt']);

		$emailDataResult = array(

			'e_address' => $encrypt->decryptData($emailData['e_address'], $emailKey),
			'e_description' => $encrypt->decryptData($emailData['e_description'], $emailKey)

		);

		array_push($emailArray, $emailDataResult);

	}

	while($linkdata = $linkstmt->fetch(PDO::FETCH_ASSOC)){

		$linkKey = base64_decode($linkdata['salt']);

		$linksDataResult = array(

			'l_address' => $encrypt->decryptData($linkdata['l_address'], $linkKey),
			'l_description' => $encrypt->decryptData($linkdata['l_description'], $linkKey)

		);

		array_push($linkArray, $linksDataResult);

	}

	$fetchBranchData = $branchInfo->fetch(PDO::FETCH_ASSOC);

	$branchInfoKey = base64_decode($fetchBranchData['salt']);

	$branchinfo = array(

		'bi_name' => $encrypt->decryptData($fetchBranchData['bi_name'], $branchInfoKey),
		'bi_street' => $encrypt->decryptData($fetchBranchData['bi_street'], $branchInfoKey),
		'bi_city_municipality' => $encrypt->decryptData($fetchBranchData['bi_city_municipality'], $branchInfoKey),
		'bi_buildingNumber' => $encrypt->decryptData($fetchBranchData['bi_buildingNumber'], $branchInfoKey),
		'bi_about' => $encrypt->decryptData($fetchBranchData['bi_about'], $branchInfoKey)
	);

	array_push($branchArray, $branchinfo);

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
						'contact' => $contactArray,
						'link' => $linkArray,
						'email' => $emailArray,
						'branch' => $branchArray
					)

				)

			)

		);

		echo  $apiResult;



