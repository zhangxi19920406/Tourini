<?php

class Location {

	var $location_id, $longitude, $latitude, $city, $attraction;

	function __construct($location_id, $longitude, $latitude, $city, $attraction) {
		$this->location_id = $location_id;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->city = $city;
		$this->attraction = $attraction;
	}

	function location_id() {
		return $this->location_id;
	}

	function longitude() {
		return $this->longitude;
	}

	function latitude() {
		return $this->latitude;
	}

	function city() {
		return $this->city;
	}

	function attraction() {
		return $this->attraction;
	}
}


?>