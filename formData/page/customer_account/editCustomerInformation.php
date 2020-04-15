
<div id="content">

		<div class="informations">
			<a href=

				<?php 

					echo "customerControlPage.php?cp=" . base64_encode('index');

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
					<input class="inputmobile" type="email" id="customerinformation_email" name="" placeholder="*Email name" required>
					<input class="inputmobile" type="text" id="customerinformation_firstname" name="" placeholder="*First name" required>
					<input class="inputmobile" type="text" id="customerinformation_lastname" name="" placeholder="*Last name" required>
					<input class="inputmobile" type="text" id="customerinformation_middlename" name="" placeholder="*Middle name" required>
					<input class="inputmobile" type="number" id="customerinformation_contactNumber" name="" placeholder="*Contact number" required>
					<input class="inputmobile" type="number" id="customerinformation_telephoneNumber" name="" placeholder="*Telephone number" required>
					<input class="inputmobile" type="text" id="customerinformation_street" name="" placeholder="*Street Address" required>
					<input class="inputmobile" type="text" id="customerinformation_city" name="" placeholder="*City/Municipality" required>
					<input class="inputmobile" type="text" id="customerinformation_province" name="" placeholder="*Province" required>
					<input class="inputmobile" type="number" id="customerinformation_zip" name="" placeholder="*Zip Code" required><br>
					<label style="color:gray; font-size: 20px;">birthday</label><br>
					<input class="inputmobile" type="date" id="customerinformation_birthday" name="" placeholder="*Birthday" required>
				</div>

				<div class="informations" style="text-align:  center;">
					<p style="color: rgb(56, 80, 128);">
						NOTICE : In compliance to RA 10173 known as Data Privacy Act of 2012, an Act of Protecting Individual Information, please be informed that gathered  information are recorded to better facilitate concerns assistance . Rest assured that information shall remain confidential and shall be used solely for official purposes.
					</p>
				</div>

				<div class="informations" style="text-align: center;">
					<button class="coloredButton" >Submit</button>
				</div>
			</form>
		</div>

<script type="text/javascript">

const APIeditPersonalInformation = '../../../api/creator/editUserInfo.php';
const APIgeuserInFormation = '../../../api/creator/readCustomerinformation.php';


var reference = window.referenceData = '<?= $_SESSION['accountHash'] ?>';
	
register(reference);

function register(reference){
	
	var data = {
			UserInformation:{
				reference: reference
			}
		};

	var tojson = JSON.stringify(data);
	callAPIgeuserInFormationToinput(tojson);
}// end of function
	

const email = document.getElementById('customerinformation_email');
const phone = document.getElementById('customerinformation_contactNumber');
const telephone = document.getElementById('customerinformation_telephoneNumber');
const street = document.getElementById('customerinformation_street');
const province = document.getElementById('customerinformation_province');
const zipcode = document.getElementById('customerinformation_zip');
const city = document.getElementById('customerinformation_city');
const bday = document.getElementById('customerinformation_birthday');
const firstname = document.getElementById('customerinformation_firstname');
const lastname = document.getElementById('customerinformation_lastname');
const middlename = document.getElementById('customerinformation_middlename');

document.getElementById('formdata').addEventListener('submit', event=>{
	event.preventDefault();
	editCustomer(reference);
});


callAPIgeuserInFormationToinput();

function editCustomer(reference){
	var data = {
			UserInformation:{
				"ci_email": email.value,
				"ci_firstname": firstname.value,
				"ci_lastname": lastname.value,
				"ci_middlename": middlename.value,
				"ci_street": street.value,
				"ci_city_municipality": city.value,
				"ci_province": province.value,
				"ci_zipcode": zipcode.value,
				"ci_phonenumber": phone.value,
				"ci_telephonenumber": telephone.value,
				"ci_bday": bday.value,
				"reference": reference
			}
		};
	var tojson = JSON.stringify(data);
	callAPIeditPersonalInformation(tojson);

}// end of function

function callAPIeditPersonalInformation(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   

            if (request.status == 200) {
              var data = this.responseText;
              var res = JSON.parse(data);
              
				if(res.response.http_response_code == 200){
					window.location.href = 'customerControlPage.php?customerInfo=' + res.response.display.message;
				}
           }
       }
   };

  request.open("POST", APIeditPersonalInformation, true);
  request.setRequestHeader('Content-Type', 'Application/json');
  request.send(jsonObj);
}// end of the function


function callAPIgeuserInFormationToinput(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {

              var data = this.responseText;
              var res = JSON.parse(this.responseText);

              if(res.response.http_response_code == 200 && res.response.reason == 'success'){
              //data here
				result.style.color = 'yellowgreen';
				result.innerHTML = res.response.display.message[0];

				email.value = res.response.result.documentInformation[0].ci_email; 
				phone.value = res.response.result.documentInformation[0].ci_phonenumber; 
				telephone.value = res.response.result.documentInformation[0].ci_telephonenumber; 
				street.value = res.response.result.documentInformation[0].ci_street; 
				city.value = res.response.result.documentInformation[0].ci_city_municipality; 
				province.value = res.response.result.documentInformation[0].ci_province; 
				zipcode.value = res.response.result.documentInformation[0].ci_zipcode;
				bday.value = res.response.result.documentInformation[0].ci_bday;
				firstname.value = res.response.result.documentInformation[0].ci_firstname;
				lastname.value = res.response.result.documentInformation[0].ci_lastname;
				middlename.value = res.response.result.documentInformation[0].ci_middlename;
              }
           }
       }
   };

   request.open("POST", APIgeuserInFormation, true);
  request.setRequestHeader('Content-Type', 'Application/json');
  request.send(jsonObj);
}
</script>