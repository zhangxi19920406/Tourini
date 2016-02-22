<?php

function db_get_all_friends($con, $user_id) {
	$query = "SELECT * FROM " . friend_circle_full_info . " WHERE `user_id` = '$user_id' ORDER BY `circle_name`";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp_friends = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp_friends[] = $rows;
	}
	return $tmp_friends;
}

function db_get_approved_friends($con, $user_id) {
	$query = "SELECT * FROM " . friend_circle_full_info . " WHERE `user_id` = '$user_id' and `status` = " . approved_status . " ORDER BY `friend_name`";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp_friends = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp_friends[] = $rows;
	}
	return $tmp_friends;
}

function db_get_waitint_friends($con, $user_id) {
	$query = "SELECT * FROM " . friend_circle_full_info . " WHERE `friend_id` = '$user_id' and `status` = " . waiting_status;
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp_friends = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp_friends[] = $rows;
	}
	return $tmp_friends;
}

function db_check_friendship_exist($con, $user_id, $friend_id) {
	$query = "SELECT 'id' FROM " . friend . " WHERE (`user_id` = '$user_id' AND `friend_id` = '$friend_id') OR (`friend_id` = '$user_id' AND `user_id` = '$friend_id')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$rows = mysql_num_rows($result);
	if ($rows == 0) {
		return false;
	}
	return true;
}

function db_request_friend($con, $user_id, $friend_id) {
	if (!db_check_friendship_exist($con, $user_id, $friend_id)) {
		$query = "INSERT INTO " . friend . " (`user_id`, `friend_id`, `request_time`, `status`) VALUES ('$user_id', '$friend_id', now(), " . waiting_status .  ")";
		$result = mysql_query($query, $con);
		$result || die(db_error_msg . mysql_error());
	}	
}

function db_verify_friend($con, $id) {
	$query = "UPDATE " . friend . " SET `status` = " . approved_status . " WHERE `id` = '$id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$query = "SELECT `user_id`, `friend_id` FROM " . friend . " WHERE `id` = '$id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp_friend_id;
	$tmp_user_id;
	while ($rows = mysql_fetch_array($result)) {
		$tmp_user_id = $rows['user_id'];
		$tmp_friend_id = $rows['friend_id'];
	}
	$query = "INSERT INTO " . friend . " (`user_id`, `friend_id`, `request_time`, `status`) VALUES ('$tmp_friend_id', '$tmp_user_id', now(), " . approved_status .  ")";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_delete_friend($con, $id) {
	$query = "SELECT * FROM " . friend . " WHERE `id` = '$id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$user_id;
	$friend_id;
	while ($rows = mysql_fetch_array($result)) {
		$user_id = $rows['user_id'];
		$friend_id = $rows['friend_id'];
	}
	$query = "DELETE FROM " . friend . " WHERE (`user_id` = '$user_id' AND `friend_id` = '$friend_id') OR (`user_id` = '$friend_id' AND `friend_id` = '$user_id')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_delete_waiting_friends($con, $user_id) {
	$query = "DELETE FROM " . friend . " WHERE `friend_id` = '$user_id' AND `status` = " . waiting_status;
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_delete_waiting_friend_according_time($con, $user_id, $days) {
	$query = "DELETE FROM " . friend . " WHERE `friend_id` = '$user_id' and DATEDIFF(DATE(NOW()), DATE(`request_time`)) > $days AND `status` = " . waiting_status;
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}


