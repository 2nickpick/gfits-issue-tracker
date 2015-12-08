<?php include( 'head.php' ); ?>
<?php
	global $currentUser;
	unset($_SESSION['users_id']);
?>

<div class="page-header">
	<h1>Log Out</h1>
</div>

<div class="alert alert-info">
	You have been successfully logged out! You will be redirected to the home page in <span id="seconds-left">3</span> seconds...
</div>

<script type="text/javascript">
	window.onload = function() {
		BackEnd.logOutWait(3);
	};
</script>
<?php include( 'foot.php' ); ?>
