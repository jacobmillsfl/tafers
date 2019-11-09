<?php

session_start();

include_once("DAL/Song.php");
include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("Utilities/Mailer.php");

Authentication::hasGeneralPermission();

$errors= array();
$userId = SessionManager::getUserId();

if($_SERVER["REQUEST_METHOD"] == "POST") {

		$songname = $_POST["songname"];
		$songimgurl = $_POST["songimgurl"];
		$songfileurl = $_POST["songfileurl"];
		$songdescription = $_POST["songdescription"];
		$currentDate = date('Y-m-d H:i:s');
		//insert into table

		if ($songimgurl == "") {
				$songimgurl = "https://tafers.net/files/horselogo.png";
		}

		$song = new Song();
		$song->setName($songname);
		$song->setImgUrl($songimgurl);
		$song->setFileUrl($songfileurl);
		$song->setDescription($songdescription);
		$song->setCreateDate($currentDate);
		$song->setCreatedByUserId($userId);
		$song->save();
    
        Mailer::sendSongCreateEmail($userId,$song->getId());

		//direct back to musichome page
		header("location: /musichome.php");

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
			<h1 class="mt-4">Create Song
					<small>- add a new song for tracking feedback</small>
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
        <div class="row mt-lg-5">
            <div class="col-lg-12 ml-auto">
                <form action="createSong.php" method="post" validate>
									<div class="row">
											<div class="control-group form-group col-lg-12">
													<div class="controls">
															<strong>Song Name:</strong><span style="color:red">*</span><small> Enter a name for this song.</small>
															<input type="text" class="form-control" id="songname" name="songname" required
																		 data-validation-required-message="This field is not optional. Don't worry, you can update the name later." maxlength="255">
													</div>
											</div>
											<div class="control-group form-group col-lg-12">
													<div class="controls">
															<strong>Song Image URL:</strong><small> (Optional) If there is an image for this song, provide the URL here. If an image still needs to be uploaded for this song, <a href="/upload.php" target="_blank">upload it here</a>.</small>
															<input type="text" class="form-control" id="songimgurl" name="songimgurl" maxlength="512">
													</div>
											</div>
											<div class="control-group form-group col-lg-12">
													<div class="controls">
															<strong>Song Recording URL:</strong><small> (Optional) If there is a current recording for this song, provide the URL here. If a recording needs to be uploaded for this song, <a href="/upload.php" target="_blank">upload it here</a>.</small>
															<input type="text" class="form-control" id="songfileurl" name="songfileurl" maxlength="512">
													</div>
											</div>

											<div class="control-group form-group col-lg-12 mt-2">
													<div class="controls">
															<strong>Description:</strong>
															<br/><small>Enter a description of this song. This can include song lyrics, style, current instruments, ideas, and etc.</small>
															<textarea rows="10" cols="100" class="form-control" id="songdescription" name="songdescription" maxlength="4096"
																				style="resize:vertical overflow:auto;" ></textarea>
													</div>
											</div>
									</div>
									<div class="row">
										<div class="col-lg-3"></div>
										<div class="col-lg-3"></div>
										<div class="col-lg-3 col-sm-12">
												<div>
														<button type="submit" class="btn btn-success btn-lg btn-block">Create</button>
												</div>
												<br/>
										</div>
										<div class="col-lg-3 col-sm-12">
												<div>
														<a href="musichome.php" class ="btn btn-danger btn-lg btn-block">Cancel</a>
												</div>
												<br/>
										</div>
									</div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
include('footer.php');
?>
</body>
</html>
