<?php
/**
 * Author: Jacob Mills
 * Date: 03/16/2018
 * Description: This file is a basic template for pages on the site
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("Utilities/Mailer.php");
include_once("DAL/Band.php");
include_once("DAL/Blog.php");
include_once("DAL/BlogComment.php");
include_once("DAL/BlogHomeViewModel.php");
include_once("DAL/BlogCommentViewModel.php");

Authentication::hasGeneralPermission();
$userId = SessionManager::getUserId();
$bandId = null;
$pageNum = 1;

if (isset($_GET['bandId'])) {
    $bandId = htmlspecialchars($_GET["bandId"]);
	if ($bandId < 1) {
		$bandId = null;
	}
}

if (isset($_GET['page'])) {
    $pageNum = htmlspecialchars($_GET["page"]);// This handles the offset for paging
	if ($pageNum < 1) {
		$pageNum = 1;
	}
}

$errors= array();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["SubmitComment"])) //Check if Submit (comment) button was clicked
    {
        $returnVal = true;
        isset($_POST["Comment"]) && $_POST["Comment"] != "" ? $comment = $_POST["Comment"] : $returnVal = false;    //check that textarea is not empty
        isset($_POST["BlogId"]) ? $targetBlogId = $_POST["BlogId"] : $returnVal = false;
        if($returnVal){
            $currentDate = date('Y-m-d H:i:s');

            $blogComment = new BlogComment();
            $blogComment->setBlogId($targetBlogId);
            $blogComment->setCreatedByUserId($userId);
            $blogComment->setCreateDate($currentDate);
            $blogComment->setMessage($comment);     
            $blogComment->save();
            Mailer::sendBlogCommentEmail($userId,$blogComment->getId());
            header("location: /blog.php?bandId=" . $bandId);
        }
        else{
            $errorMessage = "Enter a comment.";
            $errors[] = $errorMessage;
        }

    }

}


?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<script>
   $(document).on('click', ".thumb", function() {
       console.log($(this).parent().find(".like-count").text());
       var likecounter = $(this).parent().find(".like-count");
       var count = parseInt(likecounter.text(),10);
       
        if($(this).css('color') == 'rgb(0, 0, 255)') {            
            $(this).css('color','');
            count -=1;
        } else {
            $(this).css('color','rgb(0, 0, 255)');
            count +=1;
        }
       
       likecounter.text(count);

            
       $.ajax({
            type: "POST",
            url: '/API.php',
            data: {
                method: "BlogLike",
                blogId: $(this).attr('blogid')
            },
            dataType : 'json',
            /*success : function(data) {              
                alert('Data: '+data);
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }*/
        });
    });

</script>
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
<section id="FileHome" class="content-section-a">

    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Band Log
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
        <div class="row">
            <div class="col-md-8">
                <?php if ($bandId == 0) { ?>
                <p class="lead" style="text-align: justify;">Welcome to the Band Log page! Currently, there are TAFers working on music in different locations and at different times. This page is essentially a centralized whiteboard for us to note what we've been working on so the other TAF's know where we left off. It is intended to store notes and conversations regarding recent band practices. Ideally, this page should be updated after each practice, jam, and recording session, regardless of whether it was one person or the entire crew. Relevant information includes what was worked on, progress that was made, any challenges that came up, and what the next goals for that project should be. If a more detailed conversion about a particular song is needed, you should probably use the <a href="/musichome.php">Songs</a> page instead.<br/><br/>Try to keep this page as a general overview of how a practice session went. Click a <b>Project</b> to get started!</p>
                <?php } else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="blog-comment">
                            <h3><?php $band = new Band($bandId); echo $band->getName(); ?></h3>
                      <hr/>
                            <ul class="comments">
                <?php
                    $blogposts = BlogHomeViewModel::loadBlogHome($bandId,$pageNum);
                    foreach ($blogposts as $blogpost) {
                        ?>
                        <li class="clearfix">
                          <img src="<?php echo $blogpost->getBlogUserImgUrl(); ?>" class="avatar" alt="">
                          <div class="post-comments">
                              <p class="meta">
                                <?php
                                $formattedDate = strtotime($blogpost->getBlogCreateDate());
                                echo date('m-d-y @ h:i A',  $formattedDate);
                                ?> <a href="#"><?php echo $blogpost->getBlogCreatedByUsername(); ?></a> says : <i class="pull-right" style=""><i class="like-count-holder"><i class="like-count"><?php echo $blogpost->getBlogLikeCount(); ?></i> likes <i blogid="<?php echo $blogpost->getBlogId(); ?>" class="thumb fa fa-thumbs-o-up" style="font-size:1.5em; cursor:pointer;<?php if ($blogpost->getBlogLiked() > 0){ echo "color:rgb(0, 0, 255)"; } ?>"></i></i></i></p>
                              <p><?php echo nl2br($blogpost->getBlogMessage()); ?></p>
                              <br/>
                              <hr>
                              <?php 
                                // This needs to be a viewmodel minimally to include user data
                                $comments = BlogCommentViewModel::loadBlogCommentViewModel($blogpost->getBlogId());
                                foreach ($comments as $comment) {
                                    ?>
                              <!-- sub comments -->
                                  <img src="<?php echo $comment->getBlogCommentImgUrl(); ?>" class="avatar" alt="">
                                  <div class="post-comments">
                                      <p class="meta">
                                        <?php
                                        $formattedDate = strtotime($comment->getBlogCommentDate());
                                        echo date('m-d-y @ h:i A',  $formattedDate);
                                        ?> <a href="#"><?php echo $comment->getBlogCommentUsername(); ?></a> replied :</p>
                                  <p><?php echo nl2br($comment->getBlogCommentMessage()); ?></p>
                                  </div>
                              <?php
                                }
                                $btnReplyID = "BtnReply" . $blogpost->getBlogId();
                                $divReplyID = "DivReply" . $blogpost->getBlogId();
                              ?>
                              
                              <button id="<?php echo $btnReplyID; ?>" type="button" class="btn btn-light" onclick="$('#<?php echo $divReplyID; ?>').show();$('#<?php echo $btnReplyID; ?>').hide();">Reply</button>
                              <div id="<?php echo $divReplyID; ?>" class="card my-4" style="display: none;">
                                <h5 class="card-header">Response:</h5>
                                <div class="card-body">
                                    <form method = "post">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" name="Comment"></textarea>
                                        </div>
                                        <input type="hidden" name="BlogId" value="<?php echo $blogpost->getBlogId();?>">
                                        <button type="submit" class="btn btn-success" name="SubmitComment">Submit</button>
                                        <button type="button" class="btn btn-warning" name="Cancel" onclick="$('#<?php echo $btnReplyID; ?>').show();$('#<?php echo $divReplyID; ?>').hide();">Cancel</button>
                                    </form>
                                </div>
                              </div>
                          
                              
                              
                          </div>
                        </li>
                    <?php
                    }//end foreach
                ?>
              </ul>
            </div>
          </div>
        </div>

            
            
                <ul class="pagination justify-content-center mb-4">
					<li class="page-item">
                        <?php
							if ($pageNum < 2) {
								echo "<a class=\"page-link disabled\" style=\"cursor:not-allowed;\">Newer &rarr;</a>";	
							} else {
								echo "<a class=\"page-link\" href=\"?bandId=" . $bandId . "&page=" . ($pageNum - 1) . " \">Newer &rarr;</a>";	
							}
												
						?>
                    </li>
                    <li class="page-item">
						<?php
							echo "<a class=\"page-link\" href=\"?bandId=" . $bandId . "&page=" . ($pageNum + 1) . " \">Older &rarr;</a>";						
						?>
                        
                    </li>
                </ul>
                <?php } ?>

            </div>

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4 mt-lg-5">
                <br><br>
                <div class ="text-center">
                    <a href="createlog.php" class ="btn btn-primary btn-lg btn-block"><i class=""></i>Add Entry</a>
                </div>
                <br>
                <div class ="text-center">
                    <a href="blog.php" class ="btn btn-success btn-lg btn-block"><i class=""></i>Blog Home</a>
                </div>
                <br>

                <!-- Categories Widget -->
                <div class="card my-4">
                    <h5 class="card-header">Projects</h5>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $BandList = Band::loadall();
                            foreach ($BandList as $band){
                                ?>
                                <div class="col-lg-6">
                                    <a href="blog.php?bandId=<?php echo $band->getId(); ?>"><?php echo $band->getName(); ?></a>
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
