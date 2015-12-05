<?php include( 'head.php' ); ?>

<div class="inner">
	<form class="form" onsubmit="FrontEnd.signUp(); return false;" method="post">
		<h2 class="form-heading">Sign Up</h2>

		<div id="errors-container">
			<div class="alert alert-warning">
				<strong>Required Field Missing!</strong>
			</div>
		</div>

		<label for="inputFName" class="sr-only">First Name</label>
		<input type="text" name="inputFName" id="inputFName" class="form-control" placeholder="First Name" required autofocus>
		<label for="inputLName" class="sr-only">Last Name</label>
		<input type="text" name="inputLName" id="inputLName" class="form-control" placeholder="Last Name" required autofocus>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email Address" required autofocus>
		<label for="inputCell" class="sr-only">Cell Phone Number</label>
		<input type="text" name="inputCell" id="inputCell" class="form-control" placeholder="Cell Phone" autofocus>
		<label for="inputCellCarrier" class="sr-only">Cell Phone Carrier</label>
		<select name="inputCellCarrier" id="inputCellCarrier" class="form-control">
			<option value=0 selected>Cell Phone Carrier</option>
			<?php
				$cellPhoneCarriers = CellPhoneCarrier::loadAll();
				foreach($cellPhoneCarriers as $cellPhoneCarrier)
				{
					echo "<option value=" . $cellPhoneCarrier->getId() . ">" . $cellPhoneCarrier->getName() . "</option>";
				}
			?>			
		</select>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
		<label for="inputPasswordConfirm" class="sr-only">Password</label>
		<input type="password" name="inputPasswordConfirm" id="inputPasswordConfirm" class="form-control" placeholder="Confirm Password" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
	</form>
</div> <!-- inner -->
<?php include( 'foot.php' ); ?>
