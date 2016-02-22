<?php

require_once(dirname(__FILE__) . '/upload_photo.php');

function getFileType($filename) {
	return substr($filename, strrpos($filename, '.') + 1);
}

function alert($tip = "", $type = "", $url = "") {
	$js = "<script>";
	if ($tip)
		$js .= "alert('" . $tip . "');";
	switch ($type) {
		case "close" :
			$js .= "window.close();";
			break;
		case "back" :
			$js .= "history.back(-1);";
			break;
		case "refresh" :
			$js .= "parent.location.reload();";
			break;
		case "top" : 
			if ($url)
				$js .= "top.location.href='" . $url . "';";
				break;
		case "jump" : 
			if ($url)
				$js .= "window.location.href='" . $url . "';";
				break;
		default :
			break;
	}
	$js .= "</script>";
	echo $js;
	if ($type) {
		exit();
	}
}

?>