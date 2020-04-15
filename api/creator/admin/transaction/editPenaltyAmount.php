<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/transaction/createPenaltyAmount.php

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
		goto errorResult;
	}

	$raw = json_decode($userData);

		// 	adminInput:{
				// penalty: penalty.value,
				// status: status.value
		// 	}
		// }

	$encrypt = new Encryption();
	$useriv = $encrypt->ivData();

	$transaction->penalty_status = $raw->adminInput->status;
	$transaction->penalty_amount = $encrypt->encryptData($raw->adminInput->penalty, $useriv);
	$transaction->salt = base64_encode($useriv);

	$bindata = 	$transaction->penalty_date . 
				$transaction->penalty_status . 
				$transaction->penalty_amount;

	$datahash = $encrypt->dataHashing($bindata, $useriv);
	$transaction->computed_hash = $datahash;
	$transaction->reference = $raw->adminInput->reference;

	if(!$transaction->updatePenaltyAmount()){
		goto errorResult;
	}
	
	$reason = 'success';
	$status = 200;
	$error = null;
	$result = array(
		'penalty_amount' => $raw->adminInput->penalty,
		'penalty_status' => $transaction->penalty_status
	);
	array_push($errors, $error);
	array_push($mes, $result);

	goto endResult;

	errorResult:
		$reason = 'failed';
		$status = 400;
		$error = 'post';
		$message = 'cannot create';
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
						'result' => $mes

					)

				)

			)

		);

		echo  $apiResult;






