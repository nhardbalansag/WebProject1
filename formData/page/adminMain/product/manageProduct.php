 <style type="text/css">
	.category{
		padding-top: 20px; 
		width: 100%; 
		margin:auto;
	}

	.category a{
		display: flex; 
		justify-content: center; 
		width: 90%;
	}
	.categories{
		margin: 15% 0px;
	}
</style>
<div id="mainAdminContents">
	<div  id="content" class="content" style="padding-bottom: 70px;">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?product=" . base64_encode('index');

					?> >

					<p style="font-size: 20px; color: black;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<h2 style="font-size: 20px; font-weight: bolder; color: black;">manage products</h2>
	 		</div>


	 		<div class="categories">
	 			<div class="category">
					<a class="mobileContentButton" href=

						<?php 

							echo "productControlPage.php?product=" . base64_encode('addProduct');

						?> >

						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>add product</p>
						</div>
					</a>
		 		</div>
		 		<div class="category">
					<a class="mobileContentButton" href=

						<?php 

							echo "productControlPage.php?product=" . base64_encode('createdProducts');

						?> >

						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>view all publish products</p>
						</div>
					</a>
		 		</div>

		 		<div class="category">
					<a class="mobileContentButton" href=

						<?php 

							echo "productControlPage.php?product=" . base64_encode('pendingProduct');

						?> >

						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>view all pending products</p>
						</div>
					</a>
		 		</div>
		 		
	 		</div>
 		</div>
</div>

 		

