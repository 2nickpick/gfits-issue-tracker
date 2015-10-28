<?php include( 'head.php' ); ?>
<?php global $currentUser; ?>

<?php

if ( empty( $_GET['users_id'] ) ) {
	?>
	<div class="alert alert-danger">
		User was not found! <a href="/~group4/secure/users.php">Back to Users</a>
	</div>
	<?php
} else {
	$user = User::loadById( $_GET['users_id'] );
	?>
	<div class="page-header">
		<h1>
			Edit User: <?php echo $user->getFirstName() . ' ' . $user->getLastName() ?>
		</h1>
	</div>
	<div class="col-sm-2 col-sm-offset-10">
		<input class="form-control btn btn-danger" type="button" value="Delete User"
		       onclick="BackEnd.deleteUser(); return false;"/>
	</div>

	<div id="errors-container">
		<div class="alert alert-warning">
			<strong>Required Field Missing!</strong> Your message is too short! Make it longer to show success!
		</div>
	</div>

	<div id="success-container">
		<div class="alert alert-success">
			<strong>Success!</strong> We have received your ticket and a support specialist will respond shortly!
		</div>
	</div>

	<form id="edit-user-form" class="form" onsubmit="BackEnd.updateUser(); return false;"
	      enctype="multipart/form-data">

		<input type="hidden" id="hiddenUsersId" name="users_id" value="<?php echo $user->getId() ?>"/>

		<div class="col-sm-6">
			<?php
			if(!empty($user->getProfilePicture())) {
				$profile_src = '/~group4/images/uploads/' . $user->getProfilePicture();
			} else {
				$profile_src = '/~group4/images/default.png';
			}
			?>
			<div id="profile-picture-container" data-src="<?php echo $profile_src ?>"></div>
		</div>
		<div class="col-sm-6">
			<label for="inputFirstName">First Name</label>
			<input type="text" id="inputFirstName" name="first_name" class="form-control"
			       value="<?php echo $user->getFirstName() ?>">
		</div>
		<div class="col-sm-6">
			<label for="inputLastName">Last Name</label>
			<input type="text" id="inputLastName" name="last_name" class="form-control"
			       value="<?php echo $user->getLastName() ?>">
		</div>
		<div class="col-sm-6">
			<label for="inputEmailAddress">Email Address</label>
			<input type="text" id="inputEmailAddress" name="email_address" class="form-control"
			       value="<?php echo $user->getEmailAddress() ?>">
		</div>
		<div class="col-sm-6">
			<label for="inputPhoneNumber">Phone Number</label>
			<input type="text" id="inputPhoneNumber" name="phone_number" class="form-control"
			       value="<?php echo $user->getPhoneNumber() ?>">
		</div>
		<div class="col-sm-6">
			<?php
			if ( $currentUser->getTypeId() == 3 ) {
				?>
				<label for="selectLoginType">Role</label>
				<select id="selectLoginType" name="type_id" class="form-control">
					<option value="">Select a role...</option>
					<?php
					$roles = array(
						'SUBSCRIBER' => 1,
						'STAFF'      => 2,
						'ADMIN'      => 3
					);
					if ( ! empty( $roles ) ) {
						foreach ( $roles as $role_name => $role_id ) {
							$selected = '';
							if ( $user->getTypeId() == $role_id ) {
								$selected = 'selected="selected"';
							}
							?>
							<option value="<?php echo $role_id ?>" <?php echo $selected ?>>
								<?php echo $role_name ?>
							</option>
							<?php
						}
					}
					?>
				</select>
				<?php
			}
			?>
		</div>
		<div class="col-sm-6">
			<label for="selectPhoneCarrier">Phone Carrier</label>
			<select id="selectPhoneCarrier" name="cell_phone_carrier_id" class="form-control">
				<option value="">Select a carrier...</option>
				<?php
				$phone_carriers = CellPhoneCarrier::loadAll();
				if ( ! empty( $phone_carriers ) ) {
					foreach ( $phone_carriers as $phone_carrier ) {
						$selected = '';
						if ( $user->getCellPhoneCarrierId() == $phone_carrier->getId() ) {
							$selected = 'selected="selected"';
						}
						?>
						<option value="<?php echo $phone_carrier->getId() ?>" <?php echo $selected ?>>
							<?php echo $phone_carrier->getName() ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</div>

		<div class="col-sm-6">
			<label for="inputPassword">Password</label>
			<input class="form-control" type="password" name="password" value="" id="inputPassword"/>
		</div>

		<div class="col-sm-6">
			<label for="inputPasswordAgain">Password Again</label>
			<input class="form-control" type="password" name="password_again" value="" id="inputPasswordAgain"/>
		</div>

		<div class="col-sm-12">
			<input class="form-control btn btn-primary" type="submit" value="Save User"/>
		</div>
		</div>
	</form>
	<?php
}

?>
<?php include( 'foot.php' ); ?>
