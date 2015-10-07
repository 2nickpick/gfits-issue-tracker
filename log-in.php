<?php include( $_SERVER['DOCUMENT_ROOT'] . '/group4/head.php' ); ?>

<div class="inner">
	<form class="form" onsubmit="FrontEnd.logIn(); return false;">
		<h2 class="form-heading">Log In</h2>

		<div id="errors-container">
			<div class="alert alert-warning">
				<strong>Incorrect Username or Password!</strong> The password is test1234!
			</div>
		</div>

		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
	</form>
</div> <!-- inner -->

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/group4/foot.php' ); ?>
