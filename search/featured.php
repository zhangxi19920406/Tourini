
<div class="page-title"><h1>search</h1><?php if ($_POST['photo_submit']) {echo "<span>Post Success!</span>";}?></div>

<!-- side content -->
<div class="featured-posts">

		
	<!-- form -->
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<form id="search_form" action="#" method="post" enctype="multipart/form-data" >
		<fieldset>
			<div>
				<label>locations: </label>
				<select name="search_location">
					<option value = "" ></option>
					<?php 
					$con = connect_DB();
					$locations = array();
					$locations = db_get_location($con);
					foreach ($locations as $l) {
						echo "<option value='$l->location_id' id='$l->location_id()'>" . $l->city() . " - " . $l->attraction() . "</option>";
					}
					close_DB($con);
					?>
				</select>
			</div>
			<br/>
			<div>
				<label>social restriction: </label>
				<select name="restriction">
					<option value=0 selected ="selected" id="normal_post">normal</option>
					<option value=1 id="friend_post">post by friend</option>
					<option value=2 id="circle_post" action="#">post in circle</option>
				</select>
			</div>
			<div>
				<label>circles: </label>
				</br>
					<?php 
					$con = connect_DB();
					$circle = array();
					$circle = db_get_all_circle($con, USERID);
					foreach ($circle as $c) {
						echo $c['circle_name'];
						echo "<input type='checkbox' id = 'circle[]' name='circle[]' value = '" . $c['circle_id'] . "'/>";
						echo "<br />";
					}
					close_DB($con);
					?>
				
			</div>
			<br/>
			<div>
				<label>select the search time duration</label><br/>
				start time: <input type="date" name="start_time" /><br/>
				end time: <input type="date" name="end_time"/>
			</div>
			<br/>
			
			<div>
				<label>keyword: </label>
				<input type="text" name="keyword"/>
			</div>
			
			<br/>
			
			<p><input type="submit" value="search photo" name="search_photo" id="search_photo" />
			<p><input type="submit" value="search message" name="search_message" id="search_message" />
		</fieldset>
		
	</form>

	<!-- ENDS form -->	
<hr>	
<div class="featured-posts">	
<div class="mysearch" id="search_p">
<ul class="search-photo-posts">
		<?php 
		function where($pom, $toc) {
			$where = "";
			$loc = $_POST['search_location'];
			$restriction = $_POST['restriction'];
			if (!($loc == "")) {
				$where .= " AND " . $pom . ".`location_id` = " . $loc;
			}
			if ($restriction == 1) {
				$where .= " AND f.`friend_id` = " . USERID;
			} elseif ($restriction == 2) {
				$where .= " AND f.`friend_id` = " . USERID;
				$circle_id = $_POST['circle'];
				if (count($circle_id) == 0) {
					alert("Choose at lease one circle!", "jump", "search.php");
				}
				$first = TRUE;
				foreach ($circle_id as $cid) {
					if ($first) {
						$where .= " AND (ff.`circle_id` = " . $cid;
					} else {
						$where .= " OR ff.`circle_id` = " . $cid;
					}
					$first = FALSE;
				}
				$where .= ")";
			}
			$start_time = $_POST['start_time'];
			echo $start_time;
			if (!($start_time == "")) {
				$where .= " AND DATEDIFF(DATE(" . $pom . ".`post_time`), '" . $start_time . "') >= 0";
			}
			$end_time = $_POST['end_time'];
			if (!($end_time == "")) {
				$where .= " AND DATEDIFF(DATE(" . $pom . ".`post_time`), '" . $end_time . "') <= 0";
			}
			$where .= " AND " . $pom . ".`" . $toc . "` LIKE '%" . $_POST['keyword'] . "%'";
			return $where;
		}
		
		
		if ($_POST['search_photo']) {
			$pom = "p";
			$toc = "caption";
			$where = where($pom, $toc);
			$con = connect_DB();
			$photo = db_get_user_all_photo_by_where($con, USERID, $where);
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
		}
		?>
</ul>
</div>
<div class="mysearch" id="search_m">
<ul class="search-message-posts">

	<?php 
	if ($_POST['search_message']) {
		$pom = "m";
		$toc = "text";
		$where = where($pom, $toc);
		$con = connect_DB();
		$message = db_get_user_all_message_by_where($con, USERID, $where);
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
	}
	?>
</ul>
</div>
</div>
</div>


