<?php
/**
 * Author: Jacob Mills
 * Description: This is a blog page
 * Date: 11/29/2017
 */

session_start();
include_once("DAL/Song.php");
include_once("DAL/SongComment.php");
include_once("DAL/SongCommentViewModel.php");
include_once("Utilities/Authentication.php");

Authentication::hasGeneralPermission();

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
            header("location: /song.php?id=" . $songId);
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

<style>
hr {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
    border-top: 1px solid #FFFFFF;
}
a {
    color: #82b440;
    text-decoration: none;
}
.blog-comment::before,
.blog-comment::after,
.blog-comment-form::before,
.blog-comment-form::after{
    content: "";
	display: table;
	clear: both;
}

.blog-comment ul{
	list-style-type: none;
	padding: 0;
}

.blog-comment img{
	opacity: 1;
	filter: Alpha(opacity=100);
	-webkit-border-radius: 4px;
	   -moz-border-radius: 4px;
	  	 -o-border-radius: 4px;
			border-radius: 4px;
}

.blog-comment img.avatar {
	position: relative;
	float: left;
	margin-left: 0;
	margin-top: 0;
	width: 65px;
	height: 65px;
}

.blog-comment .post-comments{
	border: 1px solid #eee;
    margin-bottom: 20px;
    margin-left: 85px;
	margin-right: 0px;
    padding: 10px 20px;
    position: relative;
    -webkit-border-radius: 4px;
       -moz-border-radius: 4px;
       	 -o-border-radius: 4px;
    		border-radius: 4px;
	background: #fff;
	color: #6b6e80;
	position: relative;
}

.blog-comment .meta {
	font-size: 13px;
	color: #aaaaaa;
	padding-bottom: 8px;
	margin-bottom: 10px !important;
	border-bottom: 1px solid #eee;
}

.blog-comment ul.comments ul{
	list-style-type: none;
	padding: 0;
	margin-left: 85px;
}

.blog-comment-form{
	padding-left: 15%;
	padding-right: 15%;
	padding-top: 40px;
}

.blog-comment h3,
.blog-comment-form h3{
	margin-bottom: 40px;
	font-size: 26px;
	line-height: 30px;
	font-weight: 800;
}
</style>
<body>
<?php include('nav.php'); ?>

<!-- Page Content -->
<section id="SongSection" class="content-section-a">

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

            <div class="row">
           		<div class="col-md-12">
           		    <div class="blog-comment">
           				<h3>Comments</h3>
                  <hr/>
           				<ul class="comments">
            <?php

						$songComment = SongComment::search(null,$songId,null,null,null);
            foreach ($songComment as $comment) {
                $commentUserId = $comment->getUserId();
                $user = new User($commentUserId);

                ?>
                <li class="clearfix">
                  <img src="<?php echo $user->getImgUrl(); ?>" class="avatar" alt="">
                  <div class="post-comments">
                      <p class="meta">
                        <?php
                        $formattedDate = strtotime($comment->getCreateDate());
                        echo date('m-d-y @ h:i A',  $formattedDate);
                        ?> <a href="#"><?php echo $user->getUserName(); ?></a> says : <i class="pull-right"><a href="#"><i class="fa fa-thumbs-o-up" style="font-size:1.5em;"></i></a></i></p>
                      <p><?php echo nl2br($comment->getComment()); ?></p>
                  </div>
                </li>
            <?php
            }//end foreach

            ?>
          </ul>
        </div>
      </div>
    </div>



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
            <a href="editSong.php?id=<?php echo $song->getId(); ?>" class ="btn btn-warning btn-lg btn-block"><i class=""></i>Edit Song</a>
            </div>
            <br>
						<div class ="text-center">
						<a href="createSong.php" class ="btn btn-primary btn-lg btn-block"><i class=""></i>Create Song</a>
						</div>
						<br>
						<div class ="text-center">
								<a href="musichome.php" class ="btn btn-success btn-lg btn-block"><i class=""></i>Music Home</a>
						</div>
						<br>
						<!-- Search Widget -->
						<form action="musichome.php" method="GET">
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
</section>
<?php include "footer.php" ?>

</body>
</html>
