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
 				<p style="font-size: 20px; font-weight: bolder;">set penalty amount</p>
 				<p id="result"></p>
	 		</div>
	 		<div style="text-align: center;" id="hideInput">
	 			<div class="ProductInfoDiv" id="viewall">
					<div class="mobileContentButton">
						<div>
							<p class="linkNumber"><i  class="fas fa-eye"></i></p>
						</div>
						<div>
							<p style="font-size: 10px; margin-left: 20px;">view all penalty amount created</p>
						</div>
					</div>
	 			</div>
	 			<div class="oneSelectedProductDiv" id="ProductInfoDiv">
		 			
	 			</div>
	 			<form method="post" id="formDataFile">
	 				<div class="inputmobile adminInputDivs">
						<label>amount</label>
						<input class="inputmobile" required type="text" id="penalty" placeholder="*penalty amount">
					</div>
					<div style="width: 70%; margin:auto;">
						<button class="adminButton">
							set
						</button>
					</div>
	 			</form>
				
			</div>
			<div id="mainContainer" style="margin: auto; width: 90%" >
			
			</div>

			<div id="tableReport">
				
			</div>
 		</div>
</div>
 		
 
 <script type="text/javascript">

 	const apiLinkcreate = '../../../../api/creator/admin/transaction/createPenaltyAmount.php';
 	var apiLinkget = '../../../../api/creator/admin/transaction/readAllPenaltyAmount.php';

 	const penalty = document.getElementById('penalty');
 	const viewall = document.getElementById('viewall');
 	const hideInput = document.getElementById('hideInput');
 	const tableReport = document.getElementById('tableReport');

	const formDataFile = document.getElementById('formDataFile');

	tableReport.style.display = 'none';

	formDataFile.addEventListener('submit', event=>{
		event.preventDefault();

		 getInput();

	});

	viewall.addEventListener('click', function(){
		tableReport.style.display = 'block';
		hideInput.style.display = 'none';
		Ajaxdisplay();
	});

	function getInput(){

		if(!penalty.value || penalty.value === " "){
			penalty.style.borderColor = 'red';
		}else{

			var data = {
				adminInput:{
					penalty: penalty.value
				}
			}
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);
		}
	}// dn of the function

	function AjaxCreateInput(tojson) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	           			result.style.color = 'yellowgreen';
	           			result.innerHTML = 'added sucessfully';

	           			var divTwo = document.createElement('div');
	           			divTwo.setAttribute('class', 'linkContent');
	           			var pct_tittle = document.createElement('p');
	           			pct_tittle.innerHTML = res.response.display.result[0].penalty_amount;
	           			pct_tittle.style.fontSize = '20px';
	           			pct_tittle.style.color = 'yellowgreen';
	           			
	           			divTwo.appendChild(pct_tittle);

	           			var contentContainer = document.createElement('div');
	           			contentContainer.setAttribute('class', 'reportingContent');
	           			contentContainer.appendChild(divTwo);

	           			var container = document.createElement('div');
	           			container.setAttribute('class', 'reporting');
	           			container.appendChild(contentContainer);

	           			mainContainer.appendChild(container);
	            	}
	           	}
	       	}
	   	};

	request.open("POST", apiLinkcreate, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function



 	

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

	            		const headArray = ["date created", "amount", "status", "view"];

	            		for(var i = 0; i < 4; i++){
	            			var head = document.createElement('th');
	            			head.innerHTML = headArray[i];
	            			row_head.appendChild(head);
	            		}
	            		table.appendChild(row_head);
	            		tableReport.appendChild(table);

	            		for(var i = 0; i < count; i++){

	            			var penalty_date = res.response.display.result[i].penalty_date;
		            		var penalty_amount = res.response.display.result[i].penalty_amount;
		            		var penalty_status = res.response.display.result[i].penalty_status;
		            		var computed_hash = res.response.display.result[i].computed_hash;

		            		const dataArray = [penalty_date, penalty_amount, penalty_status, "view"];

		            		var data_row = document.createElement('tr');

		            		if((i % 2) === 0 ){
		            			data_row.setAttribute('class', 'even');
		            		}else{
		            			data_row.setAttribute('class', 'odd');
		            		}

	            			for(var j = 0; j < 4; j++){
	            				var data_td = document.createElement('td');
	            				if(j === 3){
	            					var link = document.createElement('a');
	            					link.innerHTML = dataArray[j];
	            					link.href = 'transactionControlPage.php?editPenaltyAmount=' + computed_hash;
	            					data_td.appendChild(link);
	            				}else{
	            					data_td.innerHTML = dataArray[j];
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


















