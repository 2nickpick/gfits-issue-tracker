<?php include( $_SERVER['DOCUMENT_ROOT'] . '/group4/head.php' ); ?>

<div class="inner">
	<form class="form" onsubmit="FrontEnd.signUp(); return false;">
		<h2 class="form-heading">Sign Up</h2>

		<div id="errors-container">
			<div class="alert alert-warning">
				<strong>Required Field Missing!</strong> You must make your password test1234!
			</div>
		</div>

		<label for="inputName" class="sr-only">Name</label>
		<input type="text" id="inputName" class="form-control" placeholder="Name" required autofocus>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
		<label for="inputPasswordConfirm" class="sr-only">Password</label>
		<input type="password" id="inputPasswordConfirm" class="form-control" placeholder="Confirm Password" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
	</form>
</div> <!-- inner -->

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/group4/foot.php' ); ?>
