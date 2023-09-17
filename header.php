<?php
error_reporting(E_ERROR | E_PARSE);
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHP-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
?>

<link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="styling/header.css">
<script src="lib\bootstrap\js\bootstrap.js"></script>

<!-- Begin Header -->
<div class="d-flex justify-content-center" id="navigationLinks">

    <?PHP
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    //Log-in security
    //If they aren't logged in, display our log-in form.
    if (!isset($_SESSION['logged_in'])) {
    	
        include('login_form.php');
        die();
    } else if ($_SESSION['logged_in']) {
        

        /*         * Set our permission array.
         * anything a guest can do, a volunteer and manager can also do
         * anything a volunteer can do, a manager can do.
         *
         * If a page is not specified in the permission array, anyone logged into the system
         * can view it. If someone logged into the system attempts to access a page above their
         * permission level, they will be sent back to the home page.
         */
        //pages guests are allowed to view
        $permission_array['index.php'] = 0;
        $permission_array['about.php'] = 0;
        $permission_array['apply.php'] = 0;
        //pages volunteers can view
        $permission_array['help.php'] = 1;
        $permission_array['calenderExample.php'] = 1;
        $permission_array['feedback.php'] = 1;
        //pages only managers can view
        $permission_array['personsearch.php'] = 2;
        $permission_array['personedit.php'] = 0; // changed to 0 so that applicants can apply
        $permission_array['viewschedule.php'] = 2;
        $permission_array['addweek.php'] = 2;
        $permission_array['log.php'] = 2;
        $permission_array['reports.php'] = 2;

        //Check if they're at a valid page for their access level.
        $current_page = strtolower(substr($_SERVER['PHP_SELF'], strpos($_SERVER['PHP_SELF'],"/")+1));
        $current_page = substr($current_page, strpos($current_page,"/")+1);
       
        
        $person2 = retrieve_person($_SESSION['_id']);


        if($permission_array[$current_page]>$_SESSION['access_level']){
            //in this case, the user doesn't have permission to view this page.
            //we redirect them to the index page.
            echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
            //note: if javascript is disabled for a user's browser, it would still show the page.
            //so we die().
            die();
        }
        // This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
        $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
		$venues = array("portland"=>"RMH Portland");
        
        // The user is logged in and session variables are set
        if ($_SESSION['venue'] =="") { 
        	echo(' <a href="' . $path . 'personEdit.php?id=' . 'new' . '">Apply</a>');
        	echo(' | <a href="' . $path . 'logout.php">Logout</a><br>');
        }
        else {
            echo('<nav class="navbar navbar-custom navbar-expand-lg bg-light">');
            echo('<div class="container-fluid">');
            echo('<a class="navbar-brand" href="' . $path . 'index.php">
            <img src="images\angelsIcon.png" alt="Angles on Wheels Icon">
          </a>');
//            echo('<a class="navbar-brand">Homebase</a>');
            echo('<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>');
        	echo('<div class="collapse navbar-collapse" id="navbarSupportedContent">');
            echo('<ul class="navbar-nav me-auto mb-2 mb-lg-0">');
//            echo " <br><b>"."Angels On Wheels Homebase"."</b>|"; //changed: 'Homebase' to 'Angels On Wheels Homebase'
	        if ($_SESSION['access_level'] == 1) {
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'index.php">Home</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'about.php">About</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">Help</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'calenderExample.php?venue=portland'.''.'">Calendar</a></li>');
                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');
//                echo('<a class="navbar-brand">Events</a>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'eventSearch.php">View Events</a></li>');
                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'ViewCampaign.php">View Campaigns</a></li>');
                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" target="_blank" href="' . $path . 'feedback.php">Send Feedback</a></li>');
                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'profile.php?id='.$person2->get_id().'">Profile</a></li>');


//                echo('<a class="navbar-brand" style="padding: 10px; border-right: 1px solid #333;"></a>');
//                echo('<button type="button" class="btn btn-link"><a href="' . $path . 'index.php" class="link-primary">home</a></button>');
//	        	echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'about.php">about</a></button>');
//	            echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">help</a></button>');
//	            echo(' | calendars: <a href="' . $path . 'calenderExample.php?venue=bangor'.''.'">Bangor, </a>');
//	            echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'calenderExample.php?venue=portland'.''.'">calendar</a></button>'); //added before '<a': |, changed: 'Portland' to 'calendar'
	        }
	        if ($_SESSION['access_level'] >= 2) {
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'index.php">Home</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'about.php">About</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">Help</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'calenderExample.php?venue=portland'.''.'">Calendar</a></li>');
                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');
//	            echo('<br>master schedules: <a href="' . $path . 'viewSchedule.php?venue=portland'."".'">Portland, </a>');
//	            echo('<a href="' . $path . 'viewSchedule.php?venue=bangor'."".'">Bangor</a>');
                
                echo('
                <li><div class="dropdown">
                <button class="dropbtn">Events &#9660;</button>
                    <div class="dropdown-content">
                    <a href="' . $path . 'eventSearch.php">Event search</a>
                    <a href="' . $path . 'eventCreate.php?id=new">Add Event</a>
                    </div></div></li>');
             
                //echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'eventCreate.php?id=new">Add Event</a></li>');
                //<a class="nav-link active" aria-current="page" href="' . $path . 'eventSearch.php">Search Event</a></li>');

                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');
//	            echo('<a class="navbar-brand">Volunteers</a>');

                echo('
                <li><div class="dropdown">
                <button class="dropbtn">Volunteers &#9660;</button>
                    <div class="dropdown-content">
                    <a href="' . $path . 'personSearch.php">Search Volunteer</a>
                    <a href="personEdit.php?id=' . 'new' . '">Add Volunteer</a>
                    <a href="recruitInfo.php">Recruit Info</a>
                    </div></div></li>');
                //echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'personSearch.php">Search Volunteer</a></li>
			    //    <li class="nav-item"><a class="nav-link active" aria-current="page" href="personEdit.php?id=' . 'new' . '">Add Volunteer</a></li>');
                //echo('<a class="navbar-brand" style="padding: 10px; border-right: 1px solid #333;"></a>');
                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');

                echo('
                <li><div class="dropdown">
                <button class="dropbtn">Campaigns &#9660;</button>
                    <div class="dropdown-content">
                    <a href="' . $path . 'ViewCampaign.php">View Campaign</a>
                    <a href="' . $path . 'createCampaign.php?id=new">Add Campaign</a>
                    </div></div></li>');

                //echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'ViewCampaign.php">View Campaign</a></li>');
                //echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'createCampaign.php?id=new">Add Campaign</a></li>');
                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');

                echo('
                <li><div class="dropdown">
                <button class="dropbtn">Reports &#9660;</button>
                    <div class="dropdown-content">
                    <a href="' . $path . 'reports.php?venue='.$_SESSION['venue'].'">View Reports</a>
                    <a href="' . $path . 'viewFeedbackAdmin.php">View Feedback</a>
                    <a href="' . $path . 'viewIssues.php">View Schedule Issues</a>
                    </div></div></li>');

                echo('<a class="navbar-brand" style="padding: 5px; border-right: 1px solid #333;"></a>');

                //echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'reports.php?venue='.$_SESSION['venue'].'">Reports</a></li>');
                //echo ('<div class="container-fluid" id="feedbackLink"><br><p><a href="' . $path . 'viewFeedbackAdmin.php">View Feedback from Volunteers</a></p><br></div>');
                //echo ('<div class="container-fluid" id="viewIssueLink"><br><p><a href="' . $path . 'viewIssues.php">View Schedule Issues</a></p><br></div>');
               


                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'profile.php?id='.$person2->get_id().'">Profile</a></li>');
	       
                
	       
            }
	        echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'logout.php">Logout</a></li><br>');
            echo('</div></div></nav>');
            /*echo('<br/><br/>');
            echo('
                    <div class="dropdown">
                    <button class="dropbtn">Events</button>
                    <div class="dropdown-content">
                        <a href="' . $path . 'eventSearch.php">Search Event</a>
                        <a href="' . $path . 'eventCreate.php?id=new">Add Event</a>');
            */
        }


    }
    ?>
</div>
<div class="buffer"><p></p></div>
<!-- End Header -->