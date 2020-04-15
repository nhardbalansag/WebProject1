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
	<div id="content" class="content" style="padding-bottom: 100px;">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?productCreate=" . $_SESSION['productHash'];

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">add specification</p>
 				<p id="result"></p>
	 		</div>
 			
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>

	 			<div class="ProductInfoDiv">

	 				<a class="mobileContentButton buttonDivProduct" href=
						<?php 

							echo "productControlPage.php?productSpecificationCategory=" . $_GET['viewAndAddSpecification'];

						?> >
						<div class="iconButtondesign">
							<p class="linkNumber"><i  class="fas fa-eye"></i></p>
						</div>
						<div class="icontittle">
							<p>view all specification</p>
							<p id="result"></p>
						</div>
					</a>
	 			</div>
	 			<div class="oneSelectedProductDiv" id="ProductInfoDiv">
		 			
	 			</div>

	 			<form method="post" id="formData"> 
	 				<div class="inputmobile adminInputDivs">
						<label>specification</label><br>
						<input class="inputmobile" type="text" id="s_specification_type_field" placeholder="*Specification Type" required><br>
						<input class="inputmobile" type="text" id="s_description_field" placeholder="*Description" required>
					</div>
					<div class="inputmobile adminInputDivs">
						<label>specification category</label><br>
						<select class="inputmobile" id="s_category_field" required><br>
							<option>*Category</option>
							<option value="engine">*Engine</option>
							<option value="dimension">*Dimention</option>
							<option value="framework">*Framework</option>
						</select>
					</div>
					
					<div style="width: 70%; margin:auto;">
						<button class="adminButton">
							Add
						</button>
					</div>
	 			</form>
				
			</div>

			<div id="mainContainer" style="margin: auto; width: 90%" >
			
			</div>
 		</div>
</div>
 		
 
 <script type="text/javascript">
 	const computed_hash = window.some_variable = '<?= $_GET['viewAndAddSpecification']?>';

 	const apiLinkread = '../../../../api/creator/admin/product/readProduct.php';
 	const apiLinkcreate = '../../../../api/creator/admin/product/createSpecification.php';

 	const s_specification_type_field = document.getElementById('s_specification_type_field');
 	const s_description_field = document.getElementById('s_description_field');
 	const s_category_field = document.getElementById('s_category_field');
 	const result = document.getElementById('result');

 	displaydata(computed_hash);

 	document.getElementById('formData').addEventListener('submit', event=>{
 		event.preventDefault();
 		getInput();
 	});

 	 function displaydata(computed_hash){

		var data = {
			adminInput:{
				computed_hash: computed_hash
			}
		}
		var tojson = JSON.stringify(data);
		AjaxGet(tojson);
	}// dn of the function

 	function setnull(){
		s_specification_type_field.value = null;
		s_description_field.value = null;
		s_category_field.value = null;
	}

	function setcolor(color){
		s_specification_type_field.style.borderColor = color;
		s_description_field.style.borderColor = color;
		s_category_field.style.borderColor = color;
	}

	function getInput(){

		if(!s_specification_type_field.value || !s_description_field.value || !s_category_field.value){
			setcolor('red');
			setnull();
		}else{

			var data = {
				adminInput:{
					s_specification_type_field: s_specification_type_field.value,
					s_description_field: s_description_field.value,
					s_category_field: s_category_field.value,
					productReference: computed_hash
				}
			}
			var tojson = JSON.stringify(data);
			AjaxCreateInput(tojson);
			setcolor('yellowgreen');
		}
		setnull();
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

	           			var pOne = document.createElement('p');
	           			pOne.innerHTML = res.response.display.result[0].s_category;
	           			pOne.style.color = 'yellowgreen';


	           			var divTwo = document.createElement('div');
	           			divTwo.setAttribute('class', 'linkContent');
	           			var pct_tittle = document.createElement('p');
	           			pct_tittle.innerHTML = res.response.display.result[0].s_tittle;
	           			
	           			var pct_description = document.createElement('p');
	           			pct_description.setAttribute('class', 'linkDescription');
	           			pct_description.innerHTML = res.response.display.result[0].s_description;
	           			divTwo.appendChild(pOne);
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
           			p_Imagelook.setAttribute('src', '../../pics/' + res.response.display.result[0].p_Imagelook);
           			imageDiv.appendChild(p_Imagelook);
           			p_Imagelook.setAttribute('class', 'image');

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