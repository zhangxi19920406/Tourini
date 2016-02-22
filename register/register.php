<?php
/**********************************************************************
 *Contains all the basic Configuration
 *dbHost = Host of your MySQL DataBase Server... Usually it is localhost
 *dbUser = Username of your DataBase
 *dbPass = Password of your DataBase
 *dbName = Name of your DataBase
 **********************************************************************/
require_once(dirname(dirname(__FILE__)).'/include/include.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tourini user register</title>
<link rel="stylesheet" href="css/register.css" type="text/css"/>
</head>
<body>
<div class="ad_window">
	<div class="front_line"><img src="img/register/gm_l_a.gif" /></div>
	<div class="l1 front_line">
		<div class="l2 front_line"></div>
		<div class="l3 front_line">
			<ul>
<?php 
$register_form = <<<EOD
<form class="form_label" action="" name="register" method="post">
<li><img src="img/register/gm_l_g.gif" /></li>
<li class="label">username:<input class="l4 input" type="Text" name="username" value="" style="width:128px; height:15px;"></li> 
<li class="label">password:<input class="l5 input" type="password" name="password" value="" style="width:128px; height:15px;"></li>
<li class="label"><u>password</u>:<input class="l5 input" type="password" name="password2" value="" style="width:128px; height:15px;"></li>
<li style="height:27px;"><input type="image" onclick="submit();" src="img/register/button_confirm.png" style="height:27px; width:100px;">
		<a href = "../login/login.php"
			><img src="img/register/back_button.png" style="height:27px; width:50px;">
		</a>
		</li>
</form>
EOD;

echo $register_form;
?>
			</ul>
		</div>
	</div>
	<div class="bottom_line">Copyright &copy; 2015 Tourini    </div>
</div>

</body>
</html>
<?php
$con = connect_DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username']; //Set UserName
	$password = $_POST['password']; //Set Password
	$password2 = $_POST['password2']; //Set Password
    ob_start();
    
    if ($username == "" || $password == "") {
    	alert("Enter username or passward", "jump", "register.php");
    } elseif (preg_match("^[a-z0-9_-]{3,15}$", $username)) {
    	alert("Username not mach! '^[a-z0-9_-]{3,15}$'", "jump", "register.php");
    } elseif (db_check_user_name_exist($con, $username)) {
    	alert("Username exist!", "jump", "register.php");
    } elseif (preg_match("/^[a-zA-Z\d_]{6,}$/", $username)) {
    	alert("Password not match! '/^[a-zA-Z\d_]{6,}$/'", "jump", "register.php");
    } elseif (!($password == $password2)) {
    	alert("Two password not match!", "jump", "register.php"); 
    } else {
    	db_new_user($con, $username, $password);
       	header("location:../login/login.php");
	}

	ob_end_flush();
}
close_DB($con);



?>
