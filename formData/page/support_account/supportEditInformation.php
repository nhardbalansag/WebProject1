
<div id="content">

		<div class="informations">
			<a href=
				<?php 
					echo "support_controlPage.php?aslpAccount=" . base64_encode('supportAccountInformation'); 
				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

		<div class="informations" style="color:rgb(56, 80, 128); text-align: center; ">
			<p style="font-weight: bolder; font-size: 20px;">edit information</p>
			<p style=" font-size: 30px;" id="result"></p>
		</div>

		<div class="informations">
			<form method="post" id="formdata">
				<div style="text-align: center;">
					<input required class="inputmobile" type="email" id="customerinformation_email" name="" placeholder="*Email name">
					<input required class="inputmobile" type="text" id="customerinformation_firstname" name="" placeholder="*First name">
					<input required class="inputmobile" type="text" id="customerinformation_lastname" name="" placeholder="*Last name">
					<input required class="inputmobile" type="text" id="customerinformation_middlename" name="" placeholder="*Middle name">
					<input required class="inputmobile" type="number" id="customerinformation_contactNumber" name="" placeholder="*Contact number">
					<input required class="inputmobile" type="number" id="customerinformation_telephoneNumber" name="" placeholder="*Telephone number">
					<input required class="inputmobile" type="text" id="customerinformation_street" name="" placeholder="*Street Address">
					<input required class="inputmobile" type="text" id="customerinformation_city" name="" placeholder="*City/Municipality">
					<input required class="inputmobile" type="text" id="customerinformation_province" name="" placeholder="*Province">
					<input required class="inputmobile" type="number" id="customerinformation_zip" name="" placeholder="*Zip Code"><br>
					<label required style="color:gray; font-size: 20px;">birthday</label><br>
					<input required class="inputmobile" type="date" id="customerinformation_birthday" name="" placeholder="*Birthday">
				</div>

				<div class="informations" style="text-align: center;">
					<button class="coloredButton">Submit</button>
				</div>
			</form>
		</div>

<script type="text/javascript">

var APIgeuserInFormation = '../../../api/creator/admin/account/readAccountInformation.php';
var APIEdituserInFormation = '../../../api/creator/admin/account/editAdminInformation.php';

const customerinformation_email = document.getElementById('customerinformation_email');
const customerinformation_firstname = document.getElementById('customerinformation_firstname');
const customerinformation_lastname = document.getElementById('customerinformation_lastname');
const customerinformation_middlename = document.getElementById('customerinformation_middlename');
const customerinformation_contactNumber = document.getElementById('customerinformation_contactNumber');
const customerinformation_telephoneNumber = document.getElementById('customerinformation_telephoneNumber');
const customerinformation_street = document.getElementById('customerinformation_street');
const customerinformation_city = document.getElementById('customerinformation_city');
const customerinformation_province = document.getElementById('customerinformation_province');
const customerinformation_zip = document.getElementById('customerinformation_zip');
const customerinformation_birthday = document.getElementById('customerinformation_birthday');

const result = document.getElementById('result');

const reference =  window.reference = '<?= $_SESSION['account_id'] ?>';

displaydata(reference);
function displaydata(reference){
	var data = {
		adminInput:{
			computed_hash: reference
		}
	}
	var tojson = JSON.stringify(data);
	callAPIgeuserInFormation(tojson);
	// console.log(data)
}// dn of the function

function submitEdit(){
	var data = {
		adminInput:{
			customerinformation_email: customerinformation_email.value,
			customerinformation_firstname: customerinformation_firstname.value,
			customerinformation_lastname: customerinformation_lastname.value,
			customerinformation_middlename: customerinformation_middlename.value,
			customerinformation_contactNumber: customerinformation_contactNumber.value,
			customerinformation_telephoneNumber: customerinformation_telephoneNumber.value,
			customerinformation_street: customerinformation_street.value,
			customerinformation_city: customerinformation_city.value,
			customerinformation_province: customerinformation_province.value,
			customerinformation_zip: customerinformation_zip.value,
			customerinformation_birthday: customerinformation_birthday.value,
			reference: reference
		}
	}
	var tojson = JSON.stringify(data);
	callAPIedituserInFormation(tojson);
	// console.log(data)
}// dn of the function

document.getElementById('formdata').addEventListener('submit', event=>{
	event.preventDefault();
	submitEdit();
});


function callAPIgeuserInFormation(tojson) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

			if (request.status == 200) {

				var data = this.responseText;
				var res = JSON.parse(this.responseText);
				if(res.response.http_response_code == 200 && res.response.reason == 'success'){

					customerinformation_email.value = res.response.result.documentInformation[0].info_admin_email;
					customerinformation_firstname.value = res.response.result.documentInformation[0].info_admin_firstname;
					customerinformation_lastname.value = res.response.result.documentInformation[0].info_admin_lastname;
					customerinformation_middlename.value = res.response.result.documentInformation[0].info_admin_middlename;
					customerinformation_contactNumber.value = res.response.result.documentInformation[0].info_admin_phonenumber;
					customerinformation_telephoneNumber.value = res.response.result.documentInformation[0].info_admin_telephonenumber;
					customerinformation_street.value = res.response.result.documentInformation[0].info_admin_street;
					customerinformation_city.value = res.response.result.documentInformation[0].info_admin_city_municipality;
					customerinformation_province.value = res.response.result.documentInformation[0].info_admin_province;
					customerinformation_zip.value = res.response.result.documentInformation[0].info_admin_zipcode;
					customerinformation_birthday.value = res.response.result.documentInformation[0].info_admin_bday;

				}
			}
       }
   };

	request.open("POST", APIgeuserInFormation, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}

function callAPIedituserInFormation(tojson) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

			if (request.status == 200) {

				var data = this.responseText;
				var res = JSON.parse(this.responseText);
				if(res.response.http_response_code == 200 && res.response.reason == 'success'){
					result.innerHTML = 'edited Succesfully';
					result.style.color = 'yellowgreen';
				}
			}
       }
   };

	request.open("POST", APIEdituserInFormation, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}


</script>