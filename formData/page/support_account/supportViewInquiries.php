	<div id="content">

			<div class="informations">
			<a href=

				<?php 
					echo "support_controlPage.php?aslpAccount=" . base64_encode('index'); 
				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

			<div style="text-align: center; width: 80%; margin:auto">
				<p style="color: red; font-size: 20px;" id="result"></p>
				<p id="inquiryResultlabel" style="font-size: 20px;">customer inquiries</p>
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

	var APIdisplayCustomerInquiries = '../../../api/creator/support/readCustomerMessages.php';

	var label =  document.getElementById('inquiryResultlabel');

	callAPIcustomerInquiries();

	function callAPIcustomerInquiries() {	

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status == 200) {
	              var data = this.responseText;

	              
	              var res = JSON.parse(data);// respomse of the request

	              label.innerHTML =res.response.reason + "! " + res.response.display.message;

	              if(res.response.http_response_code == 200 && res.response.reason == 'success'){

	                  label.style.color = 'green';

	                  var container =document.getElementById('container');
	                  var inquiriesAll = document.getElementById('inquiriesAll');
	                  var type;
	                 
	                  for(var i = 0; i <  res.response.display.result.length; i++){

	                    var div = document.createElement('div');

	                    div.setAttribute('id', 'inquiriesAll');


	                    var date_p = document.createElement('p');
	                    var time_p = document.createElement('p');
	                    var type_p = document.createElement('p');
	                    var a = document.createElement('a');

	                    // var link = document.createTextNode("this is alink");

	                    date_p.innerHTML = res.response.display.result[i].dateCreated;

	                    time_p.innerHTML = res.response.display.result[i].timeCreated;

	                    if(res.response.display.result[i].m_type === 'INQ'){

	                      type = 'inquiry';

	                    }else if(res.response.display.result[i].m_type === 'CM'){

	                      type = 'message';

	                    }else if(res.response.display.result[i].m_type === 'CSG'){

	                      type = 'suggestion';
	                      
	                    }

	                    type_p.innerHTML = type;


	                    a.setAttribute('id', "products_content");
	                    a.setAttribute('class', "inquiryClass");

	                    a.style.display = 'flex';
	                    a.style.justifyContent = 'space-around';
	                    a.style.padding = '5px';
	                    a.style.marginBottom = '10px';
	                    // a.appendChild(link);

	                    a.tittle = 'hello this is a link';
	                    a.href = '../../../../YAMAHA_PROJECT/formData/page/support_account/support_controlPage.php?customerInquiries=' + res.response.display.result[i].personalInfo;

	                    a.appendChild(date_p);
	                    a.appendChild(type_p);
	                    a.appendChild(time_p);

	                    div.appendChild(a);

	                    container.appendChild(div);

	                  }

	                }else{

	                  label.style.color = 'red';

	                }

	           }else{
	              // error in request status
	              label.innerHTML = "error status";
	           }
	       }else{
	          // error in request
	          label.innerHTML = "waiting for response";
	       }
	   };

	  request.open("GET", APIdisplayCustomerInquiries, true);
	  request.send();
	}// end of the function
</script>