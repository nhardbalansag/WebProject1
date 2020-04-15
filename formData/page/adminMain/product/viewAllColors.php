<div id="mainAdminContents">
	<div id="content" class="content">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?productCreate=" . $_GET['viewAllColors'];

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">color variety</p>
	 		</div>
 			
			<div id="tablediv" style="width: 90%; margin: 10% auto;">
		
			</div>
 		</div>
</div>
 		

 <script type="text/javascript">

 	var apiLinkread = '../../../../api/creator/admin/product/readAllColor.php';
 	
 	const productReference = window.some_variable = '<?= $_SESSION['productHash']?>';
 	const s_category_field =document.getElementById('s_category_field');

 	var tablediv = document.getElementById('tablediv');

 	displaydata();

	function displaydata(){

		var data = {
			adminInput:{
				reference: productReference
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

			 			var link = document.createElement('a');
			 			link.style.textAlign = 'center';
			 			link.href = 'productControlPage.php?editColor=' + res.response.display.result[i].color_computed_hash;

			 			var tittle = document.createElement('p');
			 			tittle.style.fontWeight = 'bolder';
			 			tittle.innerHTML = res.response.display.result[i].color_c_name;

			 			var tittlediv = document.createElement('div');
			 			tittlediv.style.textAlign = 'center';
			 			tittlediv.style.borderBottom = '1px solid black';
			 			tittlediv.appendChild(tittle);

			 			link.appendChild(tittlediv);

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