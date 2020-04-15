<div id="mainAdminContents">
	<div id="content" class="content" style="padding: 20px 0px 70px 0px;">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "transactionControlPage.php?customerTransactionInformation=" . $_GET['editcustomerInformation'];

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;" id="tittlePage">edit information</p>
	 		</div>
 			
	 		<div style="text-align: center;" >
	 			<div id="container">
	 				
	 			</div>
	 			<div id="purchaseForm">
		 			<p id="reporting"></p>
		 			<form method="post" id="formdata">
		 				<div class="inputmobile adminInputDivs">
							<label>product category</label><br>
							<select class="inputmobile" id="customerAccounts" required><br>
							</select>
						</div>
					
						<div class="inputmobile adminInputDivs">
							<input class="inputmobile" type="email" id="emailAddress" placeholder="*Email Address" required>
							<input class="inputmobile" type="text" id="firstname" placeholder="*First Name" required>
							<input class="inputmobile" type="text" id="middlename" placeholder="*Middle Name" required>
							<input class="inputmobile" type="text" id="lastname" placeholder="*Last Name" required>
						</div>
						<div class="inputmobile adminInputDivs">
							<label>address</label><br>
							<textarea  id="customerAddress" style="resize: none; font-size: 20px; background-color: white; width: 90%; border-radius: 5px;" rows="15" required></textarea><br>
							<label>billing address</label><br>
							<textarea  id="customerBillingAddress" style="resize: none; font-size: 20px; background-color: white; width: 90%; border-radius: 5px;" rows="15" required></textarea>
						</div>
						
						<div style="width: 70%; margin:auto; display: flex; justify-content: space-around; align-items: center;">
							<button class="adminButton" id="submitEdit">
								save edit
							</button>
						</div>
		 			</form>
		 			
	 			</div>
			</div>
 		</div>

</div>
 		
 <script type="text/javascript">
 	const apiLinkread = '../../../../api/creator/admin/transaction/readOneCustomer.php';
 	const apiLinkEditCustomerInformation = '../../../../api/creator/admin/transaction/editCustomerPersonalInformation.php';
 	const apiLinkreadCustomerAccount = '../../../../api/creator/support/readCustomerAccounts.php';

 	const computed_hash = window.some_variable = '<?= $_GET['editcustomerInformation']?>';

 	const emailAddress = document.getElementById('emailAddress');
 	const firstname = document.getElementById('firstname');
 	const lastname = document.getElementById('lastname');
 	const middlename = document.getElementById('middlename');
 	const customerAddress = document.getElementById('customerAddress');
 	const customerBillingAddress = document.getElementById('customerBillingAddress');


 	displaydata(computed_hash);
 	AjaGETCategory();
 		
 	function setnull(){
		emailAddress.value = null;
		firstname.value = null;
		lastname.value = null;
		middlename.value = null;
		customerAddress.value = null;
		customerBillingAddress.value = null;
	}

	function setcolor(color){
		emailAddress.style.borderColor = color;
		firstname.style.borderColor = color;
		lastname.style.borderColor = color;
		middlename.style.borderColor = color;
		customerAddress.style.borderColor = color;
		customerBillingAddress.style.borderColor = color;
	}

	function getDatainput(referencedata){

		if(
			!emailAddress.value ||
			!firstname.value ||
			!lastname.value ||
			!middlename.value ||
			!customerAddress.value ||
			!customerBillingAddress.value
		){
			setcolor('red');
			setnull();
		}else{
			var data = {
				adminInput:{
					firstname: firstname.value,
					lastname: lastname.value,
					middlename: middlename.value,
					customerAddress: customerAddress.value,
					customerBillingAddress: customerBillingAddress.value,
					emailAddress: emailAddress.value,
					customerAccounts: customerAccounts.value,
					reference: referencedata
				}
			}
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);
			setcolor('yellowgreen');
		}
	}
	
	function displaydata(computed_hash){

		var data = {
			adminInput:{
				computed_hash: computed_hash
			}
		}
		var tojson = JSON.stringify(data);
		AjaxGet(tojson);
	}// dn of the function


 	function AjaxGet(tojson) {

		var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		emailAddress.value = res.response.display.result[0].customer.customer_aci_emailAddress;
	            		firstname.value = res.response.display.result[0].customer.customer_aci_firstName;
						lastname.value = res.response.display.result[0].customer.customer_aci_lastName;
						middlename.value = res.response.display.result[0].customer.customer_aci_middleName;
						customerAddress.value = res.response.display.result[0].customer.customer_aci_address;
						customerBillingAddress.value = res.response.display.result[0].customer.customer_aci_billingAddress;

						document.getElementById('formdata').addEventListener('submit', event=>{
 							event.preventDefault();
 							getDatainput(res.response.display.result[0].customer.customer_computed_hash);
 						});
	            	}
	           	}
	       	}
	   	};

		request.open("POST", apiLinkread, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function

function AjaGETCategory() {

	var request = new XMLHttpRequest();
   
	  request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request

	            	var	count = res.response.display.result.length;

            		if(res.response.http_response_code === 200 && res.response.reason === 'success'){

            			for (var i = 0; i < count;  i++) {

		            		var option  = document.createElement('option');

		            		option.innerHTML = res.response.display.result[i].ci_lastname;
		            		option.value = res.response.display.result[i].accountID;
		            		customerAccounts.appendChild(option);
            			}	
            		}
	           }
	       }
	   };

	request.open("GET", apiLinkreadCustomerAccount, true);
	request.send();
}// end of the function


function AjaxCreateInput(tojson) {

	var request = new XMLHttpRequest();
	   
   request.onreadystatechange = function() {

       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

            if (request.status === 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){
           			
           			window.location.href = 'transactionControlPage.php?customerTransactionInformation=' + computed_hash;
            	}
           	}
       	}
   	};

	request.open("POST", apiLinkEditCustomerInformation, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

 </script>
 		