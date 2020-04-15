<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 60px;">
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
 				<p style="font-size: 20px; font-weight: bolder;">add branch informations</p>
	 		</div>
	 		<form method="post" id="formdata">
	 			<div style="text-align: center;">
	 			<div class="inputmobile adminInputDivs">
	 				<label>branch name</label><br>
					<input class="inputmobile" type="text" id="bi_name" placeholder="*Branch Name" required>
	 			</div>
				<div class="inputmobile adminInputDivs" >
					<label>address</label><br>
					<input class="inputmobile" type="text" id="bi_street" placeholder="*Street" required><br>
					<input class="inputmobile" type="text" id="bi_city_municipality" placeholder="*City Municipality" required><br>
					<input class="inputmobile" type="text" id="bi_buildingNumber" placeholder="*Building Number" required><br>
				</div>
				<div class="inputmobile adminInputDivs">
					<label>about</label><br>
					<textarea  id="bi_about" style="resize: none; font-size: 20px; background-color: white; width: 90%; border-radius: 5px;" rows="15"></textarea>
				</div>

				<div style="text-align: center;" id="add">
					<button class="adminButton" onclick="getInput()">
						add information
					</button>
				</div>
				<div style="text-align: center;" id="submitEdit">
					<button class="adminButton" onclick="getEditInput()">
						save edit
					</button>
				</div>
			</div>
	 		</form>
 		</div>
</div>
 		

<script type="text/javascript">

	var apiLinkcreate = '../../../../api/creator/admin/branchInformation/createBranchInformation.php';
	var apiLinkread = '../../../../api/creator/admin/branchInformation/readContacts.php';
	var apiLinkedit = '../../../../api/creator/admin/branchInformation/displayEditInformation.php';
	var apiLinkSubmitEdit = '../../../../api/creator/admin/branchInformation/editBranchInformation.php';

	var resultDisplaying = document.getElementById('resultDisplaying');
	var result = document.getElementById('result');
	var reporting = document.getElementById('reporting');

	AjaxDisplayEdit();

	var bi_name = document.getElementById('bi_name');
	var bi_street = document.getElementById('bi_street');
	var bi_city_municipality = document.getElementById('bi_city_municipality');
	var bi_buildingNumber = document.getElementById('bi_buildingNumber');
	var bi_about = document.getElementById('bi_about');

	var add = document.getElementById('add');
	var submitEdit = document.getElementById('submitEdit');

	submitEdit.style.display = 'none';


	document.getElementById('formdata').addEventListener('submit', event=>{
		event.preventDefault();
	});

	function getInput(){

		if(	!bi_name.value || 
			!bi_street.value ||
			!bi_city_municipality.value ||
			!bi_buildingNumber.value ||
			!bi_about.value){

			bi_name.style.borderColor = 'red';
			bi_street.style.borderColor = 'red';
			bi_city_municipality.style.borderColor = 'red';
			bi_buildingNumber.style.borderColor = 'red';
			bi_about.style.borderColor = 'red';

		}else{

			var data = {
					adminInput:{
						bi_name: bi_name.value,
						bi_street: bi_street.value,
						bi_city_municipality: bi_city_municipality.value,
						bi_buildingNumber: bi_buildingNumber.value,
						bi_about: bi_about.value
					}
				}
			
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);

		}

		bi_name.value = null;
		bi_street.value = null;
		bi_city_municipality.value = null;
		bi_buildingNumber.value = null;
		bi_about.value = null;

	}// dn of the function

	function getEditInput(){

		if(	!bi_name.value || 
			!bi_street.value ||
			!bi_city_municipality.value ||
			!bi_buildingNumber.value ||
			!bi_about.value){

			bi_name.style.borderColor = 'red';
			bi_street.style.borderColor = 'red';
			bi_city_municipality.style.borderColor = 'red';
			bi_buildingNumber.style.borderColor = 'red';
			bi_about.style.borderColor = 'red';

		}else{

			var data = {
					adminInput:{
						bi_name: bi_name.value,
						bi_street: bi_street.value,
						bi_city_municipality: bi_city_municipality.value,
						bi_buildingNumber: bi_buildingNumber.value,
						bi_about: bi_about.value
					}
				}
			
			var tojson = JSON.stringify(data);
			AjaxEditInput(tojson);

		}

		bi_name.value = null;
		bi_street.value = null;
		bi_city_municipality.value = null;
		bi_buildingNumber.value = null;
		bi_about.value = null;

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
	           			add.style.display = 'none';
	            	}

	           }else{
	           		// error in request status
	           		result.style.color = 'red';
	           		result.innerHTML = "error status";
	           }
	       }else{
	       		// error in request
	           	result.style.color = 'red';
	       		result.innerHTML = "waiting for response";
	       }
	   };

	request.open("POST", apiLinkcreate, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

function AjaxDisplayEdit() {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code == 200){

	           			result.style.color = 'yellowgreen';
	           			result.innerHTML = res.response.display.message[0];
	           			bi_name.value = res.response.display.message[1].bi_name;
						bi_street.value = res.response.display.message[1].bi_street;
						bi_city_municipality.value = res.response.display.message[1].bi_city_municipality;
						bi_buildingNumber.value = res.response.display.message[1].bi_buildingNumber;
						bi_about.value = res.response.display.message[1].bi_about;
	           			add.style.display = 'none';
	           			submitEdit.style.display = 'block';
	            	}

	           }else{
	           		// error in request status
	           		result.style.color = 'red';
	           		result.innerHTML = "error status";
	           }
	       }else{
	       		// error in request
	           	result.style.color = 'red';
	       		result.innerHTML = "waiting for response";
	       }
	   };

	request.open("GET", apiLinkedit, true);
	request.send();
}// end of the function

function AjaxEditInput(tojson) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code == 200){

	           			result.style.color = 'yellowgreen';
	           			result.innerHTML = res.response.display.message[0];
	           			add.style.display = 'none';
	            	}

	           }else{
	           		// error in request status
	           		result.style.color = 'red';
	           		result.innerHTML = "error status";
	           }
	       }else{
	       		// error in request
	           	result.style.color = 'red';
	       		result.innerHTML = "waiting for response";
	       }
	   };

	request.open("POST", apiLinkSubmitEdit, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function


</script>
