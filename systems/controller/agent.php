<?php


/*
*  Agent management class
*  Constructor -> connect to database
*  StudyMedic.com.my
*/

class Agent extends AppController {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$query = $this->select('agents', array('id', 'username', 'email'), array('id' => $_SESSION['id'], 'username' => $_SESSION['username']));
		return $this->getResult();
	}
	
	public function graph() {
		$query = sprintf("SELECT * FROM agents WHERE id = '%d' AND username = '%s'", 
		mysql_real_escape_string($_SESSION['id']), mysql_real_escape_string($_SESSION['username']));
		
		$query = mysql_query($query) or die(mysql_error());
		
	}
}