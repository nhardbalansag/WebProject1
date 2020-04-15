
	<div id="content">
		<div class="informations" style="text-align: center;">
			<p style="color: red; font-size: 20px;" id="result"></p>
			<p style=" font-size: 30px;">REGISTER</p>
			<p>register to have setup an account</p>
		</div>

		<div class="informations">
			<form method="post" id="formdata">
				<div style="text-align: center;">
					<input class="inputmobile" type="email" id="register_email" name="" placeholder="*Email name" required>
					<input class="inputmobile" type="text" id="register_firstname" name="" placeholder="*First name" required>
					<input class="inputmobile" type="text" id="register_lastname" name="" placeholder="*Last name" required>
					<input class="inputmobile" type="text" id="register_middlename" name="" placeholder="*Middle name" required>
					<input class="inputmobile" type="number" id="register_phone" name="" placeholder="*Contact number">
					<input class="inputmobile" type="number" id="register_telephone" name="" placeholder="*Telephone number" required>
					<input class="inputmobile" type="text" id="register_street" name="" placeholder="*Street Address" required>
					<input class="inputmobile" type="text" id="register_city" name="" placeholder="*City/Municipality" required>
					<input class="inputmobile" type="text" id="register_province" name="" placeholder="*Province" required>
					<input class="inputmobile" type="number" id="register_zipcode" name="" placeholder="*Zip Code" required><br>
					<label style="color:gray; font-size: 20px;">birthday</label><br>
					<input class="inputmobile" type="date" id="register_bday" name="" placeholder="*Birthday" required>
				</div>

				<div class="informations" style="text-align:  center;">
					<p style="color: rgb(56, 80, 128);">
						NOTICE : In compliance to RA 10173 known as Data Privacy Act of 2012, an Act of Protecting Individual Information, please be informed that gathered  information are recorded to better facilitate concerns assistance . Rest assured that information shall remain confidential and shall be used solely for official purposes.
					</p>
				</div>

				<div class="informations" style="text-align: center;">
					<button class="coloredButton">Submit</button>
				</div>
			</form>
		</div>
<style type="text/css">
	.pop{
		  /*display: none;*/
		  position: fixed; /* Stay in place */
		  z-index: 1; /* Sit on top */
		  left: 0;
		  top: 0;
		  width: 100%; /* Full width */
		  height: 100%; /* Full height */
		  overflow: auto; /* Enable scroll if needed */
		  background-color: rgb(0,0,0); /* Fallback color */
		  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	.content{
		background-color: #D3E4F5;
		  margin: 50% auto; /* 15% from the top and centered */
		  padding: 20px;
		  width: 80%; /* Could be more or less, depending on screen size */
		  border-radius: 10px;
	}
	.content p{
		color: black;
		text-transform: none;
		border-bottom: 1px solid black;
	}
</style>
		<div class="pop" id="pop">
			<div class="content">
				<p id="reference">ajdskfhksfkdfh</p>
				<button class="coloredButton">copy</button>
			</div>
		</div>

<script type="text/javascript">
	var pop = document.getElementById('pop');
	var reference = document.getElementById('reference');


	pop.addEventListener('click', function(){
		reference.select();
	  reference.setSelectionRange(0, 99999); /*For mobile devices*/

	  /* Copy the text inside the text field */
	  document.execCommand("copy");

	  /* Alert the copied text */
	  alert("Copied the text: " + reference.value);
	});


















</script>

<script type="text/javascript">

var APIregister = '../../api/creator/createRegisterCustomerInformation.php';

var email = document.getElementById('register_email');
var firstname = document.getElementById('register_firstname');
var lastname = document.getElementById('register_lastname');
var middlename = document.getElementById('register_middlename');
var street = document.getElementById('register_street');
var city = document.getElementById('register_city');
var province = document.getElementById('register_province');
var zipcode = document.getElementById('register_zipcode');
var phone = document.getElementById('register_phone');
var telephone = document.getElementById('register_telephone');
var bday = document.getElementById('register_bday');

	
document.getElementById('formdata').addEventListener('submit', event=>{
	event.preventDefault();
	register();
});

function register(){
	
	
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
				"ci_bday": bday.value
			}
		};

	var tojson = JSON.stringify(data);
	callAPIregister(tojson);
}// end of function


function setnull(){
	email.value = null;
	firstname.value = null;
	lastname.value = null;
	middlename.value = null;
	street.value = null;
	city.value = null;
	province.value = null;
	zipcode.value = null;
	phone.value = null;
	telephone.value = null;
	bday.value = null;
}

function callAPIregister(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   

            if (request.status == 200) {
            	var data = this.responseText;
            	var res = JSON.parse(data);
            	if(res.response.http_response_code == 200){
               		result.style.color = 'green';
               		result.innerHTML = res.response.errors;
               		// window.location.href = 'controlpage.php?verify';
               		setnull();
               	}else{
               		result.style.color = 'red';
               	}
           }
       }
   };

	request.open("POST", APIregister, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(jsonObj);
}// end of the function

</script>