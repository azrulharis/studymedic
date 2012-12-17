<?php
define('SALT_LENGTH', 9);


class AppController {
    
    public $message = array();
    
    public function __construct() {
		$mysql_hostname = "localhost";
        $mysql_user = "studymedic";
        $mysql_password = "rahsiajun";
        $mysql_database = "studymedic";
        $prefix = "";
        $bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong");
        mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");
	}
 
    public function insert($table, $data) {
	
		$insert = sprintf('INSERT INTO %s (%s) VALUES ("%s")', $table, 
		          implode(', ', array_map('mysql_escape_string', array_keys($data))), 
		          implode('", "',array_map('mysql_escape_string', $data)));
		
		    if(mysql_query($insert)) {
		    	return true;
		    } else {
			    return false;
		    }			
	}
	
	public function rules($data) {
		foreach($data as $key => $value) {
			//echo $_POST[$key] . $value;
			foreach($value as $rule => $error) {
				//echo $rule;
				switch($rule) {
					case 'not_empty':
					    if(empty($_POST[$key]) == $key) {
							$this->message[$key] = $error;
						}
					break;
					
					case 'numeric':
					    if(!is_numeric($_POST[$key]) == $key) {
							$this->message[$key] = $error;
						}
					break;
					
					case 'is_email':
					    if(!$this->validEmail($_POST[$key]) == $key) {
							$this->message[$key] = $error;
						}
					break;
					
					case 'alphanumeric':
					    if(!ctype_alnum($_POST[$key]) == $key) {
							$this->message[$key] = $error;
						}
					break;
					
					case 'between':
					    foreach($error as $between => $minmax) {
							//echo $between .  '<br/>';
							switch($between) {
								case 'min':
								    //echo $between . $minmax;
								    if(strlen($_POST[$key]) < $minmax) {
									    $this->message[$key] = $error['error'];	
									}
								break;
								
								case 'max':
								    //echo $between . $minmax;
								    if(strlen($_POST[$key]) > $minmax) {
									    $this->message[$key] = $error['error'];	
									}
								break;
								
							}
						}
					break;
					
					case 'equal_to':

					    if($_POST[$key] != $_POST[$value['equal_to']]) {
							$this->message[$key] = $value['error'];
						}
					break;
					
					/**
                    * return url
                    */					
					case 'is_url':
					    if(!$this->is_url($_POST[$key]) == $key) {
							$this->message[$key] = $error;
						}
					break;
					
					/**
                    * check or radio button
                    */					
					case 'is_check':
					    if(empty($_POST[$key]) == $key) {
							$this->message[$key] = $error;
						}
					break;
					
					/**
                    * select option form, make sure first value = empty or 0
                    */
					case 'is_select':
					    if($_POST[$key] == '' || $_POST[$key] == 0) {
							$this->message[$key] = $error;
						}
					break;
				}
			}
		
		}
	}
	
	
    protected function select($table, $column = NULL, $data=NULL) {
        if(!empty($data)) {
			$query = "SELECT ".implode(', ', $column)." FROM `$table`"  . $this->where_list($data);
		    
		} else {
			$query = "SELECT * FROM `$table`"   . $this->where_list($data);	
		}
		$query = mysql_query($query);
		
        if($query) {
            $this->numResults = mysql_num_rows($query);
            for($i = 0; $i < $this->numResults; $i++) {
                $r = mysql_fetch_array($query);
                $key = array_keys($r);
                for($x = 0; $x < count($key); $x++) {
                    // Sanitizes keys so only alphavalues are allowed
                    if(!is_int($key[$x])) {
                        if(mysql_num_rows($query) > 0)
                            $this->result[$i][$key[$x]] = htmlentities($r[$key[$x]]);
                        else if(mysql_num_rows($query) < 1)
                            $this->result = null;
                        else
                            $this->result[$key[$x]] = htmlentities($r[$key[$x]]);
                    }
                }
            }
            return true;
        }
        else
        {
            return false;
        }
	}

    /*
    * Returns the result set
    */
    public function getResult() {
        return $this->result;
    }

    
    public function doCount($table, $data = array()) {
		$query = mysql_query("SELECT COUNT(id) FROM `$table`" . $this->where_list($data));
        list($row) = mysql_fetch_row($query);
        return $row;
	}
	
	protected function doUpdate($table, $data = array(), $where = array()) {
		foreach($data as $key => $value) { 
			$query = "UPDATE $table SET ". $this->column_list($data) . $this->where_list($where);
			return mysql_query($query);
		}
		
	}
	
	private function column_list($conditions = array()) {
        $output = " SET ";
		foreach((array) $conditions as $column => $value) {
			//If the value is an aray it must be an IN clause
			if(is_array($value)) {
				$output .= "`".$column."`". "'$value'";
			} else {
				$output .= "`".$column."`". " = "
				. ($value == '?' ? $value : "'$value'"). ", ";
			}
		}
		
		return rtrim($output, ", ");
	}
	
	private function validEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

    public function display($value) {
        if(isset($_POST)) {
		    if(isset($this->message[$value])) {
			    echo '<span class="ValidationErrors">'.$this->message[$value].'</span>'; 
		    }			
		}
    }

	private function is_url($url) {
	    if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
	    	return true;
	    } else {
	    	return false;
	    }
    } 
    
	protected function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
        } else {
            $salt = substr($salt, 0, SALT_LENGTH);
        }
        return $salt . sha1($pwd . $salt);
    }
    
    protected function get_ip() {
		 $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
 
        return $ipaddress;
	}

}