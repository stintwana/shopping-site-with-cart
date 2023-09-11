<?php

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$thankyou_page = "ThankYou.php";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$name = strip_tags($_POST['name']) ;
$email= strip_tags($_POST['email']) ;
$telephone = strip_tags($_POST['telephone']) ;
$comment = strip_tags($_POST['comment'] );



$msg =  
"Name: " . $name . "\r\n" . 
"Email: " . $email . "\r\n" . 
"Telephone: " . $telephone ."\r\n".
"Comment: " . $comment ."\r\n" ;
/*
This bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "tebogomoroka@yyahoo.com, $email";
/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
	mail( "$webmaster_email", "You've Been Contacted ", $msg );

	header( "Location: $thankyou_page" );

?>