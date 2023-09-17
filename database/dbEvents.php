<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/**
 * @version March 1, 2012
 * @author Oliver Radwan and Allen Tucker, 
 */

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 * Added to for the Angels on Wheels in 2023 using the pre-existing code as a guide.
 */


include_once('dbinfo.php');
include_once(dirname(__FILE__).'/../domain/Event.php');

/*
 * add an event to dbEvents table: if already there, return false
 */

function add_event($event) {
    if (!$event instanceof Event)
        die("Error: add_event type mismatch");
    $con=connect();
    $query = "SELECT * FROM dbEvents WHERE id = '" . $event->get_id() . "'";
    $result = mysqli_query($con,$query);
    //if there's no entry for this id, add it
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_query($con,'INSERT INTO dbEvents VALUES("' .
                $event->get_id() . '","' .
                $event->get_event_date() . '","' .
                $event->get_start() . '","' .
                $event->get_end() . '","' . 
                $event->get_venue() . '","' .
                $event->get_event_name() . '","' . 
                $event->get_description() . '","' .
                $event->get_event_id() .  '","' .
                $event->get_event_working() .         
                '");');							
        mysqli_close($con);
        return true;
    }
    mysqli_close($con);
    return false;
}

/*
 * remove an event from dbEvents table.  If already there, return false
 */

function remove_event($id) {
    $con=connect();
    $query = 'SELECT * FROM dbEvents WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $query = 'DELETE FROM dbEvents WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return true;
}


/*
 * @return an Event from dbEvents table matching a particular id.
 * if not in table, return false
 */

function retrieve_event($id) {
    $con=connect();
    $query = "SELECT * FROM dbEvents WHERE id = '" . $id . "'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return false;
    }
    $result_row = mysqli_fetch_assoc($result);
    // var_dump($result_row);
    $theEvent = make_an_event($result_row);
//    mysqli_close($con);
    return $theEvent;
}

// not in use, may be useful for future iterations in changing how events are edited (i.e. change the remove and create new event process)
function update_event_date($id, $new_event_date) {
	$con=connect();
	$query = 'UPDATE dbEvents SET event_date = "' . $new_event_date . '" WHERE id = "' . $id . '"';
	$result = mysqli_query($con,$query);
	mysqli_close($con);
	return $result;
}


function make_an_event($result_row) {
	/*
	 ($en, $v, $sd, $description, $ev))
	 */
    $theEvent = new Event(
                    $result_row['event_name'],
                    $result_row['venue'],                   
                    $result_row['event_date'],
                    $result_row['description'],
                    $result_row['event_id'],
                    $result_row['start_time'],
                    $result_row['end_time']);  
    return $theEvent;
}


// retrieve only those events that match the criteria given in the arguments
function getonlythose_dbEvents($name, $day, $venue) {
   $con=connect();
   $query = "SELECT * FROM dbEvents WHERE event_name LIKE '%" . $name . "%'" .
           " AND event_name LIKE '%" . $name . "%'" .
           " AND venue = '" . $venue . "'" . 
           " ORDER BY event_name";
   $result = mysqli_query($con,$query);
   $theEvents = array();
   while ($result_row = mysqli_fetch_assoc($result)) {
       $theEvent = make_an_event($result_row);
       $theEvents[] = $theEvent;
   }
   mysqli_close($con);
   return $theEvents;
}   


//get future events

function fix_date($wrong_format_date){
    //This function is used to take in the date of an event or campaign and return whether 
    // or not the event/campaign is in the future or not.
    $explodedString = explode("-",$wrong_format_date);
    $year = "20".$explodedString[0];
    $month = $explodedString[1];
    $day = $explodedString[2];
    $fixedTime = $year . "/" . $month . "/" . $day;
    $fixedTimeAsDateTime = strtotime($fixedTime);
    $newDate = getDate($fixedTimeAsDateTime);
    $finalDATE = $newDate['year'] . "/" . $newDate['mon'] . "/" . $newDate['mday'];
    
    //echo($finalDATE);
    
    $finalfinalDate = new Datetime($finalDATE);
    $currentDate = new DateTime('now');
    //echo($currentDate);

    //echo(gettype($finalfinalDate));
    //echo(gettype($currentDate));
    $finalfinalfinalDate = date_format($finalfinalDate,'Y-m-d H:i:s');
    $fixedCurrentDate = date_format($currentDate,'Y-m-d H:i:s');   
    //echo($finalfinalfinalDate);
    //echo($fixedCurrentDate); 
    if ($fixedCurrentDate<$finalfinalfinalDate){
        //echo("True");
        return True;

    }
    else{
        //echo("False");
        return False;
    }
}

/* Check if an event is happening in the current month */
function monthCheckEvent($event_date){
    $explodedString = explode("-",$event_date);
    $year = "20".$explodedString[0];
    $month = $explodedString[1];
    $day = $explodedString[2];
    $currentMonth = date("m");
    $currentYear = date("Y");
    if($currentYear == $year && $currentMonth == $month){
        return True;
    }
    else{
        return False;
    }
}

/* returns the date passed in in the Month day# format  */
function monthDay($date){
    $month = date("F", strtotime($date));
    $day = date("d", strtotime($date));
    $monthDay = $month . " " . $day;
    return $monthDay;
}

/* check if a certain user is working the event
    if that event is in the future
    and if the event is this month */
function checkEventWorking($user){
    $con=connect();
    $query = "SELECT * FROM dbevents";
    $resultsEvents = mysqli_query($con, $query);
    $theEvents = array();
    $eventIds = array();
    $eventDates = array();
    while ($row = mysqli_fetch_assoc($resultsEvents)) {
        if(str_contains($row['event_working'], $user)){
            if(monthCheckEvent($row['event_date'])){
                if(fix_date($row['event_date'])){
                    array_push($theEvents, $row['event_name']);
                    array_push($eventIds, $row['event_id']);
                    array_push($eventDates, $row['event_date']);
                }
            }
        }
    }
    //echo '<pre>'; print_r($theEvents); echo '</pre>';
    return [$theEvents, $eventIds, $eventDates];
}

/**
 * returns all Events 
 * @return mysqli_result of id, event_date, venue, event_name, description, and event_id
 */
function get_events() {
    $con=connect();
    $query = "SELECT * FROM dbEvents";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    if (!$result) {
        die("error getting log");
    } 
  /*  else {
        for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
       
            $result_row = mysqli_fetch_row($result);
            if ($result_row) {
                $ev[] = array($result_row[0],$result_row[1], $result_row[2], $result_row[3], $result_row[4], $result_row[5]);
            }
        }
    } */
    return $result;
}
/**
 * returns sorted Events 
 * @return mysqli_result of id, event_date, venue, event_name, description, and event_id
 */
function sort_events($sort_field, $sort_direction) {
    $con=connect();
    $query = "SELECT * FROM dbEvents ORDER BY $sort_field $sort_direction";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    if (!$result) {
        die("error getting log");
    } 
  /*  else {
        for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
       
            $result_row = mysqli_fetch_row($result);
            if ($result_row) {
                $ev[] = array($result_row[0],$result_row[1], $result_row[2], $result_row[3], $result_row[4], $result_row[5]);
            }
        }
    } */
    return $result;
}

?>