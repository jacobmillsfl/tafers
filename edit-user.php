<?php
/**
 * Author: Jacob Mills
 * Date: 10/16/2017
 * Description:
 */

session_start();

include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("Utilities/Mailer.php");
include_once("DAL/User.php");

$errorMessage = "";
$userId = SessionManager::getUserId();

// If the user is not logged in, they should not have access to this page
if ($userId == 0)
{
    header("location:/login.php");
}
else{
    $user = new User($userId);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = strip_tags($_POST["email"]);
    $imgUrl = strip_tags($_POST["imgUrl"]);


    if ($imgUrl == "") {
        $imgUrl = "/images/missing.png";
    }
		if ($email == "") {
			$errorMessage = "An email address is required";
		}
    else if ($user == null) {
        // Something went wrong while attempting to create this user
        $errorMessage = "An error occurred while updating this user account. Please try again. If the problem continues, contact TAFer support at mail@tafers.net";
    }
    else {
				$user->setImgUrl($imgUrl);
				$user->setEmail($email);
				$user->save();

        // Redirect to account page
        header("location: /account.php");
    }

}

?>






<!DOCTYPE html>
<html lang="en">
    <?php include "head.php" ?>
    <body>
        <?php include "nav.php" ?>

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4 mt-4">
                    <br/><br/>
                    <h3>Edit User</h3>
                    <br/>
                    <?php
                    if ($errorMessage != "")
                    {
                        echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">";
                        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
                        echo "<span aria-hidden=\"true\">&times;</span>";
                        echo "</button>";
                        echo "<strong>Error</strong> " . $errorMessage;
                        echo "</div>";
                    }
                    ?>

                    <br/>
                    <form name="register" id="registerForm" method="post" validate>
                        <div class="row">
                            <div class="control-group form-group col-lg-6 ">
                                <div class="controls">
                                    <h3><?php echo $user->getUsername(); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="control-group form-group col-lg-6 ">
                                <div class="controls">
                                    <strong>Email Address:</strong><span style="color:red;">*</span>
                                    <br/><small>Please enter your email address</small>
                                    <input type="email" class="form-control" id="email" name="email" required
                                           data-validation-required-message="Please enter your email address." maxlength="255" value="<?php echo $user->getEmail(); ?>">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="control-group form-group col-lg-6 ">
                                <div class="controls">
                                    <strong>User Avatar:</strong>
                                    <br/><small>Please enter the URL of an image to associate with your profile</small>
                                    <input type="text" class="form-control" id="imgUrl" name="imgUrl" maxlength="511" value="<?php echo $user->getImgUrl(); ?>">
                                </div>
                            </div>
                        </div>
												<div class="row">
													<div class="col-lg-3 col-sm-12">
							    						<div class = "text-right">
							    								<button type="submit" class="btn btn-success btn-lg btn-block">Update</button>
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

        <?php include "footer.php" ?>
    </body>
</html>
