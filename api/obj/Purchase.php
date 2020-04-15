<?php


/**
 * 
 */
class Purchase
{

	public $conn;

	public $firstName, $lastName, $middleName, $address, $billingAddress, $emailAddress, $salt, $hash;

	public $dateCreated, $purchaseType, $availedCustomerId, $productId;

	function __construct($db)
	{
		$this->conn = $db;

	}// end of the constructor

	function createAvailedCustomerInformation(){

		$query = 'INSERT INTO availed_customer_information
					SET 
						aci_firstName=:aci_firstName,
						aci_lastName=:aci_lastName,
						aci_middleName=:aci_middleName,
						aci_address=:aci_address,
						aci_billingAddress=:aci_billingAddress,
						aci_emailAddress=:aci_emailAddress,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->firstName = htmlspecialchars(strip_tags($this->firstName));
		$this->lastName = htmlspecialchars(strip_tags($this->lastName));
		$this->middleName = htmlspecialchars(strip_tags($this->middleName));
		$this->address = htmlspecialchars(strip_tags($this->address));
		$this->billingAddress = htmlspecialchars(strip_tags($this->billingAddress));
		$this->emailAddress = htmlspecialchars(strip_tags($this->emailAddress));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':aci_firstName', $this->firstName);
		$stmt->bindParam(':aci_lastName', $this->lastName);
		$stmt->bindParam(':aci_middleName', $this->middleName);
		$stmt->bindParam(':aci_address', $this->address);
		$stmt->bindParam(':aci_billingAddress', $this->billingAddress);
		$stmt->bindParam(':aci_emailAddress', $this->emailAddress);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function getAvailedCustomerId(){

		$query = '	SELECT *
					FROM availed_customer_information
					WHERE computed_hash = ?';

		$stmt = $this->conn->prepare($query);

		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(1, $this->hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}
	
	}// end of the function

		function createPurchaseInformation(){

		$query = 'INSERT INTO purchase_information
					SET 
						pi_date=:pi_date,
						pi_purchaseType=:pi_purchaseType,
						aci_id=:aci_id,
						p_id=:p_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
		$this->purchaseType = htmlspecialchars(strip_tags($this->purchaseType));
		$this->availedCustomerId = htmlspecialchars(strip_tags($this->availedCustomerId));
		$this->productId = htmlspecialchars(strip_tags($this->productId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':pi_date', $this->dateCreated);
		$stmt->bindParam(':pi_purchaseType', $this->purchaseType);
		$stmt->bindParam(':aci_id', $this->availedCustomerId);
		$stmt->bindParam(':p_id', $this->productId);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	


	

}// end of the class