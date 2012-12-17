<?php
require_once('templates/header.php');
?>
<div id="daftar">

<form action="" method="POST">
<table class="formInsert">
  <tr>
    <td width="180px">Url: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;www.jun.my/</td><td><input name="username" type="text" id="username" class="required username" minlength="5" > 
              <input name="btnAvailable" type="button" id="btnAvailable" 
			  onclick='$("#checkid").html("Please wait..."); $.get("usernameChecker/validate.php",{ cmd: "check", user: $("#username").val() } ,function(data){  $("#checkid").html(data); });'
			  value="Check Availability"> 
			  <span style="font: bold 12px verdana; float: right;" id="checkid" ></span>
			  <?php $view->display('username'); ?></td>
  </tr>

  <tr>
    <td width="180px">Full Name/Business:</td>
	<td><input type="text" name="bussinessName" id="ValidName"><?php $view->display('bussinessName'); ?></td>
  </tr>
  
  <tr>
	<td>Region:</td>
	<td>
	
<select name="region" id="ValidSelectionRegion">
<option value="">&laquo;Select&raquo;</option>
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
</select><?php $view->display('region'); ?>
	
	
	</td>
</tr>
<tr>
    <td>Ic Number:</td><td><input type="text" name="icNumber" id="ValidIcNumber"><?php $view->display('icNumber'); ?></td>
  </tr>

  <tr>
    <td>Email:</td><td><input type="text" name="email" id="ValidEmail"><?php $view->display('email'); ?></td>
  </tr>
  <tr>
    <td>Password:</td><td><input type="password" name="password" id="ValidPassword"><?php $view->display('password'); ?></td>
  </tr>
  <tr>
    <td>Retype Password:</td><td><input type="password" name="retypePassword" id="ValidConfirmPassword"><?php $view->display('retypePassword'); ?></td>
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