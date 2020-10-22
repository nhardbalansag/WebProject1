<?php


/**createAvailedCustomerInformation
 * 
 */
class Transaction
{

	public $conn;

	public $p_id;

	public $pi_date, $pi_purchaseType, $cp_id, $salt, $computed_hash, $hash;

	public $aci_firstName, $aci_lastName, $aci_middleName, $aci_address, $aci_billingAddress, $aci_emailAddress, $ca_id;

	public $ti_date, $ti_dateUpdated, $ti_previousBalance, $ti_paidAmount, $ti_status, $ti_totalPaidAmount, $ti_currentBalance, $aci_id, $pi_id, $aci_dateCreated, $aci_dateModified, $reference;

	public $penalty_date, $penalty_status, $penalty_amount;

	public $ti_id;



	function __construct($db)
	{
		$this->conn = $db;

	}// end of the constructor

	function createAvailedCustomerInformation(){

		$query = 'INSERT INTO availed_customer_information
					SET 
						aci_dateCreated=:aci_dateCreated,
						aci_dateModified=:aci_dateModified,
						aci_firstName=:aci_firstName,
						aci_lastName=:aci_lastName,
						aci_middleName=:aci_middleName,
						aci_address=:aci_address,
						aci_billingAddress=:aci_billingAddress,
						aci_emailAddress=:aci_emailAddress,
						ca_id=:ca_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->aci_dateCreated = htmlspecialchars(strip_tags($this->aci_dateCreated));
		$this->aci_dateModified = htmlspecialchars(strip_tags($this->aci_dateModified));
		$this->aci_firstName = htmlspecialchars(strip_tags($this->aci_firstName));
		$this->aci_lastName = htmlspecialchars(strip_tags($this->aci_lastName));
		$this->aci_middleName = htmlspecialchars(strip_tags($this->aci_middleName));
		$this->aci_address = htmlspecialchars(strip_tags($this->aci_address));
		$this->aci_billingAddress = htmlspecialchars(strip_tags($this->aci_billingAddress));
		$this->aci_emailAddress = htmlspecialchars(strip_tags($this->aci_emailAddress));
		$this->ca_id = htmlspecialchars(strip_tags($this->ca_id));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':aci_dateCreated', $this->aci_dateCreated);
		$stmt->bindParam(':aci_dateModified', $this->aci_dateModified);
		$stmt->bindParam(':aci_firstName', $this->aci_firstName);
		$stmt->bindParam(':aci_lastName', $this->aci_lastName);
		$stmt->bindParam(':aci_middleName', $this->aci_middleName);
		$stmt->bindParam(':aci_address', $this->aci_address);
		$stmt->bindParam(':aci_billingAddress', $this->aci_billingAddress);
		$stmt->bindParam(':aci_emailAddress', $this->aci_emailAddress);
		$stmt->bindParam(':ca_id', $this->ca_id);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function 

	function readOneCreatedProduct(){

		$query = '	SELECT 
						created_product.cp_id as createdProductId

					FROM product, created_product
					WHERE 
						(product.p_id = created_product.p_id) 
							AND created_product.p_id = ?
					GROUP BY created_product.cp_id
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->p_id = htmlspecialchars(strip_tags($this->p_id));

		$stmt->bindParam(1, $this->p_id);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function


	function readOneAvailedCustomer(){

		$query = '	SELECT *
					FROM availed_customer_information
					WHERE 
						computed_hash = ?
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function readOnePurchase(){

		$query = '	SELECT *
					FROM purchase_information
					WHERE 
						computed_hash = ?
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

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
						cp_id=:cp_id,
						aci_id=:aci_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->pi_date = htmlspecialchars(strip_tags($this->pi_date));
		$this->pi_purchaseType = htmlspecialchars(strip_tags($this->pi_purchaseType));
		$this->cp_id = htmlspecialchars(strip_tags($this->cp_id));
		$this->aci_id = htmlspecialchars(strip_tags($this->aci_id));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':pi_date', $this->pi_date);
		$stmt->bindParam(':pi_purchaseType', $this->pi_purchaseType);
		$stmt->bindParam(':cp_id', $this->cp_id);
		$stmt->bindParam(':aci_id', $this->aci_id);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function createTransaction(){

		$query = 'INSERT INTO transaction_information
					SET 
						ti_date=:ti_date,
						ti_dateUpdated=:ti_dateUpdated,
						ti_previousBalance=:ti_previousBalance,
						ti_paidAmount=:ti_paidAmount,
						ti_status=:ti_status,
						ti_totalPaidAmount=:ti_totalPaidAmount,
						ti_currentBalance=:ti_currentBalance,
						aci_id=:aci_id,
						pi_id=:pi_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->ti_date = htmlspecialchars(strip_tags($this->ti_date));
		$this->ti_dateUpdated = htmlspecialchars(strip_tags($this->ti_dateUpdated));
		$this->ti_previousBalance = htmlspecialchars(strip_tags($this->ti_previousBalance));
		$this->ti_paidAmount = htmlspecialchars(strip_tags($this->ti_paidAmount));
		$this->ti_status = htmlspecialchars(strip_tags($this->ti_status));
		$this->ti_totalPaidAmount = htmlspecialchars(strip_tags($this->ti_totalPaidAmount));
		$this->ti_currentBalance = htmlspecialchars(strip_tags($this->ti_currentBalance));
		$this->aci_id = htmlspecialchars(strip_tags($this->aci_id));
		$this->pi_id = htmlspecialchars(strip_tags($this->pi_id));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':ti_date', $this->ti_date);
		$stmt->bindParam(':ti_dateUpdated', $this->ti_dateUpdated);
		$stmt->bindParam(':ti_previousBalance', $this->ti_previousBalance);
		$stmt->bindParam(':ti_paidAmount', $this->ti_paidAmount);
		$stmt->bindParam(':ti_status', $this->ti_status);
		$stmt->bindParam(':ti_totalPaidAmount', $this->ti_totalPaidAmount);
		$stmt->bindParam(':ti_currentBalance', $this->ti_currentBalance);
		$stmt->bindParam(':aci_id', $this->aci_id);
		$stmt->bindParam(':pi_id', $this->pi_id);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);



		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function readCustomerTransactionInformation(){

		$query = '	SELECT
						availed_customer_information.aci_id as customer_aci_id,
						availed_customer_information.aci_dateCreated as customer_aci_dateCreated,
						availed_customer_information.aci_dateModified as customer_aci_dateModified,
						availed_customer_information.aci_firstName as customer_aci_firstName,
						availed_customer_information.aci_lastName as customer_aci_lastName,
						availed_customer_information.aci_middleName as customer_aci_middleName,
						availed_customer_information.aci_address as customer_aci_address,
						availed_customer_information.aci_billingAddress as customer_aci_billingAddress,
						availed_customer_information.aci_emailAddress as customer_aci_emailAddress,
						availed_customer_information.ca_id as customer_ca_id,
						availed_customer_information.salt as customer_salt,
						availed_customer_information.computed_hash as customer_computed_hash,

						customer_account.ca_id as account_ca_id,
						customer_account.ca_date_created as account_ca_date_created,

						purchase_information.pi_id as purchase_pi_id,
						purchase_information.pi_date as purchase_pi_date,
						purchase_information.pi_purchaseType as purchase_pi_purchaseType,
						purchase_information.cp_id as purchase_cp_id,
						purchase_information.aci_id as purchase_aci_id,
						purchase_information.salt as purchase_salt,
						purchase_information.computed_hash as purchase_computed_hash,

						transaction_information.ti_currentBalance as transaction_ti_currentBalance,
						transaction_information.salt as transaction_salt,
						transaction_information.ti_id as transaction_ti_id


					FROM purchase_information, availed_customer_information, customer_account, transaction_information
					WHERE 
						(purchase_information.computed_hash = ?)
							AND (availed_customer_information.aci_id = purchase_information.aci_id)
								AND (availed_customer_information.ca_id = customer_account.ca_id)
								 	AND (transaction_information.aci_id = availed_customer_information.aci_id)
								 		AND (transaction_information.pi_id = purchase_information.pi_id)
					GROUP BY
						availed_customer_information.aci_id,
						availed_customer_information.aci_firstName,
						availed_customer_information.aci_lastName,
						availed_customer_information.aci_middleName,
						availed_customer_information.aci_address,
						availed_customer_information.aci_billingAddress,
						availed_customer_information.aci_emailAddress,
						availed_customer_information.ca_id,
						availed_customer_information.salt,
						availed_customer_information.computed_hash,

						purchase_information.pi_id,
						purchase_information.pi_date,
						purchase_information.pi_purchaseType,
						purchase_information.cp_id,
						purchase_information.aci_id,
						purchase_information.salt,
						purchase_information.computed_hash,
						transaction_information.ti_currentBalance,
						transaction_information.salt
					ORDER BY 
						transaction_information.ti_date DESC
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function updateCustomerInformation(){

		$query = ' UPDATE availed_customer_information
            		SET
						aci_dateModified=:aci_dateModified,
						aci_firstName=:aci_firstName,
						aci_lastName=:aci_lastName,
						aci_middleName=:aci_middleName,
						aci_address=:aci_address,
						aci_billingAddress=:aci_billingAddress,
						aci_emailAddress=:aci_emailAddress,
						ca_id=:ca_id,
						salt=:salt,
						computed_hash=:computed_hash
            		WHERE
               	 		computed_hash=:reference';

		$stmt = $this->conn->prepare($query);

		$this->aci_dateModified = htmlspecialchars(strip_tags($this->aci_dateModified));
		$this->aci_firstName = htmlspecialchars(strip_tags($this->aci_firstName));
		$this->aci_lastName = htmlspecialchars(strip_tags($this->aci_lastName));
		$this->aci_middleName = htmlspecialchars(strip_tags($this->aci_middleName));
		$this->aci_address = htmlspecialchars(strip_tags($this->aci_address));
		$this->aci_billingAddress = htmlspecialchars(strip_tags($this->aci_billingAddress));
		$this->aci_emailAddress = htmlspecialchars(strip_tags($this->aci_emailAddress));
		$this->ca_id = htmlspecialchars(strip_tags($this->ca_id));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(':aci_dateModified', $this->aci_dateModified);
		$stmt->bindParam(':aci_firstName', $this->aci_firstName);
		$stmt->bindParam(':aci_lastName', $this->aci_lastName);
		$stmt->bindParam(':aci_middleName', $this->aci_middleName);
		$stmt->bindParam(':aci_address', $this->aci_address);
		$stmt->bindParam(':aci_billingAddress', $this->aci_billingAddress);
		$stmt->bindParam(':aci_emailAddress', $this->aci_emailAddress);
		$stmt->bindParam(':ca_id', $this->ca_id);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);
		$stmt->bindParam(':reference', $this->reference);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function

	function readAllCustomer(){

		$query = '	SELECT
						availed_customer_information.aci_id as customer_aci_id,
						availed_customer_information.aci_dateCreated as customer_aci_dateCreated,
						availed_customer_information.aci_dateModified as customer_aci_dateModified,
						availed_customer_information.aci_firstName as customer_aci_firstName,
						availed_customer_information.aci_lastName as customer_aci_lastName,
						availed_customer_information.aci_middleName as customer_aci_middleName,
						availed_customer_information.aci_address as customer_aci_address,
						availed_customer_information.aci_billingAddress as customer_aci_billingAddress,
						availed_customer_information.aci_emailAddress as customer_aci_emailAddress,
						availed_customer_information.ca_id as customer_ca_id,
						availed_customer_information.salt as customer_salt,
						availed_customer_information.computed_hash as customer_computed_hash,

						customer_account.ca_id as account_ca_id,
						customer_account.ca_date_created as account_ca_date_created,

						purchase_information.pi_id as purchase_pi_id,
						purchase_information.pi_date as purchase_pi_date,
						purchase_information.pi_purchaseType as purchase_pi_purchaseType,
						purchase_information.cp_id as purchase_cp_id,
						purchase_information.aci_id as purchase_aci_id,
						purchase_information.salt as purchase_salt,
						purchase_information.computed_hash as purchase_computed_hash

					FROM purchase_information, availed_customer_information, customer_account
					WHERE 
						(availed_customer_information.aci_id = purchase_information.aci_id)
							AND (availed_customer_information.ca_id = customer_account.ca_id)
					GROUP BY
						availed_customer_information.aci_id,
						availed_customer_information.aci_dateCreated,
						availed_customer_information.aci_dateModified,
						availed_customer_information.aci_firstName,
						availed_customer_information.aci_lastName,
						availed_customer_information.aci_middleName,
						availed_customer_information.aci_address,
						availed_customer_information.aci_billingAddress,
						availed_customer_information.aci_emailAddress,
						availed_customer_information.ca_id,
						availed_customer_information.salt,
						availed_customer_information.computed_hash,

						customer_account.ca_id,
						customer_account.ca_date_created,

						purchase_information.pi_id,
						purchase_information.pi_date,
						purchase_information.pi_purchaseType,
						purchase_information.cp_id,
						purchase_information.aci_id,
						purchase_information.salt,
						purchase_information.computed_hash';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function createPenalty(){

		$query = 'INSERT INTO penalty
					SET 
						penalty_date=:penalty_date,
						penalty_status=:penalty_status,
						penalty_amount=:penalty_amount,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->penalty_date = htmlspecialchars(strip_tags($this->penalty_date));
		$this->penalty_status = htmlspecialchars(strip_tags($this->penalty_status));
		$this->penalty_amount = htmlspecialchars(strip_tags($this->penalty_amount));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':penalty_date', $this->penalty_date);
		$stmt->bindParam(':penalty_status', $this->penalty_status);
		$stmt->bindParam(':penalty_amount', $this->penalty_amount);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function readAllPenaltyAmount(){

		$query = '	SELECT *
					FROM penalty
					ORDER BY
						penalty_date,
						penalty_id 
					DESC';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function readOnePenaltyAmount(){

		$query = '	SELECT *
					FROM penalty
					WHERE 
						computed_hash = ?';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function readSetPenalty(){

		$query = '	SELECT *
					FROM penalty
					WHERE 
						penalty_status = "set"';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function updatePenaltyAmount(){

		$query = ' UPDATE penalty
            		SET
						penalty_status=:penalty_status,
						penalty_amount=:penalty_amount,
						salt=:salt,
						computed_hash=:computed_hash
            		WHERE
               	 		computed_hash =:reference';

		$stmt = $this->conn->prepare($query);
		
		$this->penalty_status = htmlspecialchars(strip_tags($this->penalty_status));
		$this->penalty_amount = htmlspecialchars(strip_tags($this->penalty_amount));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(':penalty_status', $this->penalty_status);
		$stmt->bindParam(':penalty_amount', $this->penalty_amount);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);
		$stmt->bindParam(':reference', $this->reference);
		
		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function

	function readOneTranscsaction(){

		$query = '	SELECT *
					FROM transaction_information
					WHERE 
						computed_hash = ?
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function readAllOneCustomerTransaction(){

		$query = '	SELECT 
					    transaction_information.ti_previousBalance AS previousBalance,
					    transaction_information.ti_paidAmount AS paidedAmount,
					    transaction_information.ti_status AS status,
					    transaction_information.ti_date AS datePaided,
					    transaction_information.ti_currentBalance AS currentBalance,
					    transaction_information.salt AS transactionIv
					FROM
					    transaction_information,
					    purchase_information
					WHERE
					    purchase_information.computed_hash = ?
					        AND (purchase_information.pi_id = transaction_information.pi_id)
					ORDER BY 
						transaction_information.ti_date
					desc';
						

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function
	
	function readAllOneCustomerPenalty(){

		$query = '	SELECT 
					    penalty_transaction.date_created AS datecreated,
					    penalty_balance.balance AS balance
					FROM
					    penalty_transaction,
					    penalty_balance,
					    transaction_information,
					    purchase_information
					WHERE
					    purchase_information.computed_hash = ?
				        AND (transaction_information.pi_id = purchase_information.pi_id)
				        AND (transaction_information.ti_id = penalty_transaction.ti_id)
				        AND (penalty_transaction.penalty_balance_id = penalty_balance.penalty_balance_id)
					ORDER BY 
						transaction_information.ti_date 
					DESC';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function
	


	
	

}