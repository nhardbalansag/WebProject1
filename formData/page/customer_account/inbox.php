		<div id="content">

			<div class="informations">
			<a href=

				<?php 

					echo "customerControlPage.php?cp=" . base64_encode('index');

				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

			<div style="text-align: center; width: 80%; margin:auto">
				<p style="color: red; font-size: 20px;" id="inboxResultlabel"></p>
				<p id="inquiryResultlabel" style="font-size: 20px;">inbox</p>
			</div>

		<div class="informations">
			<div id="container">
				
			</div>
			<a style="margin-top: 5%;">
				<button style="font-size: 20px; padding: 5px; width: 100%; background-color: rgb(236, 244, 252); border:none">load More.. <i  class="fas fa-angle-down" style="font-size: 20px; color: black;"></i></button>
			</a>
		</div>

<script type="text/javascript">

	var APIgetAdminReplies = '../../../api/creator/support/getAdminReplies.php';

	const label =  document.getElementById('inboxResultlabel');

	var accoundId = window.account = '<?= $_SESSION['accountID']  ?>';

	getAdminReplies(accoundId);

	function getAdminReplies(accoundId){
		var data = {
			AdminMessageData:{
				"customerAccountId": accoundId
			}
		};

		var tojson = JSON.stringify(data);
		callAPIgetAdminReplies(tojson);
	}// end of function

	function callAPIgetAdminReplies(jsonObj) {	

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status == 200) {
	              var data = this.responseText;
	              var res = JSON.parse(data);// respomse of the request

	              console.log(data)
	              label.innerHTML = res.response.display.message;
	              if(res.response.http_response_code == 200 && res.response.reason == 'success'){

						label.style.color = 'green';

						var container =document.getElementById('container');
						var inquiriesAll = document.getElementById('inquiriesAll');
						var type;
	                 
						for(var i = 0; i <  res.response.display.result.adminReply.length; i++){

							var div = document.createElement('div');
							div.setAttribute('id', 'inquiriesAll');
							var date_p = document.createElement('p');
							var time_p = document.createElement('p');
							var type_p = document.createElement('p');
							var a = document.createElement('a');

							date_p.innerHTML = res.response.display.result.adminReply[i].adminMessageDate;
							time_p.innerHTML = res.response.display.result.adminReply[i].adminMessagetime;
							type_p.innerHTML = 'message';

							a.setAttribute('id', "products_content");
							a.setAttribute('class', "inquiryClass");

							a.style.display = 'flex';
							a.style.justifyContent = 'space-around';
							a.style.padding = '5px';
							a.style.marginBottom = '10px';
							a.tittle = 'hello this is a link';
							a.href = 'customerControlPage.php?customerAccountAdminReply=' + res.response.display.result.adminReply[i].adminMessageReplyId;

							a.appendChild(date_p);
							a.appendChild(type_p);
							a.appendChild(time_p);

							div.appendChild(a);

							container.appendChild(div);
						}
	                }
	           	}
	       	}
	   	};

		request.open("POST", APIgetAdminReplies, true);
		request.setRequestHeader('Content-Type', 'Application/json');
		request.send(jsonObj);
	}// end of the function
</script>