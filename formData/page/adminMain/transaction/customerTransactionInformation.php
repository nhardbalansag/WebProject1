<style type="text/css">
.customerInformationReport{
border-radius: 10px;
margin: 10px;
text-align: center;
background-color: #385080;
color: white;
padding: 5px 0px;
}
.customerInformationReport label{
font-weight: bolder;
color: white;
}
.customerInformationReport a{
color: white;
}

.linkstyle{
display: flex;
justify-content: space-around;
align-items: center;
}

@media screen and (min-width: 700px) {  

.desktopView{
	width: 80%;
}

}
</style>

<div id="mainAdminContents">
	<div id="content" class="content" style="padding-bottom: 70px;">
 			<div style="padding-top: 20px; width: 100%; margin:auto;">
					<a style="display: flex; justify-content: center; width: 90" class="mobileContentButton" href=

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

 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">customer transaction information</p>
	 		</div>
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>

	 			
	 			
	 			<h2 id="reporting"></h2>
	 			<div>
	 				<div class="ProductInfoDiv" id="ProductInfoDiv">
						
		 			</div>
	 				<div class="oneSelectedProductDiv desktopView" id="oneSelectedProductDiv">
		 			
		 			</div>
	 			</div>
			</div>
 		</div>
</div>
 		
<script type="text/javascript">

const apiLinkread = '../../../../api/creator/admin/transaction/readOneCustomer.php';


const oneSelectedProductDiv = document.getElementById('oneSelectedProductDiv');
const reporting = document.getElementById('reporting');
const cp_status = document.getElementById('cp_status');
const ProductInfoDiv = document.getElementById('ProductInfoDiv');
	
const reference = window.linkUrl = '<?= $_GET['customerTransactionInformation'] ?>';

displaydata(reference);

function displaydata(computed_hash){

		var data = {
			adminInput:{
				computed_hash: computed_hash
			}
		}
		var tojson = JSON.stringify(data);
		AjaxGet(tojson);
}// dn of the function

	
function AjaxGet(tojson) {

	var request = new XMLHttpRequest();
	   
   request.onreadystatechange = function() {

       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

            if (request.status === 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
            	if(res.response.http_response_code === 200 && res.response.reason === 'success'){

            		var balance = lname =  res.response.display.result[0].transaction.transaction_ti_currentBalance;

            		var Ci_datecreated = res.response.display.result[0].customer.customer_aci_dateCreated;
            		var Ci_id = res.response.display.result[0].customer.customer_aci_id;
            		var Ci_acid = res.response.display.result[0].customer.customer_ca_id;

            		var fname =  res.response.display.result[0].customer.customer_aci_firstName;
            		var mname =  res.response.display.result[0].customer.customer_aci_middleName;
            		var lname =  res.response.display.result[0].customer.customer_aci_lastName;

            		var email = res.response.display.result[0].customer.customer_aci_emailAddress;
            		var address = res.response.display.result[0].customer.customer_aci_address;
            		var billingaddress = res.response.display.result[0].customer.customer_aci_billingAddress;

            		var accountdateCreated = res.response.display.result[0].account.account_ca_date_created;
            		var accountid = res.response.display.result[0].account.account_ca_id;

            		var purchaseDate = res.response.display.result[0].purchase.purchase_pi_date;
            		var purchaseid = res.response.display.result[0].purchase.purchase_pi_id;
            		var purchasecustomerid = res.response.display.result[0].purchase.purchase_aci_id;
            		var purchasecreatedproductid = res.response.display.result[0].purchase.purchase_cp_id;

            		var purchasetype = res.response.display.result[0].purchase.purchase_pi_purchaseType;


            		////reference identification
            		var purchaseReferenceId = purchaseDate + "y" + purchaseid + "y" + purchasecustomerid + "y" + purchasecreatedproductid;
            		var linkAccountReference = accountdateCreated + "y" + accountid;
            		var fullname = fname + " " + mname + " " + lname;
            		var customer_Identification = Ci_datecreated + 'y' + Ci_id + 'y' + Ci_acid;


           			var divCustomerID = document.createElement('div');
           			divCustomerID.setAttribute('class', 'customerInformationReport');
           			var customerid_span = document.createElement('span');
           			customerid_span.innerHTML = "customer id:";
           			customerid_span.style.fontWeight = 'bolder';
           			customerid_span.style.fontSize = '20px';
           			var customerid_p = document.createElement('p');
           			customerid_p.innerHTML = customer_Identification;
           			var iconInfo_C = document.createElement('i');
           			iconInfo_C.setAttribute('class', 'fas fa-info');
           			var icondiv_C = document.createElement('div');
           			icondiv_C.appendChild(iconInfo_C);
           			divCustomerID.appendChild(icondiv_C);
           			divCustomerID.appendChild(customerid_span);
           			divCustomerID.appendChild(customerid_p);

           			var divPersonalInfo = document.createElement('div');
           			divPersonalInfo.setAttribute('class', 'customerInformationReport');
           			var label = ["name: ", "email: ", "address: ", "billing address: ", "link account id: "];
           			var dataInfo = [fullname, email, address, billingaddress, linkAccountReference];
           			var iconInfo_i = document.createElement('i');
           			iconInfo_i.setAttribute('class', 'fas fa-info');
           			var icondiv_i = document.createElement('div');
           			icondiv_i.appendChild(iconInfo_i);
           			divPersonalInfo.appendChild(icondiv_i);
           			for(var i = 0; i < 5; i++){

           				var personal_span = document.createElement('span');
	           			personal_span.innerHTML = label[i];
	           			personal_span.style.fontWeight = 'bolder';
	           			personal_span.style.fontSize = '20px';
	           			var personal_p = document.createElement('p');
	           			personal_p.innerHTML = dataInfo[i];
	           			
           				divPersonalInfo.appendChild(personal_span);
           				divPersonalInfo.appendChild(personal_p);
           			}

           			var linkdiv = document.createElement('a');
           			linkdiv.setAttribute('class', 'linkstyle');
           			linkdiv.href = 'transactionControlPage.php?editcustomerInformation=' + res.response.display.result[0].purchase.purchase_computed_hash;
           			var link = document.createElement('p');
           			link.innerHTML = 'edit this info';
           			link.style.borderBottom = '1px solid white'
           			
           			var linkicon = document.createElement('i');
					linkicon.setAttribute('class', 'fas fa-edit');
					
					linkdiv.appendChild(link);
					linkdiv.appendChild(linkicon);
					divPersonalInfo.appendChild(linkdiv);


           			var divPurchaseInfo = document.createElement('div');
           			divPurchaseInfo.setAttribute('class', 'customerInformationReport');
           			var labelpurchase = ["purchase id: ", "purchase date: ", "purchase type: "];
           			var dataPurchase = [purchaseReferenceId, purchaseDate, purchasetype];
           			var iconInfo = document.createElement('i');
           			iconInfo.setAttribute('class', 'fas fa-info');
           			var icondiv = document.createElement('div');
           			icondiv.appendChild(iconInfo);
           			divPurchaseInfo.appendChild(icondiv);
           			for(var i = 0; i < 3; i++){

           				var purchase_span = document.createElement('span');
	           			purchase_span.innerHTML = labelpurchase[i];
	           			purchase_span.style.fontWeight = 'bolder';
           				purchase_span.style.fontSize = '20px';
	           			var purchase_p = document.createElement('p');
	           			purchase_p.innerHTML = dataPurchase[i];
	           			
           				divPurchaseInfo.appendChild(purchase_span);
           				divPurchaseInfo.appendChild(purchase_p);
           			}

           			oneSelectedProductDiv.appendChild(divCustomerID);
           			oneSelectedProductDiv.appendChild(divPersonalInfo);
           			oneSelectedProductDiv.appendChild(divPurchaseInfo);

           			addreference();
           		
            	}
           	}
       	}
   	};

	request.open("POST", apiLinkread, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

function addreference(){

	const page = ["viewOneCustomerTransactions", "viewallpenalties", "addTransaction"];
	const icons = ["fas fa-eye", "fas fa-plus"];
	const tittle = ["view all transaction", "view all penalties", "add new transaction"];
	const eventid = ["view all penalties", "view all payments", "addTransaction"];

	var icondesign = "";

	for(var i = 0; i < page.length; i++){

		if(i < 3){
			icondesign = icons[0];
		}else{
			icondesign = icons[1];
		}

		const viewAllFeatures = document.createElement('a');
		viewAllFeatures.setAttribute('class', 'mobileContentButton');
		viewAllFeatures.href = 'transactionControlPage.php?' + page[i] + '=' + reference;
		viewAllFeatures.style.display = 'flex';
		viewAllFeatures.style.justifyContent = 'space-between';
		viewAllFeatures.style.width = '80%';

		const icondiv = document.createElement('div');
		const iconp = document.createElement('p');
		iconp.setAttribute('class', 'linkNumber');
		const icon = document.createElement('i');
		icon.setAttribute('class', icondesign);
		iconp.appendChild(icon);
		icondiv.appendChild(iconp);
		icondiv.style.width = '30%';
		icondiv.style.display = 'flex';
		icondiv.style.justifyContent = 'flex-end';
		

		const tittlediv = document.createElement('div');
		const tittlep = document.createElement('p');
		tittlep.style.fontSize = '13px';
		tittlep.style.marginLeft = '20px';
		tittlep.innerHTML = tittle[i];
		tittlediv.appendChild(tittlep);
		tittlediv.style.width = '50%';
		tittlediv.style.textAlign = 'left';
		
		viewAllFeatures.appendChild(tittlediv);
		viewAllFeatures.appendChild(icondiv);

		ProductInfoDiv.appendChild(viewAllFeatures);
	}
}

</script>

