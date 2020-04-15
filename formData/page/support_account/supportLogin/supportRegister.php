
	<div id="content">
		<div class="informations" style="text-align: center;">
			<p style="color: red; font-size: 20px;" id="result"></p>
			<p style=" font-size: 30px;">REGISTER</p>
			<p>register to have setup an account</p>
		</div>

		<div class="informations">
			<form method="post" id="formdata">
				<div style="text-align: center;">
					<input required class="inputmobile" type="email" id="register_email" name="" placeholder="*Email name">
					<input required class="inputmobile" type="text" id="register_firstname" name="" placeholder="*First name">
					<input required class="inputmobile" type="text" id="register_lastname" name="" placeholder="*Last name">
					<input required class="inputmobile" type="text" id="register_middlename" name="" placeholder="*Middle name">
					<input required class="inputmobile" type="number" id="register_phone" name="" placeholder="*Contact number">
					<input required class="inputmobile" type="number" id="register_telephone" name="" placeholder="*Telephone number">
					<input required class="inputmobile" type="text" id="register_street" name="" placeholder="*Street Address">
					<input required class="inputmobile" type="text" id="register_city" name="" placeholder="*City/Municipality">
					<input required class="inputmobile" type="text" id="register_province" name="" placeholder="*Province">
					<input required class="inputmobile" type="number" id="register_zipcode" name="" placeholder="*Zip Code"><br>
					<label required style="color:gray; font-size: 20px;">birthday</label><br>
					<input required class="inputmobile" type="date" id="register_bday" name="" placeholder="*Birthday">
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

	var APIregister = '../../../../api/creator/createAdminInformation.php';

	document.getElementById('formdata').addEventListener('submit', event=>{
		event.preventDefault();
		supportRegister();
	});

	var label =  document.getElementById('inquiryResultlabel');
	
	function supportRegister(){
	
	var email = document.getElementById('register_email').value;
	var firstname = document.getElementById('register_firstname').value;
	var lastname = document.getElementById('register_lastname').value;
	var middlename = document.getElementById('register_middlename').value;
	var street = document.getElementById('register_street').value;
	var city = document.getElementById('register_city').value;
	var province = document.getElementById('register_province').value;
	var zipcode = document.getElementById('register_zipcode').value;
	var phone = document.getElementById('register_phone').value;
	var telephone = document.getElementById('register_telephone').value;
	var bday = document.getElementById('register_bday').value;

	var data = {
			UserInformation:{
				"ci_email": email,
				"ci_firstname": firstname,
				"ci_lastname": lastname,
				"ci_middlename": middlename,
				"ci_street": street,
				"ci_city_municipality": city,
				"ci_province": province,
				"ci_zipcode": zipcode,
				"ci_phonenumber": phone,
				"ci_telephonenumber": telephone,
				"ci_bday": bday
			}
		};

	var tojson = JSON.stringify(data);
	callAPIregister(tojson);
}// end of function


function callAPIregister(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   

            if (request.status == 200) {
            	var data = this.responseText;
            	var res = JSON.parse(data);

            	result.innerHTML = res.response.reason + "! " + res.response.display.message;

            	if(res.response.http_response_code == 200){
               		result.style.color = 'green';
               		window.location.href = 'supportLoginControlPage.php?verifyadmin';
               	}else{
               		result.style.color = 'red';
               	}
           }else{

           		// error in request status
           		result.innerHTML = "error status";
           }
       }else{

       		// error in request
       		result.innerHTML = "waiting for response";
       }
   };

	request.open("POST", APIregister, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(jsonObj);
}// end of the function


</script>