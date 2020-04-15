<?php

// localhost/my_projects/YAMAHA_PROJECT/admin/api/branchInformation/createLinks.php
	

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

	$db = new Database();
	$connection = $db->connection();
	$branch = new branchInformation($connection);

	$adminRaw = json_decode($userData);

	$encrypt = new Encryption();

	$adminiv = $encrypt->ivData();

	if(empty($adminRaw->adminInput->e_address) || empty($adminRaw->adminInput->e_description)){

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
	// 		e_address: e_address,
	// 		e_description: e_description
	// 	}
	// }

	$branch->e_address = $encrypt->encryptData($adminRaw->adminInput->e_address, $adminiv);
	$branch->e_description = $encrypt->encryptData($adminRaw->adminInput->e_description, $adminiv);
	$branch->salt = base64_encode($adminiv);

	$bindData = $adminRaw->adminInput->e_address . $adminRaw->adminInput->e_description;
	$branch->computed_hash = $encrypt->dataHashing($bindData, $adminiv);

	if(!($stmt = $branch->CreateEmail())){

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






