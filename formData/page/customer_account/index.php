<?php
	if (

		!isset($_SESSION['firstname']) &&
		!isset($_SESSION['middlename']) &&
		!isset($_SESSION['lastname']) &&
		!isset($_SESSION['accountID']) &&
		!isset($_SESSION['informationID'])&&
		!isset($_SESSION['sessionID'])

	){
		
		header('location: ../controlpage.php');

	}
?>

<div id="content">
		<div class="informations" style="text-align: center;">
			<p style="font-size: 20px" id="welcomeRes">welcome</p>
			<div>
				<p>
					<span class="text" id="firstname"></span>
					<span class="text" id="middlename"></span>
					<span class="text" id="lastname"></span>
				</p>
			</div>
		</div>
		<div class="informations">
			<div style="display: flex; justify-content: space-around; align-items: center;">
				<div class="status" id="greenDots_one">
					<p >1</p>
				</div>
				<div class="status" id="greenDots_two">
					<p>2</p>
				</div>
				<div class="status" id="greenDots_three">
					<p>3</p>
				</div>
			</div>

			

			<style type="text/css">
				.text{
					font-size: 30px;
				}
			</style>

			<div style="margin-top: 80px; text-align: center;">
				<p style="color: rgb(10,15,42); font-weight: bolder; font-size: 30px;">guidelines:</p>
				<div>
					<div id="products_content" >
						<div class="prodPartial">
							<p style="color: rgb(10,15,42); font-weight: bold">STEP 1</p>
							<p><span style="font-size: 20px; text-transform: uppercase; font-weight: bolder;">sending of documents</span></p>
							<a class="coloredButton" href=

								<?php 

									echo "customerControlPage.php?cp=" . base64_encode('send_documents');

								?> >

							send douments</a>
						</div>
					</div>
					<div id="products_content" >
						<div class="prodPartial">
							<p style="color: rgb(10,15,42); font-weight: bold">STEP 2</p>
							<p><span style="font-size: 20px; text-transform: uppercase; font-weight: bolder;">verification</span></p>
							<a class="coloredButton" href=

								<?php 

									echo "customerControlPage.php?cp=" . base64_encode('document_verification');

								?> >

							check status</a>
						</div>
					</div>
				

					<div id="products_content" >
						<div class="prodPartial">
							<p><span style="font-size: 20px; text-transform: uppercase; font-weight: bolder;">messages</span></p>
							<a class="coloredButton" href=
							
								<?php 

									echo "customerControlPage.php?cp=" . base64_encode('sendMessage');

								?> >

							send message</a>
							<a class="coloredButton" href=

								<?php 

									echo "customerControlPage.php?cp=" . base64_encode('customerinbox');

								?> >

							inbox</a>
						</div>
					</div>
				</div>
			</div>

		</div>

<script type="text/javascript">

var APIgeusersDocumentCount = '../../../api/creator/documents/countUserDocument.php';
var APIgeuserInFormation = '../../../api/creator/readCustomerinformation.php';
var APIgetUserInfo = '../../../api/creator/readCustomerinformation.php';

var reference = window.referenceData = '<?= $_SESSION['accountHash'] ?>';

var firstname = document.getElementById('firstname');
var middlename = document.getElementById('middlename');
var lastname = document.getElementById('lastname');
	
register(reference);

function register(reference){
	
	var data = {
			UserInformation:{
				reference: reference
			}
		};

	var tojson = JSON.stringify(data);
	readCustomerInfo(tojson);
}// end of function

var greenDots_one = document.getElementById('greenDots_one');
var greenDots_two = document.getElementById('greenDots_two');
var greenDots_three = document.getElementById('greenDots_three');

var ctrValid = 0, ctrApproved = 0, ctrInvalid = 0;

callAPIgeusersDocumentCount();

function callAPIgeusersDocumentCount() {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {
              var data = this.responseText;
              var res = JSON.parse(this.responseText);
              if(res.response.http_response_code == 200 && res.response.reason == 'success'){
              	
                  greenDots_one.style.backgroundColor = 'yellowgreen';
                  
                  for(var i = 0; i <= res.response.display.message.length; i++){
                    if(res.response.display.message[i] === 'V'){
                      ctrValid++;
                    }else if(res.response.display.message[i] === 'A'){
                      ctrApproved++;
                    }else if(res.response.display.message[i] === 'INV'){
                      ctrInvalid++;
                    }
                  }
                  if(ctrApproved > 0){
                  	greenDots_three.style.backgroundColor = 'yellowgreen';
                  	greenDots_two.style.backgroundColor = 'yellowgreen';
                    welcomeRes.innerHTML = 'congratulations';
                    welcomeRes.style.color = 'yellowgreen';
                  }else{

					if(ctrInvalid > 0 ){
						welcomeRes.innerHTML = 'please check your documents';
						welcomeRes.style.color = 'rgb(190, 33, 60)';
						greenDots_two.style.backgroundColor = 'rgb(190, 33, 60)';
					}else if(ctrInvalid < 0 || ctrValid > 0){
						greenDots_two.style.backgroundColor = 'yellowgreen';
					}
                  }
              }else{
              		welcomeRes.innerHTML = 'welcome';
					welcomeRes.style.color = 'yellowgreen';
              }
           }
       }
   };

  request.open("GET", APIgeusersDocumentCount, true);
  request.send();
}

function readCustomerInfo(tojson) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {
              var data = this.responseText;
              var res = JSON.parse(this.responseText);
              if(res.response.http_response_code == 200 && res.response.reason == 'success'){
              	
				firstname.innerHTML = res.response.result.documentInformation[0].ci_firstname;
				middlename.innerHTML = res.response.result.documentInformation[0].ci_middlename;
				lastname.innerHTML = res.response.result.documentInformation[0].ci_lastname;
              }
           }
       }
   };

	request.open("POST", APIgetUserInfo, true);
	request.setRequestHeader('Content-Type', 'Application/json');
	request.send(tojson);
}


</script>