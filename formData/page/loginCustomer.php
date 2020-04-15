	<div id="content">
		<div class="informations" style="text-align: center;">
			<p style="color: red; font-size: 20px;" id="result"></p>
			<p style=" font-size: 30px;">login</p>
			<p>login to your account now</p>
		</div>
		<div class="informations">
			<form method="post" id="formdata">
				<div style="text-align: center;">
					<label class="label">email</label><br>
					<input class="inputmobile" id="customer_LoginEmail" type="email" name="" required><br>
					<label class="label">password</label><br>
					<input class="inputmobile" id="customer_LoginPassword" type="password" name="" required>

				</div>
				<div class="informations" style="text-align:  center;">
					<p style="color: rgb(56, 80, 128);">
						NOTICE : In compliance to RA 10173 known as Data Privacy Act of 2012, an Act of Protecting Individual Information, please be informed that gathered  information are recorded to better facilitate concerns assistance . Rest assured that information shall remain confidential and shall be used solely for official purposes.
					</p>
				</div>
				<div class="informations" style="text-align: center;">
					<button class="coloredButton">login</button>
				</div>
			</form>

			
		</div>
<script type="text/javascript">
	
const APIcustomerLogin = '../../../YAMAHA_PROJECT/api/creator/readLoginCustomerAccount.php';

const customer_LoginEmail = document.getElementById('customer_LoginEmail');
const customer_LoginPassword = document.getElementById('customer_LoginPassword');

document.getElementById('formdata').addEventListener('submit', event=>{
	event.preventDefault();
	CustomerLogin();
});


function CustomerLogin(){
	var data = {
			customerLoginInput:{
				"email": customer_LoginEmail.value,
				"password": customer_LoginPassword.value
			}
		};

	var tojson = JSON.stringify(data);
	callAPIcustomerLogin(tojson);
}// end of function

	
function callAPIcustomerLogin(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

            if (request.status === 200) {
           		var data = this.responseText;
            	var res = JSON.parse(data);// respomse of the request
            	result.innerHTML = res.response.reason + "! " + res.response.display.message;

            	if(res.response.http_response_code == 200 && res.response.reason == 'success'){
               		result.style.color = 'green';
               		window.location.href = res.response.display.message[0];
               	}
           }
       }
   };

	request.open("POST", APIcustomerLogin, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(jsonObj);
}// end of the function
</script>
