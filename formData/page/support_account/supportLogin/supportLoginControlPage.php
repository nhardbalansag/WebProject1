<?php

	//http://localhost/my_projects/YAMAHA/formData/page/controlpage.php

	include_once ('includes/Landingpageheader.php');
	include_once ('includes/landingTopNavigation.php');

	$page = 'index';

	if (isset($_GET['aslp'])) {
		# code...

		$page = base64_decode($_GET['aslp']);
	}

	if($page === 'adminsupportlogin'){

		include_once('supportLoginPage.php');

	}else if($page === 'adminsupportverify'){

		include_once('supportVerify.php');

	}else if($page === 'adminsupportregisteraccount'){

		include_once('supportRegister.php');

	}else{

		include_once('supportLoginPage.php');
		
	}

	include_once('includes/landingFooterpage.php');
	