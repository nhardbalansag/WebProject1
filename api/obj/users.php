<?php
/**

getAdminReplies accessEmailedcustomerHash
 */
class User{

	public $conn;

	public $email, $firstname, $lastname, $middlename, $street, $city, $province, $zipcode, $phonenumber, $telephone, $categorytype, $inquirymessage, $bday;

	public $date, $status, $password, $confirmpass, $customerInfoId;

	public $return_json_data;

	public $salt, $hash;

	public $inquiryMessage, $messageID;

	public $messageType;

	public $customerAccountId, $accountId, $customerCreatedMessageId;

	public $dateUpdated, $currentPassword, $PrevPassword, $userRole, $adminInformationId;

	public $createdDate, $timeCreated, $inquiryId, $adminId, $adminCreatedMessage, $computed_hash;


	function __construct($db)
	{

		$this->conn = $db;

		return $this->conn;

	}// constructors


	function create_userInformation(){

		$query = 'INSERT INTO customer_information
					SET 
					ci_email=:ci_email, 
					ci_firstname=:ci_firstname,
					ci_lastname=:ci_lastname, 
					ci_middlename=:ci_middlename, 
					ci_street=:ci_street, 
					ci_city_municipality=:ci_city_municipality, 
					ci_province=:ci_province, 
					ci_zipcode=:ci_zipcode, 
					ci_phonenumber=:ci_phonenumber, 
					ci_telephonenumber=:ci_telephonenumber, 
					ci_dateCreated=:ci_dateCreated, 
					ci_bday=:ci_bday,
					salt=:salt, 
					computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->firstname = htmlspecialchars(strip_tags($this->firstname));
		$this->lastname = htmlspecialchars(strip_tags($this->lastname));
		$this->middlename = htmlspecialchars(strip_tags($this->middlename));
		$this->street = htmlspecialchars(strip_tags($this->street));
		$this->city = htmlspecialchars(strip_tags($this->city));
		$this->province = htmlspecialchars(strip_tags($this->province));
		$this->zipcode = htmlspecialchars(strip_tags($this->zipcode));
		$this->phonenumber = htmlspecialchars(strip_tags($this->phonenumber));
		$this->telephone = htmlspecialchars(strip_tags($this->telephone));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->bday = htmlspecialchars(strip_tags($this->bday));
		$this->hash = htmlspecialchars(strip_tags($this->hash));


		$stmt->bindParam(':ci_email', $this->email);
		$stmt->bindParam(':ci_firstname', $this->firstname);
		$stmt->bindParam(':ci_lastname', $this->lastname);
		$stmt->bindParam(':ci_middlename', $this->middlename);
		$stmt->bindParam(':ci_street', $this->street);
		$stmt->bindParam(':ci_city_municipality', $this->city);
		$stmt->bindParam(':ci_province', $this->province);
		$stmt->bindParam(':ci_zipcode', $this->zipcode);
		$stmt->bindParam(':ci_phonenumber', $this->phonenumber);
		$stmt->bindParam(':ci_telephonenumber', $this->telephone);
		$stmt->bindParam(':ci_dateCreated', $this->date);
		$stmt->bindParam(':ci_bday', $this->bday);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function


	function createCustomerAccount(){

		$query = 'INSERT INTO customer_account 
					SET  
					ca_date_created=:ca_date_created,
					ca_email=:ca_email,
					cal_password=:cal_password,
					ci_id=:ci_id,
					salt=:salt,
					computed_hash=:computed_hash';


		$stmt = $this->conn->prepare($query);

		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->customerInfoId = htmlspecialchars(strip_tags($this->customerInfoId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':ca_date_created', $this->date);
		$stmt->bindParam(':ca_email', $this->email);
		$stmt->bindParam(':cal_password', $this->password);
		$stmt->bindParam(':ci_id', $this->customerInfoId);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}//end of the function



	function accessEmailedcustomerHash(){   

		$query = '	SELECT *
					FROM customer_information
					WHERE computed_hash = ?
                    LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(1, $this->hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}
	
	}// end of the function

	function accessEmailedAdminHash(){

		$query = '	SELECT *
					FROM admin_information
					WHERE admin_computed_hash = ?';

		$stmt = $this->conn->prepare($query);

		$hash_data = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(1, $hash_data);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}
	
	}// end of the function




	function createdInquiries(){

		$query = 'INSERT INTO CreatedInquiries 
					SET  
					createdInquiresDate=:createdInquiresDate,
					createdInquirestime=:createdInquirestime,
					m_id=:m_id,
					cinfo_id=:cinfo_id';


		$stmt = $this->conn->prepare($query);

		$this->messageID = htmlspecialchars(strip_tags($this->messageID));
		$this->customerInfoId = htmlspecialchars(strip_tags($this->customerInfoId));
		$this->createdDate = htmlspecialchars(strip_tags($this->createdDate));
		$this->timeCreated = htmlspecialchars(strip_tags($this->timeCreated));

		$stmt->bindParam(':m_id', $this->messageID);
		$stmt->bindParam(':cinfo_id', $this->customerInfoId);
		$stmt->bindParam(':createdInquiresDate', $this->createdDate);
		$stmt->bindParam(':createdInquirestime', $this->timeCreated);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}


	}// end of the function

	function createdCustomerMessage(){

		$query = 'INSERT INTO createdCustomerMessage 
					SET  
					m_id=:m_id,
					ca_id=:ca_id,
					dateCreated=:dateCreated,
					messageStatus=:messageStatus';

		$stmt = $this->conn->prepare($query);

		$this->messageID = htmlspecialchars(strip_tags($this->messageID));
		$this->customerAccountId = htmlspecialchars(strip_tags($this->customerAccountId));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->status = htmlspecialchars(strip_tags($this->status));

		$stmt->bindParam(':m_id', $this->messageID);
		$stmt->bindParam(':ca_id', $this->customerAccountId);
		$stmt->bindParam(':dateCreated', $this->date);
		$stmt->bindParam(':messageStatus', $this->status);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function



	function createdMessage(){

		$query = 'INSERT INTO Message 
					SET  
					m_message=:m_message,
					m_type=:m_type,
					m_salt=:salt,
					computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->inquiryMessage = htmlspecialchars(strip_tags($this->inquiryMessage));
		$this->messageType = htmlspecialchars(strip_tags($this->messageType));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':m_message', $this->inquiryMessage);
		$stmt->bindParam(':m_type', $this->messageType);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function getMessageInformationId(){

		$query = '	SELECT m_id
					FROM Message
					WHERE computed_hash = ?';

		$stmt = $this->conn->prepare($query);

		$hash_data = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(1, $hash_data);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}// end of the function

	function getCustomerAccountInfo(){

		$query = '	SELECT *
					FROM customer_account
					WHERE ca_id = ?
					LIMIT
					0,1';

		$stmt = $this->conn->prepare($query);

		$this->customerAccountId = htmlspecialchars(strip_tags($this->customerAccountId));

		$stmt->bindParam(1, $this->customerAccountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}
	
	}// end of the function


	function verifyAccountExistence(){

		$query = '	SELECT *
					FROM customer_account
					WHERE ci_id = ?
					LIMIT
					0,1';

		$stmt = $this->conn->prepare($query);

		$this->customerAccountId = htmlspecialchars(strip_tags($this->customerAccountId));

		$stmt->bindParam(1, $this->customerAccountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}
	
	}// end of the function


	function verifyAdminAccountExistence(){

		$query = '	SELECT *
					FROM admin_account
					WHERE admin_id = ?
					LIMIT
					0,1';

		$stmt = $this->conn->prepare($query);

		$this->adminInformationId = htmlspecialchars(strip_tags($this->adminInformationId));

		$stmt->bindParam(1, $this->adminInformationId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}
	
	}// end of the function 

	function createCustomerSupportMessage(){

		$query = 'INSERT INTO createdcustomersupportmessage 
					SET  
					dateCreated=:dateCreated,
					messageStatus=:messageStatus,
					m_id=:m_id,
					a_id=:a_id,
					ccm_id=:ccm_id,
					ca_id=:ca_id';

		$stmt = $this->conn->prepare($query);

		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->status = htmlspecialchars(strip_tags($this->status));
		$this->messageID = htmlspecialchars(strip_tags($this->messageID));
		$this->accountId = htmlspecialchars(strip_tags($this->accountId));
		$this->customerCreatedMessageId = htmlspecialchars(strip_tags($this->customerCreatedMessageId));
		$this->customerAccountId = htmlspecialchars(strip_tags($this->customerAccountId));

		$stmt->bindParam(':dateCreated', $this->date);
		$stmt->bindParam(':messageStatus', $this->status);
		$stmt->bindParam(':m_id', $this->messageID);
		$stmt->bindParam(':a_id', $this->accountId);
		$stmt->bindParam(':ccm_id', $this->customerCreatedMessageId);
		$stmt->bindParam(':ca_id', $this->customerAccountId);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function verifyAdmin(){

		$query = '	SELECT a_id
					FROM admin_account
					WHERE a_id = ?
					LIMIT
					0,1';

		$stmt = $this->conn->prepare($query);

		$this->accountId = htmlspecialchars(strip_tags($this->accountId));

		$stmt->bindParam(1, $this->accountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}
	
	}// end of the function

	function verifyCustomerAccount(){

		$query = '	SELECT ca_id
					FROM customer_account
					WHERE ca_id = ?
					LIMIT
					0,1';

		$stmt = $this->conn->prepare($query);

		$this->accountId = htmlspecialchars(strip_tags($this->accountId));

		$stmt->bindParam(1, $this->accountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}
	
	}// end of the function

	function createUserRole(){

		$query = 'INSERT INTO user_role 
					SET  
					ur_tittle=:ur_tittle,
					salt=:salt,
					computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->userRole = htmlspecialchars(strip_tags($this->userRole));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->userRole));
		
		$stmt->bindParam(':ur_tittle', $this->userRole);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);
	
		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function searchCustomerAccount(){

		$query = 'SELECT *
					FROM customer_account 
					WHERE ca_email = ?
					LIMIT
					0,1';

		$stmt = $this->conn->prepare($query);

		$this->email = htmlspecialchars(strip_tags($this->email));

		$stmt->bindParam(1, $this->email);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	function searchCustomerInformation(){

		$query = 'SELECT 
						(customer_information.salt) as customer_IformationIv,
						(customer_information.ci_id) as customer_ci_id,
						(customer_information.ci_email) as customer_ci_email,
						(customer_information.ci_firstname) as customer_ci_firstname,
						(customer_information.ci_lastname) as customer_ci_lastname,
						(customer_information.ci_middlename) as customer_ci_middlename,
						(customer_information.ci_street) as customer_ci_street,
						(customer_information.ci_city_municipality) as customer_ci_city_municipality,
						(customer_information.ci_province) as customer_ci_province,
						(customer_information.ci_zipcode) as customer_ci_zipcode,
						(customer_information.ci_phonenumber) as customer_ci_phonenumber,
						(customer_information.ci_telephonenumber) as customer_ci_telephonenumber,
						(customer_information.ci_bday) as customer_ci_bday,
						(customer_information.computed_hash) as customer_computed_hash,

						customer_account.ca_id as customer_account_ca_id,
						customer_account.ca_date_created as customer_account_ca_date_created,
						customer_account.ca_email as customer_account_ca_email,
						customer_account.cal_password as customer_account_cal_password,
						customer_account.ci_id as customer_account_ci_id,
						customer_account.salt as customer_account_salt,
						customer_account.computed_hash as customer_account_computed_hash

					FROM customer_account, customer_information
					WHERE ((customer_account.ci_id = customer_information.ci_id) and customer_account.ca_id = ?)
					GROUP BY
						customer_information.salt,
						customer_information.ci_id,
						customer_information.ci_email,
						customer_information.ci_firstname,
						customer_information.ci_lastname,
						customer_information.ci_middlename,
						customer_information.ci_street ,
						customer_information.ci_city_municipality,
						customer_information.ci_province,
						customer_information.ci_zipcode,
						customer_information.ci_phonenumber,
						customer_information.ci_telephonenumber,
						customer_information.ci_bday,
						customer_information.computed_hash,

						customer_account.ca_id ,
						customer_account.ca_date_created,
						customer_account.ca_email,
						customer_account.cal_password,
						customer_account.ci_id,
						customer_account.salt,
						customer_account.computed_hash
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->accountId = htmlspecialchars(strip_tags($this->accountId));

		$stmt->bindParam(1, $this->accountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	function searchCustomerInformationSpecific(){

		$query = 'SELECT 
					(customer_information.salt) as customer_IformationIv,
					(customer_information.ci_id) as customer_ci_id,
					(customer_information.ci_email) as customer_ci_email,
					(customer_information.ci_firstname) as customer_ci_firstname,
					(customer_information.ci_lastname) as customer_ci_lastname,
					(customer_information.ci_middlename) as customer_ci_middlename,
					(customer_information.ci_street) as customer_ci_street,
					(customer_information.ci_city_municipality) as customer_ci_city_municipality,
					(customer_information.ci_province) as customer_ci_province,
					(customer_information.ci_zipcode) as customer_ci_zipcode,
					(customer_information.ci_phonenumber) as customer_ci_phonenumber,
					(customer_information.ci_telephonenumber) as customer_ci_telephonenumber,
					(customer_information.ci_bday) as customer_ci_bday,
					(customer_information.computed_hash) as customer_computed_hash

					FROM customer_account, customer_information
					WHERE ((customer_account.ci_id = customer_information.ci_id) and customer_account.computed_hash = ?)
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function


	function edit_userInformation(){

		$query = ' UPDATE customer_information, customer_account
            		SET
	                	customer_information.ci_email=:ci_email, 
						customer_information.ci_firstname=:ci_firstname,
						customer_information.ci_lastname=:ci_lastname, 
						customer_information.ci_middlename=:ci_middlename, 
						customer_information.ci_street=:ci_street, 
						customer_information.ci_city_municipality=:ci_city_municipality, 
						customer_information.ci_province=:ci_province, 
						customer_information.ci_zipcode=:ci_zipcode, 
						customer_information.ci_phonenumber=:ci_phonenumber, 
						customer_information.ci_telephonenumber=:ci_telephonenumber, 
						customer_information.ci_dateCreated=:ci_dateCreated, 
						customer_information.ci_bday=:ci_bday,
						customer_information.salt=:salt, 
						customer_information.computed_hash=:computed_hash
            		WHERE
               	 		((customer_information.ci_id = customer_account.ci_id) AND customer_account.ca_id=:ca_id)';

		$stmt = $this->conn->prepare($query);

		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->firstname = htmlspecialchars(strip_tags($this->firstname));
		$this->lastname = htmlspecialchars(strip_tags($this->lastname));
		$this->middlename = htmlspecialchars(strip_tags($this->middlename));
		$this->street = htmlspecialchars(strip_tags($this->street));
		$this->city = htmlspecialchars(strip_tags($this->city));
		$this->province = htmlspecialchars(strip_tags($this->province));
		$this->zipcode = htmlspecialchars(strip_tags($this->zipcode));
		$this->phonenumber = htmlspecialchars(strip_tags($this->phonenumber));
		$this->telephone = htmlspecialchars(strip_tags($this->telephone));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->bday = htmlspecialchars(strip_tags($this->bday));
		$this->hash = htmlspecialchars(strip_tags($this->hash));
		$this->accountId = htmlspecialchars(strip_tags($this->accountId));


		$stmt->bindParam(':ci_email', $this->email);
		$stmt->bindParam(':ci_firstname', $this->firstname);
		$stmt->bindParam(':ci_lastname', $this->lastname);
		$stmt->bindParam(':ci_middlename', $this->middlename);
		$stmt->bindParam(':ci_street', $this->street);
		$stmt->bindParam(':ci_city_municipality', $this->city);
		$stmt->bindParam(':ci_province', $this->province);
		$stmt->bindParam(':ci_zipcode', $this->zipcode);
		$stmt->bindParam(':ci_phonenumber', $this->phonenumber);
		$stmt->bindParam(':ci_telephonenumber', $this->telephone);
		$stmt->bindParam(':ci_dateCreated', $this->date);
		$stmt->bindParam(':ci_bday', $this->bday);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);
		$stmt->bindParam(':ca_id', $this->accountId);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function


	function searchAdminAccount(){

		$query = 'SELECT
						admin_account.a_id as account_id,
						admin_account.a_email as account_email,
						admin_account.a_currentpassword as account_currentpassword,
						admin_account.a_prevpassword as account_prevpassword,
						admin_account.a_datecreated as account_datecreated,
						admin_account.a_dateupdated as account_dateupdated,
						admin_account.ur as account_role,
						admin_account.salt as account_key,
						admin_account.computed_hash as account_hash,
						admin_account.admin_id as account_linked_adminInfo,

						admin_information.admin_id as adminInfo_admin_id,
						admin_information.admin_firstname as adminInfo_firstname,
						admin_information.admin_lastname as adminInfo_lastname,
						admin_information.admin_middlename as adminInfo_middlename,
						admin_information.admin_salt as adminInfo_key
						

					FROM admin_account, admin_information
					WHERE 
					((admin_account.a_email = admin_information.admin_email)
						AND admin_account.a_email = ?)
						GROUP BY
							admin_account.a_id,
							admin_account.a_email,
							admin_account.a_currentpassword,
							admin_account.a_prevpassword,
							admin_account.a_datecreated,
							admin_account.a_dateupdated,
							admin_account.ur,
							admin_account.salt,
							admin_account.computed_hash,
							admin_account.admin_id,
							admin_information.admin_id,
							admin_information.admin_firstname,
							admin_information.admin_lastname,
							admin_information.admin_middlename,
							admin_information.admin_salt
					LIMIT
					0,1';

		$stmt = $this->conn->prepare($query);

		$this->email = htmlspecialchars(strip_tags($this->email));

		$stmt->bindParam(1, $this->email);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	function searchAdminInformation(){

		$query = 'SELECT 
					(admin_information.admin_id) as adminPersonalInformationId,
					(admin_information.admin_firstname) as adminfirstname,
					(admin_information.admin_lastname) as adminlastname,
					(admin_information.admin_middlename) as adminmiddlename,
					(admin_information.admin_salt) as adminPersonalInformationkeyIV,
					(admin_account.a_id) as adminAccountId,
					(admin_account.ur) as adminRole

					FROM admin_account, admin_information
					WHERE ((admin_account.admin_id = admin_information.admin_id) and admin_account.admin_id = ?)
					GROUP BY 
						admin_information.admin_id,
						admin_information.admin_firstname,
						admin_information.admin_lastname,
						admin_information.admin_middlename,
						admin_information.admin_salt,
						admin_account.a_id,
						admin_account.ur';

		$stmt = $this->conn->prepare($query);

		$this->adminInformationId = htmlspecialchars(strip_tags($this->adminInformationId));

		$stmt->bindParam(1, $this->adminInformationId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	function createAdminAccount(){

		$query = 'INSERT INTO admin_account  
					SET      
					a_email=:a_email, 
					a_currentpassword=:a_currentpassword, 
					a_prevpassword=:a_prevpassword, 
					a_datecreated=:a_datecreated, 
					a_dateupdated=:a_dateupdated, 
					ur=:ur, 
					admin_id=:ci_id, 
					salt=:salt, 
					computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->currentPassword = htmlspecialchars(strip_tags($this->currentPassword));
		$this->PrevPassword = htmlspecialchars(strip_tags($this->PrevPassword));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->dateUpdated = htmlspecialchars(strip_tags($this->dateUpdated));
		$this->userRole = htmlspecialchars(strip_tags($this->userRole));
		$this->customerInfoId = htmlspecialchars(strip_tags($this->customerInfoId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':a_email', $this->email);
		$stmt->bindParam(':a_currentpassword', $this->currentPassword);
		$stmt->bindParam(':a_prevpassword', $this->PrevPassword);
		$stmt->bindParam(':a_datecreated', $this->date);
		$stmt->bindParam(':a_dateupdated', $this->dateUpdated);
		$stmt->bindParam(':ur', $this->userRole);
		$stmt->bindParam(':ci_id', $this->customerInfoId);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}//end of the function

	function readAllCustomerMessage(){

		$query = 'SELECT 
						*
					FROM 
                        Message, 
                        CreatedInquiries
					WHERE 
                    ((Message.m_id = CreatedInquiries.m_id) 
                        AND  Message.m_type = ?)';

		$stmt = $this->conn->prepare($query);

		$this->messageType = htmlspecialchars(strip_tags($this->messageType));

		$stmt->bindParam(1, $this->messageType);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function


	function getInquiryPersonalInformation(){

		$query = 'SELECT *
					FROM CreatedInquiries, customer_information, Message
					WHERE 
					(((CreatedInquiries.cinfo_id = customer_information.ci_id) and (Message.m_id = CreatedInquiries.m_id)) 
							and CreatedInquiries.cinfo_id = ?)';

		$stmt = $this->conn->prepare($query);

		$this->customerInfoId = htmlspecialchars(strip_tags($this->customerInfoId));

		$stmt->bindParam(1, $this->customerInfoId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	
	function readAllCustomerAccounts(){

		$query = 'SELECT 
						customer_account.ca_id as accountId,
						customer_account.ca_date_created as accountdateCreated,
						customer_account.ca_email as accountEmail,
						customer_account.ci_id as accountCustomerInformationId,
						customer_information.ci_id as info_id,
						customer_information.ci_email as info_email,
						customer_information.ci_firstname as info_firstname,
						customer_information.ci_lastname as info_lastname,
						customer_information.ci_middlename as info_middlename,
						customer_information.ci_street as info_street,
						customer_information.ci_city_municipality as info_city,
						customer_information.ci_province as info_provice,
						customer_information.ci_zipcode as info_zipcode,
						customer_information.ci_phonenumber as info_phonenumber,
						customer_information.ci_telephonenumber as info_telnumber,
						customer_information.ci_bday as info_bday,
						customer_information.ci_dateCreated as info_datecreated,
						customer_information.salt as info_salt,
						customer_account.computed_hash as account_computed_hash
						
					FROM customer_account, customer_information
					WHERE (customer_account.ci_id = customer_information.ci_id)';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

		function readOneCustomerAccountsPersonalInformation(){

		$query = 'SELECT *
					FROM customer_account, customer_information
					WHERE (customer_information.ci_id = ?)';

		$stmt = $this->conn->prepare($query);

		$this->customerInfoId = htmlspecialchars(strip_tags($this->customerInfoId));

		$stmt->bindParam(1, $this->customerInfoId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	function getAllAccountMessage(){

				$query = 'SELECT 	
					customer_information.ci_id as info_ID,
					customer_information.ci_email as info_email,
					customer_information.ci_firstname as info_firstname,
					customer_information.ci_lastname as info_lastname,
					customer_information.ci_middlename as info_middlename,
					customer_information.ci_street as info_street,
					customer_information.ci_city_municipality as info_city,
					customer_information.ci_province as info_provice,
					customer_information.ci_zipcode as info_zipcode,
					customer_information.ci_phonenumber as info_phonenumber,
					customer_information.ci_telephonenumber as info_telnumber,
					customer_information.ci_bday as info_bday,
					customer_information.ci_dateCreated as info_datecreated,
					customer_information.salt as info_key,

					Message.m_id as messageID,
					Message.m_message as message,
					Message.m_type as messageType,
					Message.m_salt as message_key,
					Message.computed_hash as message_computed_hash,

					createdCustomerMessage.dateCreated as createdCustomerMessageDate,
					createdCustomerMessage.messageStatus as createdCustomerMessageStatus,
					createdCustomerMessage.m_id as createdCustomerMessageId


					FROM customer_account, customer_information, Message, createdCustomerMessage
					WHERE 
					((
						(customer_account.ci_id = customer_information.ci_id) and 
						(customer_account.ca_id = createdCustomerMessage.ca_id) and
						(createdCustomerMessage.m_id = Message.m_id)) 
						and customer_account.computed_hash = ?) 
                        group 
                        by customer_information.ci_id,
                        customer_information.ci_email,
                        customer_information.ci_firstname,
                        customer_information.ci_lastname,
                        customer_information.ci_middlename,
                        customer_information.ci_street,
                        customer_information.ci_city_municipality,
                        customer_information.ci_province,
                        customer_information.ci_zipcode,
                        customer_information.ci_phonenumber,
                        customer_information.ci_telephonenumber,
                        customer_information.ci_bday,
						customer_information.ci_dateCreated,
                        customer_information.salt,
                        Message.m_id,
                        Message.m_message,
                        Message.m_type,
                        Message.m_salt,
                        createdCustomerMessage.m_id,
                        createdCustomerMessage.dateCreated,
                        createdCustomerMessage.messageStatus
                        order by createdCustomerMessage.dateCreated desc
						';


		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	function getOneAccountSelectedMessage(){

		$query = 'SELECT 	
					customer_information.ci_id as info_ID,
					customer_information.ci_email as info_email,
					customer_information.ci_firstname as info_firstname,
					customer_information.ci_lastname as info_lastname,
					customer_information.ci_middlename as info_middlename,
					customer_information.ci_street as info_street,
					customer_information.ci_city_municipality as info_city,
					customer_information.ci_province as info_provice,
					customer_information.ci_zipcode as info_zipcode,
					customer_information.ci_phonenumber as info_phonenumber,
					customer_information.ci_telephonenumber as info_telnumber,
					customer_information.ci_bday as info_bday,
					customer_information.ci_dateCreated as info_datecreated,
					customer_information.salt as info_key,

					Message.m_id as messageID,
					Message.m_message as message,
					Message.m_type as messageType,
					Message.m_salt as message_key,

					createdCustomerMessage.dateCreated as createdCustomerMessageDate,
					createdCustomerMessage.messageStatus as createdCustomerMessageStatus,
					createdCustomerMessage.ccm_id as createdCustomerMessageId


					FROM customer_account, Message, createdCustomerMessage, customer_information
					WHERE 
					((
						(customer_account.ci_id = customer_information.ci_id) and 
						(customer_account.ca_id = createdCustomerMessage.ca_id) and
						(createdCustomerMessage.m_id = Message.m_id)) 
						and Message.computed_hash = ?)';

		$stmt = $this->conn->prepare($query);

		$this->computed_hash = htmlspecialchars(strip_tags($this->computed_hash));

		$stmt->bindParam(1, $this->computed_hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function


	function sendMessagetoOneInquiry(){

		$query = 'INSERT INTO createsupportmessage_to_inquiry
					SET
						csmti_dateCreated=:csmti_dateCreated,
						csmti_timeCreated=:csmti_timeCreated,
						m_id=:m_id,
						a_id=:a_id,
						createdInquiry_id=:createdInquiry_id';

		$stmt = $this->conn->prepare($query);

		$this->createdDate = htmlspecialchars(strip_tags($this->createdDate));
		$this->timeCreated = htmlspecialchars(strip_tags($this->timeCreated));
		$this->messageID = htmlspecialchars(strip_tags($this->messageID));
		$this->inquiryId = htmlspecialchars(strip_tags($this->inquiryId));
		$this->adminId = htmlspecialchars(strip_tags($this->adminId));

		$stmt->bindParam(':csmti_dateCreated', $this->createdDate);
		$stmt->bindParam(':csmti_timeCreated', $this->timeCreated);
		$stmt->bindParam(':m_id', $this->messageID);
		$stmt->bindParam(':a_id', $this->adminId);
		$stmt->bindParam(':createdInquiry_id', $this->inquiryId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function


	function getInquiryMessageIdCreatedId(){

		$query = 'SELECT 	
					createdinquiries.ci_id as inquiryId,
					createdinquiries.cinfo_id as personalInformationId

					FROM createdinquiries, customer_information
					WHERE (customer_information.ci_id = createdinquiries.cinfo_id) and customer_information.ci_id = ?';

		$stmt = $this->conn->prepare($query);

		$this->customerInfoId = htmlspecialchars(strip_tags($this->customerInfoId));

		$stmt->bindParam(1, $this->customerInfoId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	function supportSendReplyToCustomerAccountMessage(){ 

		$query = 'INSERT INTO createSupportMessage_to_Account
					SET
						csmta_dateCreated=:csmta_dateCreated,
						csmta_timeCreated=:csmta_timeCreated,
						m_id=:m_id,
						a_id=:a_id,
						createdCustomerAccountMessage_id=:createdCustomerAccountMessage_id';

		$stmt = $this->conn->prepare($query);

		$this->createdDate = htmlspecialchars(strip_tags($this->createdDate));
		$this->timeCreated = htmlspecialchars(strip_tags($this->timeCreated));
		$this->messageID = htmlspecialchars(strip_tags($this->messageID));
		$this->adminId = htmlspecialchars(strip_tags($this->adminId));
		$this->customerCreatedMessageId = htmlspecialchars(strip_tags($this->customerCreatedMessageId));


		$stmt->bindParam(':csmta_dateCreated', $this->createdDate);
		$stmt->bindParam(':csmta_timeCreated', $this->timeCreated);
		$stmt->bindParam(':m_id', $this->messageID);
		$stmt->bindParam(':a_id', $this->adminId);
		$stmt->bindParam(':createdCustomerAccountMessage_id', $this->customerCreatedMessageId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function

	function getCustomerAccountMessageIdCreatedId(){

		$query = 'SELECT 	
					createdCustomerMessage.ccm_id as CustomerCreatedMessageId,
					createdCustomerMessage.ccm_id as createdCustomerMessageId,
					createdCustomerMessage.ca_id as CustomerAccountId

					FROM createdCustomerMessage, customer_account
					WHERE (createdCustomerMessage.ca_id = customer_account.ca_id) and customer_account.ca_id = ?';

		$stmt = $this->conn->prepare($query);

		$this->customerAccountId = htmlspecialchars(strip_tags($this->customerAccountId));

		$stmt->bindParam(1, $this->customerAccountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function


	function getcustomerAccountCreatedId(){

		$query = '	SELECT 
					    createdCustomerMessage.ccm_id AS customerCreatedAccountId
					FROM
					    customer_account,
					    createdCustomerMessage
					WHERE
					    (customer_account.ca_id = createdCustomerMessage.ca_id)
					        AND createdCustomerMessage.ca_id = ?
					GROUP BY createdCustomerMessage.ccm_id

					';

		$stmt = $this->conn->prepare($query);

		$this->customerCreatedMessageId = htmlspecialchars(strip_tags($this->customerCreatedMessageId));

		$stmt->bindParam(1, $this->customerCreatedMessageId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function



	

	function getAdminReplies(){

		$query = '	SELECT 
					    createSupportMessage_to_Account.m_id AS adminMessageReplyId,
					    createSupportMessage_to_Account.csmta_dateCreated AS adminMessageDate,
					    createSupportMessage_to_Account.csmta_timeCreated AS adminMessagetime,
					    Message.m_message AS adminMessageReply,
					    Message.m_salt AS adminMessageReplyKey
					FROM
					    createSupportMessage_to_Account,
					    createdCustomerMessage,
					    Message
					WHERE
					    (Message.m_id = createSupportMessage_to_Account.m_id)
					        AND createSupportMessage_to_Account.createdCustomerAccountMessage_id = createdCustomerMessage.ccm_id
					        AND createdCustomerMessage.ca_id = ?
					GROUP BY 
						createSupportMessage_to_Account.m_id , 
						createSupportMessage_to_Account.csmta_dateCreated , 
						createSupportMessage_to_Account.csmta_timeCreated , 
						Message.m_message , 
						Message.m_salt
					ORDER BY 
						createSupportMessage_to_Account.csmta_dateCreated, 
						createSupportMessage_to_Account.csmta_timeCreated
					DESC';

		$stmt = $this->conn->prepare($query);

		$this->customerCreatedMessageId = htmlspecialchars(strip_tags($this->customerCreatedMessageId));

		$stmt->bindParam(1, $this->customerCreatedMessageId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function


	function getAdminOneSelectedMessage(){

		$query = '	SELECT 
					    Message.m_message AS adminMessage,
					    Message.m_salt AS adminMessageKey,
					    createSupportMessage_to_Account.csmta_dateCreated AS adminMessageDate,
					    createSupportMessage_to_Account.csmta_timeCreated AS adminMessageTime
					FROM
					    Message,
					    createSupportMessage_to_Account
					WHERE
					    ((Message.m_id = createSupportMessage_to_Account.m_id)
					        AND createSupportMessage_to_Account.m_id = ?)
					GROUP BY 
					Message.m_message , 
					Message.m_salt , 
					createSupportMessage_to_Account.csmta_dateCreated , 
					createSupportMessage_to_Account.csmta_timeCreated';

		$stmt = $this->conn->prepare($query);

		$this->adminCreatedMessage = htmlspecialchars(strip_tags($this->adminCreatedMessage));

		$stmt->bindParam(1, $this->adminCreatedMessage);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function


	function create_AdminInformation(){

		$query = 'INSERT INTO admin_information
					SET 
					admin_email=:ci_email, 
					admin_firstname=:ci_firstname,
					admin_lastname=:ci_lastname, 
					admin_middlename=:ci_middlename, 
					admin_street=:ci_street, 
					admin_city_municipality=:ci_city_municipality, 
					admin_province=:ci_province, 
					admin_zipcode=:ci_zipcode, 
					admin_phonenumber=:ci_phonenumber, 
					admin_telephonenumber=:ci_telephonenumber, 
					admin_dateCreated=:ci_dateCreated, 
					admin_bday=:ci_bday,
					admin_salt=:salt, 
					admin_computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->firstname = htmlspecialchars(strip_tags($this->firstname));
		$this->lastname = htmlspecialchars(strip_tags($this->lastname));
		$this->middlename = htmlspecialchars(strip_tags($this->middlename));
		$this->street = htmlspecialchars(strip_tags($this->street));
		$this->city = htmlspecialchars(strip_tags($this->city));
		$this->province = htmlspecialchars(strip_tags($this->province));
		$this->zipcode = htmlspecialchars(strip_tags($this->zipcode));
		$this->phonenumber = htmlspecialchars(strip_tags($this->phonenumber));
		$this->telephone = htmlspecialchars(strip_tags($this->telephone));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->bday = htmlspecialchars(strip_tags($this->bday));
		$this->hash = htmlspecialchars(strip_tags($this->hash));


		$stmt->bindParam(':ci_email', $this->email);
		$stmt->bindParam(':ci_firstname', $this->firstname);
		$stmt->bindParam(':ci_lastname', $this->lastname);
		$stmt->bindParam(':ci_middlename', $this->middlename);
		$stmt->bindParam(':ci_street', $this->street);
		$stmt->bindParam(':ci_city_municipality', $this->city);
		$stmt->bindParam(':ci_province', $this->province);
		$stmt->bindParam(':ci_zipcode', $this->zipcode);
		$stmt->bindParam(':ci_phonenumber', $this->phonenumber);
		$stmt->bindParam(':ci_telephonenumber', $this->telephone);
		$stmt->bindParam(':ci_dateCreated', $this->date);
		$stmt->bindParam(':ci_bday', $this->bday);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function

	function getOneCustomerAccount(){

		$query = '	SELECT 
					   	*
					FROM
					   	customer_account
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

	}//end of the function

	function viewAdminInfo(){

		$query = '	SELECT 
					   	admin_information.admin_email as info_admin_email,
					   	admin_information.admin_firstname as info_admin_firstname,
					   	admin_information.admin_lastname as info_admin_lastname,
					   	admin_information.admin_middlename as info_admin_middlename,
					   	admin_information.admin_street as info_admin_street,
					   	admin_information.admin_city_municipality as info_admin_city_municipality,
					   	admin_information.admin_province as info_admin_province,
					   	admin_information.admin_zipcode as info_admin_zipcode,
					   	admin_information.admin_phonenumber as info_admin_phonenumber,
					   	admin_information.admin_telephonenumber as info_admin_telephonenumber,
					   	admin_information.admin_dateCreated as info_admin_dateCreated,
					   	admin_information.admin_bday as info_admin_bday,
					   	admin_information.admin_salt as info_admin_salt,
					   	admin_information.admin_computed_hash as info_admin_computed_hash
					FROM
					   	admin_information, admin_account
					WHERE
					   	(admin_account.admin_id = admin_information.admin_id)
					   	AND admin_account.a_id = ?';

		$stmt = $this->conn->prepare($query);

		$this->accountId = htmlspecialchars(strip_tags($this->accountId));

		$stmt->bindParam(1, $this->accountId);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;

		}

	}//end of the function


	function edit_AdminInformation(){

		$query = 'UPDATE
						admin_information, admin_account
					SET 
						admin_email=:ci_email, 
						admin_firstname=:ci_firstname,
						admin_lastname=:ci_lastname, 
						admin_middlename=:ci_middlename, 
						admin_street=:ci_street, 
						admin_city_municipality=:ci_city_municipality, 
						admin_province=:ci_province, 
						admin_zipcode=:ci_zipcode, 
						admin_phonenumber=:ci_phonenumber, 
						admin_telephonenumber=:ci_telephonenumber, 
						admin_dateCreated=:ci_dateCreated, 
						admin_bday=:ci_bday,
						admin_salt=:salt, 
						admin_computed_hash=:computed_hash
				WHERE 
						(admin_account.admin_id = admin_information.admin_id)
					   	AND admin_account.a_id =:reference';

		$stmt = $this->conn->prepare($query);

		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->firstname = htmlspecialchars(strip_tags($this->firstname));
		$this->lastname = htmlspecialchars(strip_tags($this->lastname));
		$this->middlename = htmlspecialchars(strip_tags($this->middlename));
		$this->street = htmlspecialchars(strip_tags($this->street));
		$this->city = htmlspecialchars(strip_tags($this->city));
		$this->province = htmlspecialchars(strip_tags($this->province));
		$this->zipcode = htmlspecialchars(strip_tags($this->zipcode));
		$this->phonenumber = htmlspecialchars(strip_tags($this->phonenumber));
		$this->telephone = htmlspecialchars(strip_tags($this->telephone));
		$this->date = htmlspecialchars(strip_tags($this->date));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->bday = htmlspecialchars(strip_tags($this->bday));
		$this->hash = htmlspecialchars(strip_tags($this->hash));
		$this->accountId = htmlspecialchars(strip_tags($this->accountId));

		$stmt->bindParam(':reference', $this->accountId);
		$stmt->bindParam(':ci_email', $this->email);
		$stmt->bindParam(':ci_firstname', $this->firstname);
		$stmt->bindParam(':ci_lastname', $this->lastname);
		$stmt->bindParam(':ci_middlename', $this->middlename);
		$stmt->bindParam(':ci_street', $this->street);
		$stmt->bindParam(':ci_city_municipality', $this->city);
		$stmt->bindParam(':ci_province', $this->province);
		$stmt->bindParam(':ci_zipcode', $this->zipcode);
		$stmt->bindParam(':ci_phonenumber', $this->phonenumber);
		$stmt->bindParam(':ci_telephonenumber', $this->telephone);
		$stmt->bindParam(':ci_dateCreated', $this->date);
		$stmt->bindParam(':ci_bday', $this->bday);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function



}// class