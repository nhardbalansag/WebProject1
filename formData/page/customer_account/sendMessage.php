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

					echo "customerControlPage.php?cp=" . base64_encode('index');

				?> >

				<p style="font-size: 20px;">back</p>
			</a>
		</div>

		<div style="background-color:rgb(236, 244, 252); padding: 10px; border-radius: 10px; margin-bottom: 3%;" class="informations">
			<div style="text-align: center;">
			<p style="font-size: 20px">to: yamaha</p>
			<p style=" font-size: 30px;">Messaging</p>
			<p id="result"></p>
			
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

const APIcreateCustomerMessage = '../../../api/creator/createCustomerMessage.php';

const messageCreating = document.getElementById('messageCreating');

document.getElementById('formdata').addEventListener('submit', event=>{
  event.preventDefault();
  SendCustomerMessage();
});

function SendCustomerMessage(){
	var data = {
			input:{
				"message": messageCreating.value,
				"messageType": "CM"
			}
		};

	var tojson = JSON.stringify(data);

	callAPIsendCustomerMessage(tojson);
}// end of function


function callAPIsendCustomerMessage(jsonObj) {

   var request = new XMLHttpRequest();
   
   request.onreadystatechange = function() {

       if (request.readyState == 4) {   // XMLHttpRequest.DONE == 4

            if (request.status == 200) {

              var data = this.responseText;
              var res = JSON.parse(this.responseText);

              if(res.response.http_response_code == 200 && res.response.reason == 'success'){
                  result.style.color = 'yellowgreen';
                  result.innerHTML = res.response.display.message[0];
                  messageCreating.value = null;
                }else{
                  //error
                  result.style.color = 'red';
                  result.innerHTML = res.response.display.message[0];
                }
           }
       }
   };

  request.open("POST", APIcreateCustomerMessage, true);
  request.setRequestHeader('Content-Type', 'Application/json');
  request.send(jsonObj);
}

</script>