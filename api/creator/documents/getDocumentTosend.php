<?php

// localhost/my_projects/yamaha_elective/api/creator/documents/getDocumentTosend.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	$userfileData = file_get_contents('php://input');

	$fileRaw = json_decode($userfileData);

	if($fileRaw->input->image == null || $fileRaw->input->status || $fileRaw->input->categoryId){

		$result = 'failed';
		$filename = null;
		$categoryId = null;

		goto endcreate;

	}

	if(file)
		
	// $filetempname = $_FILES['filename']['tmp_name'];
	// $fileError = $_FILES['filename']['error'];
	// $filetype = $_FILES['filename']['type'];

	// $type = explode('.', $filename);

	// if(strtolower($type[1]) == 'jpg'){

    	move_uploaded_file($filetempname, "../../../api/creator/PICS/". $filename);

	// }

	if($filename == null || $categoryId == null){

		$result = 'failed';
		$filename = null;
		$categoryId = null;

		goto endcreate;
	}

	$image = $filename;
	$catId = $categoryId;
	$result = 'success';
	
	goto endcreate;

	endcreate:

		$fileData = json_encode(
					array(
						'result' => $result,
						'filename' => $filename,
						'categoryId' => $categoryId
					)
				);

		echo $fileData;

?>