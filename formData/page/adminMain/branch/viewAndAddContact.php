
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
 				<p style="font-size: 20px; font-weight: bolder;">manage Contact</p>
	 		</div>

	 		<form method="post" id="formdata">
	 			<div style="text-align: center;">
					<div class="inputmobile adminInputDivs">
						<label>contact number</label><br>
						<input class="inputmobile" type="number" id="c_number" placeholder="*number" required><br>
						<select class="inputmobile selectInput" id="c_category" required>
							<option>*Contact Category</option>
							<option value="telephone">*Telephone</option>
							<option value="mobile">*Mobile</option>
							<option value="hotline">*Hotline</option>
						</select>
					</div>
					<div>
						<button class="adminButton" >
							Add Number
						</button>
					</div>
				</div>
	 		</form>
	 	
			<div id="reporting" class="reporting">
 				<p id="resultDisplaying" style="text-align: center;"></p>
			
			</div>
 		</div>
</div>
 		
 

 <script type="text/javascript">
 	
 	var apiLinkcreate = '../../../../api/creator/admin/branchInformation/createContact.php';
	var apiLinkread = '../../../../api/creator/admin/branchInformation/readContacts.php';

	var resultDisplaying = document.getElementById('resultDisplaying');
	var result = document.getElementById('result');
	var reporting = document.getElementById('reporting');

	document.getElementById('formdata').addEventListener('submit', event=>{
		event.preventDefault();
		getInput();
	});

	AjaxgetDisplay();

	function getInput(){

		var c_number = document.getElementById('c_number');
		var c_category = document.getElementById('c_category');

		if(!c_number.value || !c_category.value){

			c_number.style.borderColor = 'red';
			c_category.style.borderColor = 'red';

		}else{

			var data = {
				adminInput:{
					c_number: c_number.value,
					c_category: c_category.value
				}
			}
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);

		}

		c_number.value = null;
		c_category.value = null;

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

	request.open("POST", apiLinkcreate, true);
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
		           				contentTwo_p_one.innerHTML = res.response.display.message[i].c_number;
		           				var contentTwo_p_two = document.createElement('p');
		           				contentTwo_p_two.setAttribute('class', 'linkDescription');
		           				contentTwo_p_two.innerHTML = res.response.display.message[i].c_category;
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

	request.open("GET", apiLinkread, true);
	request.send();
}// end of the function


 </script>