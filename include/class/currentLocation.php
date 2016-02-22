<?php

class CurrentLocation {

	var $cl_id, $location_id, $user_id, $user_name, $profile, $see_status, $post_time, $status;
	var $location;

	function __construct($cl_id, $location_id, $user_id, $user_name, $profile, $see_status, $post_time, $status) {
		$this->cl_id = $cl_id;
		$this->location_id = $location_id;
		$this->user_id = $user_id;
		$this->user_name = $user_name;
		$this->profile = $profile;
		$this->see_status = $see_status;
		$this->post_time = $post_time;
		$this->status = $status;
	}

	function setLocation($location) {
		$this->location = $location;
	}

	function cl_id() {
		return $this->cl_id;
	}

	function location_id() {
		return $this->location_id;
	}

	function location() {
		return $this->location;
	}

	function user_id() {
		return $this->user_id;
	}

	function user_name() {
		return $this->user_name;
	}

	function profile() {
		return $this->profile;
	}

	function see_status() {
		return $this->see_status;
	}

	function post_time() {
		return $this->post_time;
	}

	function status() {
		return $this->status;
	}
}


?>