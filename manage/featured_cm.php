<!-- side content -->
<div id= "side-content">

	<h2 class="title-divider">create new circle</h2>
	<!-- form to manage friends-->
	<div>
	<?php 
	$sent = "Create Success!!";
	$del = "Delete Success!";
	echo $_GET['msg'];
	?>
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<form id="create_circle" action="#" method="post">
		<span>input the name of the new circle</span><br/>
		<input type="text" id="circle_name" name="circle_name" />
		<input type="submit" id = "submit_create" name="submit_create" value="create" />
	</form>
	
	<?php 
	if ($_POST['submit_create']) {
		$circle_name = $_POST['circle_name'];
		$con = connect_DB();
		if (db_check_circle_exist($con, USERID, $circle_name)) {
			alert("circle exist!", "jump", "manage_cm.php");
		} elseif ($circle_name == "") {
			alert("Enter a circle name!", "jump", "manage_cm.php");
		} else {
			db_new_circle($con, USERID, $circle_name);
		}
		close_DB($con);
		header("location:manage_cm.php?msg=$sent");
	}
	
	?>
	
	
	</div>
	<hr />
	<br/>
	
	<h2 class="title-divider">manage your circles</h2>				
	<!-- form to manage friends-->
	<div>
	<?php echo $_GET['msg2']; ?>
	<script type="text/javascript" src="../js/form-validation.js"></script>
	<form id="manage_cir" action="#" method="post">
		<fieldset>
		<table name="circle_list" id="circle_list">
			<tr>
				<th>circle name</th>
			<!--<th>time </th>-->
				<th>option</th>
			</tr>
			<?php 
			$con = connect_DB();
			$circle = db_get_all_circle($con, USERID);
			$count = 0;
			foreach ($circle as $c) {
				$count += 1;
				echo "<tr>";
				echo "<input value = '" . $c['circle_id'] . "' name = 'circle_id" . $count . "' type='hidden' />";
				echo "<td>" . $c['circle_name'] . "</td>";
				echo "<td>";
				echo "<input type = 'submit' name='delete" . $count . "' value = 'delete' action='#'/>";
				echo "</td>";
				echo "</tr>";
			}
			
			for ($tmp_c = 1;$tmp_c <= $count; $tmp_c++) {
				if ($_POST['delete' . $tmp_c]) {
					db_delete_circle($con, USERID, $_POST['circle_id' . $tmp_c]);
					header("location:manage_cm.php?msg2=$del");
				}
			
			}
			
			
			?>
		</table>
		<br/>
		<br/>
		</fieldset>
	</form>
	</div>
	<!-- ENDS form to manage friend-->
				
	
</div>
<!-- ENDS side content -->


<?php require_once(dirname(__FILE__).'/sidebar.php'); ?>			

<div class="clear"></div>