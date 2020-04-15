<?php

// localhost/my_projects/YAMAHA/api/creator/documents/getOneDocumentInformationOfCustomerAccount.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/documents.php');

	$des = array();

	$errors = array();

	$res = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$Documents = new Documents($connection);

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	$raw = json_decode($userData);

	$Documents->documentId = $raw->documentInformationID->id;

	if($stmt = $Documents->viewDocument()){

		$count = $stmt->rowCount();

		if($count > 0){

			//data
			if($data = $stmt->fetch(PDO::FETCH_ASSOC)){

				$documentKey = base64_decode($data['documentKey']);

				$result = array(

					"documentImage" => $data['documentImage'],
					"documentStatus" => $data['documentStatus'],
					"documentDateCreated" => $data['documentDateCreated']

				);

				$reason = 'success';

				$status = 200;

				$error = 'none';

				$message = 'document information of the customer';

				array_push($errors, $error);

				array_push($mes, $message);

				array_push($res, $result);

				goto endResult;

			}else{

				$reason = 'no data';

				$status = 200;

				$error = 'none';

				$message = 'no data';

				array_push($errors, $error);

				array_push($mes, $message);

				goto endResult;

			}

		}else{
			// no data

			$reason = 'no data';

			$status = 200;

			$error = 'none';

			$message = 'no data';

			array_push($errors, $error);

			array_push($mes, $message);

			goto endResult;
		}

	}else{

		//error
		$reason = 'no data';

		$status = 200;

		$error = 'query';

		$message = 'no data';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

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

				),
				'result' => array(
					'data' => $res
				)

			)

		)

	);

	echo  $apiResult;