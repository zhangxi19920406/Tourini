<?php

function db_get_photo_by_id($con, $photo_id) {
	$query = "SELECT * FROM " . photo_full_info . " WHERE `photo_id` = '$photo_id'";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = new Photo($rows['photo_id'], $rows['photo'], $rows['time'], $rows['location_id'], $rows['caption'], $rows['post_id'], $rows['user_id'], $rows['user_name'], $rows['see_status'], $rows['post_time']);
		$tmp->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_post_photo($con, $user_id, $photo, $time, $location_id, $caption, $see_status) {
	$time_datetime = db_get_now_datetime();
	$query = "INSERT INTO " . photo . " (`photo`, `time`, `location_id`, `caption`) VALUES ('$photo', '$time', '$location_id', '$caption')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$query = "SELECT `photo_id` FROM " . photo . " WHERE `photo` = '$photo' AND `location_id` = '$location_id'";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$photo_id;
	while ($rows = mysql_fetch_array($result)) {
		$photo_id = $rows['photo_id'];
	}
	$query = "INSERT INTO " . postPhoto . " (`user_id`, `photo_id`, `post_time`, `see_status`) VALUES ('$user_id', '$photo_id', '$time_datetime', '$see_status')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$query = "SELECT `post_id` FROM " . postPhoto . " WHERE `user_id` = '$user_id' AND `post_time` = '$time_datetime'";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = $rows['post_id'];
	}
	return $tmp; 
}

function db_post_photo_circle($con, $post_id, $circle_id) {
	$query = "INSERT INTO " . photoCircleStatus . " (`post_photo_id`, `circle_id`) VALUES ('$post_id', '$circle_id')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

?>