<div id="mainAdminContents">
	<div id="content" class="content">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?product=" . base64_encode('viewAndAddProductCategoryType');

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">product category type</p>
 				<p id="result"></p>
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
 		
<script type="text/javascript">

var ApiLinkGet = '../../../../api/creator/admin/product/readProductCategory.php';
var mainContainer = document.getElementById('mainContainer');

displayProductCategoryType();

function displayProductCategoryType() {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

            if (request.status === 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request

            	var resultLength = res.response.display.result.length;

           		if(res.response.http_response_code === 200 && res.response.reason === 'success'){

           			for(var i = 0; i < resultLength; i++){

            			result.style.color = 'yellowgreen';
	           			result.innerHTML = 'product category results';

	           			var divOne = document.createElement('div');
	           			var pOne = document.createElement('p');
	           			pOne.setAttribute('class', 'linkNumber');
	           			pOne.innerHTML = i + 1;
	           			divOne.appendChild(pOne);


	           			var divTwo = document.createElement('div');
	           			divTwo.setAttribute('class', 'linkContent');
	           			var pct_tittle = document.createElement('p');
	           			pct_tittle.innerHTML = res.response.display.result[i].pct_tittle;
	           			
	           			var pct_description = document.createElement('p');
	           			pct_description.setAttribute('class', 'linkDescription');
	           			pct_description.innerHTML = res.response.display.result[i].pct_description;
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
            		}// end of the for
            	}
       		}
		}
   	};

	request.open("GET", ApiLinkGet, true);
	request.send();
}// end of the function
</script>