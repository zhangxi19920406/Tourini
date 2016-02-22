<?php

function db_new_location($con, $longitude, $latitude, $city, $attraction) {
	$query = "INSERT INTO " . location . " (`longitude`, `latitude`, `city`, `attraction`) VALUES ('$longitude', '$latitude', '$city', '$attraction')";
	$result = mysql_query($query, $con);
	$result || die(db_error_msg . mysql_error());
}

function db_get_location($con) {
	$query = "SELECT * FROM " . location;
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp = array();
	while ($rows = mysql_fetch_array($result)) {
		$tmp[$rows['location_id']] = new Location($rows['location_id'], $rows['longitude'], $rows['latitude'], $rows['city'], $rows['attraction']);
	}
	return $tmp;
}

function db_get_location_by_id($con, $location_id) {
	$query = "SELECT * FROM " . location . " WHERE `location_id` = '$location_id'";
	$result = mysql_query($query, $con);
	$result || die("Database access failed: ".mysql_error());
	$tmp;
	while ($rows = mysql_fetch_array($result)) {
		$tmp = new Location($rows['location_id'], $rows['longitude'], $rows['latitude'], $rows['city'], $rows['attraction']);
	}
	return $tmp;
}

?>