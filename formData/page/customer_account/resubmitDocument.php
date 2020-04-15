
	<div id="content">
		<div class="informations">
			<a href=

				<?php 

					echo "customerControlPage.php?cp=" . base64_encode('index');

				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>
		<div class="informations" style="text-align: center;">
			<p style="font-size: 20px">please resend a valid document</p>
			<p style=" font-size: 30px;" id="result">status</p>
			
		</div>
		<div class="informations">
			<div style="display: flex; justify-content: space-around; align-items: center;">
				<div class="status"  style="background-color: yellowgreen">
					<p>1</p>
				</div>
			</div>

			<style type="text/css">
				.fileDiv{
					margin-top: 40px; 
					text-align: center;
					padding: 10px 0px;
					background-color: #D3E4F5;
				}
				.file{
					font-size: 18px; 
					padding: 5px 10px; 
					color: black; 
					width:80%;
					border: 1px solid #A1C1F1;
				}
				.select{
					font-size: 20px; 
					padding: 5px; 
					border-radius: 5px; 
					border: 1px solid #A1C1F1;
				}
			</style>

			<div id="formSendDocs" class="fileDiv " >
				<p style="color: rgb(10,15,42); font-weight: bolder; font-size: 30px;">guidelines:</p>
				<form method="post" id="formdata">
					<select onclick="documentDescription(this.value);" class="select" name="select"  id="select" required>
						<option value="0">select document type</option>
					</select>
					<p id="descriptionCAtegory" style="font-size: 15px; text-transform: uppercase;"></p>
					<div>
						<input class="file" type="file" id="fileDocument" required>
					</div>
					<p >please check your uploade documents before submitting thank you.</p>
					<div id="submitbuttondiv">
						<button name="sendDocs" id="hideButton" class="coloredButton">submit</button>
					</div>
				</form>
			</div>
		</div>

<script type="text/javascript">

var APIsendCustomerDocument = '../../../api/creator/documents/editDocument.php';
var APIgetDocumentCategory = '../../../api/creator/documents/readAllDocumentCategory.php';
var APIgetDocumentCategoryDescription = '../../../api/creator/documents/readOneDocumentCategory.php';

var select = document.getElementById("select");
var selectedfile = document.getElementById("fileDocument");

const accountreference = window.accountid = '<?= $_SESSION['accountID'] ?>';
const documentreference = window.reference = '<?= $_GET['Resubmit'] ?>';

callAPIgetDocumentCategory();	

document.getElementById('formdata').addEventListener('submit', event=>{
	event.preventDefault();

	var fileDocument = selectedfile.files.length;
	var filename = null;

	if(	fileDocument > 1 || !selectedfile.value || !select.value){
		select.style.border = '1px solid red';
		selectedfile.style.border = '1px solid red';
	}else{

		var fileType = selectedfile.files[0].type.split('/');
		
		if(fileType.length !== 2){
			selectedfile.value = null;
			selectedfile.style.border = '1px solid red';
		}else{

			if(fileType[0] === 'image' && (fileType[1] === 'jpeg' || fileType[1] === 'jpg')){
				filename = selectedfile.files[0].name;

				const form = new FormData();
				const uploading = '../upload.php';

				form.append("file",  selectedfile.files[0]);

				fetch(uploading, {
					method: "POST",
					body: form
				});
			}
		}
		
		if(!filename){
			selectedfile.value = null;
			selectedfile.style.border = '1px solid red';
		}else{

			var CategoryArray = select.value.split(".");

			var data = {
				input:{
					image: filename,
					status: "P",
					categoryId: CategoryArray[1],
					AccountId: accountreference,
					documentreference: documentreference
				}
			}

			var tojson = JSON.stringify(data);
			callAPIsendCustomerDocument(tojson);
			select.style.border = '1px solid red';
			selectedfile.style.border = '1px solid red';
			select.value = null;
			fileDocument.value = null;
			console.log(data)
		}
	}
	
});

function documentDescription(selectData){

	var data = {
		adminInput:{
			documentReference: selectData
		}
	}

	var tojson = JSON.stringify(data);
	callAPIgetDocumentCategoryDescription(tojson);
}

function callAPIsendCustomerDocument(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
            	console.log(data)
              	result.innerHTML = res.response.display.message;
              
            	if(res.response.http_response_code == 200 && res.response.reason == 'success'){
               		result.style.color = 'green';
                 
               }
           }
       }
   };

	request.open("POST", APIsendCustomerDocument, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(jsonObj);
}// end of the function


function callAPIgetDocumentCategory() {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
            	if(res.response.http_response_code == 200 && res.response.reason == 'success'){

            		var	count = res.response.display.message.length;
            		//get the number of 
            		var select = document.getElementById('select');
            		for (var i = 0; i < count;  i++) {
            			
	            		var option  = document.createElement('option');

	            		option.innerHTML = res.response.display.message[i].categoryName;
	            		option.value = res.response.display.message[i].hash + "." + res.response.display.message[i].categoryId;
	            		select.appendChild(option);
            		}
               	}
           }
       }
   };

	request.open("GET", APIgetDocumentCategory, true);
	request.send();
}// end of the function


function callAPIgetDocumentCategoryDescription(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {

           		var data = this.responseText;
            	var res = JSON.parse(this.responseText);

            	if(res.response.http_response_code == 200 && res.response.reason == 'success'){
            		//data here
            		document.getElementById('descriptionCAtegory').innerHTML = res.response.display.message[0].description;

               	}
           }
       }
   };

	request.open("POST", APIgetDocumentCategoryDescription, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(jsonObj);
}



</script>