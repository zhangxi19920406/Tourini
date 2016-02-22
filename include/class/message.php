<?php

class Message {

	var $message_id, $text, $location_id, $post_id, $user_id, $user_name, $see_status, $post_time;
	var $location;

	function __construct($message_id, $text, $location_id, $post_id, $user_id, $user_name, $see_status, $post_time) {
		$this->message_id = $message_id;
		$this->text = $text;
		$this->location_id = $location_id;
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

	function message_id() {
		return $this->message_id;
	}

	function text() {
		return $this->text;
	}

	function location_id() {
		return $this->location_id;
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