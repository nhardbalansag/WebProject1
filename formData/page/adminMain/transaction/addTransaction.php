	<style type="text/css">
	 				.done{
	 					background-color: yellowgreen;
	 					padding:10px;
	 					border-radius: 50px;
	 					width: 50px;
	 					height: 50px;
	 					display: flex;
	 					justify-content: center;
	 					align-items: center;
	 					margin: auto;
	 				}
	 					.customerInformationReport{
	 						border-radius: 10px;
	 						margin: 10px;
	 						text-align: center;
	 						background-color: #385080;
	 						color: white;
	 						padding: 5px 0px;
	 					}
	 					.customerInformationReport label{
	 						font-weight: bolder;
	 						color: white;
	 					}
	 					.customerInformationReport a{
	 						color: white;
	 					}

	 					.linkstyle{
	 						display: flex;
	 						justify-content: space-around;
	 						align-items: center;
	 					}

	 				</style>

<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 70px;">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "transactionControlPage.php?customerTransactionInformation=" . $_GET['addTransaction'];
					?> >

					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">add transaction</p>
	 		</div>
 			
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>
	 			<div>
	 				<p>outstanding penalty balance:</p>
	 				<h1 style="color: red" id="totalPenaty"></h1>
	 			</div>
	 			<div class="oneSelectedProductDiv" id="oneSelectedProductDiv">
		 			
	 			</div>
				<div class="inputmobile adminInputDivs" id="inputmobile">
					<div id="transactionDiv">
						<label style="	color: red">transaction</label><br>	
						<form method="post" id="transactionForm">
							<div>
								<div>
									<label>previous balance</label><br>
									<input class="inputmobile" type="number" disabled id="previousBalance" required style="text-align: center; font-weight: bolder; color:red">
									<input class="inputmobile" type="number" id="payment" placeholder="*payment amount" required style="text-align: center;">
								</div>
								<div>
									<label> payment status</label><br>	
									<select class="inputmobile" id="status" required>
										<option value="null">select status</option>
										<option value="ontime">*ontime</option>
										<option value="delayed">*delayed</option>
									</select>
								</div>
							</div>
							<div style="width: 70%; margin:auto;">
								<input type="submit"class="adminButton" name="">
							</div>
						</form>
					</div>
					
					<div id="penaltyDiv">
						
						<form method="post" id="penaltyForm">
							<label style="	color: red">penalty</label><br>	
							<div>
								<div>
									<label>penalty amount</label><br>
									<input class="inputmobile" type="number" disabled id="penaltyamount" required style="text-align: center; font-weight: bolder; color:red"><br>
									<input class="inputmobile" type="number" id="penaltyPayment" placeholder="*payment amount" required style="text-align: center;">
								</div>
								<div>
									<label> payment status</label><br>	
									<select class="inputmobile" id="penaltyStatus" required>
										<option value="null">select status</option>
										<option value="pass">*pass</option>
										<option value="paid">*paid</option>
										<option value="partial">*partial</option>
									</select>
								</div>
							</div>
							<div style="width: 70%; margin:auto;">
								<input type="submit"class="adminButton" id="penaltyButton">
							</div>
						</form>
						<div style="width: 50%; margin:auto; display: flex; justify-content: center;">
							<button class="adminButton" id="addpaymentBalance">Next</button>
						</div>
					</div>
					<div id="penaltyBalancePayment">
						<label style="	color: red">penalty Balance</label><br>	
						<form method="post" id="penaltyBalanceForm">
							<div>
								<div>
									<label>total penalty balance</label><br>
									<input class="inputmobile" type="number" disabled id="penaltyTotalBalance" required style="text-align: center; font-weight: bolder; color:red">
									<input class="inputmobile" type="number" id="penaltyBalancePaymentinput" placeholder="*payment amount" required style="text-align: center;">
								</div>
								<div>
									<label> payment status</label><br>	
									<select class="inputmobile" id="penaltyBlanceStatus" required>
										<option value="null">select status</option>
										<option value="pass">*pass</option>
										<option value="paid">*paid</option>
										<option value="partial">*partial</option>
									</select>
								</div>
							</div>
							<div style="width: 70%; margin:auto;">
								<input type="submit"class="adminButton">
							</div>
						</form>
						
					</div>
				</div>
				<div id="okayResult">	
					<div class="done">	
						<i  class="fas fa-check" style="font-size: 30px; color: white;"></i>
					</div>
					<div style="margin-top: 30px;">
						<button class="adminButton" id="okayResult">okay</button>
					</div>
					
				</div>
			</div>
 		</div>
</div>
 		
 		
 <script type="text/javascript">
 	const apiLinkread = '../../../../api/creator/admin/transaction/readOneCustomer.php';
 	const apiLinCreateTransaction = '../../../../api/creator/admin/transaction/createTransaction.php';
 	const apiLinkReadPenaltyAmount = '../../../../api/creator/admin/transaction/readSetPenalty.php';
 	const apiLinkCreatePenalty = '../../../../api/creator/admin/transaction/createPenaltyTransaction.php';
 	const apiLinkPaymentToBalance = '../../../../api/creator/admin/transaction/createPaymentToPenaltyBalance.php';
 	const apiLinkgetPenaltyBalance = '../../../../api/creator/admin/transaction/readTotalPenaltyBalance.php';

 	const reference = window.linkUrl = '<?= $_GET['addTransaction'] ?>';
 	const oneSelectedProductDiv = document.getElementById('oneSelectedProductDiv');
 	const previousBalance = document.getElementById('previousBalance');
 	const payment = document.getElementById('payment');
 	const status = document.getElementById('status');
 	const transactionForm = document.getElementById('transactionForm');
 	const penaltyForm = document.getElementById('penaltyForm');
 	const transactionDiv = document.getElementById('transactionDiv');
 	const penaltyDiv = document.getElementById('penaltyDiv');
 	const penaltyamount = document.getElementById('penaltyamount');
 	const penaltyPayment = document.getElementById('penaltyPayment');
 	const penaltyStatus = document.getElementById('penaltyStatus');

 	const penaltyBalanceForm = document.getElementById('penaltyBalanceForm');
	const penaltyTotalBalance = document.getElementById('penaltyTotalBalance');
	const penaltyBalancePayment = document.getElementById('penaltyBalancePayment');
	const penaltyBlanceStatus = document.getElementById('penaltyBlanceStatus');
	const penaltyBalancePaymentinput = document.getElementById('penaltyBalancePaymentinput');
	const totalPenaty = document.getElementById('totalPenaty');

	const okayResult = document.getElementById('okayResult');
	const inputmobile = document.getElementById('inputmobile');

	const penaltyButton = document.getElementById('penaltyButton');
	const addpaymentBalance = document.getElementById('addpaymentBalance');
	
 	displaydata(reference);
 	
 	penaltyDiv.style.display = 'none';
 	penaltyBalancePayment.style.display = 'none';
 	addpaymentBalance.style.display = 'none';
 	okayResult.style.display = 'none';

 	addpaymentBalance.addEventListener('click', function(){
 		penaltyForm.style.display = 'none';
 		penaltyBalancePayment.style.display = 'block';
 		addpaymentBalance.style.display = 'none';

 	});

 	document.getElementById('okayResult').addEventListener('click', function(){
 		window.location.href = 'transactionControlPage.php?customerTransactionInformation=' + reference;
 	});

	function displaydata(computed_hash){

			var data = {
				adminInput:{
					computed_hash: computed_hash
				}
			}
			var tojson = JSON.stringify(data);
			AjaxGet(tojson);
			AjaxgetPenaltyBalance(tojson);
	}// dn of the function

	function getInput(purchaseID, CustomerId, purchase_computed_hash){

		if(
			(!previousBalance.value || previousBalance.value === " ") ||
			(!payment.value || payment.value === " ") ||
			(!status.value || status.value === 'null')
		){
			setnull('transaction');
			setcolor('red', 'transaction');
		}else{

			var data = {
				adminInput:{
					payment: payment.value,
					previousBalance: previousBalance.value,
					purchaseID: purchaseID,
					CustomerId: CustomerId,
					status: status.value, 
					purchaseReference: purchase_computed_hash
				}
			}
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);
			setnull('transaction');
			setcolor('yellowgreen', 'transaction');
		}
	}// dn of the function


	function getPenaltyInput(transactionID){

		if(
			(!penaltyPayment.value || penaltyPayment.value === " ") ||
			(!penaltyStatus.value || penaltyStatus.value === 'null')
		){
			setnull('penalty');
			setcolor('red', 'penalty');
		}else{

			var data = {
				adminInput:{
					payment: penaltyPayment.value,
					penaltyAmount: penaltyamount.value,
					transactionID: transactionID,
					status: penaltyStatus.value
				}
			}
			var tojson = JSON.stringify(data);
			AjaxCreatePenalty(tojson);
			// console.log(data);
			setnull('penalty');
			setcolor('yellowgreen', 'penalty');
		}
	}// dn of the function


	function getPaymentBalanceInput(balance, transactionReference){
		if(
			(!penaltyTotalBalance.value || penaltyTotalBalance.value === " ") ||
			(!penaltyBalancePaymentinput.value || penaltyBalancePaymentinput.value === " ") ||
			(!penaltyBlanceStatus.value || penaltyBlanceStatus.value === 'null')
		){
			setnull('balance');
			setcolor('red', 'balance');
		}else{

			var data = {
				adminInput:{
					payment: penaltyBalancePaymentinput.value,
					totalPenaltyAmount: penaltyTotalBalance.value,
					balanceReference: balance,
					transactionReference: transactionReference,
					status: penaltyBlanceStatus.value
				}
			}
			var tojson = JSON.stringify(data);
			AjaxCreatePaymentTobalance(tojson);
			setnull('balance');
			setcolor('yellowgreen', 'balance');
		}
	}// dn of the function

	function setnull(form){
		if(form === "penalty"){
			penaltyPayment.value = null;
			penaltyStatus.value = null;
		}else if(form === "transaction"){
			payment.value = null;
			status.value = null;
		}else if(form === "balance"){
			penaltyBalancePayment.value = null;
			penaltyBlanceStatus.value = null;
		}
		
	}

	function setcolor(color, form){
		if(form === "penalty"){
			penaltyPayment.style.border = '1px solid ' + color;
			penaltyStatus.style.border = '1px solid ' + color;
		}else if(form === "transaction"){
			payment.style.border = '1px solid ' + color;
			status.style.border = '1px solid ' + color;
		}else if(form === "balance"){
			penaltyBalancePayment.style.border = '1px solid ' + color;
			penaltyBlanceStatus.style.border = '1px solid ' + color;
		}
	}
	
	function AjaxGet(tojson) {

		var request = new XMLHttpRequest();
	   
   		request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		var balance = res.response.display.result[0].transaction.transaction_ti_currentBalance;
	            		var transactionID = res.response.display.result[0].transaction.transaction_ti_id;

	            		var Ci_datecreated = res.response.display.result[0].customer.customer_aci_dateCreated;
	            		var Ci_id = res.response.display.result[0].customer.customer_aci_id;
	            		var Ci_acid = res.response.display.result[0].customer.customer_ca_id;

	            		var fname =  res.response.display.result[0].customer.customer_aci_firstName;
	            		var mname =  res.response.display.result[0].customer.customer_aci_middleName;
	            		var lname =  res.response.display.result[0].customer.customer_aci_lastName;

	            		var accountdateCreated = res.response.display.result[0].account.account_ca_date_created;
	            		var accountid = res.response.display.result[0].account.account_ca_id;

	            		var purchaseDate = res.response.display.result[0].purchase.purchase_pi_date;
	            		var purchaseid = res.response.display.result[0].purchase.purchase_pi_id;
	            		var purchasecustomerid = res.response.display.result[0].purchase.purchase_aci_id;
	            		var purchasecreatedproductid = res.response.display.result[0].purchase.purchase_cp_id;

	            		var purchasetype = res.response.display.result[0].purchase.purchase_pi_purchaseType;
	            		var purchase_computed_hash = res.response.display.result[0].purchase.purchase_computed_hash;

	            		////reference identification
	            		var purchaseReferenceId = purchaseDate + "y" + purchaseid + "y" + purchasecustomerid + "y" + purchasecreatedproductid;
	            		var linkAccountReference = accountdateCreated + "y" + accountid;
	            		var fullname = fname + " " + mname + " " + lname;
	            		var customer_Identification = Ci_datecreated + 'y' + Ci_id + 'y' + Ci_acid;

	           			var divPersonalInfo = document.createElement('div');
	           			divPersonalInfo.setAttribute('class', 'customerInformationReport');
	           			var label = ["name: ", "purchase id: "];
	           			var dataInfo = [fullname, purchaseReferenceId];
	           			var iconInfo_i = document.createElement('i');
	           			iconInfo_i.setAttribute('class', 'fas fa-info');
	           			var icondiv_i = document.createElement('div');
	           			icondiv_i.appendChild(iconInfo_i);
	           			divPersonalInfo.appendChild(icondiv_i);
	           			for(var i = 0; i < 2; i++){

	           				var personal_span = document.createElement('span');
		           			personal_span.innerHTML = label[i];
		           			var personal_p = document.createElement('p');
		           			personal_p.innerHTML = dataInfo[i];
		           			
	           				divPersonalInfo.appendChild(personal_span);
	           				divPersonalInfo.appendChild(personal_p);
	           			}
	           			oneSelectedProductDiv.appendChild(divPersonalInfo);

	           			previousBalance.value = balance;

	           			transactionForm.addEventListener('submit', event=>{
							event.preventDefault();

							 getInput(purchaseid, Ci_id, purchase_computed_hash);

						});

						penaltyForm.addEventListener('submit', event=>{
							event.preventDefault();

							 getPenaltyInput(transactionID);

						});

	            	}
	           	}
	       	}
   		};

		request.open("POST", apiLinkread, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function

	function AjaxCreateInput(tojson) {

		var request = new XMLHttpRequest();
	   
   		request.onreadystatechange = function() {

	       	if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	console.log(data)
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	           			if(res.response.display.result[0].status === 'ontime'){
	           				previousBalance.value = res.response.display.result[0].currentBalance;
	           			}else if(res.response.display.result[0].status === 'delayed'){
	           				penaltyDiv.style.display = 'block';
	           				transactionDiv.style.display = 'none';
	           				AjaxGetPenaltyAmount();
	           				
	           			}
	            	}
	           	}
	       	}
   		};
		request.open("POST", apiLinCreateTransaction, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function

	function AjaxGetPenaltyAmount() {

		var request = new XMLHttpRequest();
	   
   		request.onreadystatechange = function() {

	       	if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	console.log(data);
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	           			penaltyamount.value = res.response.display.result[0].penalty_amount;
	            	}
	           	}
	       	}
   		};
		request.open("GET", apiLinkReadPenaltyAmount, true);
		request.send();
	}// end of the function

	function AjaxCreatePenalty(tojson) {

		var request = new XMLHttpRequest();
	   
   		request.onreadystatechange = function() {

	       	if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	console.log(data);
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		var balance = res.response.display.result[0].totalCurentBalance;
	            		totalPenaty.innerHTML = 'P' + balance + '.00';
	           			penaltyButton.style.display = 'none';

	           			if(balance > 0){
	           				addpaymentBalance.style.display = 'block';
	           				penaltyTotalBalance.value = balance;
	           				penaltyForm.style.display = 'none';
	           				penaltyBalanceForm.addEventListener('submit', event =>{
	           					event.preventDefault();
	           					getPaymentBalanceInput(res.response.display.result[0].balanceReference, res.response.display.result[0].transactionReference);
	           				});
	           			}
	            	}
	           	}
	       	}
   		};
		request.open("POST", apiLinkCreatePenalty, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function

	function AjaxCreatePaymentTobalance(tojson) {

		var request = new XMLHttpRequest();
	   
   		request.onreadystatechange = function() {

	       	if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	console.log(data);
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		penaltyTotalBalance.value = res.response.display.result[0];
	            		totalPenaty.innerHTML = 'P' + res.response.display.result[0] + '.00';
	            		inputmobile.style.display = 'none';
	           			okayResult.style.display = 'block';
	            	}
	           	}
	       	}
   		};
		request.open("POST", apiLinkPaymentToBalance, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function

	function AjaxgetPenaltyBalance(tojson) {

		var request = new XMLHttpRequest();
	   
   		request.onreadystatechange = function() {

	       	if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	console.log(data);
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		totalPenaty.innerHTML = 'P' + res.response.display.result[0].totalPenaltyBalance + '.00';
	           		
	            	}
	           	}
	       	}
   		};
		request.open("POST", apiLinkgetPenaltyBalance, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function

 </script>