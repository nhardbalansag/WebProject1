
<style type="text/css">

	/*desktop view*/
	@media screen and (min-width: 700px) {  

		.buttonView{
			display: flex; 
			justify-content: space-between;
			width: 80%;
		}

		.iconDivbutton{
			width: 45%;
			display: flex;
			justify-content: flex-start;
		}

		.tittledivbuttondiv{
			width: 53%;
			text-align: right;
		}

		.tittledivbuttondiv p{
			font-size: 20px;
		}
	
	}

	/*mobile view*/
	@media screen and (max-width: 700px) {  

		.buttonView{
			display: flex; 
			justify-content: space-between;
			width: 80%;
		}

		.iconDivbutton{
			width: 50%;
			display: flex;
			justify-content: flex-end;
		}

		.tittledivbuttondiv{
			width: 50%;
			text-align: center;
		}

		.tittledivbuttondiv p{
			font-size: 15px;
		}
	
	}
	
</style>

<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 70px;">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?product=" . base64_encode('productIndex');
					?> >

					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">

 				<p style="font-size: 20px; font-weight: bolder;">manage product category type</p>
 				<p id="result"></p>
 				<a class="mobileContentButton buttonView" href=
						<?php 

							echo "productControlPage.php?product=" . base64_encode('viewAllProductCategory');

						?> >
					<div class="tittledivbuttondiv">
						<p>view all product category</p>
					</div>
					<div class="iconDivbutton">
						<p class="linkNumber"><i  class="fas fa-eye"></i></p>
					</div>
				</a>
	 		</div>
	 		<div style="text-align: center;">

	 			
				<div class="inputmobile adminInputDivs">
					<label>product category type</label><br>
					<input class="inputmobile" type="text" id="pct_tittle" placeholder="*tittle"><br>
					<input class="inputmobile" type="text" id="pct_description" placeholder="*description">
					
				</div>
				<div style="width: 70%; margin:auto;">
					<button class="adminButton" onclick="getInput()">
						add category
					</button>
				</div>
			</div>
			<div id="mainContainer">
				
			</div>
 		</div>
</div>
 		
 		
 <script type="text/javascript">
 	
 	var apiLinkcreate = '../../../../api/creator/admin/product/createProductCategorytype.php';

	var result = document.getElementById('result');

	var pct_tittle = document.getElementById('pct_tittle');
	var pct_description = document.getElementById('pct_description');
	var mainContainer = document.getElementById('mainContainer');

	function setnull(){
		pct_tittle.value = null;
		pct_description.value = null;
	}

	function setcolor(color){
		pct_tittle.style.borderColor = color;
		pct_description.style.borderColor = color;
	}


	function getInput(){

		if(!pct_tittle.value || !pct_description.value){
			setcolor('red');
			setnull();
		}else{

			var data = {
				adminInput:{
					pct_tittle: pct_tittle.value,
					pct_description: pct_description.value
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

	           			var divOne = document.createElement('div');
	           			var pOne = document.createElement('p');
	           			pOne.setAttribute('class', 'linkNumber');
	           			pOne.innerHTML = 1;
	           			divOne.appendChild(pOne);


	           			var divTwo = document.createElement('div');
	           			divTwo.setAttribute('class', 'linkContent');
	           			var pct_tittle = document.createElement('p');
	           			pct_tittle.innerHTML = res.response.display.result[0].pct_tittle;
	           			
	           			var pct_description = document.createElement('p');
	           			pct_description.setAttribute('class', 'linkDescription');
	           			pct_description.innerHTML = res.response.display.result[0].pct_description;
	           			divTwo.appendChild(pct_tittle);
	           			divTwo.appendChild(pct_description);


	           			var contentContainer = document.createElement('div');
	           			contentContainer.setAttribute('class', 'reportingContent');
	           			contentContainer.appendChild(divOne);
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



 </script>