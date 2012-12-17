<?php

/*
*  Agent management class
*  Constructor -> connect to database
*  StudyMedic.com.my
*/

class Register extends AppController {
	
	/*
	*  Connect to database from extender
	*/	
	public function __construct() {
	    parent::__construct();	
	}
	
	/*
	*  Register new agent, return boolean
	*/
	public function register() {
		return $this->insert('agents', array(
		    'username' => $_POST['username'],	 
		    'email' => $_POST['email'],	
		    'nric' => $_POST['icNumber'],	
			'fullname' => $_POST['fullname'],	
			'password' => $this->passwordHash($_POST['password']),	 	
			'address' => $_POST['address'],	
			'region' => $_POST['region'],
			'ckey' => $this->passwordHash(date('Y-m-d')),
			'ip_address' => $this->get_ip(),
			'bank' => $_POST['bank'],
			'acc_number' => $_POST['acc_number']));
		
	}
	
	/*
	*  Agent login step 1 select from table by email, 2 count if email and password is match. set session id, username, salt, redirect = any page

	public function login($email, $password) {
	    $query = $this->select('agents', array('id', 'username', 'email', 'password', 'ckey'), array('email' => $email, 'ckey' => 0));
	    foreach($this->getResult() as $key => $row):
		    if($this->doCount('agents', array('email' => $email, 'password' => $this->passwordHash($password, substr($row['password'])))) == 1) {
			    $this->setSession(array(
			        'session' => array('username' => $row['username'], 'id' => $row['id']),
			        'redirect' => 'agent/index.php',
			        'salt' => 'TNqgw3S7xA7xPvyji3bnPBc9HLcYsoWHTlgUAR1qVeBYrpylyJZ5Y7GIp7x2FTk';
				));
		    } esle {
				echo $this->err('Email and Password combination not match');
			}
	    endforeach;
	}
	
	public function logout() {
		return $this->logout();
	}
	
	*/		
} 



