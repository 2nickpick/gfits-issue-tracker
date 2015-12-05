<?php include( 'head.php' ); 
      include( 'db.php' );

// Connect to server and select database.
mysql_connect("$host", "$u", "$p")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// mysql
$sql="select * from tCellPhoneCarrier";	   
$result=mysql_query($sql);

// close connection
mysql_close();

?>

<div class="inner">
	<form class="form" action="process_registration.php" method="post">
		<h2 class="form-heading">Sign Up</h2>

		<div id="errors-container">
			<div class="alert alert-warning">
				<strong>Required Field Missing!</strong> You must make your password test1234!
			</div>
			<?php
				$error = $_GET['error'];
			
				if($error == 1)
					echo "<br><b>Passwords do not match. Please re-enter.</b>";
			?>			
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
				while($row = mysql_fetch_row($result))
				{
					$CellPhoneCarrierID = $row[0];
					$CellPhoneCarrierName = $row[1];
					echo "<option value=$CellPhoneCarrierID>$CellPhoneCarrierName</option>";
				}
			?>			
		<select>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
		<label for="inputPasswordConfirm" class="sr-only">Password</label>
		<input type="password" name="inputPasswordConfirm" id="inputPasswordConfirm" class="form-control" placeholder="Confirm Password" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
	</form>
</div> <!-- inner -->
<?php include( 'foot.php' ); ?>
