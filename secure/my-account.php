<?php
include( 'head.php' );
global $currentUser;

$cell_phone_carrier = CellPhoneCarrier::loadById($currentUser->getCellPhoneCarrierId());

?>

<div class="page-header">
	<h1>My Account</h1>
</div>

<form id="my-account-form" class="form" onsubmit="BackEnd.myAccount(); return false;" enctype="multipart/form-data">

	<div id="errors-container">
		<div class="alert alert-warning">
			<strong>Required Field Missing!</strong>
		</div>
	</div>

	<div id="success-container">
		<div class="alert alert-success">
			<strong>Success!</strong> Your profile was updated successfully!
		</div>
	</div>

	<h3>Profile Picture</h3>
	<?php
	if(!empty($currentUser->getProfilePicture())) {
		$profile_src = '/~group4/images/uploads/' . $currentUser->getProfilePicture();
	} else {
		$profile_src = '/~group4/images/default.png';
	}
	?>
	<a href="/~group4/secure/profile-picture.php"><img class="profile-picture" src="<?php echo $profile_src ?>" /></a><br />
	<a href="/~group4/secure/profile-picture.php">Edit Profile Picture</a>

	<h3>Basic Information</h3>
	<label for="inputFName" class="sr-only">First Name</label>
	<input type="text" id="inputFName" class="form-control" value="<?php echo $currentUser->getFirstName() ?>"
	       placeholder="First Name" required autofocus>
	<label for="inputLName" class="sr-only">Last Name</label>
	<input type="text" id="inputLName" class="form-control" value="<?php echo $currentUser->getLastName() ?>"
	       placeholder="Last Name" required autofocus>
	<label for="inputEmail" class="sr-only">Email address</label>
	<input type="email" id="inputEmail" class="form-control" value="<?php echo $currentUser->getEmailAddress() ?>"
	       placeholder="Email" required>
	<label for="inputCell" class="sr-only">Cell Phone</label>
	<input type="text" id="inputCell" class="form-control" value="<?php echo $currentUser->getPhoneNumber() ?>"
	       placeholder="Phone Number" required>

	<label for="inputCellCarrier">Cell Phone Carrier</label>
	<select name="inputCellCarrier" id="inputCellCarrier" class="form-control">
		<option value="">Cell Phone Carrier</option>
		<?php
		$cellPhoneCarriers = CellPhoneCarrier::loadAll();
		foreach($cellPhoneCarriers as $cellPhoneCarrier)
		{
			$selected = '';
			if($currentUser->getCellPhoneCarrierId() == $cellPhoneCarrier->getId()) {
				$selected = 'selected="selected"';
			}
			echo "<option value=" . $cellPhoneCarrier->getId() . " $selected>" . $cellPhoneCarrier->getName() . "</option>";
		}
		?>
	</select>

	<h3>Password</h3>
	<p>Leave this group blank to keep existing password. </p>
	<label for="inputPassword" class="sr-only">Password</label>
	<input type="password" id="inputPassword" class="form-control" placeholder="Password">
	<label for="inputPasswordConfirm" class="sr-only">Password</label>
	<input type="password" id="inputPasswordConfirm" class="form-control" placeholder="Confirm Password">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Update Profile</button>
</form>

<?php include( 'foot.php' ); ?>
