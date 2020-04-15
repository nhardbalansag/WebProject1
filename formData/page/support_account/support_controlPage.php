<?php
	include_once('supportIncludes/supportHeader.php');
	
	$page = 'index';

	if(isset($_GET['aslpAccount'])) {
		
		$page = base64_decode($_GET['aslpAccount']);

	}else if(isset($_GET['customerInquiries'])){

		$page = 'supportViewOneInquiry';

		$_SESSION['customerInquiryID'] = $_GET['customerInquiries'];

	}else if(isset($_GET['customerAccounts'])){

		$page = 'viewAllMessagesOfOneCustomer';

		$_SESSION['customerAccountPersonalInformationID'] = $_GET['customerAccounts'];

	}else if(isset($_GET['customerAccountInfo'])){

		$page = 'viewAllMessagesOfOneCustomer';
		$_SESSION['customerAccountID'] = $_GET['customerAccountInfo'];

	}else if(isset($_GET['CustomerAccountMessages'])){

		$page = 'supportViewOneCustomerMessagesRelated';

	}else if(isset($_GET['AccountInfo'])){

		$page = 'supportViewOneCustomerAccount';
		$_SESSION['customerAccountPersonalInformationID'] = $_GET['AccountInfo'];

	}else if(isset($_GET['viewCustomerImage'])){

		$page = 'supportViewOneDocumentOfUserAandAddNote';

	}else if(isset($_GET['supportSendReplyToCustomerAccountMessage'])){

		$page = 'supportSendReplyToCustomerAccountMessage';

	}else if(isset($_GET['supportViewAllDocumentsOfOneCustomer'])){

		$page = 'supportViewAllDocumentsOfOneCustomer';

	}else{

		$page === 'adminlogout';
	}

	if(
		isset($_SESSION['adminInfo_firstname']) &&
		isset($_SESSION['adminInfo_middlename']) &&
		isset($_SESSION['adminInfo_lastname']) &&
		isset($_SESSION['account_id']) &&
		isset($_SESSION['account_role'])&&
		isset($_SESSION['adminsessionID'])
	){
		switch (strtolower($page)) {
			case strtolower('viewCustomerAccount'):
				include_once('supportViewCustomerAccounts.php');
				break;

			case strtolower('supportViewOneInquiry'):
				include_once('supportViewOneInquiry.php');
				break;

			case strtolower('supportSendReplyToInquiry'):
				include_once('supportSendReplyToInquiry.php');
				break;

			case strtolower('supportViewOneCustomerAccount'):
				include_once('supportViewOneCustomerAccount.php');
				break;

			case strtolower('supportViewOneCustomerMessagesRelated'):
				include_once('supportViewOneCustomerMessagesRelated.php');
				break;

			case strtolower('supportViewAllDocumentsOfOneCustomer'):
				include_once('supportViewAllDocumentsOfOneCustomer.php');
				break;

			case strtolower('supportViewOneDocumentOfUserAandAddNote'):
				include_once('supportViewOneDocumentOfUserAandAddNote.php');
				break;
			
			case strtolower('viewAllMessagesOfOneCustomer'):
				include_once('viewAllMessagesOfOneCustomer.php');
				break;

			case strtolower('supportAccountInformation'):
				include_once('supportAccountInformation.php');
				break;

			case strtolower('supportEditInformation'):
				include_once('supportEditInformation.php');
				break;

			case strtolower('supportSendReplyToCustomerAccountMessage'):
				include_once('supportSendReplyToCustomerAccountMessage.php');
				break;

			case strtolower('supportViewInquires'):
				include_once('supportViewInquiries.php');
				break;

			case strtolower('index'):
				include_once('supportIndex.php');
				break;

			case strtolower('adminlogout'):
				if(
					isset($_SESSION['adminInfo_firstname']) ||
					isset($_SESSION['adminInfo_middlename']) ||
					isset($_SESSION['adminInfo_lastname']) ||
					isset($_SESSION['account_id']) ||
					isset($_SESSION['account_role'])||
					isset($_SESSION['admininformationID'])||
					isset($_SESSION['adminsessionID']) ||
					isset($_SESSION['adminAccountID']) || // admin account
					isset($_SESSION['customerAccountID']) ||
					isset($_SESSION['customerInquiryID']) ||
					isset($_SESSION['customerAccountPersonalInformationID'])
				){
					// $_SESSION['adminInfo_firstname'] = null;
					// $_SESSION['adminInfo_middlename'] = null;
					// $_SESSION['adminInfo_lastname'] = null;
					// $_SESSION['account_id'] = null;
					// $_SESSION['account_role'] = null;
					// $_SESSION['admininformationID'] = null;
					// $_SESSION['adminsessionID'] = null;
					// $_SESSION['customerAccountID'] = null;
					// $_SESSION['customerInquiryID'] = null;
					// $_SESSION['customerAccountPersonalInformationID'] = null;
					// $_SESSION['adminAccountID'] = null;

					session_unset();
					session_destroy();
					session_write_close();

				}

				header('location: supportLogin/supportLoginControlPage.php');

				break;

			default:
				include_once('supportIndex.php');
				break;
		}// end of switch

	}else{
		header('location: supportLogin/supportLoginControlPage.php');
	}

	




























	include_once('supportIncludes/supportFooter.php');


?>