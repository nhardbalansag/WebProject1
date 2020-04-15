<div id="content">

		<div class="informations" style="text-align: center;">
			<p id="result" style="font-size: 20px; font-weight: bold"></p>
		</div>
	
			<div class="informations" id="products_content" style="padding: 0px 20px; padding-top: 20px;">
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

			<div class="informations" style="margin-top: 5%; text-align: center;">
				<a id="btnEditInfo" class="coloredButton" href=

					<?php 

						echo "customerControlPage.php?cp=" . base64_encode('editCustomerInformation');

					?> >

				edit information</a>
			</div>

<script type="text/javascript">

var APIgeuserInFormation = '../../../api/creator/readCustomerinformation.php';

var reference = window.referenceData = '<?= $_SESSION['accountHash'] ?>';
	
register(reference);

function register(reference){
	
	var data = {
			UserInformation:{
				reference: reference
			}
		};

	var tojson = JSON.stringify(data);
	callAPIgeuserInFormation(tojson);
}// end of function

function displayCustomerInformation(email, name, phone,telephopne, street, city, province, zip, bday){

	document.getElementById('customerinformation_email').innerHTML = email;
	document.getElementById('customerinformation_name').innerHTML = name;
	document.getElementById('customerinformation_contactNumber').innerHTML = phone;
	document.getElementById('customerinformation_telephoneNumber').innerHTML = telephopne;
	document.getElementById('customerinformation_street').innerHTML = street;
	document.getElementById('customerinformation_city').innerHTML = city;
	document.getElementById('customerinformation_province').innerHTML = province;
	document.getElementById('customerinformation_zip').innerHTML = zip;
	document.getElementById('customerinformation_birthday').innerHTML = bday;

}


function callAPIgeuserInFormation(tojson) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {

              var data = this.responseText;
              var res = JSON.parse(this.responseText);
              if(res.response.http_response_code == 200 && res.response.reason == 'success'){
              	result.style.color = 'yellowgreen';
                result.innerHTML = res.response.display.message[0];
                displayCustomerInformation(
                  res.response.result.documentInformation[0].ci_email, 
                  res.response.result.documentInformation[0].ci_firstname + ' ' + res.response.result.documentInformation[0].ci_middlename + ' ' + res.response.result.documentInformation[0].ci_lastname,
                  res.response.result.documentInformation[0].ci_phonenumber, 
                  res.response.result.documentInformation[0].ci_telephonenumber, 
                  res.response.result.documentInformation[0].ci_street, 
                  res.response.result.documentInformation[0].ci_city_municipality, 
                  res.response.result.documentInformation[0].ci_province, 
                  res.response.result.documentInformation[0].ci_zipcode,
                  res.response.result.documentInformation[0].ci_bday
                );

              }
           }
       }
   };

	request.open("POST", APIgeuserInFormation, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}

</script>