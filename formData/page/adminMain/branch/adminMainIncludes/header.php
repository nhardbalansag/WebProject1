
<!DOCTYPE html>
<html>
<head>
	<title>account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../../asset/admin.css">
	<link rel="stylesheet" type="text/css" href="../../asset/fa/fontAwesome/css/all.css">
</head>
<body>

 	<div id="mobileContent">
 		<div class="topBackgroundMobile">
 			<div class="navigations " style="display: flex; align-items: center; justify-content: space-around; ">
				<div class="brand">
					<a href="../index.php" class="brandTittle">
						<p >yamaha</p>
					</a>
				</div>
			
				<div>
					<span id="navbuttonright"><i  class="fas fa-angle-right" style="font-size: 30px; color: white;"></i></span>
					<span id="navbuttondown"><i  class="fas fa-angle-down" style="font-size: 30px; color: white;"></i></span>
				</div>
			</div>
				<div id="dropdown" class="mobileViewNav">
					<div id="about" class="dContentDesign" style="text-align: left">
						<span>
							<a href=

								<?php 
										echo "branchControlPage.php?branch=" . base64_encode('AdminAccountInformation');
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
										echo "branchControlPage.php?branch=" . base64_encode('logout');
								?> >
							<p>logout</p></a>
						</span>
					</div>
				</div>

