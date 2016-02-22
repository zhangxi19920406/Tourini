<div class="myframe" id="frame_p">
<ul class="frame-photo-posts">
		<?php 
		$con = connect_DB();
		$photo = db_get_user_all_photo($con, USERID);
		$count = 0;
		if (!($photo == "")) {
			foreach ($photo as $p) {
				$count += 1;
				$photopath;
				if ($p->photo() == "") {
					$photopath = "../img/dummies/290x170.jpg";
				} else {
					$photopath = "../photo/upload_photo/" . $p->user_id() . "/" . $p->photo();
				}
				echo "<li>";
				echo "<a href='../photo/photo.php?photo_id=". $p->photo_id() ."' class='thumb' title='An image'>";
				echo "<img src='" . $photopath . "' alt='Post' style='max-height:170px; max-width:290px;' />";
				echo "</a>";
				echo "</li>";
			}
			close_DB($con);
		}
		?>
</ul>
</div>