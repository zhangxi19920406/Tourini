<?php
echo "this is test";

require_once('include/db/tourini_db.php');

$con = connect_DB();


//$tmp = db_get_location_of_all_friends($con, $user_id);
db_request_friend($con, 1, 14);


close_DB($con);

?>