<style type="text/css">

	/*desktop view*/
	@media screen and (min-width: 700px) {  

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
			margin: 5% 10px 0px;
			padding: 10px;
			border-radius: 10px;
		}

		.indexDesign{
			/*display: flex;
			justify-content: center;
			align-items: center;*/
			padding-bottom: 10%;
			width: 30%;
		}

		.reportingIndex{
			margin: 5% 10px 0px;
			padding: 10px;
			border-radius: 10px;
		}

		.iconDescriptionDiv p{
			text-align: center;
		}
		.tittles{
			color:black;
			font-size: 20px;
			font-weight: bolder;
		}

		.incomeDiv{
			background-color: #385080;
			color: white;
		}
		.mainAdminContents{
			display: flex;
		}
		.rightbarContent{
			width: 70%;

		}
		.widget{
			width: 25%;
			text-align: center;
			background-color: #E3D3F5;
			border-radius: 10px;
			color: white;
			float: left;
			margin:2%;
			padding:10px;
		}
		.count{
			font-size: 30px;
			font-weight: bolder;
		}

		.row{
			display: flex;
			justify-content: space-around;
			align-items: center;
		}
		.panel-heading{
			padding-bottom: 10px;
		}
	}

	/*mobile view*/
	@media screen and (max-width: 700px) {  

		.category a{
			display: flex; 
			justify-content: center; 
			width: 90%;
			margin-bottom: 5px;
		}

		.categories{
			width: 95%;
			margin:auto;
			/*padding-bottom: 100%;*/
		}

		.incomeDiv{
			background-color: #111740;
			color: white;
		}

		.tittles{
			color:black;
			font-size: 20px;
		}

		.rightbarContent{
			/*display: none;*/
			padding-bottom: 20%;

		}
		.mainAdminContents{
			display: block;
			margin-top: 20px;
		}

		.widget{
			width: 80%;
			text-align: center;
			background-color: #111740;
			border-radius: 10px;
			color: white;
			margin:2% auto;
			padding:10px;
		}
		.count{
			font-size: 30px;
			font-weight: bolder;
		}

		.widget a{
			color: white;
		}

		.row{
			display: flex;
			justify-content: space-around;
			align-items: center;
		}

		.panel-heading{
			padding-bottom: 10px;
		}
	}
}
</style>	

		</div>
		<div class="mainAdminContents" id="mainAdminContents">
			<div id="content" class="indexDesign">
				<div class="reportingIndex">
					<div>
						<div class="CustomersDiv">
							<div class="customersDivCategoryTotal">
								<p class="customersDivTittle">total penalty</p>
								<p class="customersDivNumber" id="totalPenalty"></p>
							</div>
							<div class="customersDivCategoryTotal">
								<p class="customersDivTittle">penalty payments</p>
								<p class="customersDivNumber" id="penaltyPayment"></p>
							</div>
							<div class="customersDivCategoryTotal">
								<p class="customersDivTittle">total payments</p>
								<p class="customersDivNumber" id="purchasePayment"></p>
							</div>
						</div>
						<div class="CustomersDiv" style="margin-top: 10px;">
							<div class="customersDivCategoryTotal">
								<p class="customersDivTittle">customers</p>
								<p class="customersDivNumber" id="totalCustomer"></p>
							</div>
							<div class="customersDivCategoryTotal">
								<p class="customersDivTittle">inquiries</p>
								<p class="customersDivNumber" id="totalInquiries"></p>
							</div>
							<div class="customersDivCategoryTotal">
								<p class="customersDivTittle">accounts</p>
								<p class="customersDivNumber" id="totalAccounts"></p>
							</div>
						</div>
						<div class="incomeDiv">
							<div class="timeDate">
								<?php date_default_timezone_set('Asia/Manila'); ?>
								<p><span>date: </span><?php echo date('y-m-d'); ?></p>
								<p><span>time: </span><?php echo date('h:i:sa');  ?></p>
							</div>
							<div class="col-xs-3">
				                    <i class="fa fa-chart-bar fa-5x"></i>
				                </div>
							<p class="incomeNumber" id="totalIncome"></p>
							<p>total income</p>
						</div>
					</div>
				</div>
				<div class="categories">
	 				<div style="text-align: center;">
					<p class="tittles">manage and view your system</p>
					</div>
		 			<div class="category">
						<a class="mobileContentButton" href=

								<?php 

									echo "branch/branchControlPage.php?branch=" . base64_encode('index');

								?> >

							<div class="iconDiv">
								<p>
									<i  class="fas fa-info"></i>
								</p>
							</div>
							<div class="iconDescriptionDiv">
								<p>branch information</p>
							</div>
						</a>
		 			</div>
			 		<div class="category">
						<a class="mobileContentButton" href=
								<?php 

									echo "product/productControlPage.php?product=" . base64_encode('index');

								?> >
							<div class="iconDiv">
								<p>
									<i  class="fas fa-info"></i>
								</p>
							</div>
							<div class="iconDescriptionDiv">
								<p>products</p>
							</div>
						</a>
			 		</div>
			 		<div class="category">
						<a class="mobileContentButton" href=
								<?php 

									echo "transaction/transactionControlPage.php?transaction=" . base64_encode('transactionIndex');

								?> >
							<div class="iconDiv">
								<p>
									<i  class="fas fa-info"></i>
								</p>
							</div>
							<div class="iconDescriptionDiv">
								<p>transactions</p>
							</div>
						</a>
			 		</div>
		 			</div>
			</div>
			<div class="rightbarContent ">
				<div class="allWidgets">
				    <div class="widget">
				        <div class="panel-heading">
				            <div class="row">
				                <div class="col-xs-3">
				                    <i class="fa fa-user fa-5x"></i>
				                </div>
				                <div class="">
				                 <div class='count' id="widgetAccount"></div>
				                  <div>accounts</div>
				                </div>
				            </div>
				        </div>
				    </div>
				     <div class="widget">
				        <div class="panel-heading">
				            <div class="row">
				                <div class="col-xs-3">
				                    <i class="fa fa-user fa-5x"></i>
				                </div>
				                <div class="">
				                 <div class='count' id="widgetcustomer"></div>
				                  <div>customer</div>
				                </div>
				            </div>
				        </div>
				        <a href=

				        	<?php
				        		echo "transaction/transactionControlPage.php?transaction=" . base64_encode('viewAllAvailedCustomer');
				        	?>>
				            <div class="panel-footer">
				                <span class="pull-left">View Details</span>
				                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				                <div class="clearfix"></div>
				            </div>
				        </a>
				    </div>
				     <div class="widget">
				        <div class="panel-heading">
				            <div class="row">
				                <div class="col-xs-3">
				                    <i class="fa fa-cart-arrow-down fa-5x"></i>
				                </div>
				                <div class="">
				                 <div class='count' id="widgetproducts"></div>
				                  <div>product</div>
				                </div>
				            </div>
				        </div>
				        <a href=
				        	<?php
				        		echo "product/productControlPage.php?product=" . base64_encode('createdProducts');
				        	?>>
				            <div class="panel-footer">
				                <span class="pull-left">View Details</span>
				                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				                <div class="clearfix"></div>
				            </div>
				        </a>
				    </div>
				</div>
			</div>
		</div>
		
<script type="text/javascript">
	const ApiLinkRead = '../../../api/creator/admin/reports/systemReports.php';

	const totalPenalty = document.getElementById('totalPenalty');
	const penaltyPayment = document.getElementById('penaltyPayment');
	const purchasePayment = document.getElementById('purchasePayment');
	const totalCustomer = document.getElementById('totalCustomer');
	const totalInquiries = document.getElementById('totalInquiries');
	const totalAccounts = document.getElementById('totalAccounts');
	const totalIncome = document.getElementById('totalIncome');

	const widgetAccount = document.getElementById('widgetAccount');
	const widgetcustomer = document.getElementById('widgetcustomer');
	const widgetproducts = document.getElementById('widgetproducts');


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

	            		totalPenalty.innerHTML = 'P' + res.response.display.result[0].report.totalPenalty + '.00';
						penaltyPayment.innerHTML = 'P' + res.response.display.result[0].report.totalPenaltyPayment + '.00';
						purchasePayment.innerHTML = 'P' + res.response.display.result[0].report.totalpaidAmount + '.00';
						totalCustomer.innerHTML = res.response.display.result[0].report.totalCustomer;
						totalInquiries.innerHTML = res.response.display.result[0].report.totalInquiries;
						totalAccounts.innerHTML = res.response.display.result[0].report.totalAccounts;
						totalIncome.innerHTML = 'P' + res.response.display.result[0].report.income + '.00';

						widgetAccount.innerHTML = res.response.display.result[0].report.totalAccounts;
						widgetcustomer.innerHTML = res.response.display.result[0].report.totalCustomer;
						widgetproducts.innerHTML = res.response.display.result[0].report.totalProduct;
	            	}
	           	}
	       	}
	   	};

	request.open("GET", ApiLinkRead, true);
	request.send();
}// end of the function
</script>