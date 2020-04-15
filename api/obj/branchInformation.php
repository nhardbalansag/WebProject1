<?php

/**viewDocument
 * readDocumentOfUser
 */
class branchInformation
{

	public $conn;

	public $l_address, $l_description, $salt, $computed_hash, $e_address, $e_description, $cc_tittle, $c_number, $cc_id;
	public $a_id, $a_datecreated, $c_category, $bi_id, $referencehash;

	
	function __construct($db)
	{
		$this->conn = $db;

	}// end of the constructor

	function Createlinks(){

		$query = 'INSERT INTO links
					SET 
						l_address =:l_address,
						l_description=:l_description,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->l_address = htmlspecialchars(strip_tags($this->l_address));
		$this->l_description = htmlspecialchars(strip_tags($this->l_description));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':l_address', $this->l_address);
		$stmt->bindParam(':l_description', $this->l_description);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function CreateEmail(){

		$query = 'INSERT INTO email
					SET 
						e_address =:e_address,
						e_description=:e_description,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->e_address = htmlspecialchars(strip_tags($this->e_address));
		$this->e_description = htmlspecialchars(strip_tags($this->e_description));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':e_address', $this->e_address);
		$stmt->bindParam(':e_description', $this->e_description);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function createContact(){

		$query = 'INSERT INTO contact
					SET 
						c_number =:c_number,
						c_category=:c_category,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->c_number = htmlspecialchars(strip_tags($this->c_number));
		$this->c_category = htmlspecialchars(strip_tags($this->c_category));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':c_number', $this->c_number);
		$stmt->bindParam(':c_category', $this->c_category);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function CreateBranchInformation(){

		$query = 'INSERT INTO branch_information
					SET 
						bi_name =:bi_name,
						bi_street=:bi_street,
						bi_city_municipality=:bi_city_municipality,
						bi_buildingNumber=:bi_buildingNumber,
						bi_about=:bi_about,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->bi_name = htmlspecialchars(strip_tags($this->bi_name));
		$this->bi_street = htmlspecialchars(strip_tags($this->bi_street));
		$this->bi_city_municipality = htmlspecialchars(strip_tags($this->bi_city_municipality));
		$this->bi_buildingNumber = htmlspecialchars(strip_tags($this->bi_buildingNumber));
		$this->bi_about = htmlspecialchars(strip_tags($this->bi_about));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':bi_name', $this->bi_name);
		$stmt->bindParam(':bi_street', $this->bi_street);
		$stmt->bindParam(':bi_city_municipality', $this->bi_city_municipality);
		$stmt->bindParam(':bi_buildingNumber', $this->bi_buildingNumber);
		$stmt->bindParam(':bi_about', $this->bi_about);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function


	function CheckAdminAccount(){

		$query = 'SELECT
						a_id,
						a_datecreated,
						ur,
						computed_hash

					FROM admin_account
					WHERE 
						a_id = ? AND a_datecreated = ? AND computed_hash = ?
					LIMIT
					0,1';

		$stmt = $this->conn->prepare($query);

		$this->a_id = htmlspecialchars(strip_tags($this->a_id));
		$this->a_datecreated = htmlspecialchars(strip_tags($this->a_datecreated));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->a_id);
		$stmt->bindParam(2, $this->a_datecreated);
		$stmt->bindParam(3, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function


	function displayAllLinks(){

		$query = 'SELECT
						l_address,
						l_description,
						salt
					FROM links
					ORDER BY l_id DESC';

		$stmt = $this->conn->prepare($query);
		
		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function displayAllEmails(){

		$query = 'SELECT
						e_address,
						e_description,
						salt
					FROM email
					ORDER BY e_id DESC';

		$stmt = $this->conn->prepare($query);
		
		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function displayAllContacts(){

		$query = 'SELECT
						c_number,
						c_category,
						salt
					FROM contact
					ORDER BY c_id DESC';

		$stmt = $this->conn->prepare($query);
		
		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function branch_information(){

		$query = 'SELECT *
					FROM branch_information';

		$stmt = $this->conn->prepare($query);
		
		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function edit_branchInformation(){

		$query = ' UPDATE branch_information
            		SET
	                	bi_name =:bi_name,
						bi_street=:bi_street,
						bi_city_municipality=:bi_city_municipality,
						bi_buildingNumber=:bi_buildingNumber,
						bi_about=:bi_about,
						salt=:salt,
						computed_hash=:computed_hash
            		WHERE
               	 		(computed_hash=:referencehash)';

		$stmt = $this->conn->prepare($query);

		$this->bi_name = htmlspecialchars(strip_tags($this->bi_name));
		$this->bi_street = htmlspecialchars(strip_tags($this->bi_street));
		$this->bi_city_municipality = htmlspecialchars(strip_tags($this->bi_city_municipality));
		$this->bi_buildingNumber = htmlspecialchars(strip_tags($this->bi_buildingNumber));
		$this->bi_about = htmlspecialchars(strip_tags($this->bi_about));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));
		$this->referencehash = htmlspecialchars(strip_tags($this->referencehash));

		$stmt->bindParam(':bi_name', $this->bi_name);
		$stmt->bindParam(':bi_street', $this->bi_street);
		$stmt->bindParam(':bi_city_municipality', $this->bi_city_municipality);
		$stmt->bindParam(':bi_buildingNumber', $this->bi_buildingNumber);
		$stmt->bindParam(':bi_about', $this->bi_about);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);
		$stmt->bindParam(':referencehash', $this->referencehash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function

	// 	function displayAllBranchInformation(){

	// 	$query = 'SELECT
	// 					*

	// 				FROM branch_information, links, email, contact
	// 				WHERE 
	// 					(branch_information.bi_id = links.bi_id) 
	// 						AND (branch_information.bi_id = email.bi_id)
	// 							AND (branch_information.bi_id = contact.bi_id)';

	// 	$stmt = $this->conn->prepare($query);
		
	// 	if($stmt->execute()){

	// 		return $stmt;

	// 	}else{

	// 		return false;
			
	// 	}

	// }// end of the function

}// end of the class