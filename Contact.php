<?php
/**
 * Author: Bradley Williams
 * Date: 09/01/2018
 * Description: This file is to allow user feedback via email
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/FileUserViewModel.php");

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
			
			<form name="contactform" method="post" action="send_form_email.php">
			<table width="450px">
				<tr>
					<td valign="top">
						<label for="first_name">First Name *</label>
					</td>
					<td valign="top">
						<input  type="text" class="form-control" name="first_name" maxlength="50" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="last_name">Last Name *</label>
					</td>
					<td valign="top">
						<input  type="text" class="form-control" name="last_name" maxlength="50" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="email">Email Address *</label>
					</td>
					<td valign="top">
						<input  type="text" class="form-control" name="email" maxlength="80" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="telephone">Telephone Number</label>
					</td>
					<td valign="top">
						<input  type="text" class="form-control" name="telephone" maxlength="30" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="comments">Comments *</label>
					</td>
					<td valign="top">
						<textarea  name="comments" class="form-control" maxlength="1000" cols="25" rows="6"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<input type="submit" value="Submit">   <a href="http://www.freecontactform.com/email_form.php">Email Form</a>
					</td>
				</tr>
			</table>
			</form>

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