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
include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    
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
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?PHP echo($event->get_event_name()); ?></title>
    <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="styling\eventView.css" type="text/css" />
</head>
<?php include('header.php'); ?>
<body style="background-color: rgb(250, 249, 246);">
<div class="container" style="padding-bottom: 100px;">
    <h2> <?PHP echo($event->get_event_name()); ?> </h2>

    <div class= "content">
        
    <p><strong>Date: </strong><?PHP echo($event->get_event_date()); ?> </p>
    <p><strong>Venue: </strong> <?PHP echo($event->get_venue()); ?> </p>
    <p><strong>Description: </strong><?PHP echo($event->get_description()); ?> </p>

    </div>
<br>

<?php
    $evid = $event->get_event_id();
    if(isset($_POST['signup'])){
        $thisperson = retrieve_person($_SESSION['_id']);
        $this_person_id = $thisperson->get_id();
        //echo("====".$this_person_id);
        $campId = $_POST['event_id'];
        //echo($this_person_id);
        $con = connect();
        //echo("<p>SIGNUP-". $campId . '-'.$this_person_id);
        $query = 'SELECT * FROM dbevents';
        $result = mysqli_query($con, $query);
        $list = '';
        while($row = $result->fetch_assoc()){
            $list .= $row['event_working'];
            //echo('|'.$row['event_working'].'|</p>');
        }
        //echo("-----".$campId);
        $list .= $this_person_id . "#";
        $query = 'UPDATE dbevents SET event_working="'.$list.'" WHERE id="'.$campId.'"';
        mysqli_query($con, $query);
        include('eventForm.php');
        //echo($result);
        /* $list = $result['campaign_working'].$this_person_id.'#';

        $query = "UPDATE dbcampaigns SET campaign_working='".$list."' WHERE campaign_id=".$campId;
        mysqli_query($con, $query);*/
}
elseif(isset($_POST['unsignup'])){
        $thisperson = retrieve_person($_SESSION['_id']);
        $this_person_id = $thisperson->get_id();
        $campId = $_POST['event_id'];
        $con = connect();
        $query = 'SELECT * FROM dbevents';
        $result = mysqli_query($con, $query);
        $list = '';
        while($row = $result->fetch_assoc()){
            $working = explode("#", $row['event_working']);
            foreach($working as $person){
                //echo("-".$person."-");
                if($this_person_id!==$person && $person!=""){
                    $list .= $person . "#";
                }
            }
        }
        //echo("=======".$list);
        $query = 'UPDATE dbevents SET event_working="'.$list.'" WHERE id="'.$campId.'"';
        mysqli_query($con, $query);
        include('eventForm.php');
    }


?>

<!--sign up button not working yet-->
<form method="POST">
    <?PHP
    
    if ($_SESSION['access_level'] >= 1){
        $con = connect();
        echo('<p><strong>People Working:</strong> <ul>');
        $thisperson = retrieve_person($_SESSION['_id']);
        $thisname = $thisperson->get_first_name();
        $this_person_id = $thisperson->get_id();
        #echo($this_person_id);
        $eventId = $event->get_event_id();
        $query = 'SELECT * FROM dbevents WHERE id="'.$eventId.'" LIMIT 1';
        $result = mysqli_query($con, $query);
        $set = 0;
        while($row = $result->fetch_assoc()){
            $working = explode("#", $row['event_working']);
            //echo($woking);
            if(count($working)==0){
                echo('<li>No one signed up yet.</li>');
            }
            else{
                //$woking = explode("#", $people_working);
                foreach ($working as $person){
                    $query = 'SELECT * FROM dbPersons WHERE id="'.$person.'" LIMIT 1';
                    $result = mysqli_query($con, $query);
                    while($row = $result->fetch_assoc()){
                        if($row['id']==$this_person_id){
                            $set = 1;
                        }
                        echo("<li>".$row['first_name'].' '.$row['last_name'].'</li>');
                    }
                }
            } 
        }   
        echo('</ul></p>');
        if($set==0){     
            echo('&nbsp;&nbsp;&nbsp;<input class="btn btn-success" type="submit" value="Sign-up to Work" name="signup"><br /><br />');
        }
        elseif($set==1){     
            echo('&nbsp;&nbsp;&nbsp;<input class="btn btn-success" type="submit" value="Un-Sign-up" name="unsignup"><br /><br />');
        }
    }
    ?>
</form>
        <!--Start Report button-->
        <?php 
        echo    "<a href=scheduleIssue.php?id=" . 
        str_replace(" ","_",$evid) . ">";
        ?> 
            <button class= "reportButton">Report Schedule Issue</button> 
        <!--End  Report button
</div>

</body>
<br><br>
<?php include('footer.php'); ?>
</html>
