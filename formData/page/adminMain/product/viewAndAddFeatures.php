<style type="text/css">

	/*desktop view*/
	@media screen and (min-width: 700px) {  

		.image{
			width: 20%;
			border-radius: 10px;
		}

		.contentDisplay{
			display: flex;
			justify-content: center;
		}

		.buttonDivProduct{
			width: 20%; 
			margin:5% auto; 
			display: flex; 
			justify-content: space-around; 
			align-items: center;
		}

		.iconButtondesign{
			width: 30%;
			display: flex;
			justify-content: flex-start;
		}
			
	}

	/*mobile view*/
	@media screen and (max-width: 700px) {  

		.image{
			width: 40%;
			border-radius: 10px;
		}

		.contentDisplay{
			
		}

		.buttonDivProduct{
			width: 90%; 
			margin:5% auto; 
			display: flex; 
			justify-content: center; 
			align-items: center;
		}

		.iconButtondesign{
			width: 10%;
			display: flex;
			justify-content: flex-end;
		}

		.icontittle{
			width: 80%;
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
 				<p style="font-size: 20px; font-weight: bolder;">add feature</p>
	 		</div>
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>

	 			<div class="ProductInfoDiv">
					<a class="mobileContentButton buttonDivProduct" href=
						<?php 

							echo "productControlPage.php?viewAllFeatures=" . $_GET['viewAndAddFeatures'];

						?> >
						<div class="iconButtondesign">
							<p class="linkNumber"><i  class="fas fa-eye"></i></p>
						</div>
						<div class="icontittle">
							<p>view all features</p>
							<p id="result"></p>
						</div>
					</a>
	 			</div>
	 			<div class="oneSelectedProductDiv" id="ProductInfoDiv">
		 			
	 			</div>
		 		<form method="post" id="formDataFile">
					<div class="inputmobile adminInputDivs">
						<label>product image</label><br>
						<input class="inputmobile" type="file" id="f_image" placeholder="*select image" required>
					</div>
					<div class="inputmobile adminInputDivs">
						<input class="inputmobile" type="text" id="f_tittle" placeholder="*Feature Tittle" required>
					</div>
					<div class="inputmobile adminInputDivs">
						<label>description</label><br>
						<textarea  id="f_description" style="resize: none; font-size: 20px; background-color: white; width: 90%; border-radius: 5px;" rows="15" required></textarea>
					</div>
					<div style="width: 70%; margin:auto;">
						<button class="adminButton">
							Add Feature
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
 	
 	var apiLinkcreate = '../../../../api/creator/admin/product/createProductFeatures.php';
 	var apiLinkread = '../../../../api/creator/admin/product/readProduct.php';

 	var f_image = document.getElementById('f_image');
 	var f_tittle = document.getElementById('f_tittle');
 	var f_description = document.getElementById('f_description');

 	var ProductInfoDiv = document.getElementById('ProductInfoDiv');
	var reporting = document.getElementById('reporting');

	var formDataFile = document.getElementById('formDataFile');

	var computed_hash = window.some_variable = '<?= $_GET['viewAndAddFeatures']?>';

	displaydata(computed_hash);

	function setnull(){
		f_image.value = null;
		f_tittle.value = null;
		f_description.value = null;
	}

	function setcolor(color){
		f_image.style.borderColor = '1px solid ' + color;
		f_tittle.style.borderColor = '1px solid ' + color;
		f_description.style.borderColor = '1px solid ' + color;
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

		var fileLength = f_image.files.length;
		var filename = null;

		if(	fileLength > 1 || !f_tittle.value || !f_description.value){

			setcolor('red');

		}else{

			var fileType = f_image.files[0].type.split('/');
			
			if(fileType.length !== 2){
				f_image.value = null;
				f_image.style.border = '1px solid red';
			}else{

				if(fileType[0] === 'image' && (fileType[1] === 'jpeg' || fileType[1] === 'jpg')){
					filename = f_image.files[0].name;

					const form = new FormData();
					const uploading = '../../upload.php';

					form.append("file",  f_image.files[0]);

					fetch(uploading, {
						method: "POST",
						body: form
					});
				}
			}

			if(!filename){
				f_image.value = null;
				f_image.style.border = '1px solid red';
			}else{

				var data = {
					adminInput:{
						f_image: filename,
						f_tittle: f_tittle.value,
						f_description: f_description.value,
						productReference: computed_hash
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
	            		result.style.color = 'yellowgreen';
	           			result.innerHTML = 'added sucessfully';

	           			var divTwo = document.createElement('div');
	           			divTwo.setAttribute('class', 'linkContent');
	           			var pct_tittle = document.createElement('p');
	           			pct_tittle.innerHTML = res.response.display.result[0].f_tittle;
	           			
	           			var pct_description = document.createElement('p');
	           			pct_description.setAttribute('class', 'linkDescription');
	           			pct_description.innerHTML = res.response.display.result[0].f_description;
	           			divTwo.appendChild(pct_tittle);
	           			divTwo.appendChild(pct_description);


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
           			p_Imagelook.setAttribute('src', '../../pics/' + res.response.display.result[0].p_Imagelook);
           			imageDiv.appendChild(p_Imagelook);

           			// alert('/product_pics/' + res.response.display.result[0].p_Imagelook);

           			var contentDiv =  document.createElement('div');
           			contentDiv.setAttribute('class','ProductInfoDiv');
           			var p_name = document.createElement('p');
           			p_name.innerHTML = res.response.display.result[0].p_name;
           			var p_caption = document.createElement('p');
           			p_caption.innerHTML = res.response.display.result[0].p_caption;
           			var p_price = document.createElement('p');
           			p_price.innerHTML = res.response.display.result[0].p_price;
           			var p_description = document.createElement('p');
           			p_description.innerHTML = res.response.display.result[0].p_description;
           			var p_datecreated = document.createElement('p');
           			p_datecreated.innerHTML = 'date created: ' +  res.response.display.result[0].p_datecreated;
           			contentDiv.appendChild(p_name);
           			contentDiv.appendChild(p_caption);
           			contentDiv.appendChild(p_price);
           			contentDiv.appendChild(p_description);
           			contentDiv.appendChild(p_datecreated);

           			ProductInfoDiv.appendChild(imageDiv);
           			ProductInfoDiv.appendChild(contentDiv);
            	}
           	}
       	}
   	};

	request.open("POST", apiLinkread, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

 </script>