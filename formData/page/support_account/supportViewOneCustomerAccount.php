
<div id="content">
		<div class="informations">
			<a href=

				<?php 
					echo "support_controlPage.php?aslpAccount=" . base64_encode('viewCustomerAccount'); 
				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>
		<div class="informations">
			<p id="res" style="text-align: center; font-size: 20px; width: 80%; margin:auto"></p>
			<div style="display: flex; justify-content: space-around; align-items: center;">
				<p style="font-weight: bolder; font-size: 30px;"></p>
			</div>		
		</div>
		<div class="informations" style="margin-top: 5%; text-align: center; ">
			<p>customer details</p>
			<div id="products_content" style="padding:0px 30px;">
				
				<div class="tableInfo" >
					<label class="labelInfo" style="font-weight: bolder">email:</label>
					<p id="customerinformation_email" class="labelInfo"></p>
				</div>

				<div class="tableInfo">
					<label class="labelInfo" style="font-weight: bolder">name:</label>
					<p id="customerinformation_name" class="labelInfo"></p>
				</div>

				<div class="tableInfo">
					<label class="labelInfo" style="font-weight: bolder">contact number:</label>
					<p id="customerinformation_contactNumber" class="labelInfo"></p>
				</div class="tableInfo">

				<div class="tableInfo">
					<label class="labelInfo" style="font-weight: bolder">telephone number:</label>
					<p id="customerinformation_telephoneNumber" class="labelInfo"></p>
				</div>
				<div class="tableInfo">
					<label class="labelInfo" style="font-weight: bolder">street:</label>
					<p id="customerinformation_street" class="labelInfo"></p>
				</div>
				<div class="tableInfo">
					<label class="labelInfo" style="font-weight: bolder">city:</label>
					<p id="customerinformation_city" class="labelInfo"></p>
				</div>
				<div class="tableInfo">
					<label class="labelInfo" style="font-weight: bolder">province:</label>
					<p id="customerinformation_province" class="labelInfo"></p>
				</div>
				<div class="tableInfo">
					<label class="labelInfo" style="font-weight: bolder">zip code:</label>
					<p id="customerinformation_zip" class="labelInfo"></p>
				</div>
				<div class="tableInfo">
					<label class="labelInfo" style="font-weight: bolder">birthday:</label>
					<p id="customerinformation_birthday" class="labelInfo"></p>
				</div>		
			</div>
			<div class="informations" style="width: 90%;">
				<div id="products_content" style="background-color: rgb(211,228,245); width: 92%">
						<div class="prodPartial" style="display: flex; justify-content: space-around;;">
							<div style="text-align: center">
								<p style="color: rgb(10,15,42); font-weight: lighter">see all messages</p>
								<p><span style="font-size: 20px; text-transform: uppercase; font-weight: bolder; color: rgb(56, 80, 128);">messages</span></p>
								<a class="coloredButton" href=

									<?php 
										echo "support_controlPage.php?customerAccountInfo=" . $_SESSION['customerAccountPersonalInformationID']; 
									?> >

								view all message</a>
							</div>
						</div>
					</div>

					<div id="products_content" style="background-color: rgb(211,228,245); width: 92%">
						<div class="prodPartial" style="display: flex; justify-content: space-around;;">
							<div style="text-align: center">
								<p style="color: rgb(10,15,42); font-weight: lighter">see all documents</p>
								<p><span style="font-size: 20px; text-transform: uppercase; font-weight: bolder; color: rgb(56, 80, 128);">documents</span></p>
								<a class="coloredButton" href=

									<?php 
										echo "support_controlPage.php?supportViewAllDocumentsOfOneCustomer=" . $_SESSION['customerAccountPersonalInformationID']; 
									?> >

								view all documents</a>
							</div>
						</div>
					</div>
			</div>



<script type="text/javascript">

var APIgetOneCustomerInquiry = '../../../api/creator/support/viewCustomerAccountPersonalInfo.php';
getInquiryId();

var customerinformation_email = document.getElementById('customerinformation_email');
var customerinformation_name = document.getElementById('customerinformation_name');
var customerinformation_contactNumber = document.getElementById('customerinformation_contactNumber');
var customerinformation_telephoneNumber = document.getElementById('customerinformation_telephoneNumber');
var customerinformation_street = document.getElementById('customerinformation_street');
var customerinformation_city = document.getElementById('customerinformation_city');
var customerinformation_province = document.getElementById('customerinformation_province');
var customerinformation_zip = document.getElementById('customerinformation_zip');
var customerinformation_birthday = document.getElementById('customerinformation_birthday');

// var inquiryMessage = document.getElementById('inquiryMessage');

function getInquiryId(){

var customerRererence = window.reference = '<?= $_SESSION['customerAccountPersonalInformationID'] ?>';

  var data = {
      accountId:{
        customerRererence: customerRererence
      }
    };

  var tojson = JSON.stringify(data);

  callAPIgetOneCustomerInquiry(tojson);
}// end of function


function callAPIgetOneCustomerInquiry(jsonObj) {

   var request = new XMLHttpRequest();
   var result = document.getElementById('res');
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {

              var data = this.responseText;
              var res = JSON.parse(data);// respomse of the request
              if(res.response.http_response_code === 200 && res.response.reason === 'success'){

                result.style.color = 'yellowgreen';
                result.innerHTML = res.response.display.message[0];

				var name = res.response.result.documentInformation[0].ci_firstname + ' ' + res.response.result.documentInformation[0].ci_middlename + ' ' + res.response.result.documentInformation[0].ci_lastname;

				customerinformation_email.innerHTML = res.response.result.documentInformation[0].ci_email;
				customerinformation_name.innerHTML =  name;
				customerinformation_contactNumber.innerHTML = res.response.result.documentInformation[0].ci_phonenumber; 
				customerinformation_telephoneNumber.innerHTML = res.response.result.documentInformation[0].ci_telephonenumber; 
				customerinformation_street.innerHTML = res.response. result.documentInformation[0].ci_street;
				customerinformation_city.innerHTML = res.response. result.documentInformation[0].ci_city_municipality;
				customerinformation_province.innerHTML = res.response.result.documentInformation[0].ci_province; 
				customerinformation_zip.innerHTML = res.response.result.documentInformation[0].ci_zipcode; 
				customerinformation_birthday.innerHTML = res.response.result.documentInformation[0].ci_bday; 
				// inquiryMessage.innerHTML = res.response.result.documentInformation[0].m_message; 

              }
           }
       }
   };

  request.open("POST", APIgetOneCustomerInquiry, true);
  request.setRequestHeader('Content-Type', 'Application/json');
  request.send(jsonObj);
 
}// end of the function


</script>