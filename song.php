<?php
/**
 * Author: Jacob Mills
 * Description: This is a blog page
 * Date: 11/29/2017
 */

 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

session_start();
include_once("DAL/Song.php");
include_once("DAL/SongComment.php");
include_once("DAL/SongCommentViewModel.php");
include_once("Utilities/Authentication.php");

$userId = SessionManager::getUserId();


$songId = 0;

if (isset($_GET['id'])) {
    $songId = htmlspecialchars($_GET["id"]);
}

$song = new Song($songId);

// Check to ensure a song has been loaded
if($song->getId() < 1)
{
    header("location:/musichome.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["SubmitComment"])) //Check if Submit (comment) button was clicked
    {
        $returnVal = true;
        isset($_POST["Comment"]) && $_POST["Comment"] != "" ? $comment = $_POST["Comment"] : $returnVal = false;    //check that textarea is not empty
        if($returnVal){
            $currentDate = date('Y-m-d H:i:s');

            $newComment = new SongComment();
            $newComment->setSongId($songId);
            $newComment->setComment($comment);
            $newComment->setCreateDate($currentDate);
            $newComment->setUserId($userId);
            $newComment->save();
        }
        else{
            $errorMessage = "Enter a comment.";
        }

    }

}

?>

<!DOCTYPE html>
<html lang="es">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">TAF
        <small>Song</small>
    </h1>

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">
					<div class="row">

<div class="col-lg-4">

            <!-- Preview Image -->
            <?php
            echo "<img class=\"img-fluid rounded\" src=\"". $song->getImgUrl() ."\" alt=\"songImage\">";
            ?>

</div>
<div class="col-lg-8">
            <!-- Date/Time -->
            <?php
						echo "<h3>" . $song->getName() . "</h3>";
            $date = new DateTime($song->getCreateDate());
            echo "<p>Posted on " . $date->format('l, F d y h:i:s') . "</p>";

						if ($song->getFileUrl() != "") {
							echo "<p><a href=\"" . $song->getFileUrl() . "\">Link to recording</a><p>";
						}

            ?>
						<hr>
						<p>

                <?php
                echo nl2br($song->getDescription());
                ?>
            </p>
</div>
            <hr>

					</div>
            <hr>
            <?php

						$songComment = SongComment::search(null,$songId,null,null,null);
            foreach ($songComment as $comment) {
                $commentUserId = $comment->getUserId();
                $user = new User($commentUserId);

                ?>
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="<?php echo $user->getImgUrl(); ?>" alt="UserIcon" style="max-height: 50px;max-width: 50px;">
                    <div class="media-body">

                        <h5 class="mt-0"><?php echo $user->getUsername(); ?> </h5>
                        <small class="float-right">
                            <?php
                            $date = new DateTime($comment->getCreateDate());
                            echo " Posted on " . $date->format('l, F d y h:i:s') ;
                            ?>
                        </small>
                        <br>
                        <?php echo nl2br($comment->getComment());?>
                    </div>
                </div>
								<hr>
            <?php
            }//end foreach

            ?>
						<!-- Comments Form -->
            <?php if($userId > 0): ?>
                <?php
                if (isset($errorMessage) && $errorMessage != "")
                {
                    echo "<div class=\"alert alert-danger\">" . $errorMessage . "</div>";
                }
                ?>
                <div class="card my-4">
                    <h5 class="card-header">Leave a Comment:</h5>
                    <div class="card-body">
                        <form method = "post">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="Comment"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="SubmitComment">Submit</button>
                        </form>
                    </div>
                </div>
            <?php endif ?>


        </div>
				<!-- Sidebar Widgets Column -->
				<div class="col-md-4 mt-4">
						<div class ="text-center">
						<a href="createSong.php" class ="btn btn-primary btn-lg btn-block"><i class=""></i>Create Song</a>
						</div>
						<br>
						<div class ="text-center">
								<a href="musichome.php" class ="btn btn-success btn-lg btn-block"><i class=""></i>Music Home</a>
						</div>
						<br>
						<!-- Search Widget -->
						<form action="songhome.php" method="GET">
								<div class="card mb-4">
										<h5 class="card-header">Search</h5>
										<div class="card-body">
												<div class="input-group">
														<input type="text" name="content" class="form-control" placeholder="Search for...">
														<span class="input-group-btn">
													<button class="btn btn-secondary" type="submit">Go!</button>
												</span>
												</div>
										</div>
								</div>
						</form>
				</div>

    </div>

</div><!-- /.container -->

<?php include "footer.php" ?>

</body>
</html>
