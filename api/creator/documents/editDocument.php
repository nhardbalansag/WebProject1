<?php

// localhost/my_projects/YAMAHA/api/creator/documents/createDocument.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	include_once ('../../obj/documents.php');

	$errors = array();
	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$userData = file_get_contents('php://input');

	if(empty($userData)){
		goto errorReport;
	}

	$userData_raw = json_decode($userData);

	$customer_user = new User($connection);

	// input:{
	// 	image: filename,
	// 	status: "P",
	// 	categoryId: select.value,
	// 	AccountId: accountreference
	// }

	// $customer_user->accountId = $_SESSION['accountID'];
	$customer_user->accountId = $userData_raw->input->AccountId;

	if(!($stmt = $customer_user->verifyCustomerAccount())){
		goto errorReport;
	}

	$count = $stmt->rowCount();

	if($count <= 0){
		
		goto errorReport;
	}

	//data
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$custAccountId = $row['ca_id'];

	if($custAccountId !== $userData_raw->input->AccountId){
		goto errorReport;
	}

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	// get the image
	$docsimage = $userData_raw->input->image;
	// get the status
	$docsStatus= $userData_raw->input->status;
	// get the date
	$docsDateCreated = date("Y-m-d");
	// get the category type id
	$docsCategoryId = $userData_raw->input->categoryId;
	//get the account id
	$accountId = $userData_raw->input->AccountId;

	$binddata = $docsimage . $docsStatus . $docsDateCreated . $docsCategoryId . $accountId;
	//get the hash
	$computedhash = $encrypt->dataHashing($binddata, $useriv);
	// get the user iv
	$salt = base64_encode($useriv);

		//create
	$document = new Documents($connection);
	// pass the image
	$document->image = $docsimage;
	// pass the status
	$document->status = $docsStatus;
	// pass the document category id
	$document->docsId = $docsCategoryId;
	// pass the account id
	$document->accountId = $accountId;
	// pass the date
	$document->date = $docsDateCreated;
	// pass the user iv
	$document->salt = $salt;
	// pass the hash
	$document->hash = $computedhash;
	//reference
	$document->reference = $userData_raw->input->documentreference;
	
	//execute the query
	if(!($document->editDocument())){
		goto errorReport;
	}

	// success
	$reason = 'success';
	$status = 200;
	$error = 'none';
	$message = 'document Succesfully edited';

	array_push($errors, $error);

	array_push($mes, $message);

	goto endResult;

	errorReport:

		$reason = 'null';
		$status = 400;
		$error = 'no data';
		$message = 'cannot send!';

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
					'message' => $mes
				)
			)
		)
	);

	echo  $apiResult;