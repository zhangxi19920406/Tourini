<?php
require_once(dirname(dirname(__FILE__)).'/include/run_session.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Welcome To Admin Page Demonstration</title>
</head>
<body>
    <h1>Welcome To Admin Page </h1>
    <p><a href="logout.php">Logout</a></p> <!-- A link for the logout page -->
    <p>Put Admin Contents</p>
	<?php
	echo USERID;
	?>
</body>
</html>