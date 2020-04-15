<?php

// localhost/my_projects/YAMAHA_PROJECT/api/creator/admin/reports/systemReports.php
	session_start();

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once ('../../../config/database.php');

	include_once ('../../../obj/encryption.php');

	include_once ('../../../obj/report.php');

	$errors = array();

	$mes = array();

	$db = new Database();
	$connection = $db->connection();
	$report = new Reports($connection);

	//////////////////////////////////////////////////////////read total penalty
	if(!($stmt = $report->getTotalPenalty())){
		goto errorReport;
	}
	$penaltyresult = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalPenalty = $penaltyresult['totalPenalty'];
	//////////////////////////////////////////////////////////end total penalty
	//////////////////////////////////////////////////////////read total penalty payment
	if(!($stmt = $report->getTotalPenaltyPayment())){
		goto errorReport;
	}
	$paymentresult = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalPenaltyPayment = $paymentresult['totalPenaltyPayment'];
	//////////////////////////////////////////////////////////end total penalty payment
	//////////////////////////////////////////////////////////read total purchase payment
	if(!($stmt = $report->getTotalPurchasePayment())){
		goto errorReport;
	}
	$purchaseresult = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalpaidAmount = $purchaseresult['totalpaidAmount'];
	//////////////////////////////////////////////////////////end total purchase payment
	//////////////////////////////////////////////////////////read total customer
	if(!($stmt = $report->getTotalCustomer())){
		goto errorReport;
	}
	$customereresult = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalCustomer = $customereresult['totalCustomer'];
	//////////////////////////////////////////////////////////end total customer
	//////////////////////////////////////////////////////////read total inquiries
	if(!($stmt = $report->getTotalInquiries())){
		goto errorReport;
	}
	$inquiriesresult = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalInquiries = $inquiriesresult['totalInquiries'];
	//////////////////////////////////////////////////////////end total inquiries
	//////////////////////////////////////////////////////////read total accounts
	if(!($stmt = $report->getTotalAccounts())){
		goto errorReport;
	}
	$accountsresult = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalAccounts = $accountsresult['totalAccounts'];
	//////////////////////////////////////////////////////////end total accounts
	//////////////////////////////////////////////////////////read total products
	if(!($stmt = $report->getTotalProduct())){
		goto errorReport;
	}
	$productsresult = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalProduct = $productsresult['totalProduct'];
	//////////////////////////////////////////////////////////end total products

	$data = array(
		'report' => array(
			'totalPenalty' => $totalPenalty,
			'totalPenaltyPayment' => $totalPenaltyPayment,
			'totalpaidAmount' => $totalpaidAmount,
			'totalCustomer' => $totalCustomer,
			'totalInquiries' => $totalInquiries,
			'totalAccounts' => $totalAccounts,
			'income' => (int)(((int)$totalPenaltyPayment) + ((int)$totalpaidAmount)),
			'totalProduct' => $totalProduct
		)
	);

	array_push($mes, $data);

	//success
	$reason = 'success';
	$status = 200;
	$error = 'none';
	array_push($errors, $error);
	goto endResult;

	errorReport:
		$reason = 'failed';
		$status = 400;
		$error = 'get';
		$message = 'unable to read data';
		array_push($errors, $error);
		array_push($mes, $message);

		goto endResult;

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






