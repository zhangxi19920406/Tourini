
<div class="page-title"><h1>Post Photo</h1><?php if ($_POST['photo_submit']) {echo "<span>Post Success!</span>";}?></div>

<!-- side content -->
<div class="featured-posts">

	<h4>Post instruction</h4>
					
					<p>Please select the place and date you take the photo and who can see your photo.If your photo is set to be seen by certain circle, please select those circles. </p>
						<p>If your operating system is windows, please press ctrl to select multiple circles. If it is a Mac, please press command instead.</p>
	

	
	<h2 class="title-divider">Post photo</h2>			
	<!-- form -->
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<form id="poster" action="#" method="post" enctype="multipart/form-data" >
		<fieldset>
			<div>
				<label>locations: </label>
				<select name="location">
					<option value = "" ></option>
					<?php 
					$con = connect_DB();
					$locations = array();
					$locations = db_get_location($con);
					foreach ($locations as $l) {
						echo "<option value='$l->location_id()' id='$l->location_id()'>" . $l->city() . " - " . $l->attraction() . "</option>";
					}
					close_DB($con);
					?>
				</select>
			</div>
			<br/>
			<div>
				<label>see status: </label>
				<select name="status">
					<option value=0 selected ="selected" id="public">public</option>
					<option value=1 id="friend">only friend can see</option>
					<option value=2 id="circle" action="#">certain circle can see</option>
					<option value=3 id="private">private</option>
				</select>
			</div>
			<br/>
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
				
				select a date: <input type="date" name="photo_time" />
			</div>
			<br/>
			
			<div>
				<label>Caption: </label>
				</br>
				<textarea  name="messages"  id="messages" rows="5" cols="20" maxlength="250" class="form-poshytip" title="Enter your comments"></textarea>
			</div>
			
			<br/>
			<div>
				<label>upload photo: </label>
			</div>
			
			<div>
				<input type="file" name="upfile" accept="image/*" />
			</div>
			<br/>
			
			<p><input type="submit" value="Post" name="photo_submit" id="submit" /> <span id="error" class="warning">Photo</span></p>
		</fieldset>
		
	</form>
	
	<?php 
	$con = connect_DB();
	$caption = $_POST['messages'];
	$location_id = $_POST['location'];
	$see_status = $_POST['status'];
	$time = $_POST['photo_time'];
	$circle_id = array();
	$circle_id = $_POST['circle'];
	if ($_POST['photo_submit']) {
		if ($location_id == "") {
			alert("Choose a location!", "jump", "post_photo.php");
		} elseif ($time == "") {
			alert("Select a Time!", "jump", "post_photo.php");
		} elseif ($_FILES['upfile']['name'] == "") {
			alert("Select a Photo!", "jump", "post_photo.php");
		}
		
		$photoname = upload_photo(USERID, $_FILES['upfile']);
		$post_id = db_post_photo($con, USERID, $photoname, $time, $location_id, $caption, $see_status);
		if ($see_status == circle_base) {
			if (count($circle_id) == 0) {
				alert("Choose at lease one circle!", "jump", "post_photo.php");
			}
			foreach ($circle_id as $cid) {
				db_post_photo_circle($con, $post_id, $cid);
			}
		}

	}
	
	close_DB($con);

	?>
	</br>
	<!-- ENDS form -->				
	
</div>
