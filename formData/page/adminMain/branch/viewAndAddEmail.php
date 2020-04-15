<div id="mainAdminContents">
	<div id="content" class="content">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "branchControlPage.php?branch=" . base64_encode('index');

					?> >

					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p id="result"></p>
 				<p style="font-size: 20px; font-weight: bolder;">manage emails</p>
	 		</div>
	 		<div style="text-align: center;">
				
					<form method="post" id="formdata">
						<div class="inputmobile adminInputDivs">
							<label>email address</label><br>
							<input class="inputmobile" type="email" id="e_address" placeholder="*Email Address" required><br>
							<input class="inputmobile" type="text" id="e_description" placeholder="*Email Description" required>
						</div>
						<div>
							<button class="adminButton" >
								Add Email
							</button>
						</div>
					</form>
					
			</div>
			<div id="reporting" class="reporting">
 				<p id="resultDisplaying" style="text-align: center;"></p>
			</div>
 		</div>
</div>

 		
 	
 	<script type="text/javascript">

	var createData = '../../../../api/creator/admin/branchInformation/createEmail.php';
	var getDisplay = '../../../../api/creator/admin/branchInformation/readEmails.php';

	var resultDisplaying = document.getElementById('resultDisplaying');
	var result = document.getElementById('result');
	var reporting = document.getElementById('reporting');



	document.getElementById('formdata').addEventListener('submit', event=>{
		evnet.preventDefault();
		getInput();
	});

	AjaxgetDisplay();

	function getInput(){

		var e_address = document.getElementById('e_address');
		var e_description = document.getElementById('e_description');

		if(!e_address.value || !e_description.value){

			e_address.style.borderColor = 'red';
			e_description.style.borderColor = 'red';

		}else{

			var data = {
					adminInput:{
						e_address: e_address.value,
						e_description: e_description.value
					}
				}
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);
		}

		e_address.value = null;
		e_description.value = null;

	}// dn of the function

	function AjaxCreateInput(tojson) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code == 200){

	           			result.style.color = 'yellowgreen';
	           			result.innerHTML = res.response.display.message[0];
	            	}
	           }
	       }
	   };

	request.open("POST", createData, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

	function AjaxgetDisplay() {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request

	            	if(res.response.http_response_code == 200){

	           			var resultCount = res.response.display.message.length;

	           			if(res.response.http_response_code == 200){

	           				resultDisplaying.style.color = 'yellowgreen';
	           				resultDisplaying.innerHTML = res.response.reason;

	           				for(var i  = 0; i < resultCount; i++){

		           				var reportingContent = document.createElement('div'); // main div
		           				reportingContent.setAttribute('class', 'reportingContent');

		           				var contentOne = document.createElement('div'); //first div
		           				var contentOne_p = document.createElement('p');
		           				contentOne_p.setAttribute('class', 'linkNumber');
		           				contentOne_p.innerHTML = i + 1;
		           				contentOne.appendChild(contentOne_p);

		           				var contentTwo = document.createElement('div'); // second div
		           				contentTwo.setAttribute('class', 'linkContent');
		           				var contentTwo_p_one = document.createElement('p');
		           				contentTwo_p_one.innerHTML = res.response.display.message[i].e_address;
		           				var contentTwo_p_two = document.createElement('p');
		           				contentTwo_p_two.setAttribute('class', 'linkDescription');
		           				contentTwo_p_two.innerHTML = res.response.display.message[i].e_description;
		           				contentTwo.appendChild(contentTwo_p_one);
		           				contentTwo.appendChild(contentTwo_p_two);

		           				reportingContent.appendChild(contentOne)
		           				reportingContent.appendChild(contentTwo)

		           				reporting.appendChild(reportingContent);

		           			}// end of the for
	           			}
	            	}
	           }
	       }
	   };

	request.open("GET", getDisplay, true);
	request.send();
}// end of the function


</script>