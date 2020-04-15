<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/product/createSpecificationCategory.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/transaction.php');

	include_once ('../../../obj/product.php');

	$errors = array();

	$mes = array();

	$db = new Database();
	$connection = $db->connection();
	$transaction = new Transaction($connection);
	$product = new Products($connection);

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		goto errorReport;
	}

	$raw = json_decode($userData);

		// 	adminInput:{
				// firstname: firstname.value,
				// lastname: lastname.value,
				// middlename: middlename.value,
				// customerAddress: customerAddress.value,
				// customerBillingAddress: customerBillingAddress.value,
				// emailAddress: emailAddress.value,
				// customerAccounts: customerAccounts.value,
				// reference: referencedata
		// 	}
		// }

	$encrypt = new Encryption();
	$customerIV = $encrypt->ivData();

	////////////////////////////////////////////////////////////////////////create customer information

	$transaction->aci_dateModified = date('y-m-d');
	$transaction->aci_firstName = $encrypt->encryptData($raw->adminInput->firstname, $customerIV);
	$transaction->aci_lastName = $encrypt->encryptData($raw->adminInput->lastname, $customerIV);
	$transaction->aci_middleName = $encrypt->encryptData($raw->adminInput->middlename, $customerIV);
	$transaction->aci_address = $encrypt->encryptData($raw->adminInput->customerAddress, $customerIV);
	$transaction->aci_billingAddress = $encrypt->encryptData($raw->adminInput->customerBillingAddress, $customerIV);
	$transaction->aci_emailAddress = $encrypt->encryptData($raw->adminInput->emailAddress, $customerIV);
	$transaction->ca_id = (int)$raw->adminInput->customerAccounts;
	$transaction->salt = base64_encode($customerIV);

	$bindata = 	date('y-m-d') . 
				$raw->adminInput->firstname . 
				$raw->adminInput->lastname . 
				$raw->adminInput->middlename . 
				$raw->adminInput->customerAddress . 
				$raw->adminInput->customerBillingAddress . 
				$raw->adminInput->emailAddress . 
				$raw->adminInput->customerAccounts;

	$customerDataHash = $encrypt->dataHashing($bindata, $customerIV);
	$transaction->computed_hash = $customerDataHash;
	$transaction->reference = $raw->adminInput->reference;

	if(!($stmt = $transaction->updateCustomerInformation())){

		goto errorReport;
	}

	///////////////////////////////////////////////////////////////////////////end create customer information

	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = 'success';
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






