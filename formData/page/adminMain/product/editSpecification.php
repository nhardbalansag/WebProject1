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
 				<p style="font-size: 20px; font-weight: bolder;">edit specification</p>
 				<p id="result"></p>
	 		</div>
 			
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>
	 			<div class="oneSelectedProductDiv" id="ProductInfoDiv">
		 			
	 			</div>
	 			<form method="post" id="formdata">
	 				<div class="inputmobile adminInputDivs">
						<label>specification</label><br>
						<input class="inputmobile" type="text" id="s_specification_type_field" placeholder="*Specification Type" required>
						<input class="inputmobile" type="text" id="s_description_field" placeholder="*Description" required>
					</div>
					<div class="inputmobile adminInputDivs">
						<label>specification category</label><br>
						<select class="inputmobile" id="s_category_field" required>
							<option>*Category</option>
							<option value="engine">*Engine</option>
							<option value="dimension">*Dimention</option>
							<option value="framework">*Framework</option>
						</select>
					</div>
					
					<div style="width: 70%; margin:auto;">
						<button class="adminButton">
							save edit
						</button>
					</div>
	 			</form>
				
			</div>

			<div id="mainContainer" style="margin: auto; width: 90%" >
			
			</div>
 		</div>
</div>
 		
 
 <script type="text/javascript">
 	const computed_hash = window.some_variable = '<?= $_GET['editSpecification']?>';
 	const productReference = window.some_variable = '<?= $_SESSION['productHash']?>';

 	const apiLinkread = '../../../../api/creator/admin/product/readOneSpecification.php';
 	const apiLinkcreate = '../../../../api/creator/admin/product/editSpecification.php';

 	const s_specification_type_field = document.getElementById('s_specification_type_field');
 	const s_description_field = document.getElementById('s_description_field');
 	const s_category_field = document.getElementById('s_category_field');
 	const result = document.getElementById('result');

 	const ProductInfoDiv = document.getElementById('ProductInfoDiv');

 	document.getElementById('formdata').addEventListener('submit', event=>{
 		event.preventDefault();
 		getInput();
 	});

 	displaydata(computed_hash);

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
					reference: computed_hash
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
	           			result.innerHTML = 'edited sucessfully';

	           			var pOne = document.createElement('p');
	           			pOne.innerHTML = res.response.display.result.s_category;
	           			pOne.style.color = 'yellowgreen';

	           			var divTwo = document.createElement('div');
	           			divTwo.setAttribute('class', 'linkContent');
	           			var pct_tittle = document.createElement('p');
	           			pct_tittle.innerHTML = res.response.display.result.s_tittle;
	           			
	           			var pct_description = document.createElement('p');
	           			pct_description.setAttribute('class', 'linkDescription');
	           			pct_description.innerHTML = res.response.display.result.s_description;
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

	           			window.location.href = 'productControlPage.php?editSpecification=' + res.response.display.result.reference;
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

            		s_specification_type_field.value = res.response.display.result[0].s_specification_type;
            		s_description_field.value = res.response.display.result[0].s_description;
            		s_category_field.value = res.response.display.result[0].s_category;

            		const viewAllFeatures = document.createElement('a');
					viewAllFeatures.setAttribute('class', 'mobileContentButton');
					viewAllFeatures.setAttribute('class', 'buttonDivProduct');
					viewAllFeatures.href = 'productControlPage.php?productSpecificationCategory=' + productReference;

					const icondiv = document.createElement('div');
					const iconp = document.createElement('p');
					iconp.setAttribute('class', 'linkNumber');
					const icon = document.createElement('i');
					icon.setAttribute('class', 'fas fa-eye');
					icondiv.setAttribute('class', 'iconButtondesign');
					iconp.appendChild(icon);
					icondiv.appendChild(iconp);

					const tittlediv = document.createElement('div');
					const tittlep = document.createElement('p');
					tittlep.innerHTML = 'view all specification';
					tittlediv.appendChild(tittlep);
					tittlediv.setAttribute('class', 'icontittle');
					
					viewAllFeatures.appendChild(tittlediv);
					viewAllFeatures.appendChild(icondiv);

					ProductInfoDiv.appendChild(viewAllFeatures);
            	}
           	}
       	}
   	};

	request.open("POST", apiLinkread, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function
 </script>