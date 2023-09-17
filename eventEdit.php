<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHC-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/*
 * 	eventEdit.php
 *  oversees the editing of an event to be added, changed, or deleted from the database
 * 	@author Oliver Radwan, Xun Wang and Allen Tucker
 * 	@version 9/1/2008 revised 4/1/2012 revised 8/3/2015
 */

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */
session_cache_expire(30);
session_start();

include_once('database/dbEvents.php');
include_once('domain/Event.php');
include_once('database/dbPersons.php');
include_once('domain/Person.php');
include_once('database/dbLog.php'); // can be used in later iterations
$id = str_replace("_"," ",$_GET["id"]);

if ($id == 'new') {
    $event = new Event('event', $_SESSION['venue'],  
                    null, null, null, null, null);
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
<html>
    <head>
        <title>
            Editing <?PHP echo($event->get_event_name()); ?>
        </title>
        <link rel="stylesheet" href="lib/jquery-ui.css" />
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <script src="lib/jquery-1.9.1.js"></script>
		<script src="lib/jquery-ui.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<script>
			$(function(){
				$( "#start_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
				$( "#end_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
			})
		</script>
    </head>
    <body style="background-color: rgb(250, 249, 246);">
        <div id="container">
            <?PHP include('header.php'); ?>
            <div id="content">
                <?PHP
                include('eventValidate.inc');
                if ($_POST['_form_submit'] != 1)
                //in this case, the form has not been submitted, so show it
                    include('eventForm.php');
                elseif($_POST['signup']){
                    //in ths case the person is signing up to work the event
                        $thisperson = retrieve_person($_SESSION['_id']);
                        $this_person_id = $thisperson->get_id();
                        //echo("====".$this_person_id);
                        $campId = $_POST['event_id'];
                        //echo($this_person_id);
                        $con = connect();
                        //echo("<p>SIGNUP-". $campId . '-'.$this_person_id);
                        $query = 'SELECT * FROM dbevents where id="'.$campId.'"';
                        $result = mysqli_query($con, $query);
                        $list = '';
                        while($row = $result->fetch_assoc()){
                            $list .= $row['event_working'];
                            //echo('|'.$row['event_working'].'|</p>');
                        }
                        //echo("-----".$campId);
                        $list .= $this_person_id . "#";
                        //$query = 'UPDATE dbevents SET event_working="" WHERE id="'.$campId.'"';
                        $query = 'UPDATE dbevents SET event_working="'.$list.'" WHERE id="'.$campId.'"';
                        mysqli_query($con, $query);
                        include('eventForm.php');
                        //echo($result);
                        /* $list = $result['campaign_working'].$this_person_id.'#';
    
                        $query = "UPDATE dbcampaigns SET campaign_working='".$list."' WHERE campaign_id=".$campId;
                        mysqli_query($con, $query);*/
                }
                elseif($_POST['unsignup']){
                    //in this case the person is no longer able to work the event
                        $thisperson = retrieve_person($_SESSION['_id']);
                        $this_person_id = $thisperson->get_id();
                        $campId = $_POST['event_id'];
                        $con = connect();
                        $query = 'SELECT * FROM dbevents WHERE id="'.$campId.'"';
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
                else {
                    //in this case, the form has been submitted, so validate it
                    //       $errors = validate_form($event);  //step one is validation.
                    // errors array lists problems on the form submitted
                    if ($errors) {
                        // display the errors and the form to fix
                        show_errors($errors);
                        $event = new Event($event->get_event_name(), $_POST['location'],   
                                        $_POST['event_date'], $_POST['description'], $_POST['event_id'], $_POST['start_time'], $_POST['end_time']);
                        include('eventForm.php');
                    }
                    // this was a successful form submission; update the database and exit
                    else
                        process_form($id,$event);
                        echo "</div>";
                    include('footer.php');
                    echo('</div></body></html>');
                    die();
                }

                /**
                 * process_form sanitizes data, concatenates needed data, and enters it all into a database
                 */
                function process_form($id,$event) {
                    //step one: sanitize data by replacing HTML entities and escaping the ' character
                    $event_name = trim(str_replace('\\\'', '\'', htmlentities($_POST['event_name'])));
                    //location = venue? may be useful for adding to calendar
                    $location = $_POST['location'];
                    $event_date = $_POST['event_date'];
                    $start = $_POST['start_time'];
                    $end = $_POST['end_time'];
                    $description = trim(str_replace('\\\'', '\'', htmlentities($_POST['description'])));
                    //$event_id = trim(str_replace('\\\'', '\'', htmlentities($_POST['event_id'])));
                    $event_id = uniqid();
                    //used for url path in linking user back to edit form
                    $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
                    //step two: try to make the deletion, addition, or change
                    if ($_POST['deleteMe'] == "DELETE") {
                        $result = retrieve_event($id);
                        if (!$result)
                            echo('<p>Unable to delete. ' . $event_name . ' is not in the database. <br>Please report this error to the Manager.');
                        else {
                                $result = remove_event($id);
                                echo("<p>You have successfully removed " . $event_name . " from the database.</p>");
                                if ($id == $_SESSION['_id']) {
                                    session_unset();
                                    session_destroy();
                                }
                        }
                    }


                    // try to add a new event to the database
                    else if ($_POST['old_id'] == 'new') {
                        //$id = $first_name . $clean_phone1; 
                        $id = $event_id; 
                        //check if there's already an entry
                        $dup = retrieve_event($id);
                        if ($dup)
                            echo('<p class="error">Unable to add ' . $event_name . ' to the database. <br>Another event with the same info is already there.');
                        else {
                        	$newevent = new Event($event_name, $location,  
                                        $event_date, $description, $event_id, $start, $end);
                            $result = add_event($newevent);
                            if (!$result)
                                echo ('<p class="error">Unable to add " .$event_name. " in the database. <br>Please report this error to the Manager.');
                            else if ($_SESSION['access_level'] == 0)
                                echo("<p>Your application has been successfully submitted.<br>  The Manager will contact you soon.  Thank you!");
                            else
                                echo('<p>You have successfully added <a href="' . $path . 'eventEdit.php?id=' . $id . '"><b>' . $event_name . ' </b></a> to the database.</p>');
                        }
                    }

                    // try to replace an existing event in the database by removing and adding
                    else {
                        
                        $id = $_POST['old_id'];
                        $result = remove_event($id);
                        if (!$result)
                            echo ('<p class="error">Unable to update ' . $event_name . '. <br>Please report this error to the Manager.');

                        else {
                            //Pass the old id into the new event instead of event_id, this prevents a new id being created
                            $newevent = new Event($event_name, $location,  
                                        $event_date, $description, $id, $start, $end);
                            $result = add_event($newevent);
                            if (!$result)
                                echo ('<p class="error">Unable to update ' . $event_name . '. <br>Please report this error to the Manager.');
                            
                            else
                                echo('<p>You have successfully edited <a href="' . $path . 'eventEdit.php?id=' . $id . '"><b>' . $event_name . ' </b></a> to the database.</p>');
                        }
                    }
                }
                ?>
            </div>
            <?PHP include('footer.php'); ?>
        </div>
    </body>
</html> 