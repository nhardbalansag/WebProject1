<?php
	
	
	
	include_once ('../../../api/config/database.php');

	include_once ('../../../api/obj/documents.php');

	$db = new Database();

	$connection = $db->connection();

	$Documents = new Documents($connection);


	if(isset($_GET['image'])){

		$Documents->documentId = $_GET['image'];

		if($stmt = $Documents->viewDocument()){

			$count = $stmt->rowCount();

			if($count > 0){

				while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

					$imageData = $data['documentImage ; charset=UTF-8'];

				}

				header("Content-Type: image/jpeg");


				echo $imageData;


			}else{

				echo 'no data';
			}

		}else{


			echo 'error loading image';
		}


	}

?>