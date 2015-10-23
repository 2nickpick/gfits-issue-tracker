<?php

global $currentUser;

if(empty($currentUser)) {
	header('Location: /~group4/log-in.php');
	exit();
}

