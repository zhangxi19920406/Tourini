<?php

function db_get_message_by_id($con, $message_id) {
	$query = "SELECT * FROM " . message_full_info . " WHERE `message_id` = '$message_id'";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = new Message($rows['message_id'], $rows['text'], $rows['location_id'], $rows['post_id'], $rows['user_id'], $rows['user_name'], $rows['see_status'], $rows['post_time']);
		$tmp->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_post_message($con, $user_id, $text, $location_id, $see_status) {
	$time_datetime = db_get_now_datetime();
	$query = "INSERT INTO " . message . " (`text`, `location_id`) VALUES ('$text', '$location_id')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$query = "SELECT `message_id` FROM " . message . " WHERE `text` = '$text' AND `location_id` = '$location_id'";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$message_id;
	while ($rows = mysql_fetch_array($result)) {
		$message_id = $rows['message_id'];
	}
	$query = "INSERT INTO " . postMessage . " (`user_id`, `message_id`, `post_time`, `see_status`) VALUES ('$user_id', '$message_id', '$time_datetime', '$see_status')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$query = "SELECT `post_id` FROM " . postMessage . " WHERE `user_id` = '$user_id' AND `post_time` = '$time_datetime'";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = $rows['post_id'];
	}
	return $tmp; //do the post and return the id! set the judgment in PHP
	//PHP 多选框，array or 分开单独计算
}

function db_post_message_circle($con, $post_id, $circle_id) {
	$query = "INSERT INTO " . messageCircleStatus . " (`post_message_id`, `circle_id`) VALUES ('$post_id', '$circle_id')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

?>