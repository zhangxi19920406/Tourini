<?php
/**********************************************************************
 *Contains all the basic Configuration
 *dbHost = Host of your MySQL DataBase Server... Usually it is localhost
 *dbUser = Username of your DataBase
 *dbPass = Password of your DataBase
 *dbName = Name of your DataBase
 **********************************************************************/
 session_start();
 require_once(dirname(dirname(__FILE__)).'/include/include.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tourini user login</title>
<link rel="stylesheet" href="css/login.css" type="text/css"/>
</head>
<body>
<div class="ad_window">
	<div class="front_line"><img src="img/login/gm_l_a.gif" /></div>
	<div class="l1 front_line">
		<div class="l2 front_line"></div>
		<div class="l3 front_line">
			<ul>

				<form class="form_label" action="" name="login" method="post">
					<li><img src="img/login/gm_l_g.gif" /></li>
					<li class="label">username:<input class="l4 input" type="Text" name="username" value="" style="width:128px; height:15px;"></li> 
					<li class="label">password:<input class="l5 input" type="password" name="password" value="" style="width:128px; height:15px;"></li>
					<li style="height:27px;"><input type="image" onclick="submit();" src="img/login/gm_l_dl.gif" style="height:27px; width:128px;"></li>
					<li class="label"><a href = "../register/register.php">Not an user? register here.<a/></li>
				</form>
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
	if(isset($username, $password)) {
		ob_start();
		
		if(db_login_check($con, $username, $password)){

			
 			$_SESSION['user_id']= db_login($con, $username, $password); // user_id
			session_write_close();
			header("location:../home/home.php"); 
			
		}
		else {
			 $msg = "Wrong Username or Password. Please retry";
			 header("location:login.php?msg=$msg");
		}
	
	ob_end_flush();
	}
}
close_DB($con);

?>
