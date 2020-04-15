<?php

	include_once ('customer_includes/header.php');

	$page = 'index';

	if (isset($_GET['cp'])) {
		# code...

		$page = base64_decode($_GET['cp']);

	}else if(isset($_GET['customerAccountAdminReply'])){

		$page = 'customerAccountAdminReply';

	}else if(isset($_GET['Resubmit'])){

		$page = 'resubmitDocuments';

	}else if(isset($_GET['customerInfo'])){

		$page = 'viewCustomerInformation';

	}

	if (

		isset($_SESSION['firstname']) &&
		isset($_SESSION['middlename']) &&
		isset($_SESSION['lastname']) &&
		isset($_SESSION['accountID']) &&
		isset($_SESSION['informationID'])&&
		isset($_SESSION['sessionID'])

	){

		if($page === 'vInquire'){

			include_once('inquire.php');

		}else if($page === 'index'){

			include_once('index.php');
			
		}else if($page === 'customerinbox'){

			include_once('inbox.php');

		}else if($page === 'send_documents'){

			include_once('sendDocuments.php');

		}else if($page === 'document_verification'){

			include_once('documentVerification.php');

		}else if($page === 'checkApproval'){

			include_once('checkApproval.php');

		}else if($page === 'sendMessage'){

			include_once('sendMessage.php');

		}else if($page === 'resubmitDocuments'){

			include_once('resubmitDocument.php');

		}else if($page === 'view_Message'){

			include_once('viewMessage.php');

		}else if($page === 'viewCustomerInformation'){

			include_once('displayCustomerInformation.php');

		}else if($page === 'editCustomerInformation'){

			include_once('editCustomerInformation.php');

		}else if($page = 'customerAccountAdminReply'){

			include_once('viewMessage.php');

		}else{

			include_once('index.php');
			
		}


		
		
	}else{

		header('location: ../controlpage.php');
	}

	

	include_once('customer_includes/footer.php');

	?>


	<script type="text/javascript">
		var products = document.getElementById('products');
		products.addEventListener('click', function(){
			clickProd++;
			console.log(clickProd);
			if(clickProd == 1){
				product_miniDrop.style.display = 'block';
			}else if(clickProd == 2){
				product_miniDrop.style.display = 'none';
				clickProd = 0;
			}
		});
	</script>

