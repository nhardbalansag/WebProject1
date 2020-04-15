<style type="text/css">

	/*desktop view*/
	@media screen and (min-width: 700px) {  

			.image{
				width: 20%;
				border-radius: 10px;
			}

			.checkFormData{
				width: 50%;
 				text-align: center;
 				width: 40%;
			}

			.checkFormTittle{
				font-weight:bolder;
 				width:40%;
 				text-align:left;
 				color :black;
 				font-size: 20px;
 				width: 40%;
			}
	}

	/*mobile view*/
	@media screen and (max-width: 700px) {  

		.image{
			width: 40%;
			border-radius: 10px;
		}

		.checkFormData{
			width: 50%;
 			text-align: center;
 			overflow: scroll;
 			width: 40%;
		}

		.checkFormTittle{
			font-weight:bolder;
 			width:40%;
 			text-align:left;
 			color :black;
 			font-size: 20px;
 			width: 40%;
		}

		.checkSubmit{
			width: 100px;
			margin: 20px 0px;
		}
	
	}
</style>
<div id="mainAdminContents">
	<div id="content" class="content" style="padding: 20px 0px 70px 0px;">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "transactionControlPage.php?transaction=" . base64_encode('viewAllProduct');

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;" id="tittlePage">new purchase</p>
	 		</div>
	 		<div style="text-align: center;" >
	 			<div id="container">
	 				
	 			</div>
	 			<div id="purchaseForm">
 					<div class="searchDiv">
	 					<input type="text" placeholder="search here">
		 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
		 			</div>
	 				<form method="post" id="formdataPurchase">
			 			<p id="reporting"></p>
			 			<div class="oneSelectedProductDiv" id="oneSelectedProductDiv">
				 			
			 			</div>
			 			<div class="inputmobile adminInputDivs">
							<label>product category</label><br>
							<select class="inputmobile" id="customerAccounts" required>
							</select>
						</div>
						<div class="inputmobile adminInputDivs">
							<label>purchase type</label><br>
							<select class="inputmobile" id="purchaseType" required>
								<option value ="null">select purchase type</option>
								<option value="cash">*cash</option>
								<option value="mortgage">*mortgage</option>
							</select>
						</div>
						<div class="inputmobile adminInputDivs">
							<label style="	color: red">transaction</label><br>	
							<label>total purchase price</label><br>
							<input class="inputmobile" type="number" disabled id="productPrice" placeholder="0" required>
							<input class="inputmobile" type="number" id="downpayment" placeholder="*Downpayment" required>
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
							<button class="adminButton">
								continue
							</button>
						</div>
	 				</form>
	 				
	 			</div>
			</div>
 		</div>
</div>
 		

 <script type="text/javascript">
 	const apiLinkreadOneProductInfo = '../../../../api/creator/admin/product/readProduct.php';
 	const apiLinkreadCustomerAccount = '../../../../api/creator/support/readCustomerAccounts.php';
 	const apiLinkProductCategory = '../../../../api/creator/admin/product/readProductCategory.php';
 	const apiLinkCreatePurchaseTransaction = '../../../../api/creator/admin/transaction/createPurchase.php';

 	const computed_hash = window.some_variable = '<?= $_GET['createNewPurchase']?>';

 	const purchaseForm = document.getElementById('purchaseForm');

 	const customerAccounts = document.getElementById('customerAccounts');
 	const purchaseType = document.getElementById('purchaseType');
 	const productPrice = document.getElementById('productPrice');
 	const downpayment = document.getElementById('downpayment');
 	const emailAddress = document.getElementById('emailAddress');
 	const firstname = document.getElementById('firstname');
 	const lastname = document.getElementById('lastname');
 	const middlename = document.getElementById('middlename');
 	const customerAddress = document.getElementById('customerAddress');
 	const customerBillingAddress = document.getElementById('customerBillingAddress');
 	const tittlePage = document.getElementById('tittlePage');

 	const formdataPurchase = document.getElementById('formdataPurchase');

 	formdataPurchase.addEventListener('submit', event=>{
 		event.preventDefault();
 		submitPurchaseInput();
 	});

 	var sampleCount = 0;

 	displaydata(computed_hash);
 	
 	AjaGETCategory();

 	function setnull(){
		customerAccounts.value = null;
		purchaseType.value = null;
		downpayment.value = null;
		emailAddress.value = null;
		firstname.value = null;
		lastname.value = null;
		middlename.value = null;
		customerAddress.value = null;
		customerBillingAddress.value = null;
	}

	function setcolor(color){
		customerAccounts.style.borderColor = color;
		purchaseType.style.borderColor = color;
		downpayment.style.borderColor = color;
		emailAddress.style.borderColor = color;
		firstname.style.borderColor = color;
		lastname.style.borderColor = color;
		middlename.style.borderColor = color;
		customerAddress.style.borderColor = color;
		customerBillingAddress.style.borderColor = color;
	}

	function submitPurchaseInput(){

		var data = {
				adminInput:{
					firstname: firstname.value,
					lastname: lastname.value,
					middlename: middlename.value,
					customerAddress: customerAddress.value,
					customerBillingAddress: customerBillingAddress.value,
					emailAddress: emailAddress.value,
					customerAccounts: customerAccounts.value,

					purchaseType: purchaseType.value,
					productReference: computed_hash,

					productPrice: productPrice.value,
					downpayment: downpayment.value
				}
			}
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);
			setcolor('yellowgreen');
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

	           			var imageDiv =  document.createElement('div');
	           			var p_Imagelook =  document.createElement('img');
	           			p_Imagelook.setAttribute('class', 'productImg');
	           			p_Imagelook.setAttribute('src', '../../pics/' + res.response.display.result[0].p_Imagelook);
	           			p_Imagelook.setAttribute('class', 'image');
	           			imageDiv.appendChild(p_Imagelook);

	           			var contentDiv =  document.createElement('div');
	           			contentDiv.setAttribute('class','ProductInfoDiv');
	           			var p_name = document.createElement('p');
	           			p_name.innerHTML = res.response.display.result[0].p_name;
	           			var p_caption = document.createElement('p');
	           			p_caption.innerHTML = res.response.display.result[0].p_caption;
	           			var p_price = document.createElement('p');
	           			p_price.innerHTML = res.response.display.result[0].p_price;
	           			var p_description = document.createElement('p');
	           			p_description.innerHTML = res.response.display.result[0].p_description;
	           			var p_datecreated = document.createElement('p');
	           			p_datecreated.innerHTML = 'date created: ' +  res.response.display.result[0].p_datecreated;
	           			contentDiv.appendChild(p_name);
	           			contentDiv.appendChild(p_caption);
	           			contentDiv.appendChild(p_price);
	           			contentDiv.appendChild(p_description);
	           			contentDiv.appendChild(p_datecreated);

	           			oneSelectedProductDiv.appendChild(imageDiv);
	           			oneSelectedProductDiv.appendChild(contentDiv);

	           			productPrice.value = res.response.display.result[0].p_price;
	           			productPrice.style.color = 'red';
	           			productPrice.style.textAlign = 'center';
	           			productPrice.style.fontWeight = 'bolder';
	            	}
	           	}
	       	}
	   	};

		request.open("POST", apiLinkreadOneProductInfo, true);
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
            	console.log(data);
            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){
           			
           			window.location.href = 'transactionControlPage.php?customerTransactionInformation=' + res.response.display.result[0];
            	}
           	}
       	}
   	};

	request.open("POST", apiLinkCreatePurchaseTransaction, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function
 </script>
 		

