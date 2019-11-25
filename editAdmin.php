<?php
/**
 * Author: Bradley Williams
 * Date: 11/23/2019
 * Description: This file is an administration tool for editing user role IDs
 */

session_start();

include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("DAL/User.php");
include_once("DAL/Role.php");

$errorMessage = "";

Authentication::hasGeneralPermission();

$userId = SessionManager::getUserId();
$roleId = SessionManager::getUserRoleId();

if ($roleId != 2)
{
    header("location:/index.php");
}


$errors= array();


if($_SERVER["REQUEST_METHOD"] == "POST") {
	

		$id = $_POST["Id"];
		$newroleid = $_POST["NewRoleId"];

    if ($id == "") {
        $errorMessage = "A user is required";
    }
		if ($newroleid == "") {
			$errorMessage = "A role ID is required";
		}

    else {
				$user = new User($id);
				$user->setRoleId($newroleid);
				$user->save();

        // Redirect to account page
        header("location: /admin.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>

<!-- Page Content -->
<section id="Upload" class="content-section-b">

    <div class="container">
		</br>
        <h1 class="mt-4 mb-3">Edit User Role
            <small></small>
        </h1>

        <?php
        if(empty($errors)==false){
            foreach($errors as $err){
                echo "<div class=\"row\">";
                echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\" style=\"width:100%;\">";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
                echo "<span aria-hidden=\"true\">&times;</span>";
                echo "</button>";
                echo "<strong>Error</strong> " . $err;
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
        <div class="row" style="width:308%;">
					<div class="col-md-4 mt-lg-5">		
							<div class="card my-4">
								<h5 class="card-header">Role Descriptions</h5>
								<div class="card-body">
									<div class="row">
									<?php
										$viewmodel = Role::loadall();
										foreach ($viewmodel as $item){
											?>
											<div class="col-lg-6">
												<?php echo $item->getId();?> &nbsp;&nbsp;&nbsp; <?php echo $item->getName(); ?> &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp; <?php echo $item->getDescription(); ?>
											</div>
											<?php
											}
											?>
									</div>
								</div>
							</div>			
					</div>
        </div>
        <div class="row">
            <div class="col-lg-12 ml-auto">
                <form action="editAdmin.php" method="post">
                    <div class="form-group">
                        <div class="card mt-5">
                            <h5 class="card-header"><label for="NewRoleId">Select User and Enter Role</label>
                            <br/><small>Enter Role ID below:</small></h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <textarea class="form-control" rows="1" name="NewRoleId" style="width:10%;"></textarea>
                                    </div>

                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6" >
                                        <div class="controls">
                                            <label for="project">User account</label>
                                            <br/><small>Please select the user account you want to edit</small>
                                            <select name="Id" id="Id" class="form-control" style="height:34px !important;">
                                                <option value="0">--Select User--</option>
                                                <?php
                                                $categories = User::loadall();
                                                foreach ($categories as $category) {
                                                    echo "<option value=\"" . $category->getId() . "\">" . $category->getUsername() . "</option>";
                                                }
                                                ?>
                                            </select>
											<?php $editUser = $category;?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <br/><br/>
                                        <button type="submit" class="btn btn-primary btn-block float-left" name="SubmitRoleId">Submit</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <br/><br/>
                                        <a href="/admin.php"><button type="button" class="btn btn-warning btn-block float-left">Cancel</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <br/><br/><br/><br/>
                    <?php if (empty($errors)==false): ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Errors</h3><br/>
                                <?php
                                    echo "<ol>";
                                    foreach ($errors as $error)
                                    {
                                        echo "<li>" . $error . "</li>";
                                    }
                                    echo "</ol>";
                                ?>
                            </div>
                        </div>
                    <?php endif ?>

                </form>
            </div>
        </div>

    </div>
    <!-- /.container -->
</section>	


        <?php include "footer.php" ?>
</body>
</html>
