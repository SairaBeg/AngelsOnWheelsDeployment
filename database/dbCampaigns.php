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
 * @author Oliver Radwan and Allen Tucker
 */

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */


include_once('dbinfo.php');
include_once(dirname(__FILE__).'/../domain/Campaign.php');


/*
 * add an campaign to dbcampaign table: if already there, return false
 */

function add_campaign($campaign) {
    if (!$campaign instanceof Campaign)
        die("Error: add_campaign type mismatch");
    $con=connect();
    $query = "SELECT * FROM dbcampaigns WHERE campaign_id = '" . $campaign->get_campaign_id() . "'";
    $result = mysqli_query($con,$query);
    $desc = "description";
    $camp_name = "campaign_name";
    
    //if there's no entry for this id, add it
    if ($result == null || mysqli_num_rows($result) == 0) {
        #$sql = "SELECT MAX(`campaign_id`) FROM `dbCampaigns`";
        #mysqli_query($con,$sql);
        
        $sql = "INSERT INTO `dbcampaigns` (`description`, `campaign_name`,`campaign_start_date`,`campaign_end_date`) VALUES 
        ( '" . $campaign->get_description() . "','" . $campaign->get_campaign_name() . "','" .
        $campaign->get_campaign_start() . "','" . $campaign->get_campaign_end() . "')";

        mysqli_query($con,$sql);
        mysqli_close($con);
        return true;
    }
    mysqli_close($con);
    return false;
}

/*
 * remove an campaign from dbCampaign table.  If already there, return false
 */

function remove_campaign($id) {
    $con=connect();
    $query = 'SELECT * FROM dbcampaigns WHERE campaign_id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $query = 'DELETE FROM dbcampaigns WHERE campaign_id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return true;
}

/*
 * @return an Event from dbEvents table matching a particular id.
 * if not in table, return false
 */
function retrieve_campaign($id) {
    $con=connect();
    $query = "SELECT * FROM dbcampaigns WHERE campaign_id = '" . $id . "'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return false;
    }
    $result_row = mysqli_fetch_assoc($result);
    // var_dump($result_row);
    $theCampaign = make_a_campaign($result_row);
//    mysqli_close($con);
    return $theCampaign;
}



//COULD BE USED FOR A DATE RANGE
// not in use, may be useful for future iterations in changing how events are edited (i.e. change the remove and create new event process)
function update_campaign_date($id, $new_event_date) {
	$con=connect();
	$query = 'UPDATE dbcampaigns SET event_date = "' . $new_event_date . '" WHERE id = "' . $id . '"';
	$result = mysqli_query($con,$query);
	mysqli_close($con);
	return $result;
}


function make_a_campaign($result_row) {
	/*
	 ($en, $v, $sd, $description, $ev))
	 */
    $theCampaign = new Campaign(
                    $result_row['campaign_name'],                                      
                    $result_row['description'],
                    $result_row['campaign_id'],
                    $result_row['campaign_start_date'],
                    $result_row['campaign_end_date']);  
    return $theCampaign;
}

// retrieve only those events that match the criteria given in the arguments
function get_all_campaigns() {
    $con=connect();
    $query = "SELECT * FROM `dbcampaigns`";
    $result = mysqli_query($con,$query);
    $theCampaigns = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        
        $theCampaign = make_a_campaign($result_row);
        $theCampaigns[] = $theCampaign;
    }
    mysqli_close($con);
    return $theCampaigns;
 } 


//This function is used to take in the date of an event or campaign and return whether 
    // or not the event/campaign is in the future or not.
 function fix_camp_date($wrong_format_date){
    $explodedString = explode("-",$wrong_format_date);
    $year = "20".$explodedString[0];
    $month = $explodedString[1];
    $day = $explodedString[2];
    $fixedTime = $year . "/" . $month . "/" . $day;
    $fixedTimeAsDateTime = strtotime($fixedTime);
    $newDate = getDate($fixedTimeAsDateTime);
    $finalDATE = $newDate['year'] . "/" . $newDate['mon'] . "/" . $newDate['mday'];
    $finalfinalDate = new Datetime($finalDATE);
    $currentDate = new DateTime('now');
    $finalfinalfinalDate = date_format($finalfinalDate,'Y-m-d H:i:s');
    $fixedCurrentDate = date_format($currentDate,'Y-m-d H:i:s');   
    if ($fixedCurrentDate<$finalfinalfinalDate){    
        return True;
    }
    else{   
        return False;
    }
 }

 

 //Given a campaign this returns that campaign
 function get_campaign_by_name($name) { 
    $con=connect();
    $query = "SELECT * FROM dbcampaigns WHERE campaign_name = '" . $name . "'";
    $result = mysqli_query($con,$query);
    $theCampaigns = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        $theCampaign = make_a_campaign($result_row);
        $theCampaigns[] = $theCampaign;
    }
    mysqli_close($con);
    return $theCampaigns;
 }


 function monthCheckCampaign($event_start_date, $event_end_date){
    $explodedStart = explode("-",$event_start_date);
    $yearStart = "20".$explodedStart[0];
    $monthStart = $explodedStart[1];
    $currentMonth = date("m");
    $currentYear = date("Y");
    $explodedEnd = explode("-",$event_end_date);
    $yearEnd = "20".$explodedEnd[0];
    $monthEnd = $explodedEnd[1];
    if($currentYear == $yearStart && $currentMonth == $monthStart){
        return True;
    }
    elseif($currentYear == $yearEnd && $currentMonth == $monthEnd){
        return True;
    }
    else{
        return False;
    }
}

function checkCampaignWorking($user){
    $con=connect();
    $query = "SELECT * FROM dbcampaigns";
    $resultsCampaign = mysqli_query($con, $query);
    $theCampaigns = array();
    $campaignIds = array();
    $campaignDates = array();
    while ($row = mysqli_fetch_assoc($resultsCampaign)) {
        if(str_contains($row['campaign_working'], $user)){
            if(monthCheckCampaign($row['campaign_start_date'], $row['campaign_end_date'])){
                if(fix_date($row['campaign_start_date'])){
                    array_push($theCampaigns, $row['campaign_name']);
                    array_push($campaignIds, $row['campaign_id']);
                    array_push($campaignDates, $row['campaign_start_date']);
                }
            }
        }
    }
    //echo '<pre>'; print_r($theEvents); echo '</pre>';
    return [$theCampaigns, $campaignIds, $campaignDates];
}


 //Sorts campaign by name ASC or DESC
 function get_campaign_by_name_sort($type) { 
    $con=connect();
    $query = "SELECT * FROM `dbcampaigns` ORDER BY `dbcampaigns`.`campaign_name`" . $type;
    $result = mysqli_query($con,$query);
    $theCampaigns = array();
    while ($result_row = mysqli_fetch_assoc($result)) {      
        $theCampaign = make_a_campaign($result_row);
        $theCampaigns[] = $theCampaign;
    }
    mysqli_close($con);
    return $theCampaigns;
 } 

function sort_start_dates_by($type) { 
    $con=connect();    
    if($type == "start_asc"){
        $type = "start_date` ASC";
    }
    if($type == "start_desc"){
        $type = "start_date` DESC";
    }
    if($type == "end_asc"){
        $type = "end_date` ASC";
    }
    if($type == "end_desc"){
        $type = "end_date` DESC";
    }
    $query = "SELECT * FROM `dbcampaigns` ORDER BY `dbcampaigns`.`campaign_".$type;
    $result = mysqli_query($con,$query); 
    $theCampaigns = array();
    while ($result_row = mysqli_fetch_assoc($result)) {     
        $theCampaign = make_a_campaign($result_row);
        $theCampaigns[] = $theCampaign;
    }
    mysqli_close($con);
    return $theCampaigns;
 } 

 function dayCheckCampaign($start, $end){
    $diff = strtotime($start) - strtotime($end);
    return abs(round($diff / 86400));
}
?>