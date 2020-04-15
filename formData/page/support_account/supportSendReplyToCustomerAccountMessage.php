
<style type="text/css">
  .textArea{
    resize: none; 
    font-size: 20px; 
    border:1px solid black; 
    background-color: white; 
    width: 90%; 
    border-radius: 5px;
  }
</style>
<div id="content">

		<div class="informations">
			<a href=

				<?php 
					echo "support_controlPage.php?aslpAccount=" . base64_encode('viewAllMessagesOfOneCustomer'); 
				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

			<div style="text-align: center;">
  			 <p style=" font-size: 20px;">Messaging</p>
  			 <p id="displayMessageHere" style="font-size: 18px;"></p>
			</div>


  <form method="post" id="formdata">
    <div style="text-align: center;">
      <textarea  id="messageCreating" class="textArea" rows="15" required></textarea>
    </div>

    <div class="informations" style="text-align: center">
      <button class="coloredButton" style=" width: 30%; height: 50px;">
      send 
      <span>
      <i  class="fas fa-angle-right" style="font-size: 20px; color: white;"></i>
      </span>
      </button>
    </div>
  </form>


<script type="text/javascript">

var APIgetCustomerAccountMessageIdCreatedId = '../../../api/creator/support/createsupportMessageToaccount.php';
var displayMessageHere = document.getElementById('displayMessageHere');

var adminReply = document.getElementById('messageCreating');

document.getElementById('formdata').addEventListener('submit', event=>{
  event.preventDefault();
  getAccountId();
});

function getAccountId(){
  var data = {
      customerAccount:{
        "customerCreatedMessageId": window.customerId = '<?= $_GET['supportSendReplyToCustomerAccountMessage'] ?>',
        "AdminAccountId": window.customerId = '<?= $_SESSION['account_id'] ?>',
        "adminReply": adminReply.value,
        "messageType": 'AMA'
      }
    };
  var tojson = JSON.stringify(data);
  callAPIAPIgetInquiryMessageIdCreatedId(tojson);
}// end of function


function callAPIAPIgetInquiryMessageIdCreatedId(jsonObj) {

   var request = new XMLHttpRequest();
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {

              var data = this.responseText;
              var res = JSON.parse(data);// respomse of the request
              if(res.response.http_response_code == 200 && res.response.reason == 'success'){

              	displayMessageHere.innerHTML = res.response.display.message[0];
                displayMessageHere.style.color = 'yellowgreen';
                adminReply.value = null;
              }
           }
       }
   };
  request.open("POST", APIgetCustomerAccountMessageIdCreatedId, true);
  request.setRequestHeader('Content-Type', 'Application/json');
  request.send(jsonObj);
 
}// end of the function


	
</script>