<body>
	<div class="navigations" style="display: flex; align-items: center; justify-content: space-around; ">
		<a href=

			<?php 

				echo "../../index.php"; 

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
							echo "controlpage.php?p=" . base64_encode('vInquire'); 
					?> >
				<p>inquiries</p></a>
			</span>
		</div>
		<div id="login" class="dContentDesign">
			<span>
				<a href= 
					<?php 
							echo "controlpage.php?p=" . base64_encode('login'); 
					?> >
				<p>login</p></a>
			</span>
		</div>
		<div id="verify" class="dContentDesign">
			<span>
				<a href= 
					<?php 
							echo "controlpage.php?p=" . base64_encode('verify'); 
					?> >
				<p>verify</p></a>
				
			</span>
		</div>
		<div id="register" class="dContentDesign">
			<span>
				<a href=
					<?php 
								echo "controlpage.php?p=" . base64_encode('register'); 
					?> >
				<p>register</p></a>
			</span>
		</div>
	</div>