<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/transaction/createTransaction.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/Transaction.php');

	include_once ('../../../obj/product.php');

	include_once ('../../../obj/penalty.php');

	

	$errors = array();

	$mes = array();

	$db = new Database();
	$connection = $db->connection();
	$transaction = new Transaction($connection);
	$product = new Products($connection);
	$penalty = new Penalty($connection);

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		goto errorReport;
	}

	$raw = json_decode($userData);

		// 	adminInput:{
				// payment: payment.value,
				// previousBalance: previousBalance,
				// purchaseID: purchaseID,
				// CustomerId: CustomerId,
				// status: status.value
		// 	}
		// }

	if(	
		empty($raw->adminInput->payment) ||
		empty($raw->adminInput->previousBalance) ||
		empty($raw->adminInput->purchaseID) ||
		empty($raw->adminInput->CustomerId) ||
		empty($raw->adminInput->status)
	){
		goto errorReport;
	}

	$encrypt = new Encryption();
	$transactionIv = $encrypt->ivData();

	/////////////////////////////////////////////////////////////////process

	// previous balance is the product price
	$balance = $raw->adminInput->previousBalance;

	//downpayment and the total payment amount
	$payment = $raw->adminInput->payment;

	$currentBalance = (int)((int)$balance - (int)$payment);

	////////////////////////////////////////////////////////////////end of process

	$transaction->ti_date = date('y-m-d h:i:s');
	$transaction->ti_dateUpdated = date('y-m-d');
	$transaction->ti_previousBalance = (int)$balance;
	$transaction->ti_paidAmount = (int)$payment;
	$transaction->ti_status = $raw->adminInput->status;
	$transaction->ti_totalPaidAmount = (int)$payment;
	$transaction->ti_currentBalance = (int)$currentBalance;
	$transaction->aci_id = (int)$raw->adminInput->CustomerId;
	$transaction->pi_id = (int)$raw->adminInput->purchaseID;
	$transaction->salt = base64_encode($transactionIv);

	$bindata = 	date('y-m-d h:i:s') . 
				date('y-m-d') . 
				$balance . 
				$payment . 
				 $raw->adminInput->status . 
				$payment . 
				$currentBalance . 
				$raw->adminInput->CustomerId . 
				$raw->adminInput->purchaseID;

	$datahash = $encrypt->dataHashing($bindata, $transactionIv);
	$transaction->computed_hash = $datahash;

	if(!($stmt = $transaction->createTransaction())){
		
		goto errorReport;
	}

	//////////////////////////////////read transaction
	$transaction->computed_hash = $datahash;

	if(!($stmt = $transaction->readOneTranscsaction())){

		$reason = 'failed';
		$status = 200;
		goto endResult;
		
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		$reason = 'failed';
		$status = 200;
		goto endResult;
	}

	$encrypt = new Encryption();

	$stmtdata = $stmt->fetch(PDO::FETCH_ASSOC);

	$key = base64_decode($stmtdata['salt']);

	$data = array(
		'ti_id' => $stmtdata['ti_id'],
		'status' => $raw->adminInput->status,
		'currentBalance' => $currentBalance
	);
	array_push($mes, $data);

	$reason = 'success';
	$status = 200;
	$error = 'none';
	array_push($errors, $error);
	goto endResult;

	errorReport:

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






