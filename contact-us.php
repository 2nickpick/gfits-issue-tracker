<?php include( 'head.php' ); ?>

<div class="inner">
	<form class="form" onsubmit="FrontEnd.contactUs(); return false;">
		<h2 class="form-heading">Contact Us</h2>

		<div id="errors-container">
			<div class="alert alert-warning">
				<strong>Required Field Missing!</strong> You must make your message longer than 5 characters!
			</div>
		</div>

		<label for="inputName" class="sr-only">Name</label>
		<input type="text" id="inputName" name="name" class="form-control" placeholder="Name" required autofocus>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
		<label for="inputMessage" class="sr-only">Message</label>
		<textarea id="inputMessage" class="form-control" name="message" placeholder="Your Message" required></textarea>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	</form>
</div> <!-- inner -->

<?php include( 'foot.php' ); ?>
