<div id="mainAdminContents">
	<div id="content" class="content">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "transactionControlPage.php?transaction=" . base64_encode('transactionIndex');

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
			
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">all product list</p>
	 		</div>
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>
			</div>
			<div id="mainContainer">
			
			</div>
 		</div>
</div>
 		
  <script type="text/javascript">
 	
 	var apiLinkget = '../../../../api/creator/admin/product/readAllPublishProducts.php';

 	var mainContainer = document.getElementById('mainContainer');

 	Ajaxdisplay();

	function Ajaxdisplay() {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	var count = res.response.display.result.length;
	            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	            		for(var i = 0; i < count; i++){

		           			var featuresDiv = document.createElement('a');
		           			featuresDiv.style.float = 'left';
		           			featuresDiv.style.width = '45%';
		           			featuresDiv.style.margin = '2%';
		           			featuresDiv.style.textAlign = 'center';
		           			featuresDiv.href = 'transactionControlPage.php?createNewPurchase=' + res.response.display.result[i].computed_hash;

		           			var item_image = document.createElement('img');
		           			item_image.setAttribute('src', '../../pics/' + res.response.display.result[i].productImage);
		           			item_image.style.width = '50%';
		           			item_image.style.borderRadius = '10px';

		           			var item_tittle = document.createElement('p');
		           			item_tittle.innerHTML = 'name: ' + res.response.display.result[i].p_name;

		           			featuresDiv.appendChild(item_image);
		           			featuresDiv.appendChild(item_tittle);

		           			mainContainer.appendChild(featuresDiv);
	            		}
	            	}
	           	}
	       	}
	   	};

	request.open("GET", apiLinkget, true);
	request.send();
}// end of the function


 </script>	