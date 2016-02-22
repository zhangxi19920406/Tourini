<!-- side content -->
<div id= "side-content">

	<h2 class="title-divider">manage your friends in certain circle</h2>
					
	<!-- form to manage friends-->
	<div>
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<?php 
	$msg = "Change Success!";
	$del = "Delete Success!";
	echo $_GET['msg'];
	?>
	<form id="friend_manage" action="#" method="post">
		<fieldset>
		<table name="friend_list" id="friend_list">
			<tr>
				<th>friend name</th>
				<th>friend profile</th>
				<th>current location</th>
				<th>belong to circle:</th>
				<th>option</th>
			</tr>
			
			<?php 
			$con = connect_DB();
			$friend = db_get_approved_friends($con, USERID);
			$count = 0;
			foreach ($friend as $f) {
				$count += 1;
				echo "<tr>";
				echo "<input value = '" . $f['id'] . "' name = 'friend_id" . $count . "' type='hidden' />";
				echo "<td>" . $f['friend_name'] . "</td>";
				$profile = db_get_profile($con,  $f['friend_id']);
				echo "<td>" . $profile . "</td>";
				echo "<td>;";
				$current_location = db_get_user_all_current_location_by_id($con, USERID, $f['friend_id']);
				if (!($current_location == "")){
					$location = db_get_location_by_id($con, $current_location->location_id());
					echo $location->city() . " - " . $location->attraction();
				}
				echo "</td>";
				echo "<td>";
				echo "<select name = 'circle" . $count . "'>";
				echo "<option value = 'null'></option>";
				$circle = db_get_all_circle($con, USERID);
				foreach ($circle as $c) {
					echo "<option ";
					if ($c['circle_id'] == $f[circle_id])
						echo "selected='selected' ";
					echo "value = '" . $c['circle_id'] . "'>" . $c['circle_name'] . "</option>";
				}
				echo "</td>";
				echo "<td>";
				echo "<input type = 'submit' name='update" . $count . "' value = 'update' action='#'/>";
				echo "<input type = 'submit' name='delete" . $count . "' value = 'delete' action='#'/>";
				echo "</td>";
				echo "</tr>";
				
			}
			
			for ($tmp_c = 1;$tmp_c <= $count; $tmp_c++) {
				if ($_POST['update' . $tmp_c]) {
					if ($_POST['circle' . $tmp_c] == 'null') {
						db_delete_friend_from_circle($con, $_POST['friend_id' . $tmp_c]);
						header("location:manage_fm.php?msg=$msg");
					} else {
						db_add_friend_into_circle($con, $_POST['friend_id' . $tmp_c], $_POST['circle' . $tmp_c]);
						header("location:manage_fm.php?msg=$msg");
					}
				}
				
				if ($_POST['delete' . $tmp_c]) {
					db_delete_friend($con, $_POST['friend_id' . $tmp_c]);
					header("location:manage_fm.php?msg=$del");
				}

			}
			close_DB($con);
			?>
			
		</table>
		</fieldset>
	</form>
	</div>
	<!-- ENDS form to manage friend-->
				
	
</div>
<!-- ENDS side content -->

<?php require_once(dirname(__FILE__).'/sidebar.php'); ?>			

<div class="clear"></div>