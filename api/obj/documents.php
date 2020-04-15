<?php

/**viewDocument
 * readDocumentOfUser
 */
class Documents
{

	public $conn;

	public $categoryType, $hash, $salt, $date, $description, $computed_hash, $reference;

	public $image, $docsId, $accountId, $status, $documentId, $note;
	
	function __construct($db)
	{
		$this->conn = $db;

	}// end of the constructor

	function createDocumentCategory(){

		$query = 'INSERT INTO document_category_type
					SET 
						dc_document_category_name=:dc_document_category_name,
						dc_document_category_description=:dc_document_category_description,
						salt=:salt,
						dc_date_created=:dc_date_created,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->categoryType = htmlspecialchars(strip_tags($this->categoryType));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':dc_document_category_name', $this->categoryType);
		$stmt->bindParam(':dc_document_category_description', $this->description);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':dc_date_created', $this->date);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function createDocument(){

		$query = 'INSERT INTO document
					SET 
						d_image=:d_image,
						d_status=:d_status,
						dc_id=:dc_id,
						ca_id=:ca_id,
						d_datecreated=:d_datecreated,
						d_salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->image = htmlspecialchars(strip_tags($this->image));
		$this->status = htmlspecialchars(strip_tags($this->status));
		$this->docsId = htmlspecialchars(strip_tags($this->docsId));
		$this->accountId = htmlspecialchars(strip_tags($this->accountId));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':d_image', $this->image);
		$stmt->bindParam(':d_status', $this->status);
		$stmt->bindParam(':dc_id', $this->docsId);
		$stmt->bindParam(':ca_id', $this->accountId);
		$stmt->bindParam(':d_datecreated', $this->date);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;
			
		}

	}// end of the function

	function readDocumentCategory(){

		$query = 'SELECT * 
					FROM document_category_type';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function readDocumentCategoryForDescription(){

		$query = 'SELECT * 
					FROM document_category_type
					WHERE dc_id = ?';

		$stmt = $this->conn->prepare($query);

		$this->docsId = htmlspecialchars(strip_tags($this->docsId));

		$stmt->bindParam(1, $this->docsId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function readDocumentOfUser(){

		$query = 'SELECT 
					document.d_id as d_id, 
					document.d_image as d_image,
					document.d_status as d_status,
					document.dc_id as dc_id,
					document.ca_id as ca_id,
					document.d_datecreated as d_datecreated,
					document.d_salt as documentIv,
					document.computed_hash as documentHash,
					document.d_note as notetodocs

					FROM document, customer_account
					WHERE 
					(document.ca_id = customer_account.ca_id) AND document.ca_id = ?
					GROUP BY
						document.d_id,
						document.d_image,
						document.d_status,
						document.dc_id,
						document.ca_id,
						document.d_datecreated,
						document.d_salt,
						document.computed_hash,
						document.d_note

					';

		$stmt = $this->conn->prepare($query);

		$this->accountId = htmlspecialchars(strip_tags($this->accountId));

		$stmt->bindParam(1, $this->accountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function readDocumentOfUser_information(){

		$query = 'SELECT *
					FROM document, document_category_type
					WHERE ((document.dc_id = document_category_type.dc_id) AND document.ca_id = ?)';

		$stmt = $this->conn->prepare($query);

		$this->docsId = htmlspecialchars(strip_tags($this->docsId));

		$stmt->bindParam(1, $this->docsId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	
	function countUserDocuments(){

		$query = 'SELECT *
					FROM document, customer_account
					WHERE ((document.ca_id = customer_account.ca_id) AND customer_account.ca_id = ?)';

		$stmt = $this->conn->prepare($query);

		$this->accountId = htmlspecialchars(strip_tags($this->accountId));

		$stmt->bindParam(1, $this->accountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function getDocumentsOfOneCustomerAccount(){

		$query = '
				SELECT 
				    document.d_id AS documentId,
				    document.d_image AS documentImage,
				    document.d_datecreated AS documentDateCreated,
				    document_category_type.dc_document_category_name AS documentCategoryName,
				    document_category_type.salt AS documentCategoryNameKey,
				    document.ca_id AS customerAccountId
				FROM
				    customer_account,
				    document,
				    document_category_type
				WHERE
				    ((customer_account.ca_id = document.ca_id)
				        AND customer_account.computed_hash = ?)
				GROUP BY document.d_id , document.d_image , document.d_datecreated , document_category_type.dc_document_category_name , document_category_type.salt
				ORDER BY document.d_datecreated DESC';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function viewDocument(){

		$query = '
				SELECT 
				    document.d_image as documentImage,
				    document.d_status as documentStatus,
				    document.d_salt as documentKey,
				    document.d_datecreated as documentDateCreated
				FROM
				    document,
				    customer_account
				WHERE
				    ((document.ca_id = customer_account.ca_id)
				        AND document.d_id = ?)
				GROUP BY 
				document.d_image,
				document.d_status,
				document.d_salt,
				document.d_datecreated';

		$stmt = $this->conn->prepare($query);

		$this->documentId = htmlspecialchars(strip_tags($this->documentId));

		$stmt->bindParam(1, $this->documentId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function updateDocumentStatus(){

		$query = ' UPDATE document, customer_account
            		SET
	                	document.d_status=:d_status,
	                	document.d_note=:d_note,
	                	document.d_salt=:d_salt
            		WHERE
               	 		(
               	 		(document.ca_id = customer_account.ca_id) 
               	 			AND document.ca_id=:ca_id) 
               	 				AND document.d_id = :d_id';

		$stmt = $this->conn->prepare($query);

		$this->accountId = htmlspecialchars(strip_tags($this->accountId));
		$this->note = htmlspecialchars(strip_tags($this->note));
		$this->status = htmlspecialchars(strip_tags($this->status));
		$this->docsId = htmlspecialchars(strip_tags($this->docsId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));

		$stmt->bindParam(':ca_id', $this->accountId);
		$stmt->bindParam(':d_note', $this->note);
		$stmt->bindParam(':d_status', $this->status);
		$stmt->bindParam(':d_id', $this->docsId);
		$stmt->bindParam(':d_salt', $this->salt);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function

	function readOneDocumentCategory(){

		$query = 'SELECT *
					FROM 
						document_category_type
					WHERE 
						computed_hash = ?';

		$stmt = $this->conn->prepare($query);

		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(1, $this->reference);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function editDocumentCategory(){

		$query = 'UPDATE  
						document_category_type
					SET 
						dc_document_category_name=:dc_document_category_name,
						dc_document_category_description=:dc_document_category_description,
						salt=:salt,
						computed_hash=:computed_hash
					WHERE
						computed_hash =:reference';

		$stmt = $this->conn->prepare($query);

		$this->categoryType = htmlspecialchars(strip_tags($this->categoryType));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(':dc_document_category_name', $this->categoryType);
		$stmt->bindParam(':dc_document_category_description', $this->description);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);
		$stmt->bindParam(':reference', $this->reference);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function editDocument(){

		$query = 'UPDATE document
					SET 
						d_image=:d_image,
						d_status=:d_status,
						dc_id=:dc_id,
						ca_id=:ca_id,
						d_datecreated=:d_datecreated,
						d_salt=:salt,
						computed_hash=:computed_hash
					WHERE
						computed_hash =:reference';

		$stmt = $this->conn->prepare($query);

		$this->image = htmlspecialchars(strip_tags($this->image));
		$this->status = htmlspecialchars(strip_tags($this->status));
		$this->docsId = htmlspecialchars(strip_tags($this->docsId));
		$this->accountId = htmlspecialchars(strip_tags($this->accountId));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(':d_image', $this->image);
		$stmt->bindParam(':d_status', $this->status);
		$stmt->bindParam(':dc_id', $this->docsId);
		$stmt->bindParam(':ca_id', $this->accountId);
		$stmt->bindParam(':d_datecreated', $this->date);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);
		$stmt->bindParam(':reference', $this->reference);

		if($stmt->execute()){

			return true;

		}else{

			return false;
			
		}

	}// end of the function







}