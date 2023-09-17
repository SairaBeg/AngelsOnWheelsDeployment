<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or
 * modify it under the terms of the GNU General Public License as published by the
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
session_cache_expire(30);
session_start();
?>
<html lang="">
<head>
    <title>
        Angel's on Wheels
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="styling\notification.css" type="text/css" />
    <style>
        #appLink:visited {
            color: gray;
        }

        li.list-custom {
            background-color: rgb(250, 249, 246);
        }
    </style>
</head>
<?PHP 
include('header.php');
include_once('database/dbPersons.php');
include_once('domain/Person.php');
include_once('database/dbLog.php');
include_once('domain/Shift.php');
include_once('database/dbShifts.php');
include_once('database/dbEvents.php');
include_once('database/dbCampaigns.php');
?>

<body style="background-color: rgb(250, 249, 246);">

    <?PHP 
    if($_SESSION['_id'] != 'guest'){
    $person = retrieve_person($_SESSION['_id']);
    $personId = $person->get_id();
    list($eventWorking, $eventIds, $eventDates) = checkEventWorking($personId);
    list($theCampaigns, $campaignIds, $campDates) = checkCampaignWorking($personId);
    
    if(count($eventWorking)>0 || count($theCampaigns)>0){
        //echo '<pre>'; print_r($eventWorking); echo '</pre>';
        ?>
            <div class="banner">
                <div class="around_items">
                <div class="around_grid">
                <div class="grid">
                    <div class="grid_image"><img src="images\calendar_icon1.png" alt="Calendar Icon" class="banner_image"></div>
                    <div class="grid_number"><div class="banner_number "><?PHP echo(count($eventWorking)+count($theCampaigns)); ?></div></div>
                </div>
                </div>
                <div class="around_list">
                <span class="list_events">
                <h5>You're signed up for:</h5>
                <ul>
                <?PHP 
                if(count($eventWorking)>0){
                $count = 0;
                echo('<li>Events: </li> <strong>|</strong>');
                foreach($eventWorking as $eventName){
                    echo('<li> <a href=eventEdit.php?id='.$eventIds[$count].'>'.$eventName.'</a> ('.monthDay($eventDates[$count]).') </li><strong>|</strong>');
                    $count = $count + 1;
                } 
                }
                if(count($eventWorking)>0 && count($theCampaigns)>0){
                    echo('<br/>');
                }
                $count = 0;
                if(count($theCampaigns)>0){
                echo('<li>Campaigns: </li> <strong>|</strong>');
                foreach($theCampaigns as $campName){
                    echo('<li> <a href=campaignEdit.php?id='.$campaignIds[$count].'>'.$campName.'</a> ('.monthDay($campDates[$count]).')</li> <strong>|</strong>');
                    $count = $count + 1;
                } 
                }
                ?>
                </ul>
                </span>
                </div>
                </div>
            </div>
        <?PHP
    }
}
    ?>

    

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v16.0" nonce="Mb0V1Edj"></script>
    <div class="container-fluid">
        <div class="container-fluid border border-dark" id="content">
            <?PHP
            
            date_default_timezone_set('America/New_York');
            //    fix_all_birthdays();
            if ($_SESSION['_id'] != "guest") {
                $person = retrieve_person($_SESSION['_id']);
                echo ('<p class="text-center">Welcome, ' . $person->get_first_name() . ', to the Angels On Wheels Volunteer Page! <br/>');
            } else
                echo "<p>Welcome!";
            echo "   Today is " . date('l F j, Y') . ".<p>";
            ?>

            <!-- main page data goes here. This is the place to enter content -->
            <p>
                <?PHP
                if ($_SESSION['access_level'] == 0)
                    echo '<script>window.location.href = "' . 'personEdit.php?id=new";</script>';
//                    echo('<p> To apply for volunteering '. 'please select <b>apply</b>.');
                if ($person) {
                    /*
                    * Check type of person, and display home page based on that.
                    * admin: password check
                    * guests: show link to application form
                    * applicants: show status of application form
                    * Volunteers, subs: show upcoming schedule and log sheet
                    * Managers: show upcoming vacancies, birthdays, anniversaries, applicants
                    */

                    //APPLICANT CHECK
                    if ($person->get_first_name() != 'guest' && $person->get_status() == 'applicant') {
                        //SHOW STATUS
                        echo ('<div class="infobox"><p><strong>Your application has been submitted.</strong><br><br /><table><tr><td><strong>Step</strong></td><td><strong>Completed?</strong></td></tr><tr><td>Background Check</td><td>' . $person['background_check'] . '</td></tr><tr><td>Interview</td><td>' . $person['interview'] . '</td></tr><tr><td>Shadow</td><td>' . $person['shadow'] . '</td></tr></table></p></div>');
                    }

                    //VOLUNTEER CHECK
                    if ($_SESSION['access_level'] == 1) {

                        // link to personal profile for editing
                        echo('<br><div class="container-fluid" id="scheduleBox"><p><strong>Your Personal Profile:</strong><br /></p><ul>');
                        echo('</ul><p>Go <strong><a href="profile.php?id='.$person->get_id()
                        	     .'">here</a></strong> to view your account.</p></div>');
                        echo('<br></br>');

//                        // display upcoming schedule
//                        $shifts = selectScheduled_dbShifts($person->get_id());
//
//                        $scheduled_shifts = array();
//                        foreach ($shifts as $shift) {
//                            $shift_month = get_shift_month($shift);
//                            $shift_day = get_shift_day($shift);
//                            $shift_year = get_shift_year($shift);
//
//                            $shift_time_s = get_shift_start($shift);
//                            $shift_time_e = get_shift_end($shift);
//
//                            $cur_month = date("m");
//                            $cur_day = date("d");
//                            $cur_year = date("y");
//
//                            if ($shift_year > $cur_year)
//                                $upcoming_shifts[] = $shift;
//                            else if ($shift_year == $cur_year) {
//                                if ($cur_month < $shift_month)
//                                    $upcoming_shifts[] = $shift;
//                                else if ($shift_month == $cur_month) {
//                                    if ($cur_day <= $shift_day) {
//                                        $upcoming_shifts[] = $shift;
//                                    }
//                                }
//                            }
//                        }
//                        if ($upcoming_shifts) {
//                            echo ('<div class="container-fluid"><p><strong>Your Upcoming Schedule:</strong><br/></p><ul>');
//                            foreach ($upcoming_shifts as $tableId) {
//                                echo ('<li type="circle">' . get_shift_name_from_id($tableId)) . '</li>';
//                            }
//                        }


                        // link to personal log sheet
                        /*echo('<br><div class="scheduleBox"><p><strong>Your Log Sheet:</strong><br /></p><ul>');
                             echo('</ul><p>Go <strong><a href="volunteerLog.php?id='.$person->get_id()
                        	   .'">here</a></strong> to view or enter your recent volunteering hours.</p></div>');*/
                    }

                    if ($_SESSION['access_level'] == 2) {
                        //We have a manager authenticated
                        //active applicants box
                        $con = connect();
                        $app_query = "SELECT first_name,last_name,id,start_date FROM dbPersons WHERE status LIKE '%applicant%'  AND venue='" .
                            $_SESSION['venue'] . "'order by start_date desc";
                        $applicants_tab = mysqli_query($con, $app_query);
                        $numLines = 0;
                        //   if (mysqli_num_rows($applicants_tab) > 0) {
                        echo ('<div class="container-fluid"><p><b>Open Applications / Dates:</b></p><ul class="list-group list-group-flush">');
                        while ($thisRow = mysqli_fetch_array($applicants_tab, MYSQLI_ASSOC)) {
                            echo ('<li class="list-group-item w-25 p-3 list-custom"><a href="' . $path . 'personEdit.php?id=' . $thisRow['id'] . '" id = "appLink">' .
                                $thisRow['last_name'] . ', ' . $thisRow['first_name'] . '</a> / ' .
                                $thisRow['start_date'] . '</li>');
                        }
                        echo ('</ul></div>'); //<br>'
                        //    }
                        mysqli_close($con);

                        // link to personal profile for editing
                        echo('<br><div class="container-fluid" id="scheduleBox"><p><strong>Your Personal Profile:</strong><br /></p><ul>');
                        echo('</ul><p>Go <strong><a href="profile.php?id='.$person->get_id()
                        .'">here</a></strong> to view your account.</p></div>');
                        //echo('<br></br>');

                            //DEFAULT PASSWORD CHECK
                        if (md5($person->get_id()) == $person->get_password()) {
                            echo ('<br>');
                            if (!isset($_POST['_rp_submitted']))
                                echo ('<p><div class="container-fluid">
                                    <form method="post"><p><strong>We recommend that you change your password, which is currently default.</strong>
                                    <table class="warningTable"><tr><td class="warningTable">Old Password:</td>
                                    <td class="warningTable"><input class="form-control" type="password" name="_rp_old"></td>
                                    </tr><tr><td class="warningTable">New password</td>
                                    <td class="warningTable"><input class="form-control" type="password" name="_rp_newa"></td></tr>
                                    <tr><td class="warningTable">New password<br/>(confirm)</td><td class="warningTable">
                                    <input class="form-control" type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="right" class="warningTable">
                                    <input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></td></tr></table></p></form></div>');
                            else {
                                //they've submitted
                                if (($_POST['_rp_newa'] != $_POST['_rp_newb']) || (!$_POST['_rp_newa']))
                                    echo ('<div class="warning">
                                        <form method="post">
                                        <p>Error with new password. Ensure passwords match.</p><br/>
                                        <table class="warningTable">
                                        <tr>
                                        <td class="warningTable">Old Password:</td>
                                        <td class="warningTable">
                                        <input type="password" name="_rp_old">
                                        </td></tr>
                                        <tr>
                                        <td class="warningTable">New password</td>
                                        <td class="warningTable"><input type="password" name="_rp_newa"></td></tr>
                                        <tr><td class="warningTable">New password<br/>(confirm)</td>
                                        <td class="warningTable"><input type="password" name="_rp_newb"></td></tr>
                                        <tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form>
                                        </td></tr>
                                        </table></div>');
                                else if (md5($_POST['_rp_old']) != $person->get_password())
                                    echo ('<div class="warning"><form method="post"><p>Error with old password.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
                                else if ((md5($_POST['_rp_old']) == $person->get_password()) && ($_POST['_rp_newa'] == $_POST['_rp_newb'])) {
                                    $newPass = md5($_POST['_rp_newa']);
                                    change_password($person->get_id(), $newPass);
                                }
                            }
                            echo ('<br clear="all">');
                        }
                            // give admin ability to change password even if it is not default
                            if (md5($person->get_id()) != $person->get_password() && $_SESSION['access_level'] == 2) {
                                echo('<br><div class="container-fluid" id="scheduleBox"><p><strong>Change Password:</strong><br /></p>');
                                echo('<p>Click <strong><a href="changePassword.php">here</a></strong> to change your password</p>');
                                //echo('<br></br>');
                                echo('<br clear="all">');
                            }

                    }
                    if ($_SESSION['access_level'] == 2) {
                        //We have a manager authenticated
                        //log box used to be Recent Schedule Changes
                        echo ('<div class="container-fluid" id="logBox"><p><strong>Profile Changes:</strong><br/>');
                        echo ('<table class="table border table-striped-columns table-hover table-bordered w-auto p-3" id="searchResults">');
                        echo ('
                            <theadx>
                            <tr>
                            <th scope="col">
                            <u>Time</u>
                            </th>
                            <th scope="col"><u>Message</u></th>
                            </tr>
                            </thead>
                            <tbody>
                            ');

                        $log = get_last_log_entries(5);
                        foreach ($log as $lo) {
                            echo ('<tr><td class="searchResults">' . $lo[1] . '</td>' .
                               '<td class="searchResults">' . $lo[2] . '</td></tr>');
                        }
                        echo ('</tbody></table><br><a href="' . $path . 'log.php">View full log</a></p></div><br>');
                    }
                    //display upcoming events
                        echo ('<div class="container-fluid" id="logBox"><p><strong>Upcoming Events:</strong><br/>');
                        echo ('<table class="table border table-striped-columns table-hover table-bordered w-auto p-3" id="searchResults">');
                        echo ('
                            <thead>
                            <tr>
                            <th scope="col">
                            <u>Date</u>
                            </th>
                            <th scope="col"><u>Event</u></th>
                            </tr>
                            </thead>
                            <tbody>
                            ');
                        $con = connect();   
                        $query = "SELECT * FROM dbevents";
                        $result = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Access the row's values using associative array syntax
                            //echo $row['event_name'];
                            
                            $futureCheck = fix_date($row['event_date']);
                            if ($futureCheck){
                                echo ('<tr><td class="searchResults">' .$row['event_date']. '</td>' . 
                                '<td class="searchResults">' . $row['event_name'] . '</td></tr>');
                            }
                            
                            //echo ('<tr><td class="searchResults">' .$row['event_date']. '</td>' . 
                                //'<td class="searchResults">' . $row['event_name'] . '</td></tr>');
                        }
                        echo ('</tbody></table><br>');

                        //foreach ($events as $event) {
                        //    
                        //    echo ('<tr><td class="searchResults">' . $event[0] . '</td>' .
                        //        '<td class="searchResults">' . $event[0] . '</td></tr>');
                        //}
                        echo ('</div>');

						//i hope this fixes everything
            


                        

                        echo ('</tbody></table><br></p><br>');
                        echo('<div class="fb-page" data-href="https://m.facebook.com/angelsonwheelscharity" data-tabs="timeline" data-width="1200" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://m.facebook.com/angelsonwheelscharity" class="fb-xfbml-parse-ignore"><a href="https://m.facebook.com/angelsonwheelscharity">Angels On Wheels Charity Organization</a></blockquote></div></div>');
                     
                        echo ('</div>');
                    }
                ?>
        </div>
    </div>
    <?PHP
    include('footer.php');
    ?>
</body>
</html>