<div id="content">

			<div class="informations">
			<a href=

				<?php 
					echo "support_controlPage.php?aslpAccount=" . base64_encode('supportViewOneCustomerAccount'); 
				?> 
				>

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

			<div style="text-align: center;">
				<p style="font-size: 20px;">customer documents</p>
				<p id="testingResult"></p>
			</div>
		<div id="documentDiv">

		
		</div>

			<a style="margin-top: 5%;">
				<button style="font-size: 20px; padding: 5px; width: 100%; background-color: rgb(236, 244, 252); border:none">load More.. <i  class="fas fa-angle-down" style="font-size: 20px; color: black;"></i></button>
			</a>
		</div>

<script type="text/javascript">
	var APIgetDocumentsOfOneCustomerAccount = '../../../api/creator/documents/getDocumentsOfOneCustomerAccount.php';

	var testingResult =  document.getElementById('testingResult');

	getDocumentsOfOneCustomerAccount();

	function getDocumentsOfOneCustomerAccount(){

		var customerAccountReference = window.referenceid = '<?= $_SESSION['customerAccountPersonalInformationID'] ?>';
		var data = {
			customerAccount:{
				customerAccountReference: customerAccountReference
			}
		};

		var tojson = JSON.stringify(data);

		callAPIgetDocumentsOfOneCustomerAccount(tojson);

	}// end of function


	function callAPIgetDocumentsOfOneCustomerAccount(jsonObj) {	

		var request = new XMLHttpRequest();

		request.onreadystatechange = function() {

			if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

				if (request.status == 200) {

					var data = this.responseText;
					var res = JSON.parse(data);
					var documentDiv = document.getElementById('documentDiv');
					if(res.response.http_response_code === 200 && res.response.reason === 'success'){

						testingResult.style.color = 'green';

						for(var i = 0; i <  res.response.result.data.length; i++){

							var firstDiv = document.createElement('div');

							firstDiv.style.width = '90%';
							firstDiv.style.margin = 'auto';
							firstDiv.style.backgroundColor = 'rgb(211, 228, 245)';
							firstDiv.style.padding = '10px';
							firstDiv.style.borderRadius = '5px';
							firstDiv.style.marginBottom = '10px';
							firstDiv.style.textAlign = 'center';

							var documentType = document.createElement('p');

							documentType.color = 'black';
							documentType.fontWeight = 'bolder';
							documentType.fontSize = '25px';
							documentType.innerHTML = res.response.result.data[i].documentCategoryName;

							var dateCreated = document.createElement('p');

							dateCreated.fontSize = '20px';
							dateCreated.fontWeight = 'lighter';
							dateCreated.innerHTML = res.response.result.data[i].documentDateCreated;

							var fileLocation = document.createElement('p');
							fileLocation.innerHTML = res.response.result.data[i].documentImage;

							var linkToImage = document.createElement('a');

							linkToImage.href = 'support_controlPage.php?viewCustomerImage=' + res.response.result.data[i].documentId + "." + res.response.result.data[i].customerAccountId;

							firstDiv.appendChild(documentType);
							firstDiv.appendChild(dateCreated);
							firstDiv.appendChild(fileLocation);

							linkToImage.appendChild(firstDiv);

							documentDiv.appendChild(linkToImage);
						}
					}
				}
			}
		};

		request.open("POST", APIgetDocumentsOfOneCustomerAccount, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(jsonObj);
	}// end of the function

</script>