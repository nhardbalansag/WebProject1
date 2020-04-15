<div style="margin-top: 5%;">
	 			<div style="background-color:rgb(10,15,42); margin-top: 5%; ">
					<div id="branchInformation">
						
						<div id="bi_content">
							<div id="links">
								<h3 style="color: white; font-size: 30px">LINKS</h3>
								<!-- <div>
									<a href="">facebook.com</a>
									<p style="color:white">sample description</p>
								</div> -->
							</div>
						</div>

						<div class="informations" id="about">
							<h3 style="color: white; font-size: 30px">ABOUT US</h3>
							<p style="color: white" id="bi_about">
								
							</p>
						</div>

						<div id="contact">
							<p style="font-weight: bold; color: white; text-align: center;">TALK TO US</p>
<!-- 
							<div class="informations" id="talktous">
								<p style="font-weight: lighter;">category</p>
								<p>11111111111</p>
							</div> -->

						</div>

						<div id="email">
							<p style="font-weight: bold; color: white; text-align: center;">MESSAGE US</p>

							<!-- <div class="informations" id="talktous">
								<p></p>
								<p>11111111111</p>
							</div> -->

						</div>

						<div class="informations" id="about">
							<h3 style="color: white; font-size: 30px">ADDRESS</h3>
							<p style="color: white" id="address">
								
							</p>
						</div>

						<div  class="informations" id="talktous" style="border-bottom: none">
							<p style="font-weight: bold;">official business hours</p>
							<p>monday to thursday & saturday (10:00am - 8:00pm) friday(10:00am - 9:00Pm)</p>

							<p style="font-weight: bold;">service hours</p>
							<p>monday to thursday & saturday (10:00am - 8:00pm) friday(10:00am - 9:00Pm)</p>
						</div>
					</div>
				</div>
	 		</div>
</div>	

<script type="text/javascript" src="../asset/js/yamaha.js"></script>

<script type="text/javascript">

	var apilink = '../../../api/creator/admin/branchInformation/readAllInformation.php';

	var linksContainer = document.getElementById('links');
	var emailContainer = document.getElementById('email');
	var contactContainer = document.getElementById('contact');
	var bi_about = document.getElementById('bi_about');
	var address = document.getElementById('address');

	AjaxDisplay();
	
	function AjaxDisplay() {

	   var request = new XMLHttpRequest();
	   
	   request.onreadystatechange = function() {

	       if (request.readyState === 4) {   // XMLHttpRequest.DONE == 4

	            if (request.status === 200) {
	           		var data = this.responseText;
	            	var res = JSON.parse(data);// respomse of the request
	            	if(res.response.http_response_code == 200){

	            		var linkCount = res.response.display.link.length;
	            		var emailCount = res.response.display.email.length;
	            		var contactCount = res.response.display.contact.length;
	            		var branchCount = res.response.display.branch.length;

	            		if(linkCount > 0){

	            			for(var i = 0; i < linkCount; i++){

	            				var linkDiv = document.createElement('div');
	            				var link = document.createElement('a');
	            				link.innerHTML = res.response.display.link[i].l_address;
	            				link.href = res.response.display.link[i].l_address;
	            				var linkDescription = document.createElement('p');
	            				linkDescription.innerHTML = res.response.display.link[i].l_description;
	            				linkDescription.style.color = 'white';

	            				linkDiv.appendChild(link);
	            				linkDiv.appendChild(linkDescription);

	            				linksContainer.appendChild(linkDiv);

	            			}// end of the for

	            		}// end of if for link

	            		if(emailCount > 0){

	            			for(var i = 0; i < emailCount; i++){

	            				var emailDiv = document.createElement('div');
	            				emailDiv.setAttribute('class', 'informations');
	            				emailDiv.setAttribute('id', 'talktous');
	            				var e_address = document.createElement('p');
	            				e_address.innerHTML = res.response.display.email[i].e_address;
	            				e_address.style.fontWeight = 'lighter';
	            				var e_description = document.createElement('p');
	            				e_description.innerHTML = res.response.display.email[i].e_description;

	            				emailDiv.appendChild(e_address);
	            				emailDiv.appendChild(e_description);

	            				emailContainer.appendChild(emailDiv);
	            			}
	            		}// end of of for email

	            		if(contactCount > 0){

	            			for(var i = 0; i < contactCount; i++){

	            				var contactDiv = document.createElement('div');
	            				contactDiv.setAttribute('class', 'informations');
	            				contactDiv.setAttribute('id', 'talktous');
	            				var c_category = document.createElement('p');
	            				c_category.innerHTML = res.response.display.contact[i].c_category;
	            				c_category.style.fontWeight = 'lighter';
	            				var c_number = document.createElement('p');
	            				c_number.innerHTML = res.response.display.contact[i].c_number;

	            				contactDiv.appendChild(c_category);
	            				contactDiv.appendChild(c_number);

	            				contactContainer.appendChild(contactDiv);
	            			}
	            		}// end of the if for contact
	            		if(branchCount > 0){
	            			bi_about.innerHTML = res.response.display.branch[0].bi_about;

	            			var bi_name = res.response.display.branch[0].bi_name;
	            			var bi_street = res.response.display.branch[0].bi_street;
	            			var bi_city_municipality = res.response.display.branch[0].bi_city_municipality;

	            			address.innerHTML = bi_name + " " + bi_street + " " + bi_city_municipality;
	            		}
	            	}
	           }
	       }
	   };

	request.open("GET", apilink, true);
	request.send();
}// end of the function

</script>

	
</body>
</html>