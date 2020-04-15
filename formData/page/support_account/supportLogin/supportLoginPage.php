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
					<input required class="inputmobile" id="support_LoginEmail" type="email" name=""><br>
					<label class="label">password</label><br>
					<input required class="inputmobile" id="support_LoginPassword" type="password" name="">

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
	
	var APIsupportLogin = '../../../../api/creator/readAdminLogin.php';

	document.getElementById('formdata').addEventListener('submit', event=>{
		event.preventDefault();
		AdminLogin();
	});

	function AdminLogin(){

		var support_LoginEmail = document.getElementById('support_LoginEmail').value;
		var support_LoginPassword = document.getElementById('support_LoginPassword').value;

		var data = {
				adminLoginInput:{
					"email": support_LoginEmail,
					"password": support_LoginPassword
				}
			};

		var tojson = JSON.stringify(data);
		callAPIsupportLogin(tojson);
	}// end of function

	function callAPIsupportLogin(jsonObj) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status == 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	// alert(data)
	            	result.innerHTML = res.response.reason;

	            	if(res.response.http_response_code == 200 && res.response.reason == 'success'){

	               		result.style.color = 'green';
	               		window.location.href = res.response.display.message[0];

	               	}else{
	               		result.style.color = 'red';
	               	}
	           }
	       }
	   };

		request.open("POST", APIsupportLogin, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(jsonObj);
	}// end of the function

</script>