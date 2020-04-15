 <?php

	
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/Transaction.php');

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

				// purchaseType: purchaseType.value,
				// productReference: computed_hash
				
				// productPrice: productPrice.value,
				// downpayment: downpayment.value,
		// 	}
		// }

	$encrypt = new Encryption();
	$customerIV = $encrypt->ivData();

	////////////////////////////////////////////////////////////////////////create customer information

	$transaction->aci_dateCreated = date('y-m-d');
	$transaction->aci_dateModified = date('y-m-d');
	$transaction->aci_firstName = $encrypt->encryptData($raw->adminInput->firstname, $customerIV);
	$transaction->aci_lastName = $encrypt->encryptData($raw->adminInput->lastname, $customerIV);
	$transaction->aci_middleName = $encrypt->encryptData($raw->adminInput->middlename, $customerIV);
	$transaction->aci_address = $encrypt->encryptData($raw->adminInput->customerAddress, $customerIV);
	$transaction->aci_billingAddress = $encrypt->encryptData($raw->adminInput->customerBillingAddress, $customerIV);
	$transaction->aci_emailAddress = $encrypt->encryptData($raw->adminInput->emailAddress, $customerIV);
	$transaction->ca_id = $raw->adminInput->customerAccounts;
	$transaction->salt = base64_encode($customerIV);

	$bindata = 	date('y-m-d') . 
				date('y-m-d') . 
				$raw->adminInput->firstname . 
				$raw->adminInput->lastname . 
				$raw->adminInput->middlename . 
				$raw->adminInput->customerAddress . 
				$raw->adminInput->customerBillingAddress . 
				$raw->adminInput->emailAddress . 
				$raw->adminInput->customerAccounts;

	$customerDataHash = $encrypt->dataHashing($bindata, $customerIV);
	$transaction->computed_hash = $customerDataHash;

	if(!($transaction->createAvailedCustomerInformation())){

		$reason = "dito yung errror";
		$status = 400;
		$error = 'post';
		$message = 'cannot create';
		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;
	}

	///////////////////////////////////////////////////////////////////////////end create customer information


	//////////////////////////////////////////////////////////////////////////create product purchase

	$product->hash = $raw->adminInput->productReference;

	if(!($stmt = $product->readOneProduct())){

		goto errorReport;
		
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorReport;
	}

	$encrypt = new Encryption();

	$stmtdata = $stmt->fetch(PDO::FETCH_ASSOC);

	$inputDb = json_decode(
		json_encode(
			array(
				'p_id' => $stmtdata['p_id']
			)
		)
	);

	$transaction->p_id = $inputDb->p_id;

	if(!($stmt = $transaction->readOneCreatedProduct())){

		goto errorReport;
		
	}

	$count = $stmt->rowCount();

	if($count <= 0){

		goto errorReport;
	}

	$createdProductData = $stmt->fetch(PDO::FETCH_ASSOC);

	$createdProductJson = json_decode(
		json_encode(
			array(
				'createdProductId' => $createdProductData['createdProductId']
			)
		)
	);

	$transaction->computed_hash = $customerDataHash;

	if(!($customer_stmt = $transaction->readOneAvailedCustomer())){

		goto errorReport;
		
	}

	$count = $customer_stmt->rowCount();

	if($count <= 0){

		goto errorReport;
	}

	$CustomerStmtdata = $customer_stmt->fetch(PDO::FETCH_ASSOC);

	$customerData = json_decode(
		json_encode(
			array(
				'availedCustomerID' => $CustomerStmtdata['aci_id']
			)
		)
	);

	$purchase = $encrypt->ivData();

	$transaction->pi_date = date('y-m-d');
	$transaction->pi_purchaseType = $encrypt->encryptData($raw->adminInput->purchaseType, $purchase);
	$transaction->cp_id = $createdProductJson->createdProductId;
	$transaction->aci_id = $customerData->availedCustomerID;
	$transaction->salt = base64_encode($purchase);

	$bindata = 	date('y-m-d') . 
				$raw->adminInput->purchaseType . 
				$customerData->availedCustomerID . 
				$createdProductJson->createdProductId;

	$purchaseDataHash = $encrypt->dataHashing($bindata, $purchase);
	$transaction->computed_hash = $purchaseDataHash;

	if(!($stmt = $transaction->createPurchaseInformation())){

		goto errorReport;
	}

	////////////////////////////////////////////////////////////////////////end create product purchase

	/////////////////////////////////////////////////////////////////////// create transaction information

	// $purchaseDataHash // this is the purchase reference hash for getting the purchase id

	$transaction->computed_hash = $purchaseDataHash;

	if(!($purchase_stmt = $transaction->readOnePurchase())){

		goto errorReport;
		
	}

	$count = $purchase_stmt->rowCount();

	if($count <= 0){

		goto errorReport;
	}
	
	$PurchaseStmtdata = $purchase_stmt->fetch(PDO::FETCH_ASSOC);

	$customerAndPurchaseData = json_decode(
		json_encode(
			array(
				'purchaseId' => $PurchaseStmtdata['pi_id'],
				'availedCustomerID' => $customerData->availedCustomerID
			)
		)
	);

	// previous balance is the product price
	$balance = $raw->adminInput->productPrice;

	//downpayment and the total payment amount
	$payment = $raw->adminInput->downpayment;

	$currentBalance = (int)((int)$balance - (int)$payment);

	$transactionStatus = "ontime";

	$transaction->ti_date = date('y-m-d h:i:s');
	$transaction->ti_dateUpdated = date('y-m-d');
	$transaction->ti_previousBalance = $balance;
	$transaction->ti_paidAmount = $payment;
	$transaction->ti_status = $transactionStatus;
	$transaction->ti_totalPaidAmount = $payment;
	$transaction->ti_currentBalance = $currentBalance;
	$transaction->aci_id = $customerAndPurchaseData->availedCustomerID;
	$transaction->pi_id = $customerAndPurchaseData->purchaseId;
	$transaction->salt = base64_encode($customerIV);

	$bindata = 	date('y-m-d h:i:s') . 
				date('y-m-d') . 
				$balance . 
				$payment . 
				$transactionStatus . 
				$payment . 
				$currentBalance . 
				$customerAndPurchaseData->availedCustomerID . 
				$customerAndPurchaseData->purchaseId;

	$datahash = $encrypt->dataHashing($bindata, $customerIV);
	$transaction->computed_hash = $datahash;

	if(!($stmt = $transaction->createTransaction())){
		
		goto errorReport;
	}

	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = $purchaseDataHash;
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







