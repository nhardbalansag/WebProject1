<?php


/**
 * 
 */
class Penalty
{

	public $conn;

	public $payment, $penaltyAmount, $balance, $payment_status, $salt, $computed_hash;
	public $date_created, $date_updated, $ti_id, $penalty_payment_id, $penalty_balance_id, $penalty_transaction_id, $reference;


	function __construct($db)
	{
		$this->conn = $db;

	}// end of the constructor

	function createPenaltyPayment(){

		$query = 'INSERT INTO penalty_payment
					SET 
						payment=:payment,
						penaltyAmount=:penaltyAmount,
						balance=:balance,
						payment_status=:payment_status,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->payment = htmlspecialchars(strip_tags($this->payment));
		$this->penaltyAmount = htmlspecialchars(strip_tags($this->penaltyAmount));
		$this->balance = htmlspecialchars(strip_tags($this->balance));
		$this->payment_status = htmlspecialchars(strip_tags($this->payment_status));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':payment', $this->payment);
		$stmt->bindParam(':penaltyAmount', $this->penaltyAmount);
		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':payment_status', $this->payment_status);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function getTotalPenaltyBalance(){

		$query = 'SELECT 
						SUM(balance) as totalBalance
					FROM 
						penalty_payment';

		$stmt = $this->conn->prepare($query);
		
		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function createPenaltyTotalBalance(){

		$query = 'INSERT INTO penalty_balance
					SET 
						balance=:balance,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->balance = htmlspecialchars(strip_tags($this->balance));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function getPrincipalpaymentInfo(){

		$query = 'SELECT 
						*
					FROM 
						penalty_payment
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

	function getBalanceInfo(){

		$query = 'SELECT 
						*
					FROM 
						penalty_balance
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

	function createPenaltyTransaction(){

		$query = 'INSERT INTO penalty_transaction
					SET 
						date_created=:date_created,
						date_updated=:date_updated,
						ti_id=:ti_id,
						penalty_payment_id=:penalty_payment_id,
						penalty_balance_id=:penalty_balance_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->date_created = htmlspecialchars(strip_tags($this->date_created));
		$this->date_updated = htmlspecialchars(strip_tags($this->date_updated));
		$this->ti_id = htmlspecialchars(strip_tags($this->ti_id));
		$this->penalty_payment_id = htmlspecialchars(strip_tags($this->penalty_payment_id));
		$this->penalty_balance_id = htmlspecialchars(strip_tags($this->penalty_balance_id));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':date_created', $this->date_created);
		$stmt->bindParam(':date_updated', $this->date_updated);
		$stmt->bindParam(':ti_id', $this->ti_id);
		$stmt->bindParam(':penalty_payment_id', $this->penalty_payment_id);
		$stmt->bindParam(':penalty_balance_id', $this->penalty_balance_id);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function createPaymentToBalance(){

		$query = 'INSERT INTO penalty_balance_payment
					SET 
						date_created=:date_created,
						payment=:payment,
						payment_status=:payment_status,
						penalty_transaction_id=:penalty_transaction_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->date_created = htmlspecialchars(strip_tags($this->date_created));
		$this->payment = htmlspecialchars(strip_tags($this->payment));
		$this->payment_status = htmlspecialchars(strip_tags($this->payment_status));
		$this->penalty_transaction_id = htmlspecialchars(strip_tags($this->penalty_transaction_id));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(':date_created', $this->date_created);
		$stmt->bindParam(':payment', $this->payment);
		$stmt->bindParam(':payment_status', $this->payment_status);
		$stmt->bindParam(':penalty_transaction_id', $this->penalty_transaction_id);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->computed_hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function editCurrentBalance(){

		$query = 'UPDATE penalty_balance
            		SET
	                	balance=:balance,
						salt=:salt,
						computed_hash=:computed_hash

					WHERE computed_hash =:reference';

		$stmt = $this->conn->prepare($query);

		$this->balance = htmlspecialchars(strip_tags($this->balance));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam('balance', $this->balance);
		$stmt->bindParam('salt', $this->salt);
		$stmt->bindParam('computed_hash', $this->computed_hash);
		$stmt->bindParam('reference', $this->reference);
		
		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function getOnePenaltyTransactionInfo(){

		$query = 'SELECT 
						*
					FROM 
						penalty_transaction
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

	function penaltyBalanceTotalPayment(){

		$query = 'SELECT 
						SUM(payment) as totalPaymentBalance
					FROM 
						penalty_balance_payment';

		$stmt = $this->conn->prepare($query);
		
		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function totalPrincipal(){

		$query = 'SELECT 
						SUM(penalty_payment.balance) as totalPenaltyPrincipal
					FROM 
						purchase_information,
						transaction_information,
						penalty_transaction,
						penalty_payment

					WHERE
						purchase_information.computed_hash = ?
						AND (purchase_information.pi_id = transaction_information.pi_id)
						AND (transaction_information.ti_id = penalty_transaction.ti_id)
						AND (penalty_transaction.penalty_payment_id = penalty_payment.penalty_payment_id)';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);
		
		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function getTotalPenaltyPayment(){

		$query = 'SELECT 
						SUM(penalty_balance_payment.payment) as totalPayment
					FROM 
						purchase_information,
						transaction_information,
						penalty_transaction,
						penalty_balance_payment

					WHERE
						purchase_information.computed_hash = ?
						AND (purchase_information.pi_id = transaction_information.pi_id)
						AND (transaction_information.ti_id = penalty_transaction.ti_id)
						AND (penalty_transaction.penalty_transaction_id = penalty_balance_payment.penalty_transaction_id)';

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