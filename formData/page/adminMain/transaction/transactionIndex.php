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
	<div id="content" class="content" style="padding-bottom: 70px;">
			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "../index.php";
					?> >

					<p style="font-size: 20px;">back</p>
				</a>
			</div>
			<div style="text-align: center;">
 				<h2 style="font-size: 20px; font-weight: bolder; color:white;">transaction category</h2>
	 		</div>


	 		<div class="categories">
	 			<div class="category">
					<a class="mobileContentButton" href=
						<?php 

							echo "transactionControlPage.php?transaction=" . base64_encode('viewAllProduct');

						?> >
						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>add new purchase</p>
						</div>
					</a>
		 		</div>

		 		<div class="category">
					<a class="mobileContentButton" href=

						<?php 

							echo "transactionControlPage.php?transaction=" . base64_encode('viewAllAvailedCustomer');

						?> >

						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>view all customers</p>
						</div>
					</a>
		 		</div>
		 		<div class="category">
					<a class="mobileContentButton" href=

						<?php 

							echo "transactionControlPage.php?transaction=" . base64_encode('addPenalty');

						?> >

						<div class="iconDiv">
							<p>
								<i  class="fas fa-info"></i>
							</p>
						</div>
						<div class="iconDescriptionDiv">
							<p>add penalty amount</p>
						</div>
					</a>
		 		</div>
	 		</div>
 		</div>
</div>
 		

