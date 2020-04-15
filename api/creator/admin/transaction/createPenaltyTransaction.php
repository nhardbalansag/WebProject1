<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/transaction/createPenaltyTransaction.php

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
				// payment: previousBalance,
				// penaltyAmount: previousBalance,
				// status: purchaseID,
				// transactionID: payment.value
		// 	}
		// }

	///////////////////////////// create penalty principal payment

	$payment = (int)$raw->adminInput->payment;
	$amount = (int)$raw->adminInput->penaltyAmount;

	$balance = (int)($amount - $payment);

	$status = $raw->adminInput->status;

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	$penalty->payment = (int)$payment; // payment
	$penalty->penaltyAmount = (int)$amount; // penalty amount
	$penalty->balance = (int)$balance; // penalty balance
	$penalty->payment_status = $status; // penalty satatus

	$penalty->salt = $salt = base64_encode($useriv);

	$dataToHash = 
					$payment . 
					$amount . 
					$balance . 
					$status;

	$Principalcomputedhash = $encrypt->dataHashing($dataToHash, $useriv);

	$penalty->computed_hash = $Principalcomputedhash;

	if(!($stmt = $penalty->createPenaltyPayment())){
		goto errorReport;
	}

	//////////////////////// end create principal penalty payment

	/////////////////////// create the total balance penalty

	if(!($stmt = $penalty->getTotalPenaltyBalance())){
		goto errorReport;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	$balanceData = $stmt->fetch(PDO::FETCH_ASSOC);

	$penalty->balance = (int)$balanceData['totalBalance']; // total balance data minus the payment amount

	$penaltyIv = $encrypt->ivData();

	$penalty->salt = $salt = base64_encode($penaltyIv);

	$dataToHash = $balanceData['totalBalance'];

	$Balancecomputedhash = $encrypt->dataHashing($dataToHash, $penaltyIv);

	$penalty->computed_hash = $Balancecomputedhash;

	if(!($stmt = $penalty->createPenaltyTotalBalance())){
		goto errorReport;
	}

	///////////////////////// end create penalty balance

	//////////////////////// create penalty transaction

	/*
	* get the id of principal payment through its hash
	*/

	$penalty->computed_hash = $Principalcomputedhash;

	if(!($stmt = $penalty->getPrincipalpaymentInfo())){
		goto errorReport;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	$principalPenaltyData = $stmt->fetch(PDO::FETCH_ASSOC);

	$principalPenaltyId = (int)$principalPenaltyData['penalty_payment_id']; // penalty principapl id 

	/*
	* get the id of balance through its hash 
	*/

	$penalty->computed_hash = $Balancecomputedhash;

	if(!($stmt = $penalty->getBalanceInfo())){
		goto errorReport;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	$principalPenaltyData = $stmt->fetch(PDO::FETCH_ASSOC);

	$BalanceId = (int)$principalPenaltyData['penalty_balance_id']; // total balance id 
	$Balance = (int)$principalPenaltyData['balance']; // total balance id 

	/////////////////////////////////////////////////// get the total of balance payment


	if(!($totalPayment_stmt = $penalty->penaltyBalanceTotalPayment())){
		goto errorReport;
	}

	$count = $totalPayment_stmt->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	$TotalPaymentBalance = $totalPayment_stmt->fetch(PDO::FETCH_ASSOC);

	$totalPaymentToBalance = (int)$TotalPaymentBalance['totalPaymentBalance']; // total payment in balance

	/////////////////////////////////////////////////// end		

	/////////////////////////process

	$Balance = $Balance - $totalPaymentToBalance;

	/////////////////////////////end


	$dateCreated = date('y-m-d h:i:s');

	$balancePaymentIv = $encrypt->ivData();

	$penalty->date_created = $dateCreated; 
	$penalty->date_updated = $dateCreated; 
	$penalty->ti_id = (int)$raw->adminInput->transactionID; // transaction id
	$penalty->penalty_payment_id = (int)$principalPenaltyId; // principal penalty id
	$penalty->penalty_balance_id = (int)$BalanceId; 
	$penalty->salt = base64_encode($balancePaymentIv);

	$dataToHash = 
					$penalty->date_created . 
					$penalty->date_updated . 
					$penalty->ti_id . 
					$penalty->penalty_payment_id . 
					$penalty->penalty_balance_id;

	$transactioncomputedhash = $encrypt->dataHashing($dataToHash, $balancePaymentIv);

	$penalty->computed_hash = $transactioncomputedhash;

	if(!($stmt = $penalty->createPenaltyTransaction())){
		goto errorReport;
	}

	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = array(
		'totalCurentBalance' => $Balance,
		'balanceReference' => $Balancecomputedhash,
		'transactionReference' => $transactioncomputedhash
	);
	
	array_push($mes, $message);
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






