	<div id="content">
		<div class="informations" style="text-align: center;">
			<p style="color: red; font-size: 20px;" id="result"></p>
			<p style=" font-size: 30px;">setup your account now</p>
			<p>please provide the reference code we have sended to your email</p>
		</div>

		<div class="informations">
			<form method="post" id="formdata">
				<div style="text-align: center;">
					<label class="label">reference code</label><br>
					<input class="inputmobile" type="text" id="customer_referenceCode" name="" required><br>
					<label class="label">password</label><br>
					<input class="inputmobile" type="password" id="customer_password" name="" required>

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
const APIcreateCustomerAccount = '../../api/creator/createAccount.php';

const customer_referenceCode = document.getElementById('customer_referenceCode');
const customer_password = document.getElementById('customer_password');

document.getElementById('formdata').addEventListener('submit', event=>{
	event.preventDefault();
	CreateCustomerAccount();
});


function CreateCustomerAccount(){
	var data = {
			customerAccountInput:{
				"referenceCode": customer_referenceCode.value,
				"cal_password": customer_password.value
			}
		};

	var tojson = JSON.stringify(data);

	setUpCustomerAccount(tojson);
}// end of function
		
function setUpCustomerAccount(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
         
            	result.innerHTML = res.response.reason + "! " + res.response.display.message;

            	if(res.response.http_response_code == 200){
               		result.style.color = 'green';
               		window.location.href = 'controlpage.php?login';
               	}else{
               		result.style.color = 'red';
               	}
           }
       }
   };

	request.open("POST", APIcreateCustomerAccount, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(jsonObj);
}// end of the function
	</script>