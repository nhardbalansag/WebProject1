<?php

/**
 * 
 */
class Database
{
	private $server = 'localhost';

	private $db_name = 'yamaha_capstone_project';

	private $password = '';

	private $username = 'root';

	public $conn = null;
	
	public function connection(){

		try {
			
			$this->conn = new PDO('mysql:host=' . $this->server . ";dbname=" . $this->db_name, $this->username, $this->password);

		} catch (Exception $e) {
			// error handling function goes here
		}
		
		return $this->conn;

	}// end of the function

} // eend of the class