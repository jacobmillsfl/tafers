<?php
session_start();
include_once("Utilities/SessionManager.php");
include_once("DAL/User.php");
include_once("DAL/FileUserViewModel.php");
include_once("DAL/UserStatsViewModel.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$userId = SessionManager::getUserId();

// If the user is not logged in, they should not have access to this page
if ($userId == 0)
{
    header("location:/login.php");
}
else{
    $user = new User($userId);
}


$UserStats = new UserStatsViewModel();
$UserStats->loadUserStats($userId);

?>



<!DOCTYPE html>
<html lang="en">
<?php include "head.php" ?>
<body>
<?php include "nav.php" ?>

<!-- Page Content -->
<div class="container mt-5">
	<br>
    <div class="row">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="activity-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Activity Feed</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#friends" role="tab" aria-controls="friends" aria-selected="false">Friends</a>
  </li>
	<li class="nav-item">
    <a class="nav-link" id="pictures-tab" data-toggle="tab" href="#pictures" role="tab" aria-controls="pictures" aria-selected="false">Pictures</a>
  </li>
</ul>
</div>
<div class="row">
<div class="tab-content" id="myTabContent" style="width:100%;padding:1em;">
  <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		<div class="col-lg-12 mt-5">
      <div class="row">
				<div class="col-lg-12 col-sm-6">
					<div class="row">
						<div class="col-lg-3 col-sm-6 mb-4">
								<div>
										<?php
										echo "<img class=\"img-responsive \" src=\"" . $user->getImgUrl() . "\" alt=\"avatar\" style=\"max-height:255px;max-width:100%;\" />";
										?>
								</div>
						</div>

            <div class="col-lg-3 col-sm-6 mb-4">
              <div class="row">
                  <?php
                  echo "<h2>" . $user->getUsername() . "</h2>"
                  ?>
              </div>
              <div class="row">
                  <?php
                  echo "<p><a href='mailto:" . $user->getEmail() . "'>" . $user->getEmail() . "</a></p>";
                  ?>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12 mb-4">
              <div class="row" style="font-family: Courier New;">
                <div class="col-sm-12"><label>Reputation:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $UserStats->getTotalStatPoints(); ?></div>
                <div class="col-sm-12"><label>Files Uploaded:</label>&nbsp;<?php echo $UserStats->getTotalStatPoints(); ?></div>
                <div class="col-sm-12"><label>Songs Created:</label>&nbsp;&nbsp;<?php echo $UserStats->getSongsUploaded(); ?></div>
                <div class="col-sm-12"><label>Song Comments:</label>&nbsp;&nbsp;<?php echo $UserStats->getSongComments(); ?></div>
                <div class="col-sm-12"><label>Tasks Created:</label>&nbsp;&nbsp;<?php echo $UserStats->getTasksCreated(); ?></div>
                <div class="col-sm-12"><label>Tasks Closed:</label>&nbsp;&nbsp;&nbsp;<?php echo $UserStats->getTasksClosed(); ?></div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
    						<div class = "text-right">
    								<a href="edit-user.php" class ="btn btn-info btn-lg btn-block">Edit Profile</a>
    								<br><br>
    								<a href="reset-password.php" class ="btn btn-warning btn-lg btn-block">Reset Password</a>
    						</div>
    				</div>
					</div>
				</div>
      </div>
      <div class="row">

     </div>
		</div>
	</div>
  <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">Coming soon...</div>
  <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
		<div class="mt-5">
			<div class="col-lg-12">
			<?php
			 $userlist = User::loadall();
			 foreach($userlist as $useritem)
			 {
			 ?>
			 <div class="" style="display:inline-block;width:10em; margin:auto;">
					 <img style="max-height: 50px;max-width: 50px;" class="d-flex mr-3 rounded-circle blogComment" src="<?php echo $useritem->getImgUrl(); ?>" alt="Icon">
					 <p style="margin-bottom:0px;"><?php echo $useritem->getUsername(); ?></p>
			 </div>

			<?php
			}
			 ?>
	</div>
 </div>
	</div>
  <div class="tab-pane fade" id="pictures" role="tabpanel" aria-labelledby="pictures-tab">

		<?php

			$viewmodel = FileUserViewModel::loadGallery();
      $columnNumber = 0;
			foreach($viewmodel as $file)
			{
						if ($file->getIsPublic() == 0 || $file->getUserId() != $userId) {
							continue;
						}

						if ($columnNumber == 0) {
								?>
								<div class="row mt-4">
										<div class="col-lg-12 ml-auto">
											<div class="row card-deck">
								<?php
						}
					?>

					<div class="card col-lg-3">
						<div class="card-body">
							<a href="<?php echo $_SERVER['REQUEST_SCHEME'] . "://". $_SERVER['SERVER_NAME'] . "/files/". $file->getFileName(); ?>" target="_blank">
							<img class="card-img-top" src="<?php echo $_SERVER['REQUEST_SCHEME'] . "://". $_SERVER['SERVER_NAME'] . "/files/". $file->getFileName(); ?>" alt="<?php echo $file->getFileName(); ?>">
							</a>
						</div>
					</div>

		 <?php
					 $columnNumber = $columnNumber + 1;
					 if ($columnNumber >= 4) {
			           $columnNumber = 0;
							 ?>
									 </div>
								 </div>
							 </div>
							 <?php
					 }
			}
		 ?>
	</div>
</div>
    </div>
    <!-- /.row -->
		<br><br>
</div>
<!-- /.container -->
<?php include "footer.php" ?>
</body>
</html>
