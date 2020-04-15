<?php

// localhost/my_projects/yamaha_elective/api/creator/purchase/createPurchaseInformation.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	include_once ('../../obj/Purchase.php');

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

	$customer_user->accountId = $userData_raw->purchaseInformation->account->adminId;

	if($stmt = $customer_user->verifyAdmin()){

		$count = $stmt->rowCount();

		if($count > 0){

			//data
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$custAccountId = $row['a_id'];

			if($custAccountId == $userData_raw->purchaseInformation->account->adminId){

				// real admin
				goto createAvailedCustomerInformation;

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

createAvailedCustomerInformation:

	$encrypt = new Encryption();

	$iv = $encrypt->ivData();

	// get the first name
	$firstName = $encrypt->encryptData($userData_raw->purchaseInformation->AvailedCustomerInformation->firstName, $iv);

	// get the last name
	$lastName = $encrypt->encryptData($userData_raw->purchaseInformation->AvailedCustomerInformation->lastName, $iv);

	// get the middle name
	$middleName = $encrypt->encryptData($userData_raw->purchaseInformation->AvailedCustomerInformation->middleName, $iv);

	// get the address
	$address = $encrypt->encryptData($userData_raw->purchaseInformation->AvailedCustomerInformation->address, $iv);

	// get the billing address
	$billingAddress = $encrypt->encryptData($userData_raw->purchaseInformation->AvailedCustomerInformation->billingAddress, $iv);

	// get the email address
	$emailAddress = $encrypt->encryptData($userData_raw->purchaseInformation->AvailedCustomerInformation->emailAddress, $iv);

	$dataToHash = $firstName . $lastName . $middleName . $address . $billingAddress . $emailAddress;

	$hash = $encrypt->dataHashing($dataToHash, $iv);

	$useriv = base64_encode($iv);

	$rawData = json_decode(
		json_encode(
			array(
				'firstName' => $firstName,
				'lastName' => $lastName,
				'middleName' => $middleName,
				'address' => $address,
				'billingAddress' => $billingAddress,
				'emailAddress' => $emailAddress,
				'security' => array(
					'iv' => $useriv,
					'hash' => $hash
				)
			)
		)
	);

	if(
		empty($rawData->firstName) ||
		empty($rawData->lastName) ||
		empty($rawData->middleName) ||
		empty($rawData->address) ||
		empty($rawData->billingAddress) ||
		empty($rawData->emailAddress) ||
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
		$Purchase = new Purchase($connection);

		// pass the number
		$Purchase->firstName = $rawData->firstName;

		// pass the number
		$Purchase->lastName = $rawData->lastName;

		// pass the number
		$Purchase->middleName = $rawData->middleName;

		// pass the number
		$Purchase->address = $rawData->address;

		// pass the number
		$Purchase->billingAddress = $rawData->billingAddress;

		// pass the category id
		$Purchase->emailAddress = $rawData->emailAddress;

		// pass iv
		$Purchase->salt = $rawData->security->iv;

		// pass hash
		$Purchase->hash = $rawData->security->hash;
		
		//execute the query
		if($Purchase->createAvailedCustomerInformation()){

			// go to query to get the availed customer id and information
			goto getId;

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


getId:

	$Purchase->hash = $rawData->security->hash;

	if($stmt = $Purchase->getAvailedCustomerId()){

		$count = $stmt->rowCount();

		// success query
		if($count > 0){

			//data
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// availed customer information id
			$custAccountId = $row['aci_id'];

			goto createPurchase;
			
		}else{

			// no data
			$reason = 'no data';

			$status = 400;

			$error = 'empty';

			$message = 'no data';

			array_push($errors, $error);

			array_push($mes, $message);

			goto endResult;

		}

	}else{

		// failed query
		$reason = 'failed';

		$status = 400;

		$error = 'query';

		$message = 'failed';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

createPurchase:

	$purchaseiv = $encrypt->ivData();

	// get the date
	$date = date("y-m-d");

	// get the last name
	$purchaseType = $userData_raw->purchaseInformation->purchase->purchaseType;

	// get the availed customer account id
	$availedCustomerAccountId = $custAccountId;

	// get the product Id
	$productId = $userData_raw->purchaseInformation->purchase->keys->productId;

	$dataToHash = $purchaseType . $availedCustomerAccountId . $productId;

	$hash = $encrypt->dataHashing($dataToHash, $purchaseiv);

	$useriv = base64_encode($purchaseiv);

	$rawData = json_decode(
		json_encode(
			array(
				'date' => $date,
				'purchaseType' => $purchaseType,
				'availedCustomerAccountId' => $availedCustomerAccountId,
				'productId' => $productId,
				'security' => array(
					'iv' => $useriv,
					'hash' => $hash
				)
			)
		)
	);

	if(
		empty($rawData->date) ||
		empty($rawData->purchaseType) ||
		empty($rawData->availedCustomerAccountId) ||
		empty($rawData->productId) ||
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
		$Purchase = new Purchase($connection);

		// pass the date
		$Purchase->dateCreated = $rawData->date;

		// pass the purchase type
		$Purchase->purchaseType = $rawData->purchaseType;

		// pass the availed customer id
		$Purchase->availedCustomerId = $rawData->availedCustomerAccountId;

		// pass the product id
		$Purchase->productId = $rawData->productId;

		// pass iv
		$Purchase->salt = $rawData->security->iv;

		// pass hash
		$Purchase->hash = $rawData->security->hash;
		
		//execute the query
		if($Purchase->createPurchaseInformation()){

			// success
			$reason = 'success';

			$status = 200;

			$error = 'none';

			$message = 'purchase succesfully';

			array_push($errors, $error);

			array_push($mes, $message);

			goto endResult;

			// go to query to get the availed customer id and information

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

