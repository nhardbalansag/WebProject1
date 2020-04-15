

<div id="mainAdminContents">
	<div id="content" class="content">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "branchControlPage.php?branch=" . base64_encode('createDocumentCategory');

					?> >

					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p id="result"></p>
 				<p style="font-size: 20px; font-weight: bolder;">edit</p>
	 		</div>
	 		<div style="text-align: center;">
				
					<form method="post" id="formdata">
						<div class="inputmobile adminInputDivs">
							<input class="inputmobile" type="text" id="categoryname" placeholder="*Document name" required><br>
							<input class="inputmobile" type="text" id="categoryDescription" placeholder="*Description" required>
						</div>
						<div>
							<button class="adminButton" >
								save
							</button>
						</div>
					</form>
			</div>
 		</div>
</div>

 		
 	
 	<script type="text/javascript">

	const createData = '../../../../api/creator/documents/editDocumentCategory.php';
	const readDocumentCategory = '../../../../api/creator/documents/readOneDocumentCategory.php';

	const resultDisplaying = document.getElementById('resultDisplaying');
	const result = document.getElementById('result');
	const reporting = document.getElementById('reporting');

	const categoryname = document.getElementById('categoryname');
	const categoryDescription = document.getElementById('categoryDescription');	

	const documentReference = window.reference = '<?= $_GET['edit'] ?>';

	getReference(documentReference); 	

	document.getElementById('formdata').addEventListener('submit', event=>{
		event.preventDefault();
		getInput(documentReference);
		
	});

	function getInput(documentReference){

		if(!categoryname.value || !categoryDescription.value){

			categoryname.style.borderColor = 'red';
			categoryDescription.style.borderColor = 'red';

		}else{

			var data = {
					adminInput:{
						categoryname: categoryname.value,
						categoryDescription: categoryDescription.value,
						documentReference: documentReference
					}
				}
				var tojson = JSON.stringify(data);
				AjaxEditData(tojson);
		}

		categoryname.value = null;
		categoryDescription.value = null;
	}// dn of the function

	function getReference(documentReference){

		var data = {
				adminInput:{
					documentReference: documentReference
				}
			}
		var tojson = JSON.stringify(data);
		AjaxgetData(tojson);
	}// dn of the function

	function AjaxgetData(tojson) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code == 200){

	       				categoryname.value = res.response.display.message[0].categoryName;
						categoryDescription.value = res.response.display.message[0].description;
	            	}
	           }
	       }
	   };

	request.open("POST", readDocumentCategory, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

	function AjaxEditData(tojson) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code === 200){
	           			result.style.color = 'yellowgreen';
	           			result.innerHTML = 'successfully edited';
	            	}
	           }
	       }
	   };

	request.open("POST", createData, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

</script>