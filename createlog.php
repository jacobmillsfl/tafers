<?php

session_start();

include_once("DAL/Band.php");
include_once("DAL/Blog.php");
include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("Utilities/Mailer.php");

Authentication::hasGeneralPermission();
$errors= array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = "";
    $userId = SessionManager::getUserId();
    $currentDate = date('Y-m-d H:i:s');
    $bandId = !isset($_POST['project']) ? 0 : $_POST['project'];

    // Validation
    isset($_POST["message"]) && $_POST["message"] != "" ? $message = $_POST["message"] : $message = "";
    if ($message == "") {
        $errors[]="You must enter a message.";
    }

    $validBandId = false;
    $bands = Band::loadall();
    foreach ($bands as $band) {
        if ($band->getId() == $bandId){
            $validBandId = true;
            break;
        }
    }

    if (!$validBandId) {
        $errors[]="Invalid Band ID";
    }

    if (empty($errors))
    {
        $blog = new Blog();
        $blog->setCreatedByUserId($userId);
        $blog->setBandId($bandId);
        $blog->setMessage($message);
        $blog->setCreateDate($currentDate);
        
        // Save to database
        $blog->save();        
        Mailer::sendBlogCreateEmail($userId,$blog->getId());
        header("location: /blog.php?bandId=" . $bandId);
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
        <h1 class="mt-4 mb-3">Band Log
            <small> - Create</small>
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
            <p class="lead" style="text-align: justify;">You are creating a new Band Log! This is a great thing to do after each practice session. Remember to mention what you worked on, accomplishments made, any files that were uploaded or shared, and what the next steps should be for the items you worked on. If a particular song needs to be discussed in detail, be sure to add an entry in the <a href="/musichome.php">Songs</a> section.
            </p>
        </div>
        <div class="row">
            <div class="col-lg-12 ml-auto">
                <form action="createlog.php" method="post">
                    <div class="form-group">
                        <div class="card mt-5">
                            <h5 class="card-header"><label for="message">Message</label>
                            <br/><small>Enter a message below.</small></h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <textarea class="form-control" rows="10" name="message"></textarea>
                                    </div>

                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6" >
                                        <div class="controls">
                                            <label for="project">Project</label>
                                            <br/><small>Please select the Project for this new band log.</small>
                                            <select name="project" id="project" class="form-control" style="height:34px !important;">
                                                <option value="0">--Select Project--</option>
                                                <?php
                                                $categories = Band::loadall();
                                                foreach ($categories as $category) {
                                                    echo "<option value=\"" . $category->getId() . "\">" . $category->getName() . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <br/><br/>
                                        <button type="submit" class="btn btn-primary btn-block float-left">Submit</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <br/><br/>
                                        <a href="/blog.php"><button type="button" class="btn btn-warning btn-block float-left">Cancel</button></a>
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

<!-- Footer -->
<?php

include('footer.php');

?>

</body>
</html>
