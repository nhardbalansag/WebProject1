<style type="text/css">

	/*desktop view*/
	@media screen and (min-width: 700px) {  

		.image{
			width: 50%;
			border-radius: 10px;
		}
	}

	/*mobile view*/
	@media screen and (max-width: 700px) {  

		.image{
			width: 100%;
			border-radius: 10px;
		}
	}
}
	
</style>

<div id="content">

			<div class="informations">
			<a href=

				<?php 
					echo "support_controlPage.php?aslpAccount=" . base64_encode('supportViewAllDocumentsOfOneCustomer'); 
				?> 
				>

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

			<div style="text-align: center;">
				<p id="result"></p>
				<p style="font-size: 20px;">customer documents</p>
			</div>
		<div class="informations">
				<div style="text-align: center;">
					<p style="color:black; font-weight: bolder; font-size: 25px;" id="docstatus"></p>
					<p style="font-size: 20px; font-weight: lighter" id="type"></p>
					<div id="imagediv">
						<p id="filename"></p>
					</div>
				</div>

				<form method="post" id="formdata">
					<div style="text-align: center;">
						<select class="inputmobile" id="categoryType" style="width: 84%; " required>
							<option>select document status</option>
							<option value="V" style="color: blue">valid</option>
							<option value="A" style="color: yellowgreen">approved</option>
							<option value="INV" style="color: red">invalid</option>
							<option value="P" style="color: gray">pending</option>
						</select>
					</div>
					<div style="text-align: center;">
						<textarea  id="message" style="resize: none;  font-size: 20px;  width: 90%; border-radius: 5px;" rows="15" required></textarea>
					</div>
					<div class="informations" style="text-align: center">
						<button id="sendCustomerMessage" class="coloredButton" style=" width: 30%; height: 50px;" >
							send 
						<span>
							<i  class="fas fa-angle-right" style="font-size: 20px; color: white;"></i>
						</span>
						</button>
					</div>
				</form>
		</div>
			
		</div>

<script type="text/javascript">

	var APIgetOneDocumentInformationOfCustomerAccount = '../../../api/creator/documents/getOneDocumentInformationOfCustomerAccount.php';
	var APIgetupdateDocumentStatus = '../../../api/creator/documents/updateDocumentStatus.php';

	const documentid = window.reference = '<?= $_GET['viewCustomerImage'] ?>';

	var statusdocument =  document.getElementById('categoryType');
	var note =  document.getElementById('message');

	var documenntkeys = documentid.split(".");
	var documentId = documenntkeys[0];
	var customerAccountId = documenntkeys[1];


	document.getElementById('formdata').addEventListener('submit', event=>{
		event.preventDefault();
		getupdateDocumentStatus();
	});

	var label =  document.getElementById('result');
	var type = document.getElementById('type');
	var docstatus = document.getElementById('docstatus');
	var customerMessage = document.getElementById('customerMessage');

	var imageDocument = document.getElementById('imageDocument');

	var filename = document.getElementById('filename');

	var imagediv = document.getElementById('imagediv');

	getOneDocumentInformationOfCustomerAccount(documentId);

	function getOneDocumentInformationOfCustomerAccount(documentId){

		var data = {
			documentInformationID:{
				"id": documentId
			}
		};

		var tojson = JSON.stringify(data);
		callAPIcustomerAccounts(tojson);

	}// end of function

	function getupdateDocumentStatus(){
		var data = {
			update:{
				"status": statusdocument.value,
				"note": note.value,
				"customerId": customerAccountId,
				"documentId": documentId
			}
		};

		var tojson = JSON.stringify(data);
		callAPIgetupdateDocumentStatus(tojson);
	}// end of function

	function callAPIcustomerAccounts(jsonObj) {	

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status == 200) {

	              var data = this.responseText;

	              var res = JSON.parse(data);// respomse of the request

	              	label.innerHTML = res.response.display.message;
	              	// label.innerHTML = data;

					if(res.response.http_response_code === 200 && res.response.reason === 'success'){

						var statusResult;
						label.style.color = 'green';

						type.innerHTML = res.response.result.data[0].documentDateCreated;


						if(res.response.result.data[0].documentStatus === 'P'){

							statusResult = 'pending';
							docstatus.style.color = 'gray';

						}else if(res.response.result.data[0].documentStatus === 'INV'){

							statusResult = 'invalid';
							docstatus.style.color = 'red';
						                 
						}else if(res.response.result.data[0].documentStatus === 'V'){

							// greenDots_two.style.backgroundColor = 'yellowgreen';
							statusResult = 'valid';
							docstatus.style.color = 'green';

						}else if(res.response.result.data[0].documentStatus === 'A'){

							// greenDots_two.style.backgroundColor = 'yellowgreen';
							statusResult = 'approved';
							docstatus.style.color = 'green';

						}else{

							// greenDots_two.style.backgroundColor = 'yellowgreen';
							statusResult = 'error';
							docstatus.style.color = 'red';

						}

						docstatus.innerHTML = statusResult;

						var img  = document.createElement('img');

						img.setAttribute('src', '../pics/'+res.response.result.data[0].documentImage);
						img.setAttribute('class', 'image');

						imagediv.appendChild(img);

						filename.innerHTML = res.response.result.data[0].documentImage;
					}
	           }
	       }
	   };

		request.open("POST", APIgetOneDocumentInformationOfCustomerAccount, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(jsonObj);
	}// end of the function


	function callAPIgetupdateDocumentStatus(jsonObj) {	

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status == 200) {

	              var data = this.responseText;
	              
	              var res = JSON.parse(data);// respomse of the request

					if(res.response.http_response_code === 200 && res.response.reason === 'success'){

						label.style.color = 'green';

						label.innerHTML = res.response.display.message[0];

						var stat = document.getElementById('categoryType').value;

						if(stat === 'P'){

							statusResult = 'pending';
							docstatus.style.color = 'gray';

						}else if(stat === 'INV'){

							statusResult = 'invalid';
							docstatus.style.color = 'red';
						                 
						}else if(stat === 'V'){

							// greenDots_two.style.backgroundColor = 'yellowgreen';
							statusResult = 'valid';
							docstatus.style.color = 'green';

						}else if(stat === 'A'){

							// greenDots_two.style.backgroundColor = 'yellowgreen';
							statusResult = 'approved';
							docstatus.style.color = 'green';

						}else{

							// greenDots_two.style.backgroundColor = 'yellowgreen';
							statusResult = 'error';
							docstatus.style.color = 'red';

						}

						docstatus.innerHTML = statusResult;
						note.value  = null;

					}
	           }
	       }
	   };

		request.open("POST", APIgetupdateDocumentStatus, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(jsonObj);
	}// end of the function
	
</script>