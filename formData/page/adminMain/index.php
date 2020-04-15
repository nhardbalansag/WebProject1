<?php
	
	session_start();
	
	include_once('adminMainIncludes/header.php');

	if (isset($_GET['admin'])) {

		$page = base64_decode($_GET['admin']);

	}else{

		$page = 'index';

	}

	if(
		!isset($_SESSION['MAIN_adminInfo_firstname']) &&
		!isset($_SESSION['MAIN_adminInfo_middlename']) &&
		!isset($_SESSION['MAIN_adminInfo_lastname']) &&
		!isset($_SESSION['MAIN_account_id']) &&
		!isset($_SESSION['MAIN_adminInfo_admin_id'])&&
		!isset($_SESSION['MAIN_adminsessionID']) &&
		!isset($_SESSION['MAIN_account_role'])
	){
		// not admin
		header('location: ../support_account/supportLogin/supportLoginControlPage.php');
	}

	switch (strtolower($page)) {
		case strtolower('index'):

			include_once('indexPage.php');
			break;

		case strtolower('personalInfo'):

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

			header('location: ../support_account/supportLogin/supportLoginControlPage.php');
			break;
		
		default:

			include_once('indexPage.php');
			break;
	}
	
	include_once('adminMainIncludes/footer.php');

?>