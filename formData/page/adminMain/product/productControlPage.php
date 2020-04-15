<?php

	session_start();
	
	include_once('adminMainIncludes/header.php');

	if (isset($_GET['product'])) {

		$page = base64_decode($_GET['product']);

	}else if(isset($_GET['productCreate'])){

		$page = 'CreatedProductInformation';
		
	}else if(isset($_GET['viewAllFeatures'])){ // you can refer to it on the created product information

		$page = 'viewAllFeatures';
		
	}else if(isset($_GET['productSpecificationCategory'])){ // you can refer to it on the created product information

		$page = 'productSpecificationCategory';
		
	}else if(isset($_GET['viewAndAddFeatures'])){ // you can refer to it on the created product information

		$page = 'viewAndAddFeatures';
		
	}else if(isset($_GET['viewAndAddSpecification'])){ // you can refer to it on the created product information

		$page = 'viewAndAddSpecification';
		
	}else if(isset($_GET['viewAndAddColor'])){ // you can refer to it on the created product information

		$page = 'viewAndAddColor';
		
	}else if(isset($_GET['editProduct'])){ // you can refer to it on the created product information

		$page = 'editProduct';
		
	}else if(isset($_GET['editFeature'])){ // you can refer to it on the created product information

		$page = 'editFeature';
		
	}else if(isset($_GET['viewallSpecificationCategory'])){ // you can refer to it on the created product information

		$page = 'viewAllSpecification';
		
	}else if(isset($_GET['editSpecification'])){ // you can refer to it on the created product information

		$page = 'editSpecification';
		
	}else if(isset($_GET['viewAllColors'])){ // you can refer to it on the created product information

		$page = 'viewAllColors';
		
	}else if(isset($_GET['editColor'])){ // you can refer to it on the created product information

		$page = 'editColor';
		
	}else{

		$page = 'productIndex';

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

		case strtolower('productIndex'):
			
			include_once('productIndex.php');
			break;

		case strtolower('manageProduct'):
			
			include_once('manageProduct.php');
			break;

		case strtolower('addProduct'):
			
			include_once('addProduct.php');
			break;

		case strtolower('pendingProduct'):
			
			include_once('pendingProduct.php');
			break;

		case strtolower('CreatedProductInformation'):
			
			include_once('CreatedProductInformation.php');
			break;

		case strtolower('createdProducts'):
			
			include_once('createdProducts.php');
			break;

		case strtolower('viewAllFeatures'):
			
			include_once('viewAllFeatures.php');
			break;

		case strtolower('viewAndAddFeatures'):
			
			include_once('viewAndAddFeatures.php');
			break;

		case strtolower('productSpecificationCategory'):
			
			include_once('productSpecificationCategory.php');
			break;

		case strtolower('viewAndAddSpecification'):
			
			include_once('viewAndAddSpecification.php');
			break;

		case strtolower('viewAndAddColor'):
			
			include_once('viewAndAddColor.php');
			break;

		case strtolower('viewAllColors'):
			
			include_once('viewAllColors.php');
			break;

		case strtolower('viewAndAddProductCategoryType'):
			
			include_once('viewAndAddProductCategoryType.php');
			break;

		case strtolower('viewAllProductCategory'):
			
			include_once('viewAllProductCategory.php');
			break;

		case strtolower('editProduct'):
			
			include_once('editProduct.php');
			break;

		case strtolower('editFeature'):
			
			include_once('editFeature.php');
			break;

		case strtolower('viewAllSpecification'):
			
			include_once('viewAllSpecification.php');
			break;

		case strtolower('editSpecification'):
			
			include_once('editSpecification.php');
			break;

		case strtolower('editColor'):
			
			include_once('editColor.php');
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