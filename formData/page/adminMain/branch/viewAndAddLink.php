 
<div id="mainAdminContents">
	<div id="content" class="content">
 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "branchControlPage.php?branch=" . base64_encode('index');

					?> >

					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p id="result"></p>
 				<p style="font-size: 20px; font-weight: bolder;">manage links</p>
	 		</div>
	 		<div style="text-align: center;">
	 			<form method="post" id="formdata">
	 				<div class="inputmobile adminInputDivs" >
						<label>link address</label><br>
						<input class="inputmobile" type="link" id="l_address" placeholder="*link address" required><br>
						<input class="inputmobile" type="text" id="l_description" placeholder="*link description" required>
					</div>

					<div>
						<button name="submitLink" class="adminButton">
							Add Link
						</button>
					</div>
	 			</form>
				
			</div>
			<div id="reporting" class="reporting">
 				<p id="resultDisplaying" style="text-align: center;"></p>

			</div>
 		</div>
</div>
 		

<script type="text/javascript">

	var getLinkInput = '../../../../api/creator/admin/branchInformation/createLinks.php';
	var getLinkDisplay = '../../../../api/creator/admin/branchInformation/readLinks.php';

	var resultDisplaying = document.getElementById('resultDisplaying');
	var result = document.getElementById('result');
	var reporting = document.getElementById('reporting');

	document.getElementById('formdata').addEventListener('submit', event=>{
		event.preventDefault();
		getlinkData();
	});


	AjaxDisplaylinkData();

	function getlinkData(){

		var l_address = document.getElementById('l_address');
		var l_description = document.getElementById('l_description');

		if(!l_address.value || !l_description.value){

			l_address.style.borderColor = 'red';
			l_description.style.borderColor = 'red';

		}else{

			var data = {
				adminInput:{
					l_address: l_address.value,
					l_description: l_description.value
				}
			}
			var tojson = JSON.stringify(data);
			AjaxgetlinkData(tojson);

		}

		l_address.value = null;
		l_description.value = null;

	}// dn of the function

	function AjaxgetlinkData(tojson) {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code == 200){

	           			result.style.color = 'yellowgreen';
	           			result.innerHTML = res.response.display.message[0];
	            	}
	           }
	       }
	   };

	request.open("POST", getLinkInput, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}// end of the function

	function AjaxDisplaylinkData() {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request

	            	if(res.response.http_response_code == 200){

	           			var resultCount = res.response.display.message.length;

	           			if(res.response.http_response_code == 200){

	           				resultDisplaying.style.color = 'yellowgreen';
	           				resultDisplaying.innerHTML = res.response.reason;

	           				for(var i  = 0; i < resultCount; i++){


		           				var reportingContent = document.createElement('div');
		           				reportingContent.setAttribute('class', 'reportingContent');

		           				var contentOne = document.createElement('div');
		           				var contentOne_p = document.createElement('p');
		           				contentOne_p.setAttribute('class', 'linkNumber');
		           				contentOne_p.innerHTML = i + 1;
		           				contentOne.appendChild(contentOne_p);

		           				var contentTwo = document.createElement('div');
		           				contentTwo.setAttribute('class', 'linkContent');
		           				var contentTwo_a = document.createElement('a');
		           				contentTwo_a.href = res.response.display.message[i].l_address;
		           				contentTwo_a.innerHTML = res.response.display.message[i].l_address;
		           				var contentTwo_p = document.createElement('p');
		           				contentTwo_p.setAttribute('class', 'linkDescription');
		           				contentTwo_p.innerHTML = res.response.display.message[i].l_description;
		           				contentTwo.appendChild(contentTwo_a);
		           				contentTwo.appendChild(contentTwo_p);

		           				reportingContent.appendChild(contentOne)
		           				reportingContent.appendChild(contentTwo)

		           				reporting.appendChild(reportingContent);
		           			}// end of the for
	           			}
	            	}
	           }
	       }
	   };

	request.open("GET", getLinkDisplay, true);
	request.send();
}// end of the function


</script>