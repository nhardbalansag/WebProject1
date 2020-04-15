<?php

// localhost/my_projects/yamaha_elective/api/creator/documents/createDocumentCategory.php

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
		goto errorResult;
	}

	$userData_raw = json_decode($userData);

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	// get the inputs

	// adminInput:{
		// 	categoryname: categoryname.value,
		// 	categoryDescription: categoryDescription.value
	// }

	$docsCategoryType = $encrypt->encryptData($userData_raw->adminInput->categoryname, $useriv);
	$docsDescription = $encrypt->encryptData($userData_raw->adminInput->categoryDescription, $useriv);
	$docsCategoryDateCreated = date("Y-m-d");
	$binddata = 
				$userData_raw->adminInput->categoryname . 
				$userData_raw->adminInput->categoryDescription . 
				$docsCategoryDateCreated;
	$computedhash = $encrypt->dataHashing($binddata, $useriv);
	$salt = base64_encode($useriv);

	//create
	$documents = new Documents($connection);
	// get the tittle
	$documents->categoryType = $docsCategoryType;
	// get the description
	$documents->description = $docsDescription;
	// get the iv
	$documents->salt = $salt;
	// get the date
	$documents->date = $docsCategoryDateCreated;
	// get the hash
	$documents->hash = $computedhash;
	
	//execute the query
	if(!($documents->createDocumentCategory())){
		goto errorResult;
	}

	$message = array(
		'datecreated' => $docsCategoryDateCreated,
		'tittle' => $userData_raw->adminInput->categoryname
	);

	array_push($mes, $message);

	$reason = 'success';
	$status = 200;
	goto endResult;

	errorResult:

		$reason = 'failed';
		$status = 400;
		$error = 'failed';
		$message = 'cannot create, try again';

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