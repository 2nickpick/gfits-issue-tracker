<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="GFITS - Group Four Issue Tracking System">
	<meta name="keywords" content="issue tracking, customer service">
	<meta name="author" content="University of North Florida, Internet Programming Group Four, Fall 2015">

	<title>GFITS - Group Four Issue Tracking System</title>

	<!-- Bootstrap core CSS -->
	<link href="/~group4/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Project-specific CSS -->
	<link href="/~group4/vendor/animate.css" rel="stylesheet">
	<link rel="stylesheet" href="/~group4/css/style.css" />
	<link rel="stylesheet" href="/~group4/css/backend.css"/>

	<!-- Favicons -->
	<link rel="icon" href="/~group4/favicon.ico">

</head>
<body>

	<!-- Fixed navbar -->
	<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
				        aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/~group4/secure/dashboard.php">GFITS</a>
				<p class="navbar-text">Welcome back, <span class="username">Tester</span>!</p>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="new-ticket btn btn-success">
						<a href="/~group4/secure/add-ticket.php">
							<span class="glyphicon glyphicon-plus"></span> New Ticket
						</a>
					</li>
					<li role="separator" class="divider"></li>
					<li><a href="/~group4/secure/my-account.php">My Account</a></li>
					<li><a href="/~group4/secure/log-out.php">Log Out</a></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container theme-showcase" role="main">
