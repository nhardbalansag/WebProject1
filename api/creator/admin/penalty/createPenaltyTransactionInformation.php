<?php

// localhost/my_projects/yamaha_elective/api/creator/penalty/createPenaltyTransactionInformation.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	include_once ('../../obj/penalty.php');

	$errors = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

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

	$userData_raw = json_decode($userData);

	$customer_user = new User($connection);

	$customer_user->accountId = $userData_raw->penaltyTransactionInformation->account->adminId;

	if($stmt = $customer_user->verifyAdmin()){

		$count = $stmt->rowCount();

		if($count > 0){

			//data
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$custAccountId = $row['a_id'];

			if($custAccountId == $userData_raw->penaltyTransactionInformation->account->adminId){

				// real admin
				goto createTransaction;

			}else{

				//not an admin

				$reason = 'forbidden';

				$status = 400;

				$error = 'security';

				$message = 'not exist';

				array_push($errors, $error);

				array_push($mes, $message);

				goto endResult;
			}


		}else{

			//no data
			$reason = 'forbidden';

			$status = 400;

			$error = 'security';

			$message = 'not exist';

			array_push($errors, $error);

			array_push($mes, $message);

			goto endResult;
		}


	}else{

		$reason = 'forbidden';

		$status = 400;

		$error = 'query';

		$message = 'forbidden';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}


createTransaction:

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	// get the date
	$dateCreated = date("y-m-d");

	// get previous balance
	$status = $encrypt->encryptData($userData_raw->penaltyTransactionInformation->status, $useriv);

	// get the paided amount
	$paidedAmount = $encrypt->encryptData($userData_raw->penaltyTransactionInformation->paidedAmount, $useriv);

	// get the previous balance
	$totalPreviousBalance = $encrypt->encryptData($userData_raw->penaltyTransactionInformation->totalPreviousBalance, $useriv);

	// get the current balance
	$totalCurrentBalance = $encrypt->encryptData($userData_raw->penaltyTransactionInformation->totalCurrentBalance, $useriv);

	// get the total paided
	$totalPaided = $encrypt->encryptData($userData_raw->penaltyTransactionInformation->totalPaided, $useriv);

	// get the penalty id
	$penaltyId =$userData_raw->penaltyTransactionInformation->keys->penaltyId;

	// get the transaction information id
	$transactionInformationId = $userData_raw->penaltyTransactionInformation->keys->transactionInformationId;
	
	// get the salt
	$salt = base64_encode($useriv);

	$binddata = $dateCreated . $status . $paidedAmount . $totalPreviousBalance . $totalCurrentBalance . $totalPaided . $penaltyId . $transactionInformationId;

	//get the hash
	$computedhash = $encrypt->dataHashing($binddata, $useriv);

	$rawData = json_decode(
		json_encode(
			array(
				'dateCreated' => $dateCreated,
				'status' => $status,
				'paidedAmount' => $paidedAmount,
				'totalPreviousBalance' => $totalPreviousBalance,
				'totalCurrentBalance' => $totalCurrentBalance,
				'totalPaided' => $totalPaided,
				'penaltyId' => $penaltyId,
				'transactionInformationId' => $transactionInformationId,
				'security' => array(
					'iv' => $salt,
					'hash' => $computedhash
				)
			)
		)
	);

	if(
		empty($rawData->dateCreated) || 
		empty($rawData->status) || 
		empty($rawData->paidedAmount) || 
		empty($rawData->totalPreviousBalance) || 
		empty($rawData->totalCurrentBalance) || 
		empty($rawData->totalPaided) || 
		empty($rawData->penaltyId) || 
		empty($rawData->transactionInformationId) || 
		empty($rawData->security->iv) ||
		empty($rawData->security->hash)
	){

		// do not create
		$reason = 'incomplete';

		$status = 400;

		$error = 'incomplete';

		$message = 'incomplete data';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}else{

		//create
		$penalty = new Penalty($connection);

		// pass the date created
		$penalty->penaltyDate = $rawData->dateCreated;

		// pass previous balance
		$penalty->status = $rawData->status;

		// pass paid amount
		$penalty->paidedAmount = $rawData->paidedAmount;

		// pass status
		$penalty->totalPreviousBalance = $rawData->totalPreviousBalance;

		// pass total paid amount
		$penalty->totalCurrentBalance = $rawData->totalCurrentBalance;

		// pass current balance
		$penalty->totalPaided = $rawData->totalPaided;

		// pass purchase information id
		$penalty->penaltyId = $rawData->penaltyId;

		// pass customer account
		$penalty->transactionInformationId = $rawData->transactionInformationId;

		// pass iv
		$penalty->salt = $rawData->security->iv;

		// pass the hash
		$penalty->hash = $rawData->security->hash;
		
		//execute the query
		if($penalty->createPenaltyTransactionInformation()){

			// success
			$reason = 'success';

			$status = 200;

			$error = 'none';

			$message = 'Succesfully added';

			array_push($errors, $error);

			array_push($mes, $message);

			goto endResult;

		}else{

			$reason = 'failed';

			$status = 400;

			$error = 'query';

			$message = 'cannot add';

			array_push($errors, $error);

			array_push($mes, $message);

			goto endResult;

		}

	}

	endResult:

	$result_array = array($mes, $reason, $status, $errors);

	for ($i = 0; $i < count($result_array); $i++) { 
		# code...
		if(empty($result_array[$i])){

			$result_array[$i] = null;

		}

	}

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