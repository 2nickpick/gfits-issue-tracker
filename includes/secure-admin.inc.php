<?php

global $currentUser;

//if user is not an admin, kick them out.
if(empty($currentUser) || $currentUser->getTypeId() !== 3) {
	header('Location: /dashboard.php');
	exit();
}

