<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/transaction/readAllCustomer.php
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

	if(!($stmt = $transaction->readAllCustomer())){

		$reason = 'failed';
		$status = 200;
		goto endResult;
		
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		$reason = 'no added customer';
		$status = 200;
		goto endResult;
	}

	$encrypt = new Encryption();

	while($stmtdata = $stmt->fetch(PDO::FETCH_ASSOC)){

		$customerKey = base64_decode($stmtdata['customer_salt']);
		$purchaseKey = base64_decode($stmtdata['purchase_salt']);

		$data = array(

			'customer' => array(
				'customer_aci_id' => $stmtdata['customer_aci_id'],
				'customer_aci_dateCreated' => $stmtdata['customer_aci_dateCreated'],
				'customer_aci_dateModified' => $stmtdata['customer_aci_dateModified'],
				'customer_ca_id' => $stmtdata['customer_ca_id'],
				'customer_aci_firstName' => $encrypt->decryptData($stmtdata['customer_aci_firstName'], $customerKey),
				'customer_aci_lastName' => $encrypt->decryptData($stmtdata['customer_aci_lastName'], $customerKey),
				'customer_aci_middleName' => $encrypt->decryptData($stmtdata['customer_aci_middleName'], $customerKey),
				'customer_aci_address' => $encrypt->decryptData($stmtdata['customer_aci_address'], $customerKey),
				'customer_aci_billingAddress' => $encrypt->decryptData($stmtdata['customer_aci_billingAddress'], $customerKey),
				'customer_aci_emailAddress' => $encrypt->decryptData($stmtdata['customer_aci_emailAddress'], $customerKey),
				'customer_computed_hash' => $stmtdata['customer_computed_hash']
			),
			'account' => array(
				'account_ca_id' => $stmtdata['account_ca_id'],
				'account_ca_date_created' => $stmtdata['account_ca_date_created']
			),
			'purchase' => array(
				'purchase_pi_id' => $stmtdata['purchase_pi_id'],
				'purchase_aci_id' => $stmtdata['purchase_aci_id'],
				'purchase_cp_id' => $stmtdata['purchase_cp_id'],
				'purchase_pi_date' => $stmtdata['purchase_pi_date'],
				'purchase_pi_purchaseType' => $encrypt->decryptData($stmtdata['purchase_pi_purchaseType'], $purchaseKey),
				'purchase_computed_hash' => $stmtdata['purchase_computed_hash']
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






