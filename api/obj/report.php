<?php


/**getTotalInquiries
 * 
 */
class Reports
{

	public $conn;

	public $payment, $penaltyAmount, $balance, $payment_status, $salt, $computed_hash;
	public $date_created, $date_updated, $ti_id, $penalty_payment_id, $penalty_balance_id, $penalty_transaction_id, $reference;


	function __construct($db)
	{
		$this->conn = $db;

	}// end of the constructor

	function getTotalPenalty(){

		$query = 'SELECT 
						SUM(penaltyAmount) as totalPenalty
					FROM 
						penalty_payment';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function getTotalPenaltyPayment(){

		$query = 'SELECT 
						SUM(payment) as totalPenaltyPayment
					FROM 
						penalty_payment';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function getTotalPurchasePayment(){

		$query = 'SELECT 
						SUM(ti_paidAmount) as totalpaidAmount
					FROM 
						transaction_information';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function getTotalCustomer(){

		$query = 'SELECT 
						count(aci_id) as totalCustomer
					FROM 
						availed_customer_information';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function getTotalInquiries(){

		$query = 'SELECT 
						count(ci_id) as totalInquiries
					FROM 
						CreatedInquiries';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function
	
	function getTotalAccounts(){

		$query = 'SELECT 
						count(ca_id) as totalAccounts
					FROM 
						customer_account';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function getTotalProduct(){

		$query = 'SELECT 
						count(cp_id) as totalProduct
					FROM 
						created_product
					WHERE 
						cp_status = "publish"';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function
	
	

}