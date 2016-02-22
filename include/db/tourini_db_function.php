<?php

function db_get_now_datetime() {
	$t = getdate();
	$time = ("$t[year]-$t[mon]-$t[mday] $t[hours]:$t[minutes]:$t[seconds]");
	return $time;
}

?>