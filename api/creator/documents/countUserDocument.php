<?php

// localhost/my_projects/YAMAHA/api/creator/documents/countUserDocument.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	include_once ('../../obj/documents.php');

	session_start();

	$des = array();

	$errors = array();

	$res = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$documentCategory = new Documents($connection);	

	$encryption = new Encryption();
// $_SESSION['accountID']
	$documentCategory->accountId = $_SESSION['accountID'];

	if($stmt = $documentCategory->countUserDocuments()){

		$count = $stmt->rowCount();

		if($count > 0){

			//data

			while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

				$result = array(

					"status" => $data['d_status'],
					"iv" => $data['d_salt']
						
				);

				$iv = base64_decode($result['iv']);

				$stat = $result['status'];

				array_push($mes, $stat);

			}

			$error = 'none';

			array_push($errors, $error);

			$reason = 'success';

			$status = 200;

			$error = 'none';

			

			goto endResult;

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
					'documentInformation' => $res,
					'categoryInformation' => $des
				)


			)

		)

	);

	echo  $apiResult;