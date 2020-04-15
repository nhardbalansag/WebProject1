<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/transaction/readTotalPenaltyBalance.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/Transaction.php');

	include_once ('../../../obj/product.php');

	include_once ('../../../obj/penalty.php');

	$errors = array();

	$mes = array();

	$db = new Database();
	$connection = $db->connection();
	$transaction = new Transaction($connection);
	$product = new Products($connection);
	$penalty = new Penalty($connection);

	$userData = file_get_contents('php://input');

	if(empty($userData)){
		goto errorReport;
	}

	$raw = json_decode($userData);

	// {
	// 	adminInput:{
	// 		computed_hash: computed_hash
	// 	}
	// }

	if(empty($raw->adminInput->computed_hash)){
		goto errorReport;
	}

	//////////////////////////////////////////////////////////////////// get the total principal
	$penalty->computed_hash = $raw->adminInput->computed_hash;

	if(!($totalPrincipal = $penalty->totalPrincipal())){
		goto errorReport;
	}

	$count = $totalPrincipal->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	$Totalprincipal = $totalPrincipal->fetch(PDO::FETCH_ASSOC);

	$totalPenaltyPrincipal = (int)$Totalprincipal['totalPenaltyPrincipal']; // total payment in balance
	////////////////////////////////////////////////////////////////////end

	/////////////////////////////////////////////////////////////////// get the total payments
	$penalty->computed_hash = $raw->adminInput->computed_hash;

	if(!($getTotalPenaltyPayment = $penalty->getTotalPenaltyPayment())){
		$reason = 'heillo';
		$status = 400;
		$error = 'post';
		$message = 'cannot create';
		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;
	}

	$count = $getTotalPenaltyPayment->rowCount();

	if($count <= 0){
		goto errorReport;
	}

	$TotalPayment = $getTotalPenaltyPayment->fetch(PDO::FETCH_ASSOC);

	$totalPayment = (int)$TotalPayment['totalPayment']; // total payment in balance
	////////////////////////////////////////////////////////////////// end

	/////////////////////////////////////////////////////////////////process
	$totalPenatyBalance = $totalPenaltyPrincipal - $totalPayment;
	/////////////////////////////////////////////////////////////////end

	$data = array(
		'totalPenaltyBalance' => $totalPenatyBalance
	);
	array_push($mes, $data);

	$reason = 'success';
	$status = 200;
	$error = 'none';
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






