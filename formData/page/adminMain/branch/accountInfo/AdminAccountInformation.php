<div id="mainAdminContents" class="content" style="padding-bottom: 70px;">

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

						echo "branchControlPage.php?branch=" . base64_encode('editAdminPersonalInfo');

					?> >

				edit information</a>
			</div>
<script type="text/javascript">

var APIgeuserInFormation = '../../../../api/creator/admin/account/readAccountInformation.php';

const email = document.getElementById('customerinformation_email');
const name = document.getElementById('customerinformation_name');
const phone = document.getElementById('customerinformation_contactNumber');
const telephopne = document.getElementById('customerinformation_telephoneNumber');
const street = document.getElementById('customerinformation_street');
const city = document.getElementById('customerinformation_city');
const province = document.getElementById('customerinformation_province');
const zip = document.getElementById('customerinformation_zip');
const bday = document.getElementById('customerinformation_birthday');
	
displaydata();
function displaydata(){
		var data = {
			adminInput:{
				computed_hash: window.reference = '<?= $_SESSION['MAIN_account_id'] ?>'
			}
		}
		var tojson = JSON.stringify(data);
		callAPIgeuserInFormation(tojson);
		// console.log(data)
	}// dn of the function


function callAPIgeuserInFormation(tojson) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

			if (request.status == 200) {

				var data = this.responseText;
				var res = JSON.parse(this.responseText);
				console.log(data)
				if(res.response.http_response_code == 200 && res.response.reason == 'success'){

					var info_admin_firstname = res.response.result.documentInformation[0].info_admin_firstname;
					var info_admin_lastname =  res.response.result.documentInformation[0].info_admin_lastname;
					var info_admin_middlename =  res.response.result.documentInformation[0].info_admin_middlename;

					var fullname = info_admin_firstname + " " + info_admin_middlename + " " + info_admin_lastname;
					result.style.color = 'yellowgreen';
					result.innerHTML = res.response.display.message[0];
					email.innerHTML = res.response.result.documentInformation[0].info_admin_email
					name.innerHTML = fullname;
					phone.innerHTML = res.response.result.documentInformation[0].info_admin_phonenumber;
					telephopne.innerHTML = res.response.result.documentInformation[0].info_admin_telephonenumber;
					street.innerHTML = res.response.result.documentInformation[0].info_admin_street;
					city.innerHTML = res.response.result.documentInformation[0].info_admin_city_municipality;
					province.innerHTML = res.response.result.documentInformation[0].info_admin_province;
					zip.innerHTML = res.response.result.documentInformation[0].info_admin_zipcode;
					bday.innerHTML = res.response.result.documentInformation[0].info_admin_bday;

				}
			}
       }
   };

	request.open("POST", APIgeuserInFormation, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}

</script>