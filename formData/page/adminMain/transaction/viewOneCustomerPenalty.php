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

						echo "transactionControlPage.php?customerTransactionInformation=" . $_GET['viewallpenalties']

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">penalty</p>
	 		</div>
			<div id="tableReport">
			</div>
 		</div>
</div>
 		
<script type="text/javascript">
	var apiLinkget = '../../../../api/creator/admin/transaction/readAllOneCustomerPenalty.php';

	const tableReport = document.getElementById('tableReport');

 	var reference = window.referenceVar = '<?= $_GET['viewallpenalties'] ?>';

 	getInput(reference);

	function getInput(reference){

		var data = {
			adminInput:{
				reference: reference
			}
		}
		var tojson = JSON.stringify(data);
		Ajaxdisplay(tojson);
		
	}// dn of the function

	function Ajaxdisplay(tojson) {

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

	            		const headArray = ["date", "balance"];

	            		for(var i = 0; i < 2; i++){
	            			var head = document.createElement('th');
	            			head.innerHTML = headArray[i];
	            			row_head.appendChild(head);
	            		}
	            		table.appendChild(row_head);
	            		tableReport.appendChild(table);

	            		for(var i = 0; i < count; i++){

	            			var date = res.response.display.result[i].penalty.datecreated;
		            		var balance = res.response.display.result[i].penalty.balance;

		            		const dataArray = [date.split(" ")[0], balance];

		            		var data_row = document.createElement('tr');

		            		if((i % 2) === 0 ){
		            			data_row.setAttribute('class', 'even');
		            		}else{
		            			data_row.setAttribute('class', 'odd');
		            		}

	            			for(var j = 0; j < 2; j++){
	            				var data_td = document.createElement('td');
	            				
	            				data_td.innerHTML = dataArray[j];
	            				data_row.appendChild(data_td);
	            			}

	            			table.appendChild(data_row);
	            			tableReport.appendChild(table);
	            		}
	            	}
	           	}
	       	}
	   	};

	request.open("POST", apiLinkget, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function
</script>