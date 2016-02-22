<!-- side content -->
<div id= "side-content">

<?php $msg = "Success!"?>
	
	<h2 class="title-divider">change password</h2>			
	<!-- form to change password-->
	<div>
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<form id="chpassword" action="#" method="post">
		<div>
			<label>input your old password: </label>
			<input name="oldpassword" type = "password" id="oldpassword"/>
			</br>
			<label>input your new password: </label>
			<input name="newpassword" type = "password" id="newpassword"/>
			</br>
			<label>confirm your new password: </label>
			<input name="newpassword2" type = "password" id="oldpassword"/>
			</br>
			<p><input name="submit_password" type = "submit" id="submit_password" value = "confirm"/></p>

		</div>
		
	<?php
	$con = connect_DB();
	$old_password = $_POST['oldpassword'];
	$new_password = $_POST['newpassword'];
	$new_password2 = $_POST['newpassword2'];
	if ($_POST['submit_password']) {
		if (!db_check_password($con, USERID, $old_password)) {
			alert("Password not correct!", "jump", "manage_pm.php");
		} elseif ($new_password == "") {
			alert("Enter new password!", "jump", "manage_pm.php");
		} elseif (!($new_password == $new_password2)) {
			alert("Password not match!", "jump", "manage_pm.php");
		} else {
			db_update_password($con, USERID, $new_password);
			header("location:manage_pm.php?pc=$msg");
		}
	}
	$pc = $_GET['pc'];
	echo $pc;
	close_DB($con);
	?>
	
	</form>
	
	</div>
	<!-- ENDS form change password-->
	</br>
	
	<h2 class="title-divider">change profile</h2>			
	<!-- form to alter profile-->
	<div>
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<form id="chprofile" action="#" method="post">
		<div>
			<label>change your profile here: </label>
			</br>
			<textarea  name="profile"  id="profile" rows="5" cols="20" class="form-poshytip" title="Change your profile" placeholder = "The old profile"><?php $con = connect_DB();	echo db_get_profile($con, USERID); close_DB($con); ?></textarea>
			</br>
			<p><input name="submit_profile" type = "submit" id="submit_profile" value = "confirm"/></p>

		</div>
		
	<?php
	$con = connect_DB();
	$profile = $_POST['profile'];
	if ($_POST['submit_profile']) {
		db_update_profile($con, USERID, $profile);
		header("location:manage_pm.php?mc=$msg");
	}
	$mc = $_GET['mc'];
	echo $mc;
	close_DB($con);
	?>
		
	</form>
	</div>
	<!-- ENDS form alter profile-->
	</br>
	
	<h2 class="title-divider">publish current location</h2>			
	<!-- form to change password-->
	<div>
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<form id="publish_location" action="#" method="post">
		<fieldset>
		<div>
			<label>locations: </label>
			<select name="location">
				<option value = "" ></option>
				<?php 
				$con = connect_DB();
				$locations = array();
				$locations = db_get_location($con);
				$cl = db_get_current_location_by_publisher_newest($con, USERID);
				$cl_id;
				if (!($cl == "")) {
					$cl_id = db_get_current_location_by_publisher_newest($con, USERID)->location_id();
				}
				foreach ($locations as $l) {
					echo "<option ";
					if ($l->location_id == $cl_id) {
						echo "selected ='selected' ";
					}
					echo "value='$l->location_id()' id='$l->location_id()'>" . $l->city() . " - " . $l->attraction() . "</option>";
				}
				close_DB($con);
				?>
			</select>
		</div>
		<br/>
		<div>
			<label>see status: </label>
			<select name="status">
				<option value=0 id="public" selected ="selected">public</option>
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
		<p><input type="submit" value="post" name="publish_location" id="publish_location" /></p>
		</fieldset>
	
	<?php 
	$con = connect_DB();
	$location_id = $_POST['location'];
	$see_status = $_POST['status'];
	$circle_id = array();
	$circle_id = $_POST['circle'];
	if ($_POST['publish_location']) {
		if ($location_id == "") {
			alert("Choose a location!", "jump", "manage_pm.php");
		}
		$post_id = db_post_current_location($con, USERID, $location_id, $see_status);
		if ($see_status == circle_base) {
			if (count($circle_id) == 0) {
				alert("Choose at lease one circle!", "jump", "manage_pm.php");
			}
			foreach ($circle_id as $cid) {
				db_post_current_location_circle($con, $post_id, $cid);
			}
		}
		header("location:manage_pm.php?tc=$msg");
	}
	$tc = $_GET['tc'];
	echo $tc;
	close_DB($con);
	?>
	</form>
	</div>
	<!-- ENDS form change password-->
				
	
</div>
<!-- ENDS side content -->

<?php require_once(dirname(__FILE__).'/sidebar.php'); ?>			

<div class="clear"></div>


