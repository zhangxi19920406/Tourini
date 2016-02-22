<!-- side content -->
<div id= "side-content">

	<h2 class="title-divider">add new friend</h2>
	<!-- form to manage friends-->
	<div>
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<?php 
	$sent = "Sent Success! OR ALREADY FRIEND!";
	$add = "Change Success!";
	echo $_GET['msg'];
	?>
	<form id="add_friend" action="#" method="post">
		<span>input the friend name and send the request</span><br/>
		<input type="text" id="friend_name" name="friend_name" />
		<input type="submit" id = "submit_req" name="submit_req" value="send" />
	</form>
	<?php 
	if ($_POST['submit_req']) {
		$friend_name = $_POST['friend_name'];
		$con = connect_DB();
		if (!db_check_user_name_exist($con, $friend_name)) {
			alert("Username not exist!", "jump", "manage_avf.php");
		} elseif ($friend_name == db_get_user_name($con, USERID)) {
			alert("You are sanding to yourself!", "jump", "manage_avf.php");
		} else {
			db_request_friend($con, USERID, db_get_user_id($con, $friend_name));
		}
		close_DB($con);
		header("location:manage_avf.php?msg=$sent");
	}
	
	?>
	</div>
	<hr />
	<br/>
	
	<h2 class="title-divider">manage friend request</h2>				
	<!-- form to manage friends-->
	<div>
	<?php echo $_GET['msg2']; ?>
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<form id="manage_req" action="#" method="post">
		<fieldset>
		<table name="friend_req_list" id="friend_req_list">
			<tr>
				<th>who sent request</th>
				<th>profile</th>
				<th>request time </th>
				<th>option</th>
			</tr>
			<?php 
			$con = connect_DB();
			$friend = db_get_waitint_friends($con, USERID);
			$count = 0;
			foreach ($friend as $f) {
				$count += 1;
				echo "<tr>";
				echo "<input value = '" . $f['id'] . "' name = 'friend_id" . $count . "' type='hidden' />";
				echo "<td>" . db_get_user_name($con, $f['user_id']) . "</td>";
				$profile = db_get_profile($con,  $f['user_id']);
				echo "<td>" . $profile . "</td>";
				echo "<td>" . $f['request_time'] . "</td>";
				echo "<td>";
				echo "<input type = 'submit' name='accept" . $count . "' value = 'accept' action='#'/>";
				echo "<input type = 'submit' name='decline" . $count . "' value = 'decline' action='#'/>";
				echo "</td>";
				echo "</tr>";
			}
			
			for ($tmp_c = 1;$tmp_c <= $count; $tmp_c++) {
				if ($_POST['accept' . $tmp_c]) {
					db_verify_friend($con, $_POST['friend_id' . $tmp_c]);
					header("location:manage_avf.php?msg2=$add");
				}
			
				if ($_POST['decline' . $tmp_c]) {
					db_delete_friend($con, $_POST['friend_id' . $tmp_c]);
					header("location:manage_avf.php?msg2=$add");
				}
			
			}
			
			
			?>
		</table>
		<br/>
		<br/>
		<p><input type = "submit" name="delete_all" value = "decline all" action="#"/>
			<input type = "submit" name="delete_expire" value = "decline requests before a week or more" action="#"/>
		</p>
		<?php 
		if ($_POST['delete_all']) {
			db_delete_waiting_friends($con, USERID);
			header("location:manage_avf.php?msg2=$add");
		}
		if ($_POST['delete_expire']) {
			db_delete_waiting_friend_according_time($con, USERID, 7);
			header("location:manage_avf.php?msg2=$add");
		}
		?>
		</fieldset>
	</form>
	</div>
	<!-- ENDS form to manage friend-->
				
	
</div>
<!-- ENDS side content -->

<?php require_once(dirname(__FILE__).'/sidebar.php'); ?>			

<div class="clear"></div>