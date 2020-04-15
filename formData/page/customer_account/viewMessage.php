<div id="content">
		<div class="informations">
			<a href=

				<?php 

					echo "customerControlPage.php?cp=" . base64_encode('customerinbox');

				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

		<div style="background-color:rgb(236, 244, 252); padding: 10px; border-radius: 10px; margin-bottom: 3%;" class="informations">
			<div style="text-align: center;">
				<p id="testing"></p>
				<div style="display: flex; justify-content: space-around;">
					<p id="date">
						date
					</p>
					<p id="time">
						time
					</p>
				</div>
				<p style="color: yellowgreen; font-size: 20px;" id="">MESSAGE</p>
				<p style="font-size: 20px">From: YAMAHA</p>
				
			</div>

			<div style="text-align: center; width: 70%; margin:auto;">
				<p id="adminMessage">
					
				</p>
			</div>
		</div>
		

<script type="text/javascript">

	var APIgetAdminMessages = '../../../api/creator/support/getAdminMessages.php';

	var adminMessage = document.getElementById('adminMessage');
	var date = document.getElementById('date');
	var time = document.getElementById('time');

	getAdminMessages();

	function getAdminMessages(){

		var data = {
			infoId:{
				"id": window.reference = '<?= $_GET['customerAccountAdminReply'] ?>'
			}
		};

		var tojson = JSON.stringify(data);

		callAPIgetAdminMessages(tojson);

	}// end of function


	function callAPIgetAdminMessages(jsonObj) {	

		var request = new XMLHttpRequest();

		request.onreadystatechange = function() {

			if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

				if (request.status == 200) {
					var data = this.responseText;
					var res = JSON.parse(data);// respomse of the request
					if(res.response.http_response_code === 200 && res.response.reason === 'success'){
						adminMessage.innerHTML = res.response.result.data[0].adminMessage;
						date.innerHTML = res.response.result.data[0].adminMessageDate;
						time.innerHTML = res.response.result.data[0].adminMessageTime;
					}
				}
			}
		};

		request.open("POST", APIgetAdminMessages, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(jsonObj);
	}// end of the function
	
</script>