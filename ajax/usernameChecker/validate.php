<style>


input:focus, select:focus {
    outline: none;
}

.InputGroup {
    display: inline-block;
    padding: 3px 4px;
    border: 1px solid #FFF;
    border-radius: 7px;
    -moz-border-radius: 7px;
}

.ErrorField {
    border-color: #D00;
    color: #D00;
    background: #FFFFFE;
}

p.ValidationErrors {
    display: inline-block;
    font-size: 11px;
    color: #D00;
    padding-left: 10px;
    font-style: italic;
}
</style>

<?php

include '../../db.php';

function isUserId($username){
	if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
		return true;
	} else {
		return false;
	}
 }


foreach($_GET as $key => $value) {
	$get[$key] = $value;
}

$user = mysql_real_escape_string($get['user']);

if(isset($get['cmd']) && $get['cmd'] == 'check') {

if(!isUserId($user)) {
echo '<p class="ValidationErrors">Invalid url</p>';
exit();
}

if(empty($user) && strlen($user) <=5) {
echo '<p class="ValidationErrors">Minimum 5 character</p>';
exit();
}


$query = sprintf("select count(username) as total from agents where username='%s'", mysql_real_escape_string($user));
$rs_duplicate = mysql_query($query) or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

	if ($total > 0)
	{
	echo '<p class="ValidationErrors">Already taken</p>';
	} else {
	echo '<p style="color:#34B309; font-size: 11px; float: left; margin-top: -25px;">Available</p>';
	}
}

?>