
	<div id="content">
		<div class="informations" style="text-align: center;">
			<p style="color: red; font-size: 20px;" id="result"></p>
			<p style=" font-size: 30px;">SEND US A MESSAGE</p>
			<p>have ideas about ways on how we can work together? or do you have questions, suggestions or concerns? wed love to hear from you</p>
		</div>

		<div class="informations">
			<form method="post" id="formdata">
				<div style="text-align: center;">
					<input required class="inputmobile" type="email" id="email" name="" placeholder="*Email name">
					<input required class="inputmobile" type="text" id="firstname" name="" placeholder="*First name">
					<input required class="inputmobile" type="text" id="lastname" name="" placeholder="*Last name">
					<input required class="inputmobile" type="text" id="middlename" name="" placeholder="*Middle name">
					<input required class="inputmobile" type="number" id="phone" name="" placeholder="*Contact number">
					<input required class="inputmobile" type="number" id="telephone" name="" placeholder="*Contact number">
					<input required class="inputmobile" type="text" id="street" name="" placeholder="*Street Address">
					<input required class="inputmobile" type="text" id="city" name="" placeholder="*City/Municipality">
					<input required class="inputmobile" type="text" id="province" name="" placeholder="*Province">
					<input required class="inputmobile" type="number" id="zipcode" name="" placeholder="*Zip Code"><br>
					<label style="color:gray; font-size: 20px;">birthday</label><br>
					<input required class="inputmobile" type="date" id="bday" name="" placeholder="*Birthday">
					<select required class="inputmobile" id="categoryType" style="width: 84%; ">
						<option value="INQ">inquiry</option>
						<option value="CSG">seggestions</option>
					</select>
					<textarea required class="inputmobile" id="message" placeholder="*Message"></textarea>
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

<script type="text/javascript">
var APIinquiry = '../../api/creator/createInquiryCustomerInformation.php';

var email = document.getElementById('email');
var firstname = document.getElementById('firstname');
var lastname = document.getElementById('lastname');
var middlename = document.getElementById('middlename');
var street = document.getElementById('street');
var city = document.getElementById('city');
var province = document.getElementById('province');
var zipcode = document.getElementById('zipcode');
var phone = document.getElementById('phone');
var telephone = document.getElementById('telephone');
var bday = document.getElementById('bday');
var categoryType = document.getElementById('categoryType');
var message = document.getElementById('message');

document.getElementById('formdata').addEventListener('submit', event=>{
	event.preventDefault();
	inquiry();
});

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
	categoryType.value = null;
	message.value = null;
}


function inquiry(){
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
				"ci_categorytype": categoryType.value,
				"ci_inquiremessage": message.value
			}
		};

	var tojson = JSON.stringify(data);
	callAPIinquire(tojson);
}// end of function
	
function callAPIinquire(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {

            if (request.status == 200) {
               var data = this.responseText;
               var res = JSON.parse(data);
              
               result.innerHTML = res.response.reason + "!, " + res.response.display.message;

               if(res.response.http_response_code == 200){
               		result.style.color = 'green';
               		setnull();
               }else{
               		result.style.color = 'red';
               }
           }
       }
   };
	request.open("POST", APIinquiry, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(jsonObj);
}// end of the function
</script>
	