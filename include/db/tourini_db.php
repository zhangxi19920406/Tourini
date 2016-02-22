
<?php
/*
 *	Filename: tourini_db.php
 *	Path: /include/db/
 *	Last Edit Date: 4-27-2015
 *	Version: 1.0
 *	Copyright @ 2015 Tourini
 *
 *	Database connect and constants
 *
 */
 
 /* all the database functions */
require_once(dirname(__FILE__) . '/account/tourini_db_account.php');
require_once(dirname(dirname(__FILE__)) . '/class/class.php');

require_once(dirname(__FILE__) . '/tourini_db_function.php');

// Connect to the database
function connect_DB() {
	$con = mysql_connect(tourini_db_host, tourini_db_user, tourini_db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db(tourini_db_name,$con);
	return $con;
}

// Close the database
function close_DB($con) {
	mysql_close($con);
}

 /* Database table constant */
define("user", "User");
define("postPhoto", "PostPhoto");
define("postMessage", "PostMessage");
define("photoCircleStatus", "PhotoCircleStatus");
define("photoAdvice", "PhotoAdvice");
define("photo", "Photo");
define("messageCircleStatus", "MessageCircleStatus");
define("messageAdvice", "MessageAdvice");
define("message", "Message");
define("location", "Location");
define("friend", "Friend");
define("currentLocationCircleStatus", "CurrentLocationCircleStatus");
define("currentLocation", "CurrentLocation");
define("circle", "Circle");

/* views */
define("friend_circle_full_info", "friend_circle_full_info");
define("current_location_full_info", "current_location_full_info");
define("photo_full_info", "photo_full_info");
define("message_full_info", "message_full_info");

/* see_status */
define("public_status", "0");
define("frined_only", "1"); /* friend see only */
define("circle_base", "2"); /* based on circle */
define("private_status", "3");

/* current location status */
define("valid_status", "4"); /* newest status */
define("not_valid_status", "5");

/* friend status */
define("approved_status", "6");
define("waiting_status", "7");

define("db_error_msg", "Database access failed: ");


require_once(dirname(__FILE__) . '/tourini_db_user.php');
require_once(dirname(__FILE__) . '/tourini_db_circle.php');
require_once(dirname(__FILE__) . '/tourini_db_friend.php');
require_once(dirname(__FILE__) . '/tourini_db_location.php');
require_once(dirname(__FILE__) . '/tourini_db_advice.php');
require_once(dirname(__FILE__) . '/tourini_db_current_location.php');
require_once(dirname(__FILE__) . '/tourini_db_photo.php');
require_once(dirname(__FILE__) . '/tourini_db_message.php');


?>