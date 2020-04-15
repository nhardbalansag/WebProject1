<style type="text/css">
.tabledesign{
	width: 95%;
	margin:5% auto;
	text-align: center;
	border-collapse: collapse;
	overflow: scroll;
}

tr, td{
	padding:20px 0px;
	border-bottom: 1px solid white;
	color: black;
}

th{
	background-color: #385080;
	color: white;
	padding:15px 0px;
}

.even{
	background-color:  #E6EDF8;
}

.odd{
	background-color: #D3E4F5;
}

tr:hover{
	background-color: white;
}
td a{
	color:black;
}

td:nth-of-type(1){
	font-weight: bolder;
}
</style>
<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 70px;">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "transactionControlPage.php?transaction=" . base64_encode('transactionIndex');

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">availed customers account</p>
	 		</div>
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>
			</div>
			<div class="sortDiv">
				<select class="sort">
					<option>sort by</option>
					<option value="telephone">date ascending</option>
					<option value="mobile">date descending</option>
					<option value="hotline">name ascending</option>
					<option value="hotline">name descending</option>
				</select>
			</div>
			<div id="tableReport">
			</div>
 		</div>
</div>
 		
 		
<script type="text/javascript">
	var apiLinkget = '../../../../api/creator/admin/transaction/readAllCustomer.php';

	const tableReport = document.getElementById('tableReport');

 	Ajaxdisplay();

	function Ajaxdisplay() {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	var count = res.response.display.result.length;
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		var table = document.createElement('table');
	            		table.setAttribute('class', 'tabledesign');
	            		var row_head = document.createElement('tr');

	            		const headArray = ["id", "lastname", "action"];

	            		for(var i = 0; i < 3; i++){
	            			var head = document.createElement('th');
	            			head.innerHTML = headArray[i];
	            			row_head.appendChild(head);
	            		}
	            		table.appendChild(row_head);
	            		tableReport.appendChild(table);

	            		for(var i = 0; i < count; i++){

	            			var purchaseDate = res.response.display.result[i].purchase.purchase_pi_date;
		            		var purchaseid = res.response.display.result[i].purchase.purchase_pi_id;
		            		var purchasecustomerid = res.response.display.result[i].purchase.purchase_aci_id;
		            		var purchasecreatedproductid = res.response.display.result[i].purchase.purchase_cp_id;
		            		var purchase_computed_hash = res.response.display.result[i].purchase.purchase_computed_hash;

		            		var purchaseReferenceId = purchaseDate + "y" + purchaseid + "y" + purchasecustomerid + "y" + purchasecreatedproductid;
		            		var lname =  res.response.display.result[i].customer.customer_aci_lastName;

		            		const dataArray = [purchaseReferenceId, lname];

		            		var data_row = document.createElement('tr');

		            		if((i % 2) === 0 ){
		            			data_row.setAttribute('class', 'even');
		            		}else{
		            			data_row.setAttribute('class', 'odd');
		            		}

	            			for(var j = 0; j < 3; j++){
	            				var data_td = document.createElement('td');
	            				
	            				if(j < 2){
	            					data_td.innerHTML = dataArray[j];
	            				}else{
	            					var iconLink = document.createElement('a');
		            				iconLink.setAttribute('class', 'fa fa-eye');
		            				iconLink.href = 'transactionControlPage.php?customerTransactionInformation=' + purchase_computed_hash;
	            					data_td.appendChild(iconLink);
	            				}
	            				data_row.appendChild(data_td);
	            			}

	            			table.appendChild(data_row);
	            			tableReport.appendChild(table);
	            		}
	            	}
	           	}
	       	}
	   	};

	request.open("GET", apiLinkget, true);
	request.send();
}// end of the function
</script>