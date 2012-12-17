<?php


class Graph extends AppController {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function statistic() {
		
	}

    public function validate($username) {
	    if($this->doCount('agents' => array('username' => $username)) == 1) {
			$_SESSION['agent'] = $username;
			$_SESSION['unique_visitor'] = $this->passwordHash(date('Y-m-d H:i:s'));
			$this->select('agents', array('id', 'username'), array('username' => $username, 'ckey' => 0));
			
			foreach($this->getResult() as $key => $row):
			return $this->insert('hits', 
			    array('user_id' => $row['id'],
			          'http_ref' => $_SERVER['HTTP_REFERER'],
			          'session_id' => $_SESSION['unique_visitor'],
			          'ip_address' => $this->get_ip(),
			          'username' => $row['username']
			    ));
			endforeach;
		} else {
			$_SESSION['agent'] = 'admin';
		}
    }
	
}