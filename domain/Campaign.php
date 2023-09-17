<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHC-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/*
 * Created on Mar 28, 2008
 * @author Oliver Radwan <oradwan@bowdoin.edu>, Sam Roberts, Allen Tucker
 * @version 3/28/2008, revised 7/1/2015
 */

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */

 class Campaign {
	private $campaign_name;  // campaign name as a string
	private $description;   // description of the campaign
	private $campaign_id;		// the unique id that is attached to each campaign, is then copied into id, used for editing campaign
	private $campaign_start_date; //Starting date of campaign
	private $campaign_end_date; //End of Campaign
	private $campaign_working;

	function __construct($en ,$description, $ev,$start,$end) {
		$this->campaign_name = $en;
		$this->description = $description;
		$this->campaign_id = $ev;
		$this->campaign_start_date = $start;
		$this->campaign_end_date = $end;
		//$this->campaign_working = "";
		
	}

	//getter functionn for campaign name
	function get_campaign_name() {
		return $this->campaign_name;
	}

	//Getter function for campaign description
	function get_description() {
		return $this->description;
	}

	//Getter Function for campaign ID
	function get_campaign_id() {
		return $this->campaign_id;
	}
	//Getter function for Start date
	function get_campaign_start() {
		return $this->campaign_start_date;
	}

	//Getter function for end date
	function get_campaign_end() {
		return $this->campaign_end_date;
	}

	function get_campaign_working(){
		return $this->campaign_working;
	}

 }
?>