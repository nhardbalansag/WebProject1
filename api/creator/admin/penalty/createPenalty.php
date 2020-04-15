<?php

// localhost/my_projects/yamaha_elective/api/creator/penalty/createPenalty.php

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

	$customer_user->accountId = $userData_raw->penalty->account->adminId;

	if($stmt = $customer_user->verifyAdmin()){

		$count = $stmt->rowCount();

		if($count > 0){

			//data
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$custAccountId = $row['a_id'];

			if($custAccountId == $userData_raw->penalty->account->adminId){

				// real admin
				goto createPenalty;

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


createPenalty:

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	// get the date
	$dateCreated = date("y-m-d");

	// get the amount
	$penaltyAmount = $encrypt->encryptData($userData_raw->penalty->amount, $useriv);

	// get the salt
	$salt = base64_encode($useriv);

	$binddata = $dateCreated . $penaltyAmount;

	//get the hash
	$computedhash = $encrypt->dataHashing($binddata, $useriv);

	$mesage_rawData = json_decode(
		json_encode(
			array(
				'date' => $dateCreated,
				'amount' => $penaltyAmount,
				'security' => array(
					'iv' => $salt,
					'hash' => $computedhash
				)
			)
		)
	);

	if(
		empty($mesage_rawData->date) || 
		empty($mesage_rawData->amount) || 
		empty($mesage_rawData->security->iv) ||
		empty($mesage_rawData->security->hash)
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

		// pass the date
		$penalty->penaltyDate = $mesage_rawData->date;

		// pass amount
		$penalty->penaltyAmount = $mesage_rawData->amount;

		// pass iv
		$penalty->salt = $mesage_rawData->security->iv;

		// pass the hash
		$penalty->hash = $mesage_rawData->security->hash;
		
		//execute the query
		if($penalty->createPenalty()){

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