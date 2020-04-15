
	<div id="content">
		<div class="informations">
			<div  style="text-align: center;">
				<p style="font-size: 20px; color:yellowgreen;">welcome</p>
				<p style=" font-size: 30px;">

				<?php

					if (

						isset($_SESSION['adminInfo_firstname']) &&
						isset($_SESSION['adminInfo_middlename']) &&
						isset($_SESSION['adminInfo_lastname']) &&
						isset($_SESSION['account_id']) &&
						isset($_SESSION['adminInfo_admin_id'])&&
						isset($_SESSION['adminsessionID'])

					){
						
						echo $_SESSION['adminInfo_firstname'] . " " . $_SESSION['adminInfo_middlename'] . " " . $_SESSION['adminInfo_lastname'];

					}else{

						header('location: supportLogin/supportLoginControlPage.php');
					}
					
				?>

				</p>
			
			</div>

			
			<div style="margin-top: 40px; text-align: center;">
				<p style="color: rgb(10,15,42); font-weight: bolder; font-size: 30px;">manage accounts and inquiries</p>
				<div>
					
					<div id="products_content" style="background-color: rgb(211,228,245);">
						<div class="prodPartial" style="display: flex; justify-content: space-around;;">
							<div style="text-align: center">
								<p style="color: rgb(10,15,42); font-weight: lighter">see all inquiries</p>
								<p><span style="font-size: 20px; text-transform: uppercase; font-weight: bolder; color: rgb(56, 80, 128);">inquiries</span></p>
								<a id="inquiryCustomer" class="coloredButton" href=

								<?php 
										echo "../../../../YAMAHA_PROJECT/formData/page/support_account/support_controlPage.php?aslpAccount=" . base64_encode('supportViewInquires'); 
								?> >

								view inquiries</a>
								
							</div>
						</div>
					</div>

					<div id="products_content" style="background-color: rgb(211,228,245);">
						<div class="prodPartial" style="display: flex; justify-content: space-around;">
							<div style="text-align: center">
								<p style="color: rgb(10,15,42); font-weight: lighter">see all inquiries</p>
								<p><span style="font-size: 20px; text-transform: uppercase; font-weight: bolder; color: rgb(56, 80, 128);">accounts</span></p>
								<a class="coloredButton" href=

									<?php 
											echo "../../../../YAMAHA_PROJECT/formData/page/support_account/support_controlPage.php?aslpAccount=" . base64_encode('viewCustomerAccount'); 
									?> >

								view customer accounts</a>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>


