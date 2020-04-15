<style type="text/css">
	.divres{
		display: flex; 
		justify-content: space-between; 
		align-items: center;
		border-bottom: 1px solid red;
	}

	.divone{
		width: 100%; 
		text-align: center;
	}

</style>

<div id="content">
		<div class="informations">
			<a href=

				<?php 

					echo "customerControlPage.php?cp=" . base64_encode('index');

				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>
		<div class="informations" style="text-align: center;">
			<p id="statusReport"></p>
			<p style=" font-size: 30px;">Verification</p>
		</div>
		<div class="informations">
			<div style="display: flex; justify-content: space-around; align-items: center;">
				<div class="status" style="background-color: yellowgreen">
					<p >2</p>
				</div>
			</div>
			<div id="contentDocument">
				
			</div>
			<div id="contentContainer">
				<div style="text-align: center;">
					<p >
						<span id="total" style="color:yellowgreen; font-weight: bolder"></span>
						
						<span id="totalDocument" style="font-weight: bolder;"></span>
					</p>
				</div>
			</div>
		</div>

<script type="text/javascript">

var APIgeusersDocument = '../../../api/creator/documents/readUserDocuments.php';

var statusReport = document.getElementById('statusReport');
var contentDocument = document.getElementById('contentDocument');
var total =document.getElementById('total');	
var totalDocument =document.getElementById('totalDocument');
var contentContainer = document.getElementById('contentContainer');	

var validCount = 0;

getlinkData();

function getlinkData(){
	var data = {
		userInput:{
			reference: window.reference = '<?=  $_SESSION['accountID'] ?>'
		}
	}
	var tojson = JSON.stringify(data);
	callAPIgeusersDocument(tojson);
}// dn of the function

function callAPIgeusersDocument(tojson) {
   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4
            if (request.status === 200) {
				var data = this.responseText;
				var res = JSON.parse(data);// respomse of the request
				if(res.response.http_response_code == 200 && res.response.reason == 'success'){
					//data here
					var statusResult;
					var count = res.response.result.documentInformation.length;
					statusReport.style.color = 'yellowgreen';
					statusReport.innerHTML = 'you have sended ' + count + ' documents';

					for (var i = 0; i < count;  i++) {

						var documentDiv = document.createElement('div');
						documentDiv.setAttribute('class', 'prodPartial');
						// documentDiv.href = 'customerControlPage.php?Resubmit=' + res.response.result.documentInformation[i].hash;

						var products_content = document.createElement('div');
						products_content.setAttribute('id', 'products_content');

						var tittle  = document.createElement('p');
						var description  = document.createElement('p');
						var status  = document.createElement('p');

						tittle.style.color = 'rgb(10,15,42)';
						tittle.style.fontWeight = 'bold';
						tittle.innerHTML = res.response.result.categoryInformation[i].categoryTittle;

						description.style.fontSize = '15px';
						description.style.textTransform = 'uppercase';

						status.style.fontSize = '20px';

						if(res.response.result.documentInformation[i].status === 'P'){

						statusResult = 'pending';
						status.style.color = 'gray';

						}else if(res.response.result.documentInformation[i].status === 'INV'){

							var linkToEdit = document.createElement('a');
							linkToEdit.href = 'customerControlPage.php?Resubmit=' + res.response.result.documentInformation[i].hash;
							linkToEdit.innerHTML = "click here to resend";

							products_content.appendChild(linkToEdit);

						statusResult = 'invalid';
						status.style.color = 'red';

						var firstdiv = document.createElement('div');
						firstdiv.setAttribute('class', 'divres');

						var firstdivone = document.createElement('div');
						firstdivone.setAttribute('class', 'divone');
						var tittleinvalid = document.createElement('p');
						tittleinvalid.style.color = 'red';
						tittleinvalid.innerHTML = res.response.result.categoryInformation[i].categoryTittle;

						var nameinvalid = document.createElement('p');
						nameinvalid.style.color = 'red';
						nameinvalid.innerHTML = res.response.result.documentInformation[i].image;

						firstdivone.appendChild(tittleinvalid);
						firstdivone.appendChild(nameinvalid);

						description.style.color = 'red';
						description.innerHTML = res.response.result.documentInformation[i].docsnote;

						firstdiv.appendChild(firstdivone);
						contentContainer.appendChild(firstdiv);
						 
						}else if(res.response.result.documentInformation[i].status === 'V'){

						// greenDots_two.style.backgroundColor = 'yellowgreen';
						statusResult = 'valid';
						status.style.color = 'green';
						validCount++;

						}else if(res.response.result.documentInformation[i].status === 'A'){

						// greenDots_two.style.backgroundColor = 'yellowgreen';
						statusResult = 'approved';
						status.style.color = 'green';

						}else{

						// greenDots_two.style.backgroundColor = 'yellowgreen';
						statusResult = 'error';
						status.style.color = 'red';

						}

						status.innerHTML = statusResult;

						products_content.appendChild(tittle);
						products_content.appendChild(description);
						products_content.appendChild(status);

						documentDiv.appendChild(products_content);

						contentDocument.appendChild(documentDiv);
					}

					total.innerHTML = validCount;
					totalDocument.innerHTML = ' / ' + count;
              }
           }
       }
   };

	request.open("POST", APIgeusersDocument, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}
</script>