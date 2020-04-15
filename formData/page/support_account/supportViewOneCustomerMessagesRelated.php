<div id="content">
		<div class="informations">
			<a href=

				<?php 
					echo "support_controlPage.php?aslpAccount=" . base64_encode('viewAllMessagesOfOneCustomer'); 
				?> 
				>

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

		<div style="background-color:rgb(236, 244, 252); padding: 10px; border-radius: 10px; margin-bottom: 3%;" class="informations">
			<div style="text-align: center;">
				<p style="color: red; font-size: 20px;" id="result"></p>
			<p style="font-size: 20px">From: <span id="customerName"></span></p>
			<p style=" font-size: 30px;" id="messageType">Messaging</p>
			
			</div>

			<div style="text-align: center; width: 70%; margin:auto;">
				<p id="customerMessage">
					
				</p>
			</div>
		</div>
		<div style="width: 50%; margin: 5% auto; text-align:center;">
			<button class="coloredButton" id="buttonreply">Reply</button>
		</div>

<script type="text/javascript">

	var APIcustomerAccounts = '../../../api/creator/support/getOneMessageOfOneCustomer.php';

	var label =  document.getElementById('result');
	var customerName = document.getElementById('customerName');
	var messageType = document.getElementById('messageType');
	var customerMessage = document.getElementById('customerMessage');

	getInfoId();

	function getInfoId(){

		var data = {
			messageReference:{
				reference: window.reference = '<?= $_GET['CustomerAccountMessages'] ?>'
			}
		};

		var tojson = JSON.stringify(data);

		callAPIcustomerAccounts(tojson);

	}// end of function


	function callAPIcustomerAccounts(jsonObj) {	

		var request = new XMLHttpRequest();

			request.onreadystatechange = function() {

			if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

				if (request.status == 200) {

					var data = this.responseText;

					var res = JSON.parse(data);// respomse of the request

					var type;

					label.innerHTML = res.response.display.message;
					// label.innerHTML = data;

					if(res.response.http_response_code === 200 && res.response.reason === 'success'){

						label.style.color = 'green';
						customerName.innerHTML = res.response.result.data[0].personalInformation.ci_firstname;
						if(res.response.result.data[0].message.messageType == 'CM'){
							type = 'Customer Account Message';
						}
						messageType.innerHTML = type;
						customerMessage.innerHTML = res.response.result.data[0].message.m_message;

						document.getElementById('buttonreply').addEventListener('click', function(){
							window.location.href = "support_controlPage.php?supportSendReplyToCustomerAccountMessage=" + res.response.result.data[0].createdMessage.createdCustomerMessageId;
						});
					}
				}
			}
		};

		request.open("POST", APIcustomerAccounts, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(jsonObj);
	}// end of the function
	
</script>