<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 70px;">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?product=" . base64_encode('manageProduct');

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>

 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">add product</p>
	 		</div>
	 		<div style="text-align: center;">
				<form method="post" id="formDataFile">
	 				<div class="inputmobile adminInputDivs">
						<label>product image</label><br>
						<input class="inputmobile" type="file" name="p_Imagelook" id="p_Imagelook" placeholder="*select image" required>
					</div>
					<div class="inputmobile adminInputDivs">
						<input class="inputmobile" type="text" id="p_name" name="p_name" placeholder="*name" required>
						<input class="inputmobile" type="text" id="p_caption" placeholder="*caption" required>
						<input class="inputmobile" type="number" id="p_price" placeholder="*price" required>
					</div>
					<div class="inputmobile adminInputDivs">
						<label>description</label><br>
						<textarea  id="p_description" style="resize: none; font-size: 20px; background-color: white; width: 90%; border-radius: 5px;" rows="15" required></textarea>
					</div>
					<div class="inputmobile adminInputDivs">
						<label>product category</label><br>
						<select class="inputmobile" id="pct_id">
							
						</select>
					</div>
					<div style="width: 70%; margin:auto;">
						<button type="submit" class="adminButton" name="sendDocs">
							Add Product
						</button>
					</div>
				</form>
			</div>
 		</div>
</div>
 		



<script type="text/javascript">
 	
 	var apiLinkcreate = '../../../../api/creator/admin/product/createProduct.php';
 	var apiLinkProductCategory = '../../../../api/creator/admin/product/readProductCategory.php';

 	var p_Imagelook = document.getElementById('p_Imagelook');
 	var p_name = document.getElementById('p_name');
 	var p_caption = document.getElementById('p_caption');
 	var p_price = document.getElementById('p_price');
 	var p_description = document.getElementById('p_description');
 	var pct_id = document.getElementById('pct_id');

	var formDataFile = document.getElementById('formDataFile');

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
						pct_id: pct_id.value
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




 </script>