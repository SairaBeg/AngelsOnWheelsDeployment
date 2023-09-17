<?php
/*
 * Copyright 2015 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
session_cache_expire(30);
session_start();

include_once('database/dbEvents.php');
include_once('domain/Event.php');
include_once('database/dbLog.php'); // can be used in later iterations

$id = str_replace("_"," ",$_GET["id"]);



if ($id == 'new') {
    $event = new Event('event', $_SESSION['venue'],  
                    null, null, null, "", "");
} else {
    $event = retrieve_event($id);
    if (!$event) { // try again by changing blanks to _ in id
        $id = str_replace(" ","_",$_GET["id"]);
        $event = retrieve_event($id);
        if (!$event) {
            echo('<p id="error">Error: there\'s no event with this id in the database</p>' . $id);
            die();
        }
    }
}
$evName = $event->get_event_name();
$evId = $event->get_event_id();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Schedule Issue</title>
    <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="styling\scheduleIssue.css" type="text/css" />
</head>
 <?php include('header.php'); ?>
 <body style="background-color: rgb(250, 249, 246);">
<div class="container" style="padding-bottom: 100px;">
  <h2>Report Schedule Issue: <?PHP echo($evName); ?></h2> 
  <form method="post">
    <div  class="id">
        <input type="text" required placeholder="Your name" name="name">
    </div>
    <div class="issueBox">
        <textarea name="issues" cols="50" rows="5" required placeholder="Report Issues here..."></textarea>
    </div>
<div class="issueButton">
        <input  class= "btn btn-success" style="float: left;" type="submit" name="submit" value="Submit">
</div>
<br>
</form>

<?php
include_once('database/dbinfo.php');
include_once('database/dbIssues.php');

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $issues = $_POST['issues'];
    $date = date("Y-m-d");
  //  
    $insertId;
    $con = connect();

    report_issue( $insertId, $name, $issues, $date, $evName, $evId);
}
?>

</div>

<br><br><br><br>
</body>

<?php include('footer.php'); ?>

</html>
