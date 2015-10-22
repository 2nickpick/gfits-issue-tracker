<?php

global $currentUser;

if(empty($currentUser)) {
	header('Location: /log-in.php');
	exit();
}

