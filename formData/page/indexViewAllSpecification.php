
<style type="text/css">
		.button{
			padding:5px;
			background-color: #385080;
			border-radius: 10px;
			width:100%;
			color: white;
			text-transform: capitalize;
			font-size: 25px;
			padding:5% 0px;
			border:none;
			margin: 5px 0px;
		}
		.divButton{
			margin: 10px auto; 
			width: 90%;
			background-color: #111740;
			padding: 10px;
			border-radius: 10px;
		}
	</style>

<div id="content" style="padding-bottom: 100px;">
	<div style="width: 95%; justify-content: flex-start; margin:auto;">
		<a href=

			<?php 

				echo "../../index.php";

			?> >
			
			<p style="font-size: 20px;">back</p>
		</a>
	</div>
	<div>
		<div class="divButton" id="divButton">

			<a href=
				<?php 
						echo "controlpage.php?specificationContent=" . $_GET['specification'] . "&type=" . 'engine'; 
				?> >
				<button class="button">engine</button>
			</a>
			<a href=
				<?php 
						echo "controlpage.php?specificationContent=" . $_GET['specification'] . "&type=" . 'framework'; 
				?> >
				<button class="button">framework</button>
			</a>
			<a href=
				<?php 
						echo "controlpage.php?specificationContent=" . $_GET['specification'] . "&type=" . 'dimention'; 
				?> >			
				<button class="button">dimention</button>
			</a>
		</div>

		<div class="divButton">
			<a href=
				<?php 
						echo "controlpage.php?features=" . $_GET['specification']; 
				?> >
				<button class="button">features</button>
			</a>
		</div>
	</div>
		
</div>


