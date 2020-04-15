<?php

	//http://localhost/my_projects/YAMAHA/formData/page/controlpage.php

	include_once ('includes/Landingpageheader.php');
	include_once ('includes/landingTopNavigation.php');

	$page = 'index';

	if (isset($_GET['p'])) {

		$page = base64_decode($_GET['p']);

	}else if(isset($_GET['specification'])){

		$page = 'specification';

	}else if(isset($_GET['specificationContent'])){
		
		$page = 'specificationContent';
		
	}else if(isset($_GET['features'])){
		
		$page = 'features';
	}else if(isset($_GET['verify'])){
		
		$page = 'verify';
	}

	if($page === 'vInquire'){

		include_once('inquire.php');

	}else if($page ==='register'){

		include_once('register.php');

	}else if($page === 'verify'){

		include_once('setUpCustomerAccount.php');

	}else if($page === 'login'){

		include_once('loginCustomer.php');

	}else if($page === 'specification'){

		include_once('indexViewAllSpecification.php');

	}else if($page === 'specificationContent'){

		include_once('viewAllSpecification.php');

	}else if($page === 'features'){

		include_once('viewAllFeatures.php');

	}else if($page === 'logout'){

		if(
			isset($_SESSION['firstname']) ||
			isset($_SESSION['middlename']) ||
			isset($_SESSION['lastname']) ||
			isset($_SESSION['accountID']) ||
			isset($_SESSION['informationID'])||
			isset($_SESSION['sessionID'])
		){

			session_unset();
			session_destroy();
			session_write_close();

		}
		
		include_once('loginCustomer.php');

	}
	else{

		include_once('../../index.php');
		
	}

	include_once('includes/landingFooterpage.php');
	