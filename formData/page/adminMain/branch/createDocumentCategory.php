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
	<div id="content" class="content" style="padding-bottom: 100px; ">
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
 				<p style="font-size: 20px; font-weight: bolder;">create document categories</p>
	 		</div>
	 		<div style="text-align: center;">
				
					<form method="post" id="formdata">
						<div class="inputmobile adminInputDivs">
							<input class="inputmobile" type="text" id="categoryname" placeholder="*Document name" required><br>
							<input class="inputmobile" type="text" id="categoryDescription" placeholder="*Description" required>
						</div>
						<div>
							<button class="adminButton" >
								create
							</button>
						</div>
					</form>
			</div>
			<div id="tableReport">
			</div>
 		</div>
</div>

 		
 	
 	<script type="text/javascript">

	var createData = '../../../../api/creator/documents/createDocumentCategory.php';
	var readDocumentCategory = '../../../../api/creator/documents/readAllDocumentCategory.php';

	var resultDisplaying = document.getElementById('resultDisplaying');
	var result = document.getElementById('result');
	var reporting = document.getElementById('reporting');

	var categoryname = document.getElementById('categoryname');
	var categoryDescription = document.getElementById('categoryDescription');	

	 Ajaxdisplay();

	document.getElementById('formdata').addEventListener('submit', event=>{
		event.preventDefault();
		getInput();
	});

	function getInput(){

		if(!categoryname.value || !categoryDescription.value){

			categoryname.style.borderColor = 'red';
			categoryDescription.style.borderColor = 'red';

		}else{

			var data = {
					adminInput:{
						categoryname: categoryname.value,
						categoryDescription: categoryDescription.value
					}
				}
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);
		}

		categoryname.value = null;
		categoryDescription.value = null;
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
	           			result.innerHTML = 'success fully added';
	            	}
	           }
	       }
	   };

	request.open("POST", createData, true);
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
	            	var count = res.response.display.message.length;
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		var table = document.createElement('table');
	            		table.setAttribute('class', 'tabledesign');
	            		var row_head = document.createElement('tr');

	            		const headArray = ["date created", "document type", "action"];

	            		for(var i = 0; i < 3; i++){
	            			var head = document.createElement('th');
	            			head.innerHTML = headArray[i];
	            			row_head.appendChild(head);
	            		}
	            		table.appendChild(row_head);
	            		tableReport.appendChild(table);

	            		for(var i = 0; i < count; i++){

	            			var dateCreated = res.response.display.message[i].dateCreated;
		            		var tittle = res.response.display.message[i].categoryName;
		            		var hash = res.response.display.message[i].hash;

		            		const dataArray = [dateCreated, tittle];

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
		            				iconLink.href = 'branchControlPage.php?edit=' + hash;
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

	request.open("GET", readDocumentCategory, true);
	request.send();
}// end of the function



</script>