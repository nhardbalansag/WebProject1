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
 				<p style="font-size: 20px; font-weight: bolder;">product features</p>
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
			<div id="mainContainer" style="margin: auto; width: 90%" >
			
			</div>
 		</div>
</div>
 		
 		

 <script type="text/javascript">
 	const apiLinkread = '../../../../api/creator/admin/product/readAllFeatures.php';

 	const computed_hash = window.some_variable = '<?= $_GET['viewAllFeatures']?>';

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

	           			var featuresDiv = document.createElement('a');
	           			featuresDiv.style.float = 'left';
	           			featuresDiv.style.width = '45%';
	           			featuresDiv.style.margin = '2%';
	           			featuresDiv.style.textAlign = 'center';
	           			featuresDiv.href = 'productControlPage.php?editFeature=' + res.response.display.result[i].feature_computed_hash;

	           			var item_image = document.createElement('img');
	           			item_image.setAttribute('src', '../../pics/' + res.response.display.result[i].feature_f_image);
	           			item_image.setAttribute('class', 'image');
	           			

	           			var  item_date = document.createElement('p');
	           			item_date.innerHTML = 'date created: ' + res.response.display.result[i].feature_f_created;

	           			var item_tittle = document.createElement('p');
	           			item_tittle.innerHTML = 'feature name: ' + res.response.display.result[i].feature_f_tittle;

	           			var item_description = document.createElement('p');
	           			item_description.innerHTML = 'description: ' + res.response.display.result[i].feature_f_description;

	           			featuresDiv.appendChild(item_image);
	           			featuresDiv.appendChild(item_date);
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