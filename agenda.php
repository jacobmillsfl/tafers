<?php
/**
 * Author: Jacob Mills
 * Date: 03/16/2018
 * Description: This file is a basic template for pages on the site
 */
session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/ToDoItem.php");
include_once("DAL/ToDoPriority.php");
include_once("DAL/ToDoItemCountsViewModel.php");
include_once("DAL/AgendaHomeViewModel.php");



Authentication::hasGeneralPermission();

$userId = SessionManager::getUserId();
$pageNum = 1;
$priorityId = null;

if (isset($_GET['priorityId'])) {
    $priorityId = htmlspecialchars($_GET["priorityId"]);
	if ($priorityId < 1) {
		$priorityId = null;
	}
}

if (isset($_GET['page'])) {
    $pageNum = htmlspecialchars($_GET["page"]);// This handles the offset for paging
	if ($pageNum < 1) {
		$pageNum = 1;
	}
}

if (isset($_GET['reopen'])) {
    $reopen = htmlspecialchars($_GET["reopen"]);
}



$errors= array();
if (isset($_GET["close"]) && Authentication::hasAdminPermission()) {
    $closeItemId = $_GET["close"];
	$currentDate = date('Y-m-d H:i:s');
	$agendaItem = new ToDoItem($closeItemId);
	$agendaItem->setClosedDate($currentDate);
	$agendaItem->setClosedByUserId($userId);
	$agendaItem->save();
  header("location: /agenda.php");
} else if (isset($_GET["reopen"]) && Authentication::hasAdminPermission()) {
    $reopenItemId = $_GET["reopen"];
	$agendaItem = new ToDoItem($reopenItemId);
	$agendaItem->setClosedDate(null);
	$agendaItem->setClosedByUserId(null);
	$agendaItem->save();
  header("location: /agenda.php");
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
		<!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Agenda
            <small>- a list of tasks to do</small>
        </h1>
		<br/>
        <div class="row mt-4">
            <div class="col-md-8">
			<div class="row"><div class="col-lg-12"><h5>Open Tasks</h5></div></div>
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

				$viewmodel = AgendaHomeViewModel::loadAgendaHome($priorityId,1,$pageNum);

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
                    echo "<td><button type=\"button\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#resolveModal" . $item->getToDoItemId() . "\">View</button></td>";
										echo "</tr>";


                }
                ?>

							</tbody>
						</table>
            <?php
            // Generate Modals
            foreach($viewmodel as $item)
            {
              echo "<div class=\"modal fade\" id=\"resolveModal" . $item->getToDoItemId() . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"resolveModalLabel" . $item->getToDoItemId() . "\" aria-hidden=\"true\">";

             ?>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="modal-title">

					<div style="width:15%;float:left;"><img style="max-height: 40px;max-width: 40px;" class="d-flex mr-3 rounded-circle" src="<?php echo $item->getCreatedByImgUrl() ?>" alt="Account"></div>

						<?php echo "<div style=\"width:85%;float:left;font-size:larger;\">" . $item->getTitle() . "</div>"; ?>
						<?php
						  $date = new DateTime($item->getCreateDate());
						  echo "<div style=\"width:100%;float:left;font-size: small;\"> Created by <b>" . $item->getCreatedByUsername() . "</b> on " . $date->format('l, F d y h:i:s') . "</div>"; ?>

                  </div>
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
                    echo "<a href=\"agenda.php?close=" . $item->getToDoItemId() . "\" class=\"btn btn-success\"><i class=\"glyphicon glyphicon-remove\"></i>&nbsp;Mark Complete</a>";
                  ?>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Exit</button>
                </div>
              </div>
            </div>
            </div>
            <?php
            }
            ?>

			<br/><br/>
			<div class="row mt-4"><div class="col-lg-12"><h5>Closed Tasks</h5></div></div>
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

				$viewmodel2 = AgendaHomeViewModel::loadAgendaHome($priorityId,0,$pageNum);

                foreach($viewmodel2 as $item)
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
                    echo "<td><button type=\"button\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#reopenModal" . $item->getToDoItemId() . "\">View</button></td>";
										echo "</tr>";


                }
                ?>

							</tbody>
						</table>
            <?php
            // Generate Modals
            foreach($viewmodel2 as $item)
            {
              echo "<div class=\"modal fade\" id=\"reopenModal" . $item->getToDoItemId() . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"reopenModalLabel" . $item->getToDoItemId() . "\" aria-hidden=\"true\">";

             ?>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="modal-title">
					<div style="width:15%;float:left;"><img style="max-height: 40px;max-width: 40px;" class="d-flex mr-3 rounded-circle" src="<?php echo $item->getCreatedByImgUrl() ?>" alt="Account"></div>

						<?php echo "<div style=\"width:85%;float:left;font-size:larger;\">" . $item->getTitle() . "</div>"; ?>
						<?php
						  $date = new DateTime($item->getCreateDate());
						  echo "<div style=\"width:100%;float:left;font-size: small;\"> Created by <b>" . $item->getCreatedByUsername() . "</b> on " . $date->format('l, F d y h:i:s') . "</div>"; ?>

                  </div>
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
                    echo "<a href=\"agenda.php?reopen=" . $item->getToDoItemId() . "\" class=\"btn btn-warning\"><i class=\"glyphicon glyphicon-remove\"></i>&nbsp;Reopen Task</a>";
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
                    <li class="page-item">
                        <?php
							if ($pageNum < 2) {
								echo "<a class=\"page-link disabled\" style=\"cursor:not-allowed;\">Newer &rarr;</a>";
							} else {
								echo "<a class=\"page-link\" href=\"?priorityId=" . $priorityId . "&page=" . ($pageNum - 1) . " \">Newer &rarr;</a>";
							}

						?>
                    </li>
                    <li class="page-item">
						<?php
							echo "<a class=\"page-link\" href=\"?priorityId=" . $priorityId . "&page=" . ($pageNum + 1) . " \">Older &rarr;</a>";
						?>

                    </li>
                </ul>

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
