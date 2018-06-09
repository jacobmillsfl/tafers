<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once("DAL/ToDoItem.php");
include_once("DAL/ToDoPriority.php");
include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");

Authentication::checkFilePermissions();

$errors= array();
$userId = SessionManager::getUserId();

if($_SERVER["REQUEST_METHOD"] == "POST") {

		$title = $_POST["itemtitle"];
		$summary = $_POST["itemcontent"];
		$priorityId = $_POST["itemPriorityId"];
		$currentDate = date('Y-m-d H:i:s');
		//insert into table

		$item = new ToDoItem();
		$item->setPriorityId($priorityId);
		$item->setTitle($title);
		$item->setCreateDate($currentDate);
		$item->setSummary($summary);
		$item->setCreatedByUserId($userId);
		$item->save();

		//direct back to bloghome page
		header("location: /agenda.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>

<!-- Page Content --> ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
<section id="Upload" class="content-section-b">

    <div class="container">

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
                <form action="createAgendaItem.php" method="post" validate>
									<div class="row">
											<div class="control-group form-group col-lg-12">
													<div class="controls">
															<strong>Title:</strong><span style="color:red">*</span>
															<input type="text" class="form-control" id="itemtitle" name="itemtitle" required
																		 data-validation-required-message="Please enter a Title for your this task." maxlength="255">
													</div>
											</div>
											<div class="control-group col-lg-12 mt-2" >
													<div class="controls">
															<label for="itemPriorityId">Task Priority:</label><span style="color:red">*</span>
															<br/><small>Please enter a the priority that this task falls under.</small>
															<select name="itemPriorityId" id="filecategory" class="form-control" style="height:34px !important;">
																	<option value="0">--Select Category--</option>
																	<?php
																	$categories = ToDoPriority::loadall();
																	foreach ($categories as $category) {
																			echo "<option value=\"" . $category->getId() . "\">" . $category->getName() . "</option>";
																	}
																	?>
															</select>
													</div>
											</div>
											<div class="control-group form-group col-lg-12 mt-2">
													<div class="controls">
															<strong>Summary:</strong><span style="color:red">*</span>
															<br/><small>Please enter a summary of this task.</small>
															<textarea rows="10" cols="100" class="form-control" id="itemcontent" name="itemcontent" required maxlength="2046"
																				style="resize:vertical overflow:auto;" ></textarea>
													</div>
											</div>
									</div>
                   <button type="submit" class="btn btn-primary float-right">Submit</button>
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
