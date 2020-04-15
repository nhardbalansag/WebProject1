<div id="mainAdminContents">
	<div id="content" class="content">

 			<div style="width: 95%; justify-content: flex-start; margin:auto;">
				<a href=

					<?php 

						echo "productControlPage.php?product=" . base64_encode('viewAndAddSpecificationCategory');

					?> >
					
					<p style="font-size: 20px;">back</p>
				</a>
			</div>
 			<div style="text-align: center;">
 				<p style="font-size: 20px; font-weight: bolder;">product category type</p>
	 		</div>
	 		<div style="text-align: center;">
	 			<div class="searchDiv">
	 				<input type="text" name="" placeholder="search here">
	 				<i  class="fas fa-search" style="font-size: 20px; color: black;"></i>
	 			</div>
			</div>
			
			<div class="sortDiv">
				<select class="sort">
					<option>sort by</option>
					<option value="telephone">date ascending</option>
					<option value="mobile">date descending</option>
					<option value="hotline">name ascending</option>
					<option value="hotline">name descending</option>
				</select>
			</div>

			<div class="reporting">	
				<div class="reportingContent">
					<div class="linkContent">
						<p>product category type tittle</p>
						<p class="linkDescription">sample product category type description</p>
					</div>
				</div>
				
			</div>
</div>
 		