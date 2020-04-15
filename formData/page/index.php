

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

<div id="content" style="padding-bottom: 100%;">
	<div id="mainContainer" style="padding-bottom: 100%">
		
	</div>
</div>

<script type="text/javascript">
 	
 	var apiLinkget = '../../api/creator/admin/product/readAllPublishProducts.php';

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
		           			featuresDiv.style.width = '95%';
		           			featuresDiv.style.margin = '2%';
		           			featuresDiv.style.textAlign = 'center';
		           			featuresDiv.href = 'productControlPage.php?productCreate=' + res.response.display.result[i].computed_hash;

		           			var item_image = document.createElement('img');
		           			item_image.setAttribute('src', 'pics/' + res.response.display.result[i].productImage);
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