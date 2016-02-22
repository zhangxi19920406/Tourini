<a href="../home/home.php"><img  id="logo" src="../img/logo.png" alt="Tourini"></a>

<!-- nav bar holder -->
<div id="nav-bar-holder">
	<!-- Navigation -->
	<ul id="nav" class="sf-menu">
		<li><a href="../home/home.php">Home</a></li>
		<li><a href="../search/search.php">search</a></li>
		<li><a href="../post/post_photo.php">Post Photo</a></li>
		<li><a href="../post/post_message.php">Post Message</a></li>
		<li><a href="../manage/manage.php">Manage</a></li>
		<li><a href="../login/logout.php">logout</a></li>
		<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome!
		<?php
		$con = connect_db();
		$User_name = db_get_user_name($con,USERID);
		echo $User_name;
		?>
		</li>
	
	</ul>
	<!-- ENDS Navigation -->
	
</div>
<!-- ENDS nav bar holder -->