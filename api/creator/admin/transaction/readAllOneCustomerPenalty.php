<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/transaction/readAllOneCustomerPenalty.php
	session_start();

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/Transaction.php');

	$errors = array();

	$mes = array();

	$db = new Database();
	$connection = $db->connection();
	$transaction = new Transaction($connection);

	$userData = file_get_contents('php://input');

	if(empty($userData)){
		goto errorReport;
	}

	$raw = json_decode($userData);

		// 	adminInput:{
				// reference: payment.value,
		// 	}
		// }

	if(	
		empty($raw->adminInput->reference) 
	){
		goto errorReport;
	}

	$transaction->computed_hash = $raw->adminInput->reference;

	if(!($stmt = $transaction->readAllOneCustomerPenalty())){
		goto errorReport;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	$encrypt = new Encryption();

	$transactionIv = $encrypt->ivData();

	while($stmtdata = $stmt->fetch(PDO::FETCH_ASSOC)){

		$data = array(
			'penalty' => array(
				'datecreated' => $stmtdata['datecreated'],
				'balance' => $stmtdata['balance']
			)
		);

		array_push($mes, $data);
	}

	//success
	$reason = 'success';
	$status = 200;
	$error = 'none';
	array_push($errors, $error);
	goto endResult;

	errorReport:
		$reason = 'failed';
		$status = 400;
		$error = 'get';
		$message = 'unable to read data';
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
						'result' => $mes
					)
				)
			)
		);

		echo  $apiResult;






