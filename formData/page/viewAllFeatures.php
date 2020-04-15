<style type="text/css">
		/*desktop view*/
		@media screen and (min-width: 700px) {  

			.image{
				width: 100%;
				border-radius: 10px;
			}

			.featureDiv{
				text-align: center;
				margin: 2%;
				background-color: #D3E4F5;
				border-radius: 10px;
				padding: 10px;
				width: 20%;
				float: left;

			}

			.featureDiv p:nth-of-type(1){
				font-size: 30px;
				font-weight: bolder;
				text-transform: uppercase;
			}

			.featureDiv p:nth-of-type(2){
				font-size: 20px;
				font-weight: bolder;
				text-transform: lowercase;
			}

		}

		/*mobile view*/
		@media screen and (max-width: 700px) {  

			.image{
				width: 100%;
				border-radius: 10px;
			}

			.featureDiv{
				text-align: center;
				margin: 2%;
				background-color: #D3E4F5;
				border-radius: 10px;
				padding: 10px;
				width: 90%;
				float: left;
			}

			.featureDiv p:nth-of-type(1){
				font-size: 30px;
				font-weight: bolder;
				text-transform: capitalize;
			}

			.featureDiv p:nth-of-type(2){
				font-size: 20px;
				font-weight: bolder;
				text-transform: lowercase;
			}
		}

		
	</style>

<div id="content">
	<div style="width: 95%; justify-content: flex-start; margin:auto;">
		<a href=

			<?php 

				echo "controlpage.php?specification=" . $_GET['features'];

			?> >
			
			<p style="font-size: 20px;">back</p>
		</a>
	</div>
	
	<div style="display: inline-block; margin: auto;" id="mainContainer">
	
	</div>

</div>

<script type="text/javascript">
 	const apiLinkread = '../../api/creator/admin/product/readAllFeatures.php';

 	const computed_hash = window.some_variable = '<?= $_GET['features']?>';

	displaydata(computed_hash);

	var mainContainer = document.getElementById('mainContainer');

 	function displaydata(computed_hash){

		var data = {
			adminInput:{
				computed_hash: computed_hash
			}
		}
		var tojson = JSON.stringify(data);
		AjaxGet(tojson);
	}// dn of the function

	function AjaxGet(tojson) {

	var request = new XMLHttpRequest();
	   
   	request.onreadystatechange = function() {

       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

            if (request.status === 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

            		var count  = res.response.display.result.length;

            		for(var i = 0; i < count; i++){

	           			var featuresDiv = document.createElement('div');
	           			featuresDiv.setAttribute('class', 'featureDiv');

	           			var item_image = document.createElement('img');
	           			item_image.setAttribute('src', 'pics/' + res.response.display.result[i].feature_f_image);
	           			item_image.setAttribute('class', 'image');
	           			
	           			var item_tittle = document.createElement('p');
	           			item_tittle.innerHTML = res.response.display.result[i].feature_f_tittle;

	           			var item_description = document.createElement('p');
	           			item_description.innerHTML = res.response.display.result[i].feature_f_description;

	           			featuresDiv.appendChild(item_image);
	           			featuresDiv.appendChild(item_tittle);
	           			featuresDiv.appendChild(item_description);

	           			mainContainer.appendChild(featuresDiv);
            		}
            	}
           	}
       	}
   	};

	request.open("POST", apiLinkread, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function
 </script>