<?php
	
	session_start();

?>


<!DOCTYPE html>
<html>
<head>
	<title>account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../asset/customer.css">
	<link rel="stylesheet" type="text/css" href="">
	<link rel="stylesheet" type="text/css" href="../asset/fa/fontAwesome/css/all.css">
	<!-- <link rel="stylesheet" type="text/css" href="asset/fa/fontAwesome/css/brand.css"> -->
</head>
<body>
	<div class="navigations" style="display: flex; align-items: center; justify-content: space-around; ">

		<a href=

			<?php 

				echo "support_controlPage.php?aslpAccount=" . base64_encode('index'); 

			?> >
			
			<h1 style="color: red; font-size: 40px;">YAMAHA</h1>

		</a>

		<span id="navbuttonright"><i  class="fas fa-angle-right" style="font-size: 30px; color: white;"></i></span>
		<span id="navbuttondown"><i  class="fas fa-angle-down" style="font-size: 30px; color: white;"></i></span>
	</div>
	<div id="dropdown">
		<div id="about" class="dContentDesign" style="text-align: left">
			<span>
				<a href=

					<?php 
							echo "support_controlPage.php?aslpAccount=" . base64_encode('supportAccountInformation'); 
					?> >

					<p>account information</p></a>
			</span>
		</div>
		<div id="products" class="dContentDesign">
			<span style="display: flex; justify-content: space-between; align-items: center;">
				<!-- <p>products</p> <span><i id="navbutton" class="fas fa-plus-square" style="font-size: 30px; color: white;"></i></span> -->
			</span>
			<div id="product_miniDrop">
				<!-- <ul>
					<li class="miniprodCat">
						<a href="" class="miniProd">category 2</a>
					</li>
					<li class="miniprodCat">
						<a href="" class="miniProd">category 2</a>
					</li>
				</ul> -->
			</div>
		</div>
		<div id="inquiries" class="dContentDesign">
			<span>
				<a href=

					<?php 
							echo "support_controlPage.php?aslpAccount=" . base64_encode('supportViewInquires'); 
					?> >

					<p>inquiries</p>
				</a>
			</span>
		</div>
		<div id="inquiries" class="dContentDesign">
			<span>
				<a href=

					<?php 
							echo "support_controlPage.php?aslpAccount=" . base64_encode('viewCustomerAccount'); 
					?> >
					
					<p>customer accounts</p>
				</a>
			</span>
		</div>
		<div id="inquiries" class="dContentDesign">
			<span>
				<a href=
					<?php 
						echo "support_controlPage.php?aslpAccount=" . base64_encode('supportViewInquires'); 
					?> >
					<p>inbox</p></a>
			</span>
		</div>
		<div id="inquiries" class="dContentDesign">
			<span>
				<a href=
					<?php 
							echo "support_controlPage.php?aslpAccount=" . base64_encode('adminlogout'); 
					?> >
				<p>logout</p></a>
			</span>
		</div>
	</div>