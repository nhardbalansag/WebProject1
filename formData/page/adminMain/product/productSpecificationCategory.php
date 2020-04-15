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
	.iconDescriptionDiv p{
		text-align: center;
	}
</style>

<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 70px;">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?productCreate=" . $_SESSION['productHash'];

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">specification categories</p>
	 		</div>
	 		<div class="categories">
	 			<div class="category">
					<a class="mobileContentButton" href=

						<?php 

							echo "productControlPage.php?viewallSpecificationCategory=" . base64_encode(strtolower('engine'));

						?> >

						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>engine</p>
						</div>
					</a>
		 		</div>
		 		<div class="category">
					<a class="mobileContentButton" href=

						<?php 

							echo "productControlPage.php?viewallSpecificationCategory=" . base64_encode(strtolower('dimension'));

						?> >

						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>dimension</p>
						</div>
					</a>
		 		</div>
		 		<div class="category">
					<a class="mobileContentButton" href=

						<?php 

							echo "productControlPage.php?viewallSpecificationCategory=" . base64_encode(strtolower('framework'));
							
						?> >

						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>framework</p>
						</div>
					</a>
		 		</div>

	 		</div>
 			
			<div id="tablediv" style="width: 90%; margin:auto;">
		
			</div>
 		</div>
</div>	
 		

 