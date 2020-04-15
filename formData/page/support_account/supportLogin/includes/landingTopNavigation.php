<body>
	<div class="navigations" style="display: flex; align-items: center; justify-content: space-around; ">
		<a href=

			<?php 

				echo "../../../../../YAMAHA_PROJECT/formData/page/support_account/supportLogin/supportLoginControlPage.php?aslp=" . base64_encode('adminsupportlogin'); 

			?> >

			<h1 style="color: red; font-size: 40px;">YAMAHA</h1>
		</a>
		<span id="navbuttonright"><i  class="fas fa-angle-right" style="font-size: 30px; color: white;"></i></span>
		<span id="navbuttondown"><i  class="fas fa-angle-down" style="font-size: 30px; color: white;"></i></span>
	</div>
	<div id="dropdown">
		
		<!-- <div id="products" class="dContentDesign"> -->
			<!-- <span style="display: flex; justify-content: space-between; align-items: center;">
				<p>products</p> <span><i id="navbutton" class="fas fa-plus-square" style="font-size: 30px; color: white;"></i></span>
			</span> -->
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
		<!-- </div> -->
	
		<div id="login" class="dContentDesign">
			<span>
				<a href= 
					<?php 
							echo "../../../../../YAMAHA_PROJECT/formData/page/support_account/supportLogin/supportLoginControlPage.php?aslp=" . base64_encode('adminsupportlogin'); 
					?> >
				<p>login</p></a>
			</span>
		</div>
		<div id="verify" class="dContentDesign">
			<span>
				<a href= 
					<?php 
							echo "../../../../../YAMAHA_PROJECT/formData/page/support_account/supportLogin/supportLoginControlPage.php?aslp=" . base64_encode('adminsupportverify');
					?> >
				<p>verify</p></a>
				
			</span>
		</div>
		<div id="register" class="dContentDesign">
			<span>
				<a href=
					<?php 
								echo "../../../../../YAMAHA_PROJECT/formData/page/support_account/supportLogin/supportLoginControlPage.php?aslp=" . base64_encode('adminsupportregisteraccount'); 
					?> >
				<p>register</p></a>
			</span>
		</div>
	</div>