<?php

class Photo {

	var $photo_id, $photo, $time, $location_id, $caption, $post_id, $user_id, $user_name, $see_status, $post_time;
	var $location;

	function __construct($photo_id, $photo, $time, $location_id, $caption, $post_id, $user_id, $user_name, $see_status, $post_time) {
		$this->photo_id = $photo_id;
		$this->photo = $photo;
		$this->time = $time;
		$this->location_id = $location_id;
		$this->caption = $caption;
		$this->post_id = $post_id;
		$this->user_id = $user_id;
		$this->user_name = $user_name;
		$this->see_status = $see_status;
		$this->post_time = $post_time;
	}

	function setLocation($location) {
		$this->location = $location;
	}

	function location() {
		return $this->location;
	}

	function photo_id() {
		return $this->photo_id;
	}

	function photo() {
		return $this->photo;
	}

	function time() {
		return $this->time;
	}

	function location_id() {
		return $this->location_id;
	}

	function caption() {
		return $this->caption;
	}

	function post_id() {
		return $this->post_id;
	}

	function user_id() {
		return $this->user_id;
	}

	function user_name() {
		return $this->user_name;
	}

	function see_status() {
		return $this->see_status;
	}

	function post_time() {
		return $this->post_time;
	}


}


?>