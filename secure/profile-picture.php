<?php
include( 'head.php' );
global $currentUser;


$errors = array();

if(@$_POST['verb'] == 'update-profile-picture') {

	require_once('../../vendor/picture-cut/src/php/core/PictureCut.php');
	$pictureCut = PictureCut::createSingleton();

	if(empty($currentUser)) {
		$errors[] = "You must be logged in to perform this action.";
	}

	$user = null;
	if(empty($_POST['users_id'])) {
		$errors[] = "User ID was not provided.";
	} else {
		$user = User::loadById($_POST['users_id']);
		if(empty($user)) {
			$errors[] = "User could not be found: " . $_POST['users_id'];
		}
	}

	if(empty($pictureCut)) {
		$errors[] = "Error occurred uploading picture.";
	}

	if(empty($errors)) {
		try {
			if($pictureCut->upload()){
				$user->setProfilePicture($pictureCut->getFileNewName());
				$user->update();
				print $pictureCut->toJson();
			} else {
				$errors[] = $pictureCut->exceptionsToJson();
			}

		} catch (Exception $e) {
			$errors[] = $e->getMessage();
		}
	}

}
?>

<div class="page-header">
	<h1>Update Profile Picture</h1>
	<a href="/~group4/secure/my-account.php">&laquo; Back to My Account</a>
</div>

<form id="profile-picture-form" class="form" action="/~group4/secure/ajax/update-profile-picture.php" enctype="multipart/form-data">

	<?php
	if(@$_POST['verb'] == 'update-profile-picture') {
		if(!empty($errors)) {
			?>
			<div id="errors-container">
				<div class="alert alert-warning">
					<?php implode("\n", $errors); ?>
				</div>
			</div>
			<?php
		} else {
			?>
			<div id="success-container">
				<div class="alert alert-success">
					<strong>Success!</strong> Your profile was updated successfully!
				</div>
			</div>
			<?php
		}
	}
	?>


	<h3>Profile Picture</h3>
	<p>Click Profile Picture to select a new image</p>
	<?php
	if(!empty($currentUser->getProfilePicture())) {
		$profile_src = '/~group4/images/uploads/' . $currentUser->getProfilePicture();
	} else {
		$profile_src = '/~group4/images/default.png';
	}
	?>
	<label for="inputName" class="sr-only">Name</label>
	<div id="container_image"></div>
	<br />

	<script>
		window.onload = function() {
			jQuery("#container_image").PictureCut({
				InputOfImageDirectory       : "profile-picture",
				PluginFolderOnServer        : "/~group4/vendor/picture-cut/",
				FolderOnServer              : "/~group4/images/uploads/",
				EnableCrop                  : false,
				ActionToSubmitUpload        : "/~group4/secure/ajax/update-profile-picture.php",
				DefaultImageButton          : "<?php echo $profile_src ?>"
			});
		};
	</script>
<?php include( 'foot.php' ); ?>
