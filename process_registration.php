<?php

include "db.php";

$firstName = $_POST['inputFName'];
$lastName = $_POST['inputLName'];
$emailAddr = $_POST['inputEmail'];
$cellPhone = $_POST['inputCell'];
$cellCarrier = $_POST['inputCellCarrier'];

$password = $_POST['inputPassword']; //**
$passwordConfirm = $_POST['inputPasswordConfirm'];

if ($password != $passwordConfirm)
	header("Location: sign-up.php?error=1");
else
{
	// Connect to server and select database.
	mysql_connect("$host", "$u", "$p")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");
	
	$cellPhone = str_replace('-', '', $cellPhone); //replace dashes from phone number
	$cellPhone = str_replace('(', '', $cellPhone); //replace open paren from phone number
	$cellPhone = str_replace(')', '', $cellPhone); //replace close paren from phone number
	$cellPhone = str_replace(' ', '', $cellPhone); //replace spaces from phone number

	// Insert data
	$sql="INSERT INTO tUser (FirstName, LastName, EmailAddress, PhoneNumber, CellPhoneCarrierID)
		  VALUES ('$firstName','$lastName','$emailAddr','$cellPhone',$cellCarrier)";
	$result=mysql_query($sql);
	
	// Get user Id I just inserted
	$sql1="select max(UserID) from tUser where EmailAddress='$emailAddr'";	   
	$result1=mysql_query($sql1);
	
	while($row = mysql_fetch_row($result1))
	{
		$UserId = $row[0];
	}
	
	// Insert login from registration
	$sql2="INSERT INTO tLogin (UserID, TypeID, Passwd)
		  VALUES ($UserId, 1, '$password')";
	$result2=mysql_query($sql2);
	
	// Get cell phone carrier email domain, if present
	$sql3="select CellPhoneCarrierEmailDom from tCellPhoneCarrier where CellPhoneCarrierID=$cellCarrier";
	$result3=mysql_query($sql3);
	
	while($row = mysql_fetch_row($result3))
	{
		$CellPhoneCarrierEmailDom = $row[0];
	}
	
	// close connection
	mysql_close();

	// email and text a welcome message
		
		$subject = "Thank You for Registering with GFITS!";

		$msg_body = "<html><head></head><body>";
		$msg_body .= "<font face=\"Verdana\" size=\"2\"><p>Thank you for registering with GFITS! ";
		$msg_body .= "We are confident that you will enjoy your user experience on our web site.</p>";
		$msg_body .= "<p>Below is your registration information:</p>";

		$msg_body .= "<div style=\"width:400px;padding:5px;border-style:solid;border-color:#333333;border-width:0.5px;\">";
		$msg_body .= "<b>Name:</b> $firstName $lastName<br>";
		$msg_body .= "<b>Email:</b>  <a href=\"mailto:$emailAddr\">$emailAddr</a><br>";
		$msg_body .= "<b>Cell Phone:</b>  $cellPhone<br>";
		$msg_body .= "<b>Cell Phone Carrier:</b>  $cellCarrier</div>";

		$msg_body .= "<p>Please remember to vote for us!</p>";
		$msg_body .= "</font></body></html>";

		// required header info
		$header_info = "MIME-Version: 1.0\r\n";
		$header_info .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$header_info .= "From: GFITS <cici.carter@gmail.com>";

		// send the message via email
		mail($emailAddr, $subject, $msg_body, $header_info);


		// Send a text to phone, if info was provided
		if ($CellPhoneCarrierEmailDom != "" && $cellPhone != "")
		{
			$cell_email = $cellPhone . "@" . $CellPhoneCarrierEmailDom;
			$subject = "Thank you for registering!";

			$msg_body = "Thank you for registering with GFITS!\r\n";
			$msg_body .= "We are confident that you will enjoy your user experience on our web site.\r\n";
			$msg_body .= "\r\nBelow is your registration information:\r\n";

			$msg_body .= "Name: $firstName $lastName\r\n";
			$msg_body .= "Email: $emailAddr\r\n";
			$msg_body .= "Cell Phone:  $cellPhone\r\n";
			$msg_body .= "Cell Phone Carrier:  $cellCarrier\r\n";

			$msg_body .= "\r\nPlease remember to vote for us!\r\n";

			$header_info = "MIME-Version: 1.0\r\n";
			$header_info .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$header_info .= "From: cici.carter@gmail.com";
			mail($cell_email, $subject, $msg_body, $header_info);		
		}
	
	/////////////////////////////////////
	
	header("Location: log-in.php");
}	
?>