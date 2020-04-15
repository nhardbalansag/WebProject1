<?php

	session_start();
	
	include_once('adminMainIncludes/header.php');

	if (isset($_GET['transaction'])) {

		$page = base64_decode($_GET['transaction']);

	}else if (isset($_GET['createNewPurchase'])) {

		$page = 'createNewPurchase';

	}else if (isset($_GET['customerTransactionInformation'])) {

		$page = 'customerTransactionInformation';

	}else if (isset($_GET['reviewPurchase'])) {

		$page = 'reviewPurchase';

	}else if (isset($_GET['editcustomerInformation'])) {

		$page = 'editcustomerInformation';

	}else if (isset($_GET['addTransaction'])) {

		$page = 'addTransaction';

	}else if (isset($_GET['editPenaltyAmount'])) {

		$page = 'editPenaltyAmount';

	}else if (isset($_GET['viewOneCustomerTransactions'])) {

		$page = 'viewOneCustomerTransactions';

	}else if (isset($_GET['viewallpenalties'])) {

		$page = 'viewOneCustomerPenalty';

	}else{

		$page = 'transactionIndex';

	}

	if(
		!(isset($_SESSION['MAIN_adminInfo_firstname'])) &&
		!(isset($_SESSION['MAIN_adminInfo_middlename'])) &&
		!(isset($_SESSION['MAIN_adminInfo_lastname'])) &&
		!(isset($_SESSION['MAIN_account_id'])) &&
		!(isset($_SESSION['MAIN_adminInfo_admin_id']))&&
		!(isset($_SESSION['MAIN_adminsessionID']))&&
		!(isset($_SESSION['MAIN_account_hash']))&&
		!(isset($_SESSION['MAIN_account_datecreated']))&&
		!(isset($_SESSION['MAIN_account_role']))
	){

		// not admin
		header('location: ../../support_account/supportLogin/supportLoginControlPage.php');

	}

	if(strtolower($_SESSION['MAIN_account_role']) != strtolower(base64_encode('MADNA'))){

		header('location: ../../support_account/supportLogin/supportLoginControlPage.php');
	}

	//admin
	switch (strtolower($page)) {

		case strtolower('transactionIndex'):
			
			include_once('transactionIndex.php');
			break;

		case strtolower('createNewPurchase'):
			
			include_once('createNewPurchase.php');
			break;

		case strtolower('viewAllProduct'):
			
			include_once('viewAllProduct.php');
			break;

		case strtolower('customerTransactionInformation'):
			
			include_once('customerTransactionInformation.php');
			break;

		case strtolower('reviewPurchase'):
			
			include_once('reviewPurchase.php');
			break;

		case strtolower('editcustomerInformation'):
			
			include_once('editcustomerInformation.php');
			break;

		case strtolower('viewAllAvailedCustomer'):
			
			include_once('viewAllAvailedCustomer.php');
			break;

		case strtolower('addTransaction'):
			
			include_once('addTransaction.php');
			break;

		case strtolower('addPenalty'):
			
			include_once('addPenalty.php');
			break;

		case strtolower('editPenaltyAmount'):
			
			include_once('editPenaltyAmount.php');
			break;

		case strtolower('viewOneCustomerTransactions'):
			
			include_once('viewOneCustomerTransactions.php');
			break;

		case strtolower('viewOneCustomerPenalty'):
			
			include_once('viewOneCustomerPenalty.php');
			break;

		case strtolower('AdminAccountInformation'):
			
			include_once('accountInfo/AdminAccountInformation.php');
			break;

		case strtolower('editAdminPersonalInfo'):
			
			include_once('accountInfo/editAdminPersonalInfo.php');
			break;

		case strtolower('logout'):

			if(
				isset($_SESSION['MAIN_adminInfo_firstname']) ||
				isset($_SESSION['MAIN_adminInfo_middlename']) ||
				isset($_SESSION['MAIN_adminInfo_lastname']) ||
				isset($_SESSION['MAIN_account_id']) ||
				isset($_SESSION['MAIN_adminInfo_admin_id']) ||
				isset($_SESSION['MAIN_adminsessionID']) ||
				isset($_SESSION['MAIN_account_hash']) ||
				isset($_SESSION['MAIN_account_datecreated']) ||
				isset($_SESSION['MAIN_account_role'])
			){
				session_unset();
				session_destroy();
				session_write_close();
			}

			header('location: ../../support_account/supportLogin/supportLoginControlPage.php');
			break;

		default:

			include_once('productIndex.php');
			break;

	}// end of the switch

	include_once('adminMainIncludes/footer.php');

?>

