<style type="text/css">

	/*desktop view*/
	@media screen and (min-width: 700px) {  

		.image{
			width: 50%;
			border-radius: 10px;
		}

	}

	/*mobile view*/
	@media screen and (max-width: 700px) {  

		.image{
			width: 100%;
			border-radius: 10px;
		}
	}
	
</style>

<div id="mainAdminContents">
	<div id="content" class="content">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?product=" . base64_encode('manageProduct');

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>

			
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">publish products</p>
	 		</div>
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>
			</div>
			<div class="sortDiv">
				<select class="sort">
					<option>sort by</option>
					<option value="telephone">date ascending</option>
					<option value="mobile">date descending</option>
					<option value="hotline">name ascending</option>
					<option value="hotline">name descending</option>
				</select>
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
		           			featuresDiv.style.float = 'left';
		           			featuresDiv.style.width = '45%';
		           			featuresDiv.style.margin = '2%';
		           			featuresDiv.style.textAlign = 'center';
		           			featuresDiv.href = 'productControlPage.php?productCreate=' + res.response.display.result[i].computed_hash;

		           			var item_image = document.createElement('img');
		           			item_image.setAttribute('src', '../../pics/' + res.response.display.result[i].productImage);
		           			item_image.setAttribute('class', 'image');

		           			var  item_date = document.createElement('p');
		           			item_date.innerHTML = 'date created: ' + res.response.display.result[i].cp_dateCreated;

		           			var item_tittle = document.createElement('p');
		           			item_tittle.innerHTML = 'name: ' + res.response.display.result[i].p_name;

		           			featuresDiv.appendChild(item_image);
		           			featuresDiv.appendChild(item_date);
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