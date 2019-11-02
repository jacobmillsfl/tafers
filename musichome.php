<?php
/**
 * Author: Jacob Mills
 * Date: 03/16/2018
 * Description: This file is a basic template for pages on the site
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/Song.php");

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
} else {
  $pageNum = 1;
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
} else if (isset($_GET["reopen"]) && Authentication::hasAdminPermission()) {
    $reopenItemId = $_GET["reopen"];
	$agendaItem = new ToDoItem($reopenItemId);
	$agendaItem->setClosedDate(null);
	$agendaItem->setClosedByUserId(null);
	$agendaItem->save();
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
        <h1 class="mt-4 mb-3">Music Home
            <small>- music & feedback</small>
        </h1>
		<br/>
			<div class="row mt-4">
			<div class="col-md-8">
				<div class="row">
				<div class="col-lg-12"><h5>Current Songs</h5></div></div>
							<table class="table table-striped dont-break-out">
							  <thead>
							    <tr>
							      <th scope="col" style="width:80%;">Song Name</th>
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

                $viewmodel = Song::loadMusicHome($content,$pageNum);

                foreach($viewmodel as $item)
                {
										echo "<tr>";
										echo "<td>". $item->getName() . "</td>";
										echo "<td><a href=\"song.php?id=" . $item->getId() ."\"><button type=\"button\" class=\"btn btn-primary\">View</button></a></td>";
                    echo "</tr>";
                }
                ?>

							</tbody>
						</table>


                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item">
                        <?php
													if ($pageNum < 2) {
														echo "<a class=\"page-link disabled\" style=\"cursor:not-allowed;\">Newer &rarr;</a>";
													} else {
														echo "<a class=\"page-link\" href=\"?page=" . ($pageNum - 1) . " \">Newer &rarr;</a>";
													}

												?>
                    </li>
                    <li class="page-item">
						<?php
							echo "<a class=\"page-link\" href=\"?page=" . ($pageNum + 1) . " \">Older &rarr;</a>";
						?>

                    </li>
                </ul>

            </div>

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4 mt-lg-3">
                <div class ="text-center">
                <a href="createSong.php" class ="btn btn-primary btn-lg btn-block"><i class=""></i>Create Song</a>
                </div>
                <br>
                <div class ="text-center">
                    <a href="musichome.php" class ="btn btn-success btn-lg btn-block"><i class=""></i>Reset Filter</a>
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
    </div>
</section>
<?php
include('footer.php');
?>
</body>
</html>
