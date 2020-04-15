<style type="text/css">

	/*desktop view*/
	@media screen and (min-width: 700px) {  

		.image{
			width: 20%;
			border-radius: 10px;
		}
			
	}

	/*mobile view*/
	@media screen and (max-width: 700px) {  

		.image{
			width: 40%;
			border-radius: 10px;
		}

	}

}
</style>
<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 70px;">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?productCreate=" . $_SESSION['productHash'];

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">edit feature</p>
 				<p id="showmessage"></p>
	 		</div>
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>
	 			
	 			<div class="oneSelectedProductDiv" id="ProductInfoDiv">
		 			
	 			</div>
		 		<form method="post" id="formDataFile">
					<div class="inputmobile adminInputDivs">
						<label>product image</label><br>
						<input class="inputmobile" type="file" id="f_image_field" placeholder="*select image" required>
					</div>
					<div class="inputmobile adminInputDivs">
						<input class="inputmobile" type="text" id="f_tittle_field" placeholder="*Feature Tittle" required>
					</div>
					<div class="inputmobile adminInputDivs">
						<label>description</label><br>
						<textarea  id="f_description_field" style="resize: none; font-size: 20px; background-color: white; width: 90%; border-radius: 5px;" rows="15" required></textarea>
					</div>
					<div style="width: 70%; margin:auto; display: flex; justify-content: space-around; align-items: center;">
						<button class="adminButton">
							save edit
						</button>
					</div>
				</form>
			</div>
			<p id="reporting"></p>
			<div id="mainContainer">
				
			</div>
 		</div>
</div>
 		

<script type="text/javascript">
 	
 	var apiLinkcreatefeature = '../../../../api/creator/admin/product/editProductFeature.php';
 	var apiLinkread = '../../../../api/creator/admin/product/readOneFeature.php';

 	var f_image_field = document.getElementById('f_image_field');
 	var f_tittle_field = document.getElementById('f_tittle_field');
 	var f_description_field = document.getElementById('f_description_field');

 	var ProductInfoDiv = document.getElementById('ProductInfoDiv');
	var reporting = document.getElementById('reporting');

	var formDataFile = document.getElementById('formDataFile');

	var computed_hash = window.some_variable = '<?= $_GET['editFeature']?>';

	var showmessage = document.getElementById('showmessage');
	var mainContainer = document.getElementById('mainContainer');


	displaydata(computed_hash)

	function setnull(){
		f_image_field.value = null;
		f_tittle_field.value = null;
		f_description_field.value = null;
	}

	function setcolor(color){
		f_image_field.style.borderColor = '1px solid ' + color;
		f_tittle_field.style.borderColor = '1px solid ' + color;
		f_description_field.style.borderColor = '1px solid ' + color;
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

 	formDataFile.addEventListener('submit', event => {
 		event.preventDefault();

		var fileLength = f_image_field.files.length;
		var filename = null;

		if(	fileLength > 1 || !f_tittle_field.value || !f_description_field.value){

			setcolor('red');

		}else{

			if(!f_image_field.value){
 				f_image_field.value = null;
				f_image_field.style.border = '1px solid red';
	 		}else{
	 			var fileType = f_image_field.files[0].type.split('/');

				if(fileType.length !== 2){
					f_image_field.value = null;
					f_image_field.style.border = '1px solid red';
				}else{

					if(fileType[0] === 'image' && (fileType[1] === 'jpeg' || fileType[1] === 'jpg')){
						filename = f_image_field.files[0].name;

						const form = new FormData();
						const uploading = '../../upload.php';

						form.append("file",  f_image_field.files[0]);

						fetch(uploading, {
							method: "POST",
							body: form
						});
					}
				}
	 		}

			if(!filename){
				f_image_field.value = null;
				f_image_field.style.border = '1px solid red';
			}else{

				var data = {
					adminInput:{
						f_image_field: filename,
						f_tittle_field: f_tittle_field.value,
						f_description_field: f_description_field.value,
						Reference: computed_hash
					}
				}

				var tojson = JSON.stringify(data);
				AjaxCreateInput(tojson);
				setcolor('yellowgreen');
				setnull();
			}
		}
 		
 	});

	function AjaxCreateInput(tojson) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){
	            		showmessage.style.color = 'yellowgreen';
	           			showmessage.innerHTML = 'edited sucessfully';

	           			var divTwo = document.createElement('div');
	           			divTwo.setAttribute('class', 'linkContent');
	           			var pct_tittle = document.createElement('p');
	           			pct_tittle.innerHTML = res.response.display.result.f_tittle;
	           			
	           			var pct_description = document.createElement('p');
	           			pct_description.setAttribute('class', 'linkDescription');
	           			pct_description.innerHTML = res.response.display.result.f_description;
	           			divTwo.appendChild(pct_tittle);
	           			divTwo.appendChild(pct_description);


	           			var contentContainer = document.createElement('div');
	           			contentContainer.setAttribute('class', 'reportingContent');
	           			contentContainer.appendChild(divTwo);

	           			var container = document.createElement('div');
	           			container.setAttribute('class', 'reporting');
	           			container.appendChild(contentContainer);

	           			mainContainer.appendChild(container);

	           			window.location.href = 'productControlPage.php?editFeature=' + res.response.display.result.reference;
	            	}
	           	}
	       	}
	   };

		request.open("POST", apiLinkcreatefeature, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function

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
	           			p_Imagelook.setAttribute('class', 'image');
	           			p_Imagelook.setAttribute('src', '../../pics/' + res.response.display.result[0].f_image);
	           			imageDiv.appendChild(p_Imagelook);

	           			var contentDiv =  document.createElement('div');
	           			contentDiv.setAttribute('class','ProductInfoDiv');

	           			var f_tittle = document.createElement('p');
	           			f_tittle.innerHTML = res.response.display.result[0].f_tittle;

	           			var f_description = document.createElement('p');
	           			f_description.innerHTML = res.response.display.result[0].f_description;

	           			var f_created = document.createElement('p');
	           			f_created.innerHTML = 'date created: ' + res.response.display.result[0].f_created;

	           			var f_modified = document.createElement('p');
	           			f_modified.innerHTML = 'last modified: ' + res.response.display.result[0].f_modified;

	           			contentDiv.appendChild(f_tittle);
	           			contentDiv.appendChild(f_description);
	           			contentDiv.appendChild(f_created);
	           			contentDiv.appendChild(f_modified);

	           			ProductInfoDiv.appendChild(imageDiv);
	           			ProductInfoDiv.appendChild(contentDiv);

	           			f_tittle_field.value = res.response.display.result[0].f_tittle;
		           		f_description_field.value = res.response.display.result[0].f_description;
	            	}
	           	}
	       	}
	   	};

		request.open("POST", apiLinkread, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function

 </script>