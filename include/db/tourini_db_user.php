<?php

function db_get_user_name($con, $user_id) {
	$query = "SELECT `user_name` FROM " . user . " WHERE `user_id` = '$user_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = $rows['user_name'];
	}
	return $tmp;
}

function db_get_user_id($con, $user_name) {
	$query = "SELECT `user_id` FROM " . user . " WHERE `user_name` = '$user_name'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = $rows['user_id'];
	}
	return $tmp;
}

function db_login($con, $user_name, $password) {
	$query = "SELECT `user_id` FROM " . user . " WHERE `user_name` = '$user_name' AND `password` = '$password'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp_user_id;
	while ($rows = mysql_fetch_array($result)) {
		$tmp_user_id = $rows['user_id'];
	}
	return $tmp_user_id;
}

function db_check_password($con, $user_id, $password) {
	$query = "SELECT `user_id` FROM " . user . " WHERE `user_id` = '$user_id' AND `password` = '$password'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$rows = mysql_num_rows($result);
	if ($rows == 0)
		return false;
	return true;
}

function db_login_check($con, $user_name, $password) {
	$query = "SELECT `user_name` FROM " . user . " WHERE `user_name` = '$user_name' AND `password` = '$password'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$rows = mysql_num_rows($result);
	if ($rows == 0)
		return false;
	return true;
}

function db_get_profile($con, $user_id) {
	$query = "SELECT `profile` FROM " . user . " WHERE `user_id` = '$user_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = $rows['profile'];
	}
	return $tmp;
}

function db_update_password($con, $user_id, $password) {
	$query = "UPDATE " . user . " SET `password` = '$password' WHERE `user_id` = '$user_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_check_user_name_exist($con, $user_name) {
	$query = "SELECT `user_name` FROM " . user . " WHERE `user_name` = '$user_name'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
	$rows = mysql_num_rows($result);
	if ($rows == 0)
		return false;
	return true;
}

function db_update_profile($con, $user_id, $profile) {
	$query = "UPDATE " . user . " SET `profile` = '$profile' WHERE `user_id` = '$user_id'";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_new_user($con, $user_name, $password) {
	$query = "INSERT INTO " . user . " (`user_name`, `password`) VALUES ('$user_name', '$password')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_get_user_all_current_location($con, $user_id) {
	$query = "SELECT c.* FROM ((" . current_location_full_info . " as c) LEFT JOIN (" . friend_circle_full_info . " as f) ON f.`user_id` = c.`user_id`) LEFT JOIN (" . currentLocationCircleStatus . " as cs) ON cs.`cl_id` = c.`cl_id` WHERE c.`status` = " . valid_status . " AND ((c.`user_id` = '$user_id') OR (c.`see_status` = " . public_status . ") OR (f.status = " . approved_status . " AND ((f.`friend_id` = '$user_id' AND ((c.`see_status` = " . frined_only . ") OR (c.`see_status` = " . circle_base . " AND cs.`circle_id` = f.`circle_id`))))))";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[$rows['cl_id']] = new CurrentLocation($rows['cl_id'], $rows['location_id'], $rows['user_id'], $rows['user_name'], $rows['profile'], $rows['see_status'], $rows['post_time'], $rows['status']);
		$tmp[$rows['cl_id']]->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_get_user_all_current_location_by_id($con, $user_id, $friend_id) {
	$query = "SELECT c.* FROM ((" . current_location_full_info . " as c) LEFT JOIN (" . friend_circle_full_info . " as f) ON f.`user_id` = c.`user_id`) LEFT JOIN (" . currentLocationCircleStatus . " as cs) ON cs.`cl_id` = c.`cl_id` WHERE c.`status` = " . valid_status . " AND c.`user_id` = '$friend_id' AND((c.`user_id` = '$user_id') OR (c.`see_status` = " . public_status . ") OR (f.status = " . approved_status . " AND ((f.`friend_id` = '$user_id' AND ((c.`see_status` = " . frined_only . ") OR (c.`see_status` = " . circle_base . " AND cs.`circle_id` = f.`circle_id`))))))";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = new CurrentLocation($rows['cl_id'], $rows['location_id'], $rows['user_id'], $rows['user_name'], $rows['profile'], $rows['see_status'], $rows['post_time'], $rows['status']);
		$tmp->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_get_user_all_photo($con, $user_id) {
	$query = "SELECT DISTINCT p.* FROM ((" . photo_full_info . " as p) LEFT JOIN (" . friend_circle_full_info . " as f) ON f.`user_id` = p.`user_id`) LEFT JOIN (" . photoCircleStatus . " as ps) ON ps.`post_photo_id` = p.`post_id` WHERE ((p.`user_id` = '$user_id') OR (p.`see_status` = " . public_status . ") OR (f.status = " . approved_status . " AND ((f.`friend_id` = '$user_id' AND ((p.`see_status` = " . frined_only . ") OR (p.`see_status` = " . circle_base . " AND ps.`circle_id` = f.`circle_id`))))))";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[$rows['photo_id']] = new Photo($rows['photo_id'], $rows['photo'], $rows['time'], $rows['location_id'], $rows['caption'], $rows['post_id'], $rows['user_id'], $rows['user_name'], $rows['see_status'], $rows['post_time']);
		$tmp[$rows['photo_id']]->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_get_user_all_photo_by_where($con, $user_id, $where) {
	$query = "SELECT DISTINCT p.* FROM ((" . photo_full_info . " as p) LEFT JOIN (" . friend_circle_full_info . " as f) ON f.`user_id` = p.`user_id`) LEFT JOIN (" . photoCircleStatus . " as ps) ON ps.`post_photo_id` = p.`post_id` LEFT JOIN (" . friend_circle_full_info . " as ff) ON ff.`friend_id` = p.`user_id` WHERE ((p.`user_id` = '$user_id') OR (p.`see_status` = " . public_status . ") OR (f.status = " . approved_status . " AND ((f.`friend_id` = '$user_id' AND ((p.`see_status` = " . frined_only . ") OR (p.`see_status` = " . circle_base . " AND ps.`circle_id` = f.`circle_id`))))))" . $where;
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[$rows['photo_id']] = new Photo($rows['photo_id'], $rows['photo'], $rows['time'], $rows['location_id'], $rows['caption'], $rows['post_id'], $rows['user_id'], $rows['user_name'], $rows['see_status'], $rows['post_time']);
		$tmp[$rows['photo_id']]->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_get_user_all_message($con, $user_id) {
	$query = "SELECT DISTINCT m.* FROM ((" . message_full_info . " as m) LEFT JOIN (" . friend_circle_full_info . " as f) ON f.`user_id` = m.`user_id`) LEFT JOIN (" . messageCircleStatus . " as ms) ON ms.`post_message_id` = m.`post_id` WHERE (m.`user_id` = '$user_id') OR (m.`see_status` = " . public_status . ") OR (f.status = " . approved_status . " AND ((f.`friend_id` = '$user_id' AND ((m.`see_status` = " . frined_only . ") OR (m.`see_status` = " . circle_base . " AND ms.`circle_id` = f.`circle_id`)))))";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[$rows['message_id']] = new Message($rows['message_id'], $rows['text'], $rows['location_id'], $rows['post_id'], $rows['user_id'], $rows['user_name'], $rows['see_status'], $rows['post_time']);
		$tmp[$rows['message_id']]->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}

function db_get_user_all_message_by_where($con, $user_id, $where) {
	$query = "SELECT DISTINCT m.* FROM ((" . message_full_info . " as m) LEFT JOIN (" . friend_circle_full_info . " as f) ON f.`user_id` = m.`user_id`) LEFT JOIN (" . messageCircleStatus . " as ms) ON ms.`post_message_id` = m.`post_id` LEFT JOIN (" . friend_circle_full_info . " as ff) ON ff.`friend_id` = m.`user_id` WHERE ((m.`user_id` = '$user_id') OR (m.`see_status` = " . public_status . ") OR (f.status = " . approved_status . " AND ((f.`friend_id` = '$user_id' AND ((m.`see_status` = " . frined_only . ") OR (m.`see_status` = " . circle_base . " AND ms.`circle_id` = f.`circle_id`))))))" . $where;
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[$rows['message_id']] = new Message($rows['message_id'], $rows['text'], $rows['location_id'], $rows['post_id'], $rows['user_id'], $rows['user_name'], $rows['see_status'], $rows['post_time']);
		$tmp[$rows['message_id']]->setLocation(db_get_location($con, $rows['location_id']));
	}
	return $tmp;
}


?>