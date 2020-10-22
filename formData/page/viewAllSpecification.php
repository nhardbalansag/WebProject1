
<style type="text/css">
		.spectab{
			width: 90%;
			border-radius: 10px;
			text-align: center;
			margin:3% auto;
			padding: 2px 0px;
			background-color: #D3E4F5;
		}
		.spectab p:nth-of-type(1){
			font-weight: bolder;
			font-size: 20px;
		}
		spectab:nth-of-type(2){
			font-weight: lighter;
			font-size: 15px;
		}
		
	</style>

<div id="content" style="padding-bottom: 100%;">
	<div style="width: 95%; justify-content: flex-start; margin:auto;">
		<a href=

			<?php 

				echo "controlpage.php?specification=" . $_GET['specificationContent'];

			?> >
			
			<p style="font-size: 20px;">back</p>
		</a>
	</div>
	
	<div style="margin-top: 20px;" id="mainContainer">
	
	</div>

</div>

<script type="text/javascript">
	 	
 	var apiLinkget = '../../api/creator/admin/product/readAllSpecification.php';

 	var mainContainer = document.getElementById('mainContainer');

 	var back = document.getElementById('back');

 	const productReference = window.reference = '<?= $_GET['specificationContent'] ?>';
 	const category = window.reference = '<?= $_GET['type'] ?>';

 	var clickCount = null;

 	getSpecification(category, productReference);

	function getSpecification(category, productReference){
		var data = {
				adminInput:{
					reference: productReference,
					category: category
				}
			}
		var tojson = JSON.stringify(data);
		Ajaxdisplay(tojson);

	}// end of the function

	function Ajaxdisplay(tojson) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	var count = res.response.display.result.length;
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		for(var i = 0; i < count; i++){

	            			var spectab = document.createElement('div');
	            			spectab.setAttribute('class', 'spectab');

	            			var tittle = document.createElement('p');
	            			tittle.innerHTML = res.response.display.result[i].specs_s_specification_type;
	            			var description = document.createElement('p');
	            			description.innerHTML = res.response.display.result[i].specs_s_description;

	            			spectab.appendChild(tittle);
	            			spectab.appendChild(description);

	            			mainContainer.appendChild(spectab);
	            		}
	            	}
	           	}
	       	}
	   	};
		request.open("POST", apiLinkget, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(tojson);
	}// end of the function
</script>	