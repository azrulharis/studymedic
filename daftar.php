<?php
require_once('templates/header.php');
require_once('systems/AppController.php');






?>
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

span.ValidationErrors {
    display: inline-block;
    font-size: 12px;
    color: #D00;
    padding-left: 10px;
    font-style: italic;
}
</style>
<script type="text/javascript">
            /* <![CDATA[ */
            jQuery(function(){
                jQuery("#ValidName").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter name"
                });
                jQuery("#username").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter username"
                });
                jQuery("#ValidAddress").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter address"
                });
                jQuery("#ValidPhoneNumber").validate({
                    expression: "if (!isNaN(VAL) && VAL) return true; else return false;",
                    message: "Please enter a valid phone number"
                });
                jQuery("#ValidEmail").validate({
                    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                    message: "Please enter a valid Email"
                });
                jQuery("#ValidIcNumber").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please Ic Number"
                });
                jQuery("#ValidPassword").validate({
                    expression: "if (VAL.length > 5 && VAL) return true; else return false;",
                    message: "Please enter a valid Password"
                });
                jQuery("#ValidSelectionRegion").validate({
                    expression: "if (VAL != '0') return true; else return false;",
                    message: "Please select region"
                });
                jQuery("#ValidConfirmPassword").validate({
                    expression: "if ((VAL == jQuery('#ValidPassword').val()) && VAL) return true; else return false;",
                    message: "Confirm password doesn't match"
                });
             });
            /* ]]> */
        </script>

<h2>Affiliate</h2>
<p>Bagi sesiapa yang berminat untuk menjadi agen affiliate, sila isikan maklumat dibawah. Kami menawarkan komisyen yang menarik bagi meraih pendapatan lumayan</p>


$view = new AppController();
if(isset($_POST['register'])) {
	$view->rules(array( 
    'fullname' => array('between' => array('min' => 5, 'max' => 32, 'error' => 'Name between 6 to 32 characters')), 
    'username' => array('between' => array('min' => 5, 'max' => 16, 'error' => 'Username between 6 to 16 characters')),
    'icNumber' => array('alphanumeric' => 'Please enter valid ic number', 
	                    'between' => array('min' => 8, 'max'=> 13, 'error' => 'Ic number between 8 to 13 characters')), 
    'email' => array('is_email' => 'Please enter valid email'),
    'password' => array('between' => array('min' => 5, 'max' => 18, 'error' => 'Password between 6 to 18 character')), 
    'retypePassword' => array('equal_to' => 'password', 'error' => 'Retype password not match'),
	'region' => array('not_empty' => 'Please select region') 
            ));

    if(empty($view->message)) {
        require_once('systems/controller/daftar.php');
        $reg = new Register();
	    if($reg->register()) {
	    	echo '<p class="flash">Register has been successful, please verified your email.</p>';
	    }
    } 

}

<div id="daftar">

<form action="" method="POST">
<table class="formInsert">
  <tr>
    <td width="200px">Username:</td><td><input name="username" type="text" id="username" class="required username" minlength="5" > 
              <input name="btnAvailable" type="button" id="btnAvailable" 
			  onclick='$("#checkid").html("Please wait..."); $.get("ajax/usernameChecker/validate.php",{ cmd: "check", user: $("#username").val() } ,function(data){  $("#checkid").html(data); });'
			  value="Check Availability"> 
			  <span style="font: bold 12px verdana; float: right;" id="checkid" ></span>
			  <?php 
			  $view->display('username'); 
			  ?></td>
  </tr>

  <tr>
    <td width="200px">Nama Penuh:</td>
	<td><input type="text" name="fullname" id="ValidName">
	<?php 
	$view->display('fullname'); 
	?></td>
  </tr>
  

<tr>
    <td>No Kad Pengenalan:</td><td><input type="text" name="icNumber" id="ValidIcNumber">
	<?php 
	$view->display('icNumber'); 
	?></td>
  </tr>

  <tr>
    <td>Email:</td><td><input type="text" name="email" id="ValidEmail"><?php $view->display('email'); 
	?></td>
  </tr>
  
    <tr>
    <td>Alamat:</td><td><textarea name="address"  id="ValidAddress"></textarea><?php $view->display('address'); 
	?></td>
  </tr>
  

  
  
  
  
    <tr>
	<td>Negeri:</td>
	<td>
	
<select name="region" id="ValidSelectionRegion">
<option value="0">Sila Pilih</option>
<option value="perlis" >Perlis</option>
<option value="kedah" >Kedah</option>
<option value="penang" >Penang</option>
<option value="kelantan" >Kelantan</option>
<option value="terengganu" >Terengganu</option>
<option value="perak" >Perak</option>
<option value="pahang" >Pahang</option>
<option value="selangor" >Selangor</option>
<option value="kuala-lumpur" >Kuala Lumpur</option>
<option value="negeri-sembilan" >Negeri Sembilan</option>
<option value="melaka" >Melaka</option>
<option value="johor" >Johor</option>
<option value="sarawak" >Sarawak</option>
<option value="sabah" >Sabah</option>
</select><?php 
$view->display('region'); 
?>
	
	
	</td>
</tr>
  
  
  
  
   <tr>
    <td>Nama Bank:</td><td><select name="bank">
<option value="0">Sila Pilih</option>
<option value="CIMB Bank">CIMB Bank</option>
<option value="Maybank">Maybank</option>
<option value="AM Bank">AM Bank</option>
<option value="RHB Bank">RHB Bank</option>
<option value="Public Bank">Public Bank</option>
<option value="Bank Islam">Bank Islam</option>
<option value="Bank Muamalat">Bank Muamalat</option>
<option value="Bank Rakyat">Bank Rakyat</option>
<option value="Central Bank Of Malaysia">Central Bank Of Malaysia</option>
<option value="Bank Simpanan Nasional">Bank Simpanan Nasional</option>
<option value="HSBC Bank">HSBC Bank</option>
<option value="Standard Chartered">Standard Chartered</option>
<option value="Affin Bank">Affin Bank</option>

</select><?php //$view->display('password'); 
	?></td>
  </tr>
    <tr>
    <td>No Akaun:</td><td><input type="text" name="acc_number"><?php //$view->display('password'); 
	?></td>
  </tr>
  
  <tr>
    <td>Password:</td><td><input type="password" name="password" id="ValidPassword"><?php  $view->display('password'); 
	?></td>
  </tr>
  <tr>
    <td>Ulang Password:</td><td><input type="password" name="retypePassword" id="ValidConfirmPassword"><?php $view->display('retypePassword'); 
	?></td>
  </tr>
  <tr>
    <td></td><td><input type="submit" name="register" value="Register"></td>
  </tr>
</table>
</form>
</div>
<?php
require_once('templates/footer.php');
?>