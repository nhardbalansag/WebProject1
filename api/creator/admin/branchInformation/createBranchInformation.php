<script type="text/javascript"></script>


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

	if(	empty($adminRaw->adminInput->bi_name) || 
		empty($adminRaw->adminInput->bi_street) ||
		empty($adminRaw->adminInput->bi_city_municipality) ||
		empty($adminRaw->adminInput->bi_buildingNumber) ||
		empty($adminRaw->adminInput->bi_about)){

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
	// 		bi_name: 'c_number',
	// 		bi_street: 'bi_street',
	// 		bi_city_municipality: 'bi_city_municipality',
	// 		bi_buildingNumber: 'bi_buildingNumber',
	// 		bi_about: 'bi_about'
	// 	}
	// }

	if(!($linkstmt = $branch->branch_information())){

		$reason = 'failed loading data';

		$status = 400;

		$message = 'cannot create';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;
		
	}

	$count = $linkstmt->rowCount();

	if($count > 0){

		$reason = 'existing';

		$status = 200;

		$error = 'query';

		$message = 'unable to add another information';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}
	
	$branch->bi_name = $encrypt->encryptData($adminRaw->adminInput->bi_name, $adminiv);
	$branch->bi_street = $encrypt->encryptData($adminRaw->adminInput->bi_street, $adminiv);
	$branch->bi_city_municipality = $encrypt->encryptData($adminRaw->adminInput->bi_city_municipality, $adminiv);
	$branch->bi_buildingNumber = $encrypt->encryptData($adminRaw->adminInput->bi_buildingNumber, $adminiv);
	$branch->bi_about = $encrypt->encryptData($adminRaw->adminInput->bi_about, $adminiv);
	$branch->salt = base64_encode($adminiv);

	$bindData = $adminRaw->adminInput->bi_name . 
				$adminRaw->adminInput->bi_street .
				$adminRaw->adminInput->bi_city_municipality .
				$adminRaw->adminInput->bi_buildingNumber .
				$adminRaw->adminInput->bi_about;

	$branch->computed_hash = $encrypt->dataHashing($bindData, $adminiv);

	if(!($stmt = $branch->CreateBranchInformation())){

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






