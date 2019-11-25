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


Authentication::hasGeneralPermission();

$userId = SessionManager::getUserId();
$roleId = SessionManager::getUserRoleId();

if ($roleId != 2)
{
    header("location:/index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>

<!-- Page Content -->
<section id="Admin" class="content-section-a">

    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Administration
            <small></small>
        </h1>
		<br/>
		<div class="row mt-4">
			<div class="col-md-8">
				<div class="row">
				<div class="col-lg-12"><h5>Current Users</h5></div></div>
							<table class="table table-striped dont-break-out">
							  <thead>
							    <tr>
							      <th scope="col" style="width:50%;">User</th>
								  <th scope="col" style="width:20%;">RoleId</th>
								  <th scope="col" style="width:30%;"><a href="editAdmin.php"><button type=\"button\" class=\"btn btn-primary\">Update</button></a></th>
                    <th scope="col" style="width:20%;"></th>
							    </tr>
							  </thead>
							  <tbody>
                <?php

                if (isset($_GET['content'])) {
                    $content = htmlspecialchars($_GET["content"]);
                } else {
								    $content = null;
                }

                $viewmodel = User::loadall();

                foreach($viewmodel as $item)
                {
										echo "<tr>";
										echo "<td>". $item->getUsername() . "</td>";
										echo "<td>". $item->getRoleId() . "</td";
										echo "<td>"."</td>";
										echo "<td>"."</td>";
										echo "<td>"."</td>";										
										echo "</tr>";
                }
                ?>

							</tbody>
						</table>
		
			</div>


						                <!-- Categories Widget -->
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
												<?php echo $item->getId();?> &nbsp; <?php echo $item->getName(); ?>
											</div>
											<?php
											}
											?>
									</div>
								</div>
							</div>			
					</div>

					
		</div>

    </div>



</section>		
		<?php
include('footer.php');
?>
</body>
</html>