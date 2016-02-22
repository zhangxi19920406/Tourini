<?php

function db_check_circle_exist($con, $user_id, $circle_name) {
	$query = "SELECT `circle_id` FROM " . circle . " WHERE `user_id` = '$user_id' and `circle_name` = '$circle_name'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$rows = mysql_num_rows($result);
	if ($rows == 0)
		return false;
	return true;
}

function db_new_circle($con, $user_id, $circle_name) {
	$query = "INSERT INTO " . circle . " (`user_id`, `circle_name`) VALUES ('$user_id', '$circle_name')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_get_all_circle($con, $user_id) {
	$query = "SELECT * FROM " . circle . " WHERE `user_id` = '$user_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[] = $rows;
	}
	return $tmp;
}

function db_add_friend_into_circle($con, $user_friend_id, $circle_id) {
	$query = "UPDATE " . friend . " SET `circle_id` = '$circle_id' WHERE `id` = '$user_friend_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_delete_friend_from_circle($con, $user_friend_id) {
	$query = "UPDATE " . friend . " SET `circle_id` = NULL WHERE `id` = '$user_friend_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_delete_circle($con, $user_id, $circle_id) { //********************************************
	$query = "UPDATE " . friend . " SET `circle_id` = NULL WHERE `circle_id` = '$circle_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$query = "DELETE FROM " . circle . " WHERE (`user_id` = '$user_id' and `circle_id` = '$circle_id')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

?>