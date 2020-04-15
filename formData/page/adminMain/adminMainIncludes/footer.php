<div>
			<footer id="footer">
				<a style="color:white;" href="index.php">
					home
				</a>
			</footer> 
 		</div>
 	</div>
</body>
	<script type="text/javascript">
		var navbuttonright  = document.getElementById('navbuttonright');
		var navbuttondown  = document.getElementById('navbuttondown');
		var dropdown = document.getElementById('dropdown');
		var product_miniDrop = document.getElementById('product_miniDrop');
		var products = document.getElementById('products');
		var content = document.getElementById('mainAdminContents');
		var click = 0, clickProd = 0;

		dropdown.style.display = 'none';
		product_miniDrop.style.display = 'none';
		navbuttondown.style.display = 'none';

		navbuttonright.addEventListener('click', function(){
			click++;
			if(click == 1){
				dropdown.style.display = 'block';
				content.style.display = 'none';
				navbuttonright.style.display = 'none';
				navbuttondown.style.display = 'block';
			}
		});

		navbuttondown.addEventListener('click', function(){
			click++;
			if(click == 2){
				dropdown.style.display = 'none';
				content.style.display = 'block';
				navbuttonright.style.display = 'block';
				navbuttondown.style.display = 'none';
				click = 0;
			}
		});

		products.addEventListener('click', function(){
			clickProd++;
		
			if(clickProd == 1){
				product_miniDrop.style.display = 'block';
			}else if(clickProd == 2){
				product_miniDrop.style.display = 'none';
				clickProd = 0;
			}
		});

	</script>
</html>

