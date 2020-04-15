<?php

// localhost/my_projects/yamaha_elective/api/creator/product/createServices.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	include_once ('../../obj/product.php');

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

	$customer_user->accountId = $userData_raw->services->account->adminId;

	if($stmt = $customer_user->verifyAdmin()){

		$count = $stmt->rowCount();

		if($count > 0){

			//data
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$custAccountId = $row['a_id'];

			if($custAccountId == $userData_raw->services->account->adminId){

				// real admin
				goto create;

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

create:

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	// get the tittle
	$tittle = $userData_raw->services->tittle;

	// get the description
	$description = $userData_raw->services->description;

	// get the date
	$date = date("y-m-d");

	$dataToHash = $tittle . $description . $date;

	$computedhash = $encrypt->dataHashing($dataToHash, $useriv);

	$useriv = base64_encode($useriv);

	$rawData = json_decode(
		json_encode(
			array(
				'tittle' => $tittle,
				'description' => $description,
				'date' => $date,
				'security' => array(
					'iv' => $useriv,
					'hash' => $computedhash
				)
			)
		)
	);

	if(
		empty($rawData->tittle) ||
		empty($rawData->description) ||
		empty($rawData->date) ||
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
		$Products = new Products($connection);

		// pass the tittle
		$Products->tittle = $rawData->tittle;

		// pass description
		$Products->description = $rawData->description;

		// pass date created
		$Products->dateCreated = $rawData->date;

		// pass iv
		$Products->salt = $rawData->security->iv;

		// pass hash
		$Products->hash = $rawData->security->hash;
		
		//execute the query
		if($Products->create_services()){

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