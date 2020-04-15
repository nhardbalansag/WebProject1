<?php

if(isset($_GET['productCreate'])){
	$_SESSION['productHash'] = $_GET['productCreate'];
}

?>
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
			width: 70%; 
			margin:5% auto; 
			display: flex; 
			justify-content: center; 
			align-items: center;
		}

		.iconButtondesign{
			width: 30%;
			display: flex;
			justify-content: flex-end;
		}

	}	
</style>
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
 				<p style="font-size: 20px; font-weight: bolder;">product information</p>
	 		</div>
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>
	 			<div class="contentDisplay">
	 				<div class="ProductInfoDiv" id="ProductInfoDiv">
					
		 			</div>
		 			<p id="reporting"></p>
		 			<div class="oneSelectedProductDiv" id="oneSelectedProductDiv">
			 			
		 			</div>

	 			</div>
			</div>
			<div style="padding-top: 20px; ">
				<div class="sortDiv">
							<select class="sort" id="cp_status" style="font-size: 20px;">
								<option value="null">Product Status</option>
								<option value="publish">publish</option>
								<option value="pending">pending</option>
							</select>
						</div>
				
				<div class="buttonDivProduct">
					<button class="adminButton" onclick="getInput();">
						save
					</button>

					<a href=
						<?php 

							echo "productControlPage.php?editProduct=" . $_GET['productCreate'];

						?> >
						edit
					</a>
					
				</div>
			</div>
 		</div>
	</div>
 		
<script type="text/javascript">

const apiLinkread = '../../../../api/creator/admin/product/readProduct.php';
const apiLinkPost = '../../../../api/creator/admin/product/addCreatedProduct.php';

const oneSelectedProductDiv = document.getElementById('oneSelectedProductDiv');
const reporting = document.getElementById('reporting');
const cp_status = document.getElementById('cp_status');
const ProductInfoDiv = document.getElementById('ProductInfoDiv');

const computed_hash = window.some_variable = '<?= $_GET['productCreate']?>';

displaydata(computed_hash);

addreference();

function displaydata(computed_hash){

		var data = {
			adminInput:{
				computed_hash: computed_hash
			}
		}
		var tojson = JSON.stringify(data);
		AjaxGet(tojson);
}// dn of the function

function getInput(){

	if(cp_status.value === 'null'){
		reporting.style.color = 'red';
        reporting.innerHTML = 'please select product status'
	}else{
		var data = {
			adminInput:{
				cp_status: cp_status.value,
				reference: computed_hash
			}
		}
		var tojson = JSON.stringify(data);
		AjaxPost(tojson);
	}
		
}// dn of the function

function AjaxPost(tojson) {

	var request = new XMLHttpRequest();
	   
   request.onreadystatechange = function() {

       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

            if (request.status === 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){
           			
           			reporting.style.color = 'yellowgreen';
           			reporting.innerHTML = res.response.display.result;
            	}
           	}
       	}
   	};

	request.open("POST", apiLinkPost, true);
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

           			oneSelectedProductDiv.appendChild(imageDiv);
           			oneSelectedProductDiv.appendChild(contentDiv);

            	}
           	}
       	}
   	};

	request.open("POST", apiLinkread, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

function addreference(){

	const page = ["viewAllFeatures", "productSpecificationCategory", "viewAllColors", "viewAndAddFeatures", "viewAndAddSpecification", "viewAndAddColor"];
	const icons = ["fas fa-eye", "fas fa-plus"];
	const tittle = ["view all feature of this product", "view all specification", "view all colors", "add features to this product", "add specification to this product", "add color to this product"];
	var icondesign = "";

	for(var i = 0; i < page.length; i++){

		if(i < 3){
			icondesign = icons[0];
		}else{
			icondesign = icons[1];
		}

		const viewAllFeatures = document.createElement('a');
		viewAllFeatures.setAttribute('class', 'mobileContentButton');
		viewAllFeatures.href = 'productControlPage.php?' + page[i] + '=' + computed_hash;
		viewAllFeatures.style.display = 'flex';
		viewAllFeatures.style.justifyContent = 'space-between';
		viewAllFeatures.style.width = '80%';

		const icondiv = document.createElement('div');
		const iconp = document.createElement('p');
		iconp.setAttribute('class', 'linkNumber');
		const icon = document.createElement('i');
		icon.setAttribute('class', icondesign);
		iconp.appendChild(icon);
		icondiv.appendChild(iconp);
		icondiv.setAttribute('class', 'iconButtondesign');
		

		const tittlediv = document.createElement('div');
		const tittlep = document.createElement('p');
		tittlep.style.fontSize = '13px';
		tittlep.style.marginLeft = '20px';
		tittlep.innerHTML = tittle[i];
		tittlediv.appendChild(tittlep);
		tittlediv.style.width = '50%';
		tittlediv.style.textAlign = 'left';
		
		viewAllFeatures.appendChild(tittlediv);
		viewAllFeatures.appendChild(icondiv);

		ProductInfoDiv.appendChild(viewAllFeatures);

	}

}


</script>