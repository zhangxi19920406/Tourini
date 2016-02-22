<!-- side content -->
<div class="featured-posts">

	<?php 
	$con = connect_DB();
	$photo = db_get_photo_by_id($con, $_GET['photo_id']);
	if ($photo == "" || $photo->photo() == "") {
		header("location:../error/not_exist.php");
	}
	$location = db_get_location_by_id($con, $photo->location_id());
 	close_DB($con);
 	$photopath = "../photo/upload_photo/" . $photo->user_id() . "/" . $photo->photo();
 	$id = $_GET['photo_id'];
	?>

	<!-- single -->
	<div class="single-post">
		<div class="post">
			<div class="post-feature-img">
				<img src="<?php echo $photopath;?>" alt="Pic" style='max-height:658px; max-width:940px;' />
			</div>
			<!--<img src="img/feature-post-shadow.png" alt="shadow" />-->
			
			<p id="photo_caption"><?php echo $photo->caption(); ?></p>
			<div class="meta">Posted by <span id="user_name"><?php echo $photo->user_name(); ?></span><u>   in   </u><span id="post_location"><?php echo $location->city() . " - " . $location->attraction(); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="post_time"><?php echo  $photo->post_time();?></span></div>
			
			
			
			
		</div>
			
	</div>	
	<!-- ENDS single -->
						
	<!-- Comments switcher -->
	<h6 class="show-comments">comments <span>click to show</span></h6>
	<div class="comments-switcher">
	
		<!-- comments list -->
		<div id="comments-wrap">
			<ol class="commentlist">
				
				<?php 
				$con = connect_DB();
				$advice = db_get_photo_advice($con, $_GET['photo_id']);
				foreach ($advice as $a) {
				?>

				<li class="comment_lv1" id="li-comment">
					
					<div id="comment-1" class="comment-body clearfix">
						<img alt='' src='http://0.gravatar.com/avatar/4f64c9f81bb0d4ee969aaf7b4a5a6f40?s=35&amp;d=&amp;r=G' class='avatar avatar-35 photo' height='35' width='35' />      
						<div class="comment-author vcard"><?php echo db_get_user_name($con, $a['advisor_id']); ?></div>
						<div class="comment-meta commentmetadata">
							<span class="comment-date">&nbsp;&nbsp;&nbsp; </span>							
						</div>
						<div class="comment-inner">
							<p><?php echo $a['advice']; ?></p>
						</div>
					</div>
			
				</li>

				<?php 
				}
				close_DB($con);
				?>
				
			</ol>

		<div class="clear"></div>
		
		</div>
		<!-- ENDS comments list -->
		
		<!-- Respond -->				
		<div id="respond">
			<h6 class="s-title">Leave a Comment</h6>
			<div class="cancel-comment-reply"><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;">Cancel reply</a></div>
			<form method="post" id="commentform">
				<textarea name="comment" id="comment"  tabindex="4"></textarea>	
				<p><input name="submit" type="submit" id="submit" tabindex="5" value="Post" /></p>
				<?php 
				if ($_POST['submit']) {
					$con = connect_DB();
					if ($_POST['comment'] == "") {
						alert("Please enter something", "jump", "photo.php?photo_id=$id");
					} else {
						db_send_photo_advice($con, $id, USERID, $_POST['comment']);
						header("location:photo.php?photo_id=$id");
					}
					close_DB($con);
				}
				?>

			</form>
		</div>
		<!-- ENDS Respond -->

		
	</div>
	<!-- ENDS Comments switcher -->
	
</div>
<!-- ENDS side content -->