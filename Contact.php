<?php
/**
 * Author: Bradley Williams
 * Date: 09/01/2018
 * Description: This file is to allow user feedback via email
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/FileUserViewModel.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'C:\Users\Bradley\vendor\autoload.php';

$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if(isset($_POST["submit"]))
{
	if(empty($_POST["name"]))
	{
		$error .= '<p><label class="text-danger">Please enter your name</label</p>';
	}
	else
	{
		$name = clean_text($_POST["name"]);
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
		{
			$error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
		}
	}
	if(empty($_POST["email"]))
	{
		$error .= '<p><label class="text-danger">Please enter your email</label></p>';
	}
	else
	{
		$email = clean_text($_POST["email"]);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error .= '<p><label class="text-danger">Invalid email format</label></p>';
		}
	}
	if(empty($_POST["subject"]))
	{
		$error .= '<p><label class="text-danger">Subject is required</label></p>';
	}
	else
	{
		$subject = clean_text($_POST["subject"]);
	}
	if(empty($_POST["message"]))
	{
		$error .= '<p><label class="text-danger">Message is required</label></p>';
	}
	else
	{
		$message = clean_text($_POST["message"]);
	}
	if($error != '')
	{
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/SMTP.php';
		require 'PHPMailer/src/OAuth.php';
		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->SMTPDebug = 2;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "brad@tafers.net";
		$mail->Password = "Typical#7";
		$mail->From = $_POST["email"];
		$mail->FromName = $_POST["name"];
		$mail->AddAddress('info@tafers.net', 'Name');
		$mail->AddCC($_POST["email"], $_POST["name"]);
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject = $_POST["subject"];
		$mail->Body = $_POST["message"];
		if($mail->Send())
		{
			$error = '<label class="text-success">Thank you for contacting us</label>';
		}
		else
		{
			$error = '<label class="text-danger">There is an error</label>';
		}
		$name = '';
		$emal = '';
		$subject = '';
		$message = '';
	}
}

?>


<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>



<!-- Page Content -->
<section id="Contact" class="content-section-a">


    <div class="container">
	
	    <h1 class="mt-4 mb-3">Contact
            <small>- share your thoughts with us</small>
		</h1>
			
        <div class="row">
            <div class="col-lg-12 ml-auto">
			<?php echo $error; ?>
			<form method="post">
				<div class="form-group">
					<label>Enter Name</label>
					<input type="text" name="name" placeholder="Enter Name" class="form-control" value="<?php echo $name; ?>" />
				</div>
				<div class="form-group">
					<label>Enter Email</label>
					<input type="text" name="email" placeholder="Enter Email" class="form-control" value="<?php echo $email; ?>" />
				</div>
				<div class="form-group">
					<label>Enter Subject</label>
					<input type="text" name="subject" placeholder="Enter Subject" class="form-control" value="<?php echo $subject; ?>" />
				</div>
				<div class="form-group">
					<label>Enter Message</label>
					<textarea name="message" placeholder="Enter Message" class="form-control"><?php echo $message; ?></textarea>
				</div>
				<div class="form-group" align="center">
					<input type="submit" name="submit" value="Submit" class="btn btn-info />
				</div>
			

            </div>
        </div>

    </div>
    <!-- /.container -->
</section>

<!-- Footer -->
<?php

include('footer.php');

?>

</body>
</html>