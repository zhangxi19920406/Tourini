<?php

function db_get_current_location_by_id($con, $cl_id) {
	$query = "SELECT * FROM " . current_location_full_info . " WHERE `cl_id` = '$cl_id'";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = new CurrentLocation($rows['cl_id'], $rows['location_id'], $rows['user_id'], $rows['user_name'], $rows['profile'], $rows['see_status'], $rows['post_time'], $rows['status']);
		$tmp->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_get_current_location_by_publisher_newest($con, $publisher_id) {
	$query = "SELECT * FROM " . current_location_full_info . " WHERE `user_id` = '$publisher_id' AND `status` = " . valid_status;
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = new CurrentLocation($rows['cl_id'], $rows['location_id'], $rows['user_id'], $rows['user_name'], $rows['profile'], $rows['see_status'], $rows['post_time'], $rows['status']);
		$tmp->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_post_current_location($con, $user_id, $location_id, $see_status) {
	$query = "UPDATE " . currentLocation . " SET `status` = " . not_valid_status . " WHERE `user_id` = '$user_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$time_datetime = db_get_now_datetime();
	$query = "INSERT INTO " . currentLocation . " (`location_id`, `user_id`, `post_time`, `see_status`, `status`) VALUES ('$location_id', '$user_id', '$time_datetime', '$see_status', " . valid_status . ")";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$query = "SELECT `cl_id` FROM " . currentLocation . " WHERE `user_id` = '$user_id' AND `post_time` = '$time_datetime' AND `status` = " . valid_status;
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = $rows['cl_id'];
	}
	return $tmp; //do the post and return the id! set the judgment in PHP
	//PHP 多选框，array or 分开单独计算
}

function db_post_current_location_circle($con, $cl_id, $circle_id) {
	$query = "INSERT INTO " . currentLocationCircleStatus . " (`cl_id`, `circle_id`) VALUES ('$cl_id', '$circle_id')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

?>