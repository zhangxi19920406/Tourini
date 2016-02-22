<?php
require_once(dirname(dirname(__FILE__)).'/include/include.php');
require_once(dirname(dirname(__FILE__)).'/include/run_session.php');
?>

<!DOCTYPE  html>
<html>
	<?php require_once(dirname(dirname(__FILE__)).'/include/header.php'); ?>
	<body>
		<?php require_once(dirname(dirname(__FILE__)).'/include/background.php'); ?>

		<!-- wrapper -->
		<div class="wrapper">
		
			<?php require_once(dirname(__FILE__).'/navigation_bar.php'); ?>
				
			<!-- content wrap -->	    	
	        <div id="content-wrap">
	        	
	        	<!-- Page wrap -->
	        	<div id="page-wrap">
	        	
	        		<div class="page-title"><h1>Photo</h1></div>
					
					<?php require_once(dirname(__FILE__).'/featured.php'); ?>
					
	        	</div>
	        	<!-- ENDS Page wrap -->
	        	
	        </div>
	        <!-- ENDS content wrap -->
	        
        </div>
		<!-- ENDS Wrapper -->
		
		<?php require_once(dirname(dirname(__FILE__)).'/include/footer_bottom.php'); ?>
	</body>
</html>