<html>
<head>
<title>ZwelLÍ¼Æ¬ÉÏ´«³ÌÐò</title>
</head>
<body>
<form id="upfile" name="upform" enctype="multipart/form-data" method="post" action="">
  <label for="upfile">UP LOAD FILE:</label>
  <input type="file" name="upfile" id="fileField" />
  <input type="submit" name="submit" value="-upload-"/>

</form>


<?php
require_once(dirname(__FILE__) . '/include/include.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$photoname = upload_photo(1, $_FILES['upfile']);
	
}

?>