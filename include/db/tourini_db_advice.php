<?php

function db_send_message_advice($con, $message_id, $advisor_id, $advice) {
	$query = "INSERT INTO " . messageAdvice . " (`message_id`, `advisor_id`, `advice`, `post_time`) VALUES ('$message_id', '$advisor_id', '$advice', now())";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_send_photo_advice($con, $photo_id, $advisor_id, $advice) {
	$query = "INSERT INTO " . photoAdvice . " (`photo_id`, `advisor_id`, `advice`, `post_time`) VALUES ('$photo_id', '$advisor_id', '$advice', now())";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_delete_message_advice($con, $ma_id) {
	$query = "DELETE FROM " . messageAdvice . " WHERE `ma_id` = '$ma_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_delete_photo_advice($con, $pa_id) {
	$query = "DELETE FROM " . photoAdvice . " WHERE `pa_id` = '$pa_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_get_photo_advice($con, $photo_id) {
	$query = "SELECT * FROM " . photoAdvice . " WHERE `photo_id` = '$photo_id' ORDER BY `post_time` DESC";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[] = $rows;
	}
	return $tmp;
}

function db_get_message_advice($con, $message_id) {
	$query = "SELECT * FROM " . messageAdvice . " WHERE `message_id` = '$message_id' ORDER BY `post_time` DESC";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[] = $rows;
	}
	return $tmp;
}
?>