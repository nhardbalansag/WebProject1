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
				// payment: penaltyPayment.value,
				// totalPenaltyAmount: penaltyTotalBalance.value,
				// balanceReference: balance,
				// transactionReference: transactionReference,
				// status: penaltyBlanceStatus.value
	// 	}
		// }

	///////////////////////////// get transaction id to total penalty balance

	$penalty->computed_hash = $raw->adminInput->transactionReference;

	if(!($stmt = $penalty->getOnePenaltyTransactionInfo())){
		goto errorReport;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	$PenaltyTransactionData = $stmt->fetch(PDO::FETCH_ASSOC);

	$penalty_transaction_id = (int)$PenaltyTransactionData['penalty_transaction_id']; // penalty principapl id 			

	/////////////////////////////////////////////////// create payment to penalty balance

	$payment = (int)$raw->adminInput->payment;
	$totalBalance = (int)$raw->adminInput->totalPenaltyAmount;

	$balance = (int)($totalBalance - $payment); // new result for update

	$status = $raw->adminInput->status;

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	$penalty->date_created = date('y-m-d h:i:s'); // payment
	$penalty->payment = (int)$payment; // penalty amount
	$penalty->payment_status = (int)$status; // penalty balance
	$penalty->penalty_transaction_id = $penalty_transaction_id; // penalty satatus

	$penalty->salt = $salt = base64_encode($useriv);

	$dataToHash = 
					$penalty->date_created . 
					$penalty->payment . 
					$penalty->payment_status . 
					$penalty->penalty_transaction_id;

	$Paymentcomputedhash = $encrypt->dataHashing($dataToHash, $useriv);

	$penalty->computed_hash = $Paymentcomputedhash;

	if(!($stmt = $penalty->createPaymentToBalance())){
		goto errorReport;
	}

	///////////////////////////update the current balance

	$penaltyIv = $encrypt->ivData();

	$penalty->reference = $raw->adminInput->balanceReference;

	$penalty->balance = (int)$balance; // total balance data

	$penalty->salt = $salt = base64_encode($penaltyIv);

	$dataToHash = $penalty->balance;

	$Balancecomputedhash = $encrypt->dataHashing($dataToHash, $penaltyIv);

	$penalty->computed_hash = $Balancecomputedhash;

	if(!($stmt = $penalty->editCurrentBalance())){
		goto errorReport;
	}

	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = $balance;
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






