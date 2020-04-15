<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 70px;">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?productCreate=" . $_GET['editProduct'];

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>

 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">edit product</p>
	 		</div>
	 		<div style="text-align: center;">
				<form method="post" id="formDataFile">
	 				<div class="inputmobile adminInputDivs">
						<label>reupload product image</label>
						<input class="inputmobile" type="file" name="p_Imagelook" id="p_Imagelook" placeholder="*select image">
					</div>
					<div class="inputmobile adminInputDivs">
						<input class="inputmobile" type="text" id="p_name" name="p_name" placeholder="*name">
						<input class="inputmobile" type="text" id="p_caption" placeholder="*caption">
						<input class="inputmobile" type="text" id="p_price" placeholder="*price">
					</div>
					<div class="inputmobile adminInputDivs">
						<label>description</label>
						<textarea  id="p_description" style="resize: none; font-size: 20px; background-color: white; width: 90%; border-radius: 5px;" rows="15"></textarea>
					</div>
					<div class="inputmobile adminInputDivs">
						<label>product category</label>
						<select class="inputmobile" id="pct_id"><br>
							
						</select>
					</div>
					<div style="width: 70%; margin:auto;">
						<button type="submit" class="adminButton" name="sendDocs">
							save edit
						</button>
					</div>
				</form>
			</div>
 		</div>
</div>		

<script type="text/javascript">
 	var apiLinkread = '../../../../api/creator/admin/product/readProduct.php';
 	var apiLinkcreate = '../../../../api/creator/admin/product/editProduct.php';
 	var apiLinkProductCategory = '../../../../api/creator/admin/product/readProductCategory.php';

 	var p_Imagelook = document.getElementById('p_Imagelook');
 	var p_name = document.getElementById('p_name');
 	var p_caption = document.getElementById('p_caption');
 	var p_price = document.getElementById('p_price');
 	var p_description = document.getElementById('p_description');
 	var pct_id = document.getElementById('pct_id');

	var formDataFile = document.getElementById('formDataFile');

	var computed_hash = window.some_variable = '<?= $_GET['editProduct']?>';

	displaydata(computed_hash);

 	AjaGETCategory();

 	function setnull(){
		p_Imagelook.value = null;
		p_name.value = null;
		p_caption.value = null;
		p_price.value = null;
		p_description.value = null;
		pct_id.value = null;
	}

	function setcolor(color){
		p_Imagelook.style.border = '1px solid ' + color;
		p_name.style.border = '1px solid ' + color;
		p_caption.style.border = '1px solid ' + color;
		p_price.style.border = '1px solid ' + color;
		p_description.style.border = '1px solid ' + color;
		pct_id.style.border = '1px solid ' + color;
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

		var fileLength = p_Imagelook.files.length;
		var filename = null;

		if(	fileLength > 1 || 
			!p_Imagelook.value || 
			!p_name.value || 
			!p_caption.value || 
			!p_price.value || 
			!p_description.value || 
			!pct_id.value)
		{

			setcolor('red');

		}else{

			var fileType = p_Imagelook.files[0].type.split('/');
			
			if(fileType.length !== 2){
				p_Imagelook.value = null;
				p_Imagelook.style.border = '1px solid red';
			}else{

				if(fileType[0] === 'image' && (fileType[1] === 'jpeg' || fileType[1] === 'jpg')){
					filename = p_Imagelook.files[0].name;

					const form = new FormData();
					const uploading = '../../upload.php';

					form.append("file",  p_Imagelook.files[0]);

					fetch(uploading, {
						method: "POST",
						body: form
					});
				}
			}

			if(!filename){
				p_Imagelook.value = null;
				p_Imagelook.style.border = '1px solid red';
			}else{

				var data = {
					adminInput:{
						p_Imagelook: filename,
						p_name: p_name.value,
						p_caption: p_caption.value,
						p_price: p_price.value,
						p_description: p_description.value,
						pct_id: pct_id.value,
						reference: computed_hash
					}
				}

				var tojson = JSON.stringify(data);
				AjaxCreateInput(tojson);
				setnull();
				setcolor('yellowgreen');
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
	            		window.location.href = 'productControlPage.php?productCreate=' + res.response.display.result[0].productLink;
	            	}
	           	}
	       	}
	   };

	request.open("POST", apiLinkcreate, true);
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

		            		option.innerHTML = res.response.display.result[i].pct_tittle;
		            		option.value = res.response.display.result[i].pct_id;
		            		pct_id.appendChild(option);
            			}	
            		}
	           }
	       }
	   };

	request.open("GET", apiLinkProductCategory, true);
	request.send();
}// end of the function

function AjaxGet(tojson) {

	var request = new XMLHttpRequest();
	   
   request.onreadystatechange = function() {

       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

            if (request.status === 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){
           			p_name.value = res.response.display.result[0].p_name;
           			p_caption.value = res.response.display.result[0].p_caption;
           			p_price.value = res.response.display.result[0].p_price;
           			p_description.value = res.response.display.result[0].p_description;
           			pct_id.value = res.response.display.result[0].pct_id;
            	}
           	}
       	}
   	};

	request.open("POST", apiLinkread, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function




 </script>