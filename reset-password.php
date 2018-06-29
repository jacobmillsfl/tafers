<?php
/**
 * Author: Jacob Mills
 * Date: 11/28/2017
 * Description: This page enables users to reset their password
 */


session_start();

include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("Utilities/Mailer.php");
include_once("DAL/User.php");

$errorMessage = "";


$userId = SessionManager::getUserId();
// If the user is not logged in, they should not have access to this page
if ($userId == 0) {
    header("location:/login");
} else {
    $user = new User($userId);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $isValid=true;
    if($_POST["currentPw"]=="")
        $isValid=false;
    if($_POST["newPw"]=="")
        $isValid=false;
    if($_POST["confirmPw"]=="")
        $isValid=false;

    if($isValid==true) {
        $username = $user->getUsername();
        $currentPw = $_POST["currentPw"];
        $newPw = $_POST["newPw"];
        $confirmPw = $_POST["confirmPw"];

        if ($newPw == $confirmPw)
        {
            $isValid = Authentication::authLogin($username,$currentPw);
            if ($isValid) {

                Authentication::updatePassword($userId,$newPw);

                //redirect to account page
                header("location:/account.php");
            }
            else {
                $errorMessage = "The current password field is not correct.";
            }
        }
        else {
            $errorMessage = "The new password fields do not match.";
        }
    }
    else {
        $errorMessage = "All fields are required.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>



<!-- Page Content -->
<section id="SectionName" class="content-section-a">

	<!-- Page Content -->
	<div class="container">
	    <div class="row">
	        <div class="col-lg-12 mb-4 mt-4">
	            <br/><br/>
	            <h3>Reset Password</h3> <small></small>
	            <br/>
	            <?php
	            if ($errorMessage != "")
	            {
	                echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">";
	                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
	                echo "<span aria-hidden=\"true\">&times;</span>";
	                echo "</button>";
	                echo "<strong>Error:</strong> " . $errorMessage;
	                echo "</div>";
	            }
	            ?>


	            <br/>
	            <form name="update" id="updateForm" method="post" validate>

	                <div class="row">
	                    <div class="control-group form-group col-lg-6 ">
	                        <div class="controls">
	                            <strong>Current Password:</strong><span style="color:red;">*</span>
	                            <input type="password" class="form-control" id="currentPw" name="currentPw" required
	                                   data-validation-required-message="Please enter your current password." maxlength="255">
	                        </div>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="control-group form-group col-lg-6 ">
	                        <div class="controls">
	                            <strong>New Password:</strong><span style="color:red;">*</span>
	                            <input type="password" class="form-control" id="newPw" name="newPw" required
	                                   data-validation-required-message="Please enter your new password." maxlength="255">
	                        </div>
	                    </div>
	                </div>
	                <div class="row">

	                    <div class="control-group form-group col-lg-6">
	                        <div class="controls">
	                            <strong>Confirm New Password:</strong><span style="color:red;">*</span>
	                            <input type="password" class="form-control" id="confirmPw" name="confirmPw" required
	                                   data-validation-required-message="Please confirm your new password." maxlength="255">
	                        </div>
	                    </div>
	                </div>
                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class = "text-right">
                            <button type="submit" class="btn btn-success btn-lg btn-block">Reset</button>
                            <br>
                            <a href="account.php" class ="btn btn-primary btn-lg btn-block">Cancel</a>
                        </div>
                    </div>
                  </div>

	            </form>
	        </div>

	    </div>
	    <!-- /.row -->

	</div>
	<!-- /.container -->
    <!-- /.container -->
</section>

<!-- Footer -->
<?php

include('footer.php');

?>

</body>
</html>
