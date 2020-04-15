
<!-- header -->
<!DOCTYPE html>
<html>
<head>
	<title>landing</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="formData/page/asset/customer.css">
	<link rel="stylesheet" type="text/css" href="formData/page/asset/fa/fontAwesome/css/all.css">
	<!-- <link rel="stylesheet" type="text/css" href="asset/fa/fontAwesome/css/brand.css"> -->
	<style type="text/css">
		/*desktop view*/
		@media screen and (min-width: 700px) {  

			.image{
				width: 100%;
				border-radius: 10px;
			}

			.ContentDiv{
				width: 20%;
				float: left;
				margin:2%;
				text-align: center;
				border-radius: 10px;
				background-color: #111740;
			}
			.tittle{
				font-size:30px;
				font-weight: bolder;
				color: white;
			}

			.footer{
				position: fixed;
				left: 0;
			   	bottom: 0;
			   	width: 100%;
			   	color: white;
			   	background-color:rgb(10,15,42);
			}

		}

		/*mobile view*/
		@media screen and (max-width: 700px) {  

			.image{
				width: 100%;
				border-radius: 10px;
			}

			.ContentDiv{
				width: 96%;
				float: left;
				margin:2%;
				text-align: center;
				background-color: #111740;
				border-radius: 10px;
			}

			.tittle{
				font-size:30px;
				font-weight: bolder;
				color: white;

			}


			
		}

		.footer{
				position: fixed;
				left: 0;
			   	bottom: 0;
			   	width: 100%;
			   	color: white;
			   	background-color:rgb(10,15,42);
			}

		
	</style>

</head>
<!-- end of the header -->

<!-- navigations	 -->
	<body>
		<div class="navigations" style="display: flex; align-items: center; justify-content: space-around; ">
			<a href=

				<?php 

					echo "index.php"; 

				?> >

				<h1 style="color: red; font-size: 40px;">YAMAHA</h1>
			</a>
			<span id="navbuttonright"><i  class="fas fa-angle-right" style="font-size: 30px; color: white;"></i></span>
			<span id="navbuttondown"><i  class="fas fa-angle-down" style="font-size: 30px; color: white;"></i></span>
		</div>
		<div id="dropdown">
			<div id="about" class="dContentDesign" style="text-align: left">
				<span>
					<a href=""><p>about</p></a>
				</span>
			</div>
			<div id="products" class="dContentDesign">
				<span style="display: flex; justify-content: space-between; align-items: center;">
					<p>products</p> <span><i id="navbutton" class="fas fa-plus-square" style="font-size: 30px; color: white;"></i></span>
				</span>
				<div id="product_miniDrop">
					<ul>
						<li class="miniprodCat">
							<a href="" class="miniProd">category 2</a>
						</li>
						<li class="miniprodCat">
							<a href="" class="miniProd">category 2</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="inquiries" class="dContentDesign">
				<span>
					<a href=
						<?php 
								echo "formData/page/controlpage.php?p=" . base64_encode('vInquire'); 
						?> >
					<p>inquiries</p></a>
				</span>
			</div>
			<div id="login" class="dContentDesign">
				<span>
					<a href= 
						<?php 
								echo "formData/page/controlpage.php?p=" . base64_encode('login'); 
						?> >
					<p>login</p></a>
				</span>
			</div>
			<div id="verify" class="dContentDesign">
				<span>
					<a href= 
						<?php 
								echo "formData/page/controlpage.php?p=" . base64_encode('verify'); 
						?> >
					<p>verify</p></a>
					
				</span>
			</div>
			<div id="register" class="dContentDesign">
				<span>
					<a href=
						<?php 
									echo "formData/page/controlpage.php?p=" . base64_encode('register'); 
						?> >
					<p>register</p></a>
				</span>
			</div>
		</div>
<!-- end of navigation -->

<!-- content -->
		<div id="content" style="padding-bottom:10%;">
			<div id="mainContainer" style="display: inline-block; margin: auto;">
				
			</div>
		</div>
<!-- end of content -->

<!-- footer -->
		<div style="background-color:rgb(10,15,42); width: 100%; margin:auto; ">
			<div class="branchInformation">
				<div id="bi_content">
					<div id="links">
						
					</div>
				</div>
				<div class="informations" id="about">
					<h3 style="color: white; font-size: 30px">ABOUT US</h3>
					<p style="color: white" id="bi_about">
						
					</p>
				</div>
				<div id="contact">
					<p style="font-weight: bold; color: white; text-align: center;">TALK TO US</p>

				</div>
				<div id="email">
					<p style="font-weight: bold; color: white; text-align: center;">MESSAGE US</p>
				</div>
				<div class="informations" id="about">
					<h3 style="color: white; font-size: 30px">ADDRESS</h3>
					<p style="color: white" id="address">
						
					</p>
				</div>
				<div  class="informations" id="talktous" style="border-bottom: none">
					<p style="font-weight: bold;">official business hours</p>
					<p>monday to thursday & saturday (10:00am - 8:00pm) friday(10:00am - 9:00Pm)</p>

					<p style="font-weight: bold;">service hours</p>
					<p>monday to thursday & saturday (10:00am - 8:00pm) friday(10:00am - 9:00Pm)</p>
				</div>
			</div>
		</div>
		
<!-- scripts -->
	<script type="text/javascript" src="formData/page/asset/js/yamaha.js"></script>
	<script type="text/javascript">

		var apilink = 'api/creator/admin/branchInformation/readAllInformation.php';

		var linksContainer = document.getElementById('links');
		var emailContainer = document.getElementById('email');
		var contactContainer = document.getElementById('contact');
		var bi_about = document.getElementById('bi_about');
		var address = document.getElementById('address');

		AjaxDisplay();
		
		function AjaxDisplay() {

		   var request = new XMLHttpRequest();
		   
		   request.onreadystatechange = function() {

		       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

		            if (request.status === 200) {
		           		var data = this.responseText;
		            	var res = JSON.parse(data);// respomse of the request
		            	if(res.response.http_response_code == 200){


		            		var linkCount = res.response.display.link.length;
		            		var emailCount = res.response.display.email.length;
		            		var contactCount = res.response.display.contact.length;
		            		var branchCount = res.response.display.branch.length;

		            		if(linkCount > 0){

		            			for(var i = 0; i < linkCount; i++){

		            				var linkDiv = document.createElement('div');
		            				var link = document.createElement('a');
		            				link.innerHTML = res.response.display.link[i].l_address;
		            				link.href = res.response.display.link[i].l_address;
		            				var linkDescription = document.createElement('p');
		            				linkDescription.innerHTML = res.response.display.link[i].l_description;
		            				linkDescription.style.color = 'white';

		            				linkDiv.appendChild(link);
		            				linkDiv.appendChild(linkDescription);

		            				linksContainer.appendChild(linkDiv);

		            			}// end of the for

		            		}// end of if for link

		            		if(emailCount > 0){

		            			for(var i = 0; i < emailCount; i++){

		            				var emailDiv = document.createElement('div');
		            				emailDiv.setAttribute('class', 'informations');
		            				emailDiv.setAttribute('id', 'talktous');
		            				var e_address = document.createElement('p');
		            				e_address.innerHTML = res.response.display.email[i].e_address;
		            				e_address.style.fontWeight = 'lighter';
		            				var e_description = document.createElement('p');
		            				e_description.innerHTML = res.response.display.email[i].e_description;

		            				emailDiv.appendChild(e_address);
		            				emailDiv.appendChild(e_description);

		            				emailContainer.appendChild(emailDiv);

		            			}

		            		}// end of of for email

		            		if(contactCount > 0){

		            			for(var i = 0; i < contactCount; i++){

		            				var contactDiv = document.createElement('div');
		            				contactDiv.setAttribute('class', 'informations');
		            				contactDiv.setAttribute('id', 'talktous');
		            				var c_category = document.createElement('p');
		            				c_category.innerHTML = res.response.display.contact[i].c_category;
		            				c_category.style.fontWeight = 'lighter';
		            				var c_number = document.createElement('p');
		            				c_number.innerHTML = res.response.display.contact[i].c_number;

		            				contactDiv.appendChild(c_category);
		            				contactDiv.appendChild(c_number);

		            				contactContainer.appendChild(contactDiv);

		            			}

		            		}// end of the if for contact

		            		if(branchCount > 0){

		            			bi_about.innerHTML = res.response.display.branch[0].bi_about;

		            			var bi_name = res.response.display.branch[0].bi_name;
		            			var bi_street = res.response.display.branch[0].bi_street;
		            			var bi_city_municipality = res.response.display.branch[0].bi_city_municipality;

		            			address.innerHTML = bi_name + " " + bi_street + " " + bi_city_municipality;
		            		}
		            	}
		           }
		       }
		   };

		request.open("GET", apilink, true);
		request.send();
	}// end of the function
	</script>
	<script type="text/javascript">
	 	
	 	var apiLinkget = 'api/creator/admin/product/readAllPublishProducts.php';

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

			           			featuresDiv.setAttribute('class', 'ContentDiv');
			           			featuresDiv.href = 'formData/page/controlpage.php?specification=' + res.response.display.result[i].computed_hash;

			           			var item_image = document.createElement('img');
			           			item_image.setAttribute('src', 'formData/page/pics/' + res.response.display.result[i].productImage);
			           			item_image.setAttribute('class', 'image');

			           			var item_tittle = document.createElement('p');
			           			item_tittle.innerHTML = res.response.display.result[i].p_name;
			           			item_tittle.setAttribute('class', 'tittle');

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
<!-- end scripts -->
	

	</body>
</html>