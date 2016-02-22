<?php

function upload_photo($user_id, $upfile) { 
	$uptypes = array (
    	'image/jpg',
    	'image/png',
    	'image/jpeg',
    	'image/pjpeg',
    	'image/gif',
    	'image/bmp',
    	'image/x-png'
	);
	$max_file_size = 20000000;
	$destination_folder = dirname(dirname(dirname(__FILE__))) . '/photo/upload_photo/' . $user_id . '/';
	if (is_uploaded_file($upfile['tmp_name'])) {
		//$name = $upfile['name']; 
		$name = time() . "." .  getFileType($upfile['name']);
		$type = $upfile['type']; 
		$size = $upfile['size']; 
		$tmp_name = $upfile['tmp_name'];
		$error = $upfile['error'];
		if ($max_file_size < $size) {
			alert("image to big", "jump", "../../post/post_photo.php");
		}
		if (!in_array($type, $uptypes)) {
	 		alert("not image type: " . $type, "jump", "../../post/post_photo.php");
		}
		if (!file_exists($destination_folder)) {
			mkdir($destination_folder);
		}
		if (move_uploaded_file($upfile["tmp_name"], $destination_folder . $name))
        	return $name;
    }
	
}



?>