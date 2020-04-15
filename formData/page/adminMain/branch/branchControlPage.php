<?php

	session_start();
	
	include_once('adminMainIncludes/header.php');

	if (isset($_GET['branch'])) {

		$page = base64_decode($_GET['branch']);

	}else if (isset($_GET['edit'])) {

		$page = 'editDocumentCategory';

	}else{

		$page = 'index';

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

		case strtolower('index'):
			
			include_once('branchInformation.php');
			break;

		case strtolower('editBranchInformation'):
		
			include_once('editBranchInformation.php');
			break;

		case strtolower('viewAndAddContact'):
		
			include_once('viewAndAddContact.php');
			break;

		case strtolower('viewAndAddEmail'):
		
			include_once('viewAndAddEmail.php');
			break;
		
		case strtolower('viewAndAddLink'):
		
			include_once('viewAndAddLink.php');
			break;

		case strtolower('createDocumentCategory'):
		
			include_once('createDocumentCategory.php');
			break;
			
		case strtolower('editDocumentCategory'):
		
			include_once('editDocumentCategory.php');
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

			include_once('branchInformation.php');
			break;

	}// end of the switch

	include_once('adminMainIncludes/footer.php');

?>