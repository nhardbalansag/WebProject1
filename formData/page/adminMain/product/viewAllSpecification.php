<style type="text/css">
	.linkstyle{
		display: flex;
		justify-content: space-between;
		align-items: center;
		width: 80%;

	}
</style>

<div id="mainAdminContents">
	<div id="content" class="content">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?productSpecificationCategory=" . $_SESSION['productHash'];

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">

 					<?php
 						echo base64_decode($_GET['viewallSpecificationCategory'])
 					?>
 				</p>
	 		</div>
 			
			<div id="tablediv" style="width: 90%; margin:auto;">
		
			</div>
 		</div>
</div>

 <script type="text/javascript">

 	var apiLinkread = '../../../../api/creator/admin/product/readAllSpecification.php';

 	const specificationCategory = window.some_variable = '<?= base64_decode($_GET['viewallSpecificationCategory'])?>';
 	const productReference = window.some_variable = '<?= $_SESSION['productHash']?>';
 	const s_category_field =document.getElementById('s_category_field');

 	displaydata();

	function displaydata(){

		var data = {
			adminInput:{
				reference: productReference,
				category: specificationCategory
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

            			var tablediv = document.getElementById('tablediv');

			 			var link = document.createElement('a');
			 			link.setAttribute('class', 'linkstyle');
			 			link.href = 'productControlPage.php?editSpecification=' + res.response.display.result[i].specs_computed_hash;

			 			var tittle = document.createElement('p');
			 			tittle.style.fontWeight = 'bolder';
			 			tittle.style.color = 'black';
			 			tittle.innerHTML = res.response.display.result[i].specs_s_specification_type;

			 			var tittlediv = document.createElement('div');
			 			tittlediv.style.width = '40%';
			 			tittlediv.style.textAlign = 'left';
			 			tittlediv.appendChild(tittle);

			 			var description = document.createElement('p');
			 			description.innerHTML = res.response.display.result[i].specs_s_description;

			 			var descriptionDiv = document.createElement('div');
			 			descriptionDiv.style.width = '60%';
			 			descriptionDiv.style.textAlign = 'center';
			 			descriptionDiv.appendChild(description);

			 			link.appendChild(tittlediv);
			 			link.appendChild(descriptionDiv);

			 			tablediv.appendChild(link);
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