<div class="myframe" id="frame_m">
<ul class="frame-message-posts">

	<?php 
	$con = connect_DB();
	$message = db_get_user_all_message($con, USERID);
	if ($message != "") {
		$count = 0;
		foreach ($message as $m) {
			$count += 1;
			echo "<li>";
			echo "<div class='heading'>";
			echo "<a href='../message/message.php?message_id=".$m->message_id()."'>";
			echo $m->text() . "</a>";
			echo "</div>";
			echo "</li>";
			echo "<br/>";
		}
		close_DB($con);
	}
	?>
</ul>
</div>