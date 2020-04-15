<div id="content">

	<div class="informations">
			<a href=

				<?php 
					echo "../../../../YAMAHA_PROJECT/formData/page/support_account/support_controlPage.php?aslpAccount=" . base64_encode('supportIndex'); 
				?> 
				>

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

		<div style="text-align: center; width: 80%; margin:auto">
				<p style="color: red; font-size: 20px;" id="result"></p>
				<p id="inquiryResultlabel" style="font-size: 20px;"></p>
			</div>
		<div id="container" class="informations">
			
		<!-- 	<div id="inquiriesAll">
				<a href="" id="products_content" style="display: flex;justify-content: space-around; padding:5px; margin-bottom: 10px;">
					<p>12:00</p>
					<p>message</p>
					<p>2010-01-12</p>
				</a>
			</div> -->
			
			

			
		</div>

		<div class="informations">
			<a style="margin-top: 5%;">
				<button style="font-size: 20px; padding: 5px; width: 100%; background-color: rgb(236, 244, 252); border:none">load More.. <i  class="fas fa-angle-down" style="font-size: 20px; color: black;"></i></button>
			</a>
		</div>


<script type="text/javascript">
	
	var APIcustomerAccounts = '../../../api/creator/support/readCustomerAccounts.php';

	var label =  document.getElementById('inquiryResultlabel');

	callAPIcustomerAccounts();

	function callAPIcustomerAccounts() {	

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status == 200) {

	              var data = this.responseText;

	              var res = JSON.parse(data);// respomse of the request

	              label.innerHTML = res.response.display.message;
	              	// label.innerHTML = data;

	              if(res.response.http_response_code === 200 && res.response.reason === 'success'){

	                  label.style.color = 'green';
	                  var container =document.getElementById('container');
	                 
	                  for(var i = 0; i <  res.response.display.result.length; i++){

	                    var div = document.createElement('div');

	                    div.setAttribute('id', 'inquiriesAll');

	                    var date_p = document.createElement('p');
	                    var accountName = document.createElement('p');
	                    var a = document.createElement('a');

	                    date_p.innerHTML = res.response.display.result[i].datecreated;
	                    date_p.style.color = 'black';
	                    
	                    accountName.innerHTML = res.response.display.result[i].ci_firstname;
	                    accountName.style.color = 'black';
	                    accountName.style.fontWeight = 'bolder';

	                    a.setAttribute('id', "products_content");
	                    a.setAttribute('class', "inquiryClass");

	                    a.style.display = 'flex';
	                    a.style.justifyContent = 'space-around';
	                    a.style.padding = '5px';
	                    a.style.marginBottom = '10px';

	                    a.tittle = 'hello this is a link';
	                    a.href = 'support_controlPage.php?AccountInfo=' + res.response.display.result[i].account_computed_hash;

	                    a.appendChild(date_p);
	                    a.appendChild(accountName);

	                    div.appendChild(a);

	                    container.appendChild(div);

	                  }

	                }
	           }
	       }
	   };

	  request.open("GET", APIcustomerAccounts, true);
	  request.send();
	}// end of the function


</script>

