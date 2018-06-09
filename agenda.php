<?php
/**
 * Author: Jacob Mills
 * Date: 03/16/2018
 * Description: This file is a basic template for pages on the site
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/File.php");
include_once("DAL/FileUserViewModel.php");
include_once("DAL/FileCategory.php");

include_once("DAL/ToDoItem.php");
include_once("DAL/ToDoItemCountsViewModel.php");
include_once("DAL/ToDoPriority.php");

Authentication::checkFilePermissions();

$userId = SessionManager::getUserId();
$filename = null;
$fileCategoryId = null;
$pageNum = 0;

if (isset($_GET['priorityId'])) {
    $priorityId = htmlspecialchars($_GET["priorityId"]);
}

if (isset($_GET['page'])) {
    $pageNum = htmlspecialchars($_GET["page"]);
}

$errors= array();
if (isset($_GET["close"]) && Authentication::hasAdminPermission()) {
    $closeItemId = $_GET["close"];
		// Load ToDoItem, update closed by user ID and closed date, then save
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav.php'); ?>



<!-- Page Content -->
<section id="FileHome" class="content-section-a">

    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Agenda
            <small>- a list of tasks to do</small>
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
							<table class="table table-striped dont-break-out">
							  <thead>
							    <tr>
							      <th scope="col" style="width:20%;">Priority</th>
							      <th scope="col" style="width:80%;">Title</th>
                    <th scope="col" style="width:20%;"></th>
							    </tr>
							  </thead>
							  <tbody>
                <?php

                $viewmodel = ToDoItem::loadall();

                foreach($viewmodel as $item)
                {
										echo "<tr>";
										if ($item->getPriorityId() == 3) {
											echo "<th><i class=\"fa fa-angle-double-up\" style=\"color: red;\" aria-hidden=\"true\"></i></th>";
										} else if ($item->getPriorityId() == 2) {
											echo "<th><i class=\"fa fa-angle-up\" style=\"color: orangered;\" aria-hidden=\"true\"></i></th>";
										} else {
                      echo "<th><i class=\"fa fa-angle-down\" style=\"color: green;\" aria-hidden=\"true\"></i></th>";
										}
										echo "<td>". $item->getTitle() . "</td>";
                    echo "<td><button type=\"button\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#resolveModal" . $item->getId() . "\">View</button></td>";
										echo "</tr>";


                }
                ?>

							</tbody>
						</table>
            <?php
            // Generate Modals
            foreach($viewmodel as $item)
            {
              echo "<div class=\"modal fade\" id=\"resolveModal" . $item->getId() . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"resolveModalLabel" . $item->getId() . "\" aria-hidden=\"true\">";

             ?>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">
                    <?php echo "<div style=\"width:100%;float:left;\">" . $item->getTitle() . "</div>"; ?>
                    <?php
                      $date = new DateTime($item->getCreateDate());
                      echo "<div style=\"width:100%;float:left;font-size: small;\">" . $date->format('l, F d y h:i:s') . "</div>"; ?>
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                   <?php echo $item->getSummary(); ?>
                </div>
                <div class="modal-footer">
                  <?php
                    if (Authentication::hasAdminPermission())
                    echo "<a href=\"agenda.php?close=" . $item->getId() . "\" class=\"btn btn-success\"><i class=\"glyphicon glyphicon-remove\"></i>&nbsp;Mark Complete</a>";
                  ?>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Exit</button>
                </div>
              </div>
            </div>
            </div>
            <?php
            }
            ?>


                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">&larr; Older</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Newer &rarr;</a>
                    </li>
                </ul>
                <!-- Pagination Example
                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item">
                        <a class="page-link" href="#">&larr; Older</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Newer &rarr;</a>
                    </li>
                </ul> -->

            </div>

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">

                <div class ="text-center">
                <a href="createAgendaItem.php" class ="btn btn-primary btn-lg btn-block"><i class=""></i>New Item</a>
                </div>
                <br>
                <div class ="text-center">
                    <a href="agenda.php" class ="btn btn-success btn-lg btn-block"><i class=""></i>Reset Filter</a>
                </div>
                <br>

                <!-- Search Widget -->

                    <div class="card mb-4">
                        <h5 class="card-header">Summary</h5>
                        <div class="card-body">
													<?php
															$itemCounts = ToDoItemCountsViewModel::loadTotalCounts();
															echo "<p>Total Items: " . $itemCounts->getTotal() . "</p>";
															echo "<p>Open Items: " . $itemCounts->getOpen() . "</p>";
															echo "<p>Closed Items: " . $itemCounts->getClosed() . "</p>";
													?>

                        </div>
                    </div>



                <!-- Categories Widget -->
                <div class="card my-4">
                    <h5 class="card-header">Priority Level</h5>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $PriorityList = ToDoPriority::loadall();
                            foreach ($PriorityList as $Priority){
                                ?>
                                <div class="col-lg-6">
                                    <a href="agenda.php?priorityId=<?php echo $Priority->getId(); ?>"><?php echo $Priority->getName(); ?></a>
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
