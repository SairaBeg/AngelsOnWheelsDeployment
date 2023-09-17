<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHC-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */

/*
 * 	personForm.inc
 *  shows a form for a person to be added or edited in the database
 * 	@author Oliver Radwan, Xun Wang and Allen Tucker
 * 	@version 9/1/2008, revised 4/1/2012, revised 3/11/2015
 */

/*
 * Modified for Gwyneth's Gift website, 2022
 */
session_cache_expire(30);
session_start();

echo('<link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css"/>');
echo('<link rel="stylesheet" href="styling/applicantForm.css" type="text/css"/>');

if ($_SESSION['access_level'] == 0) {
    echo('<div class="content-container">');
    echo('<p class ="testing" style="font-size: 25px;"><strong>Volunteer Service Application</strong><br />');
    echo('<p>Please provide as much information as you can. ' .
       '<br>When finished, hit <b>Submit</b> at the bottom of this page, and then <b>logout</b>.</p> <br>');
         echo('<p> <strong> Recruiter Contact Information </strong></p></p>');
         echo('
            <strong>ANGELS ON WHEELS CHARITY ORGANIZATION<br><br></strong>
            <strong>Address: </strong>
            <p>3102 Plank Rd Ste. 425<br>
            P.O. Box 41237<br>
            Fredericksburg, VA 22407</p>
            <strong>Email:</strong> angelsonnwheels@gmail.com<br>    
            <a href="https://www.angelsonwheelscharity.org"><strong>Website: angelsonwheelscharity.org</strong></a><br>
            <strong>Phone: </strong>(540)-735-7887');
         echo('<p></p>');
         echo('</div>');
} else if ($_SESSION['access_level'] == 1)
    if ($_SESSION['_id'] != $person->get_id()) {
        echo("<p id=\"error\">You do not have sufficient permissions to edit this user.</p>");
        include('footer.php');
        echo('</div></div></body></html>');
        die();
    } else {
        echo '<p><strong>Personnel Edit Form</strong>';
        echo(' Here you can edit your own information in the database.' .
        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
    } else if ($_SESSION['access_level'] == 2)
	    if ($id == 'new') {
	        echo('<p><strong>Volunteer Service Application</strong><br />');
	        echo('Adding a new volunteer to the database. ' .
	        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    } else {
	        echo '<p><strong>Personnel Edit Form</strong>'.
	        		'&nbsp;&nbsp;&nbsp;&nbsp;(View <strong><a href="volunteerLog.php?id='.$person->get_id().'">Log Sheet</a></strong>)<br>';
	        echo('Here you can edit, delete, or reset the password for a person in the database.' .
	        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    } 
	    else {
		    echo("<p id=\"error\">You do not have sufficient permissions to add a new person to the database.</p>");
		    include('footer.php');
		    echo('</div></div></body></html>');
		    die();
	    }
//    echo '<br> (<span style="font-size:x-large;color:FF0000">*</span> denotes required information).';
?>

<form method="POST">
    <input type="hidden" name="old_id" value=<?PHP echo("\"" . $id . "\""); ?>>
    <input type="hidden" name="old_pass" value=<?PHP echo("\"" . $person->get_password() . "\""); ?>>
    <input type="hidden" name="_form_submit" value="1">
    <script>
			$(function(){
				$( "#birthday" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
				$( "#start_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
			})
	</script>

    <?PHP
    echo('<div class="date-container">');
    $venues = array('portland'=>"Portland House");
    echo('<label style="font-size: 20px;">Start Date<br><br></label>');
    echo('<div class="input-container">');
    echo ('<input style="border: none; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px;" class="form-control-lg" name="start_date" type="text" id="start_date" value="'.$person->get_start_date().'" style="width: 100%;">');
    foreach ($venues as $venue=>$venuename) {
        echo ('<input type="hidden" name="location" value="' .$venue.'"'. ($person->get_venue()==$venue?' checked':'').'>');
    }
    echo('</div>');
    echo('</div>');
    ?>

        <div class="infoContainer">
        <fieldset class="row mb-3">
            <center><legend class="PersonalInfo col-sm-12 col-form-label col-form-label-lg" style="font-size: 24px;">Personal Information<br><br></legend></center>

            <div class="row mb-3">
                <label for="first_name" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>First Name:</label>
                <div class="col-sm-9">
                    <?php
                    if ($person->get_first_name() == "new") {
                        echo '<input class="form-control-lg" type="text" name="first_name" tabindex="1">';
                    } else {
                        echo '<p style="font-size:2em">First Name: ' . $person->get_first_name() . '</p>';
                    }
                    ?>
                </div>
            </div>

            <!-- Add other input fields with a similar structure -->
            <!-- Last Name -->
            <div class="row mb-3">
                <label for="last_name" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>Last Name:</label>
                <div class="col-sm-9">
                    <input class="form-control-lg" type="text" name="last_name" tabindex="2" value="<?PHP echo($person->get_last_name()) ?>">
                </div>
            </div>

            <!-- Email address -->
            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>Email address:</label>
                <div class="col-sm-9">
                    <input class="form-control-lg" type="text" name="email" tabindex="8" value="<?PHP echo($person->get_email()) ?>">
                </div>
            </div>

            <!-- Primary Phone -->
            <div class="row mb-3">
                <label for="primary_phone" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>Primary Phone:</label>
                <div class="col-sm-9">
                    <input class="form-control-lg" type="text" name="phone1" tabindex="9" value="<?PHP echo($person->get_phone1()) ?>">
                </div>
            </div>

            <!-- Phone Type -->
            <div class="row mb-3">
                <label for="phone_type" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>Phone Type:</label>
                <div class="col-sm-9">
                    <select class="form-select-lg" name="phone_type" tabindex="10">
                        <?PHP
                        $phone_types = array("Home", "Cell", "Work");
                        foreach ($phone_types as $ptype) {
                            echo "<option value='" . $ptype . "' ";
                            if ($person->get_phone1type() == $ptype)
                                echo("SELECTED");
                            echo ">" . $ptype . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Address -->
            <div class="row mb-3">
                <label for="address" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>Address:</label>
                <div class="col-sm-9">
                    <input class="form-control-lg" type="text" name="address" tabindex="3" size="40" value="<?PHP echo($person->get_address()) ?>">
                </div>
            </div>

            <!-- City -->
            <div class="row mb-3">
                <label for="city" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>City:</label>
                <div class="col-sm-9">
                    <input class="form-control-lg" type="text" name="city" tabindex="4" value="<?PHP echo($person->get_city()) ?>">
                </div>
            </div>

            <!-- State -->
            <div class="row mb-3">
                <label for="state" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>State:</label>
                <div class="col-sm-9">
                    <select class="form-select-lg" name="state" tabindex="5">
                        <?PHP
                        $states = array("AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "DC", "FL", "GA", "HI", "ID", "IL", "IN", "IA",
                            "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM",
                            "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA",
                            "WV", "WI", "WY");
                        foreach ($states as $st) {
                            echo "<option value='" . $st . "' ";
                            if ($person->get_state() == $st)
                                echo("SELECTED");
                            else if ($id == "new" && $st == "VA")
                                echo("SELECTED");
                            echo ">" . $st . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Zip -->
            <div class="row mb-3">
                <label for="zip" class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>Zip:</label>
                <div class="col-sm-9">
                    <input class="form-control-lg" type="text" name="zip" size="5" tabindex="6" value="<?PHP echo($person->get_zip()) ?>">
                </div>
            </div>

            <!-- Birth date -->
            <div class="row mb-3">
                <label for="birthday" class="col-sm-3 col-form-label">Birth date:</label>
                <div class="col-sm-9">
                    <input class="form-control-lg" name="birthday" type="text" id="birthday" tabindex="7" value="<?PHP echo($person->get_birthday()) ?>">
                </div>
            </div>

            <!-- Best time to contact -->
            <div class="row mb-3">
                <label for="contact_time" class="col-sm-3 col-form-label">Best time to contact:</label>
                <div class="col-sm-9">
                    <input class="form-control-lg" type="text" name="contact_time" tabindex="11" value="<?PHP echo($person->get_contact_time()) ?>">
                </div>
            </div>

            <!-- Best way to contact -->
            <div class="row mb-3">
                <label for="cMethod" class="col-sm-3 col-form-label">Best way to contact:</label>
                <div class="col-sm-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="cMethod" value="Phone" <?php echo ($person->get_cMethod() == "Phone" ? "checked" : ""); ?>>
                        <label class="form-check-label">Phone</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="cMethod" value="Email" <?php echo ($person->get_cMethod() == "Email" ? "checked" : ""); ?>>
                        <label class="form-check-label">Email</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="cMethod" value="Text" <?php echo ($person->get_cMethod() == "Text" ? "checked" : ""); ?>>
                        <label class="form-check-label">Text</label>
                    </div>
                </div>
            </div>

        </fieldset>
    </div>

    <?php

    echo('<div class="infoContainerTwo">');
echo '<fieldset class="row mb-3"> <legend style="font-size: 24px;" class="col-sm-12 col-form-label col-form-label-lg">Volunteer Information<br><br></legend>';

// dropdown for t-shirt size
echo '<div class="row mb-3">';
echo '<label class="col-sm-3 col-form-label"><span style="color:FF0000">*</span>Shirt Size:</label>';
echo '<div class="col-sm-9">';
echo '<select class="form-select-lg" name="shirt size">';

    echo '<option value="S"';
    if ($person->get_shirt_size() == 'S')
        echo ' SELECTED';
    echo '>S</option>'; // default
    echo '<option value="M"';
    if ($person->get_shirt_size() == 'M')
        echo ' SELECTED'; echo '>M</option>';
    echo '<option value="L"';
    if ($person->get_shirt_size()== 'L')
        echo ' SELECTED'; echo '>L</option>';
    echo '<option value="XL"';
    if ($person->get_shirt_size() == 'XL')
        echo ' SELECTED'; echo '>XL</option>';
    echo '<option value="XXL"';
    if ($person->get_shirt_size() == 'XXL')
        echo ' SELECTED'; echo '>XXL</option>';

echo '</select>';
echo '</div></div>';

// radio for computer
echo '<div class="row mb-3">';
echo '<label class="col-sm-3 col-form-label left-column"><span style="color:FF0000">*</span>Do you own a computer?</label>';
echo '<div class="col-sm-9 right-column">';
echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="computer" value="Yes" '.($person->get_computer()=="Yes"?"checked":"").'>';
echo '<label class="form-check-label">Yes</label>';
echo '</div>';
echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="computer" value="No" '.($person->get_computer()=="No"?"checked":"").'>';
echo '<label class="form-check-label">No</label>';
echo '</div>';
echo '</div></div>';

// radio for camera
echo '<div class="row mb-3">';
echo '<label class="col-sm-3 col-form-label left-column"><span style="color:FF0000">*</span>Do you own a camera?</label>';
echo '<div class="col-sm-9 right-column">';
echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="camera" value="Yes" '.($person->get_camera()=="Yes"?"checked":"").'>';
echo '<label class="form-check-label">Yes</label>';
echo '</div>';
echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="camera" value="No" '.($person->get_camera()=="No"?"checked":"").'>';
echo '<label class="form-check-label">No</label>';
echo '</div>';
echo '</div></div>';

// radio for transportation
echo '<div class="row mb-3">';
echo '<label class="col-sm-3 col-form-label left-column"><span style="color:FF0000">*</span>Do you have reliable transportation?</label>';
echo '<div class="col-sm-9 right-column">';
echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="transportation" value="Yes" '.($person->get_transportation()=="Yes"?"checked":"").'>';
echo '<label class="form-check-label">Yes</label>';
echo '</div>';
echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="transportation" value="No" '.($person->get_transportation()=="No"?"checked":"").'>';
echo '<label class="form-check-label">No</label>';
echo '</div>';
echo '</div></div>';

// Emergency contact information
echo '<p><br><br><b>Emergency contact information<br><br></b>';

echo '<div class="row mb-3">';
echo '<label class="col-sm-3 col-form-label left-column"><span style="color:FF0000">*</span>Emergency contact name:</label>';
echo '<div class="col-sm-9 right-column">';
echo '<input class="form-control-lg" type="text" name="contact_name" tabindex="12" value="'.$person->get_contact_name().'">';
echo '</div></div>';

echo '<div class="row mb-3">';
echo '<label class="col-sm-3 col-form-label left-column"><span style="color:FF0000">*</span>Emergency contact number:</label>';
echo '<div class="col-sm-9 right-column">';
echo '<input class="form-control-lg" type="text" name="contact_num" tabindex="13" value=" '.$person->get_contact_num().'">';
echo '</div></div>';

// dropdown for emergency contact relation
echo '<div class="row mb-3">';
echo '<label class="col-sm-3 col-form-label left-column"><span style="color:FF0000">*</span>Relationship to emergency contact:</label>';
echo '<div class="col-sm-9 right-column">';
echo '<select class="form-select-lg" name="relation">';

echo '<option value="Relative"';
if ($person->get_relation() == 'Relative')
    echo ' SELECTED';
echo '>Relative</option>'; // default
echo '<option value="Parent"';
if ($person->get_relation() == 'Parent')
    echo ' SELECTED'; echo '>Parent</option>';
echo '<option value="Spouse"';
if ($person->get_relation()== 'Spouse')
    echo ' SELECTED'; echo '>Spouse</option>';
echo '<option value="Friend"';
if ($person->get_relation() == 'Friend')
    echo ' SELECTED'; echo '>Friend</option>';
echo '<option value="Other"';
if ($person->get_relation() == 'Other')
    echo ' SELECTED'; echo '>Other</option>';

echo '</select>';
echo '</div></div>';

// How did you hear about Angels on Wheels?
echo '<p><br><br><b>How did you hear about Angels on Wheels?<br><br></b>';
echo '<div class="row mb-3">';
echo '<label class="col-sm-12">';

echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="howdidyouhear" value="internet" '.($person->get_howdidyouhear()=="internet"?"checked":"").'>';
echo '<label class="form-check-label">Internet search or website</label>';
echo '</div>';

echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="howdidyouhear" value="volunteer" '.($person->get_howdidyouhear()=="volunteer"?"checked":"").'>';
echo '<label class="form-check-label">Current volunteer</label>';
echo '</div>';

echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" name="howdidyouhear" value="other" '.($person->get_howdidyouhear()=="other"?"checked":"").'>';
echo '<label class="form-check-label">Other</label>';
echo '</div>';

echo '</label>';
echo '</div>';

echo '<p><br>Please list special skills or training you would like us to know about:<br />';
echo '<div class="row mb-3">';
echo '<div class="col-sm-12">';
echo '<textarea class="form-control-lg" name="specialties" style="width: 600px; height: 150px;">';
echo($person->get_specialties());
echo '</textarea>';
echo '</div></div>';

echo '</fieldset>';
echo '</div>';

echo('<hr>');
echo('<div class="availabilityContainer">');
echo ('<p><span style="color:FF0000">*</span>Status:&nbsp;&nbsp;');
echo('<select class="form-select-lg" name="status">');
if ($_SESSION['access_level'] == 0) {
	echo ('<option value="applicant"');
    echo (' SELECTED'); 
    echo('>applicant</option>');
}
else {
	echo ('<option value="applicant"');
	if ($person->get_status() == 'applicant')
    	echo (' SELECTED'); 
    echo('>applicant</option>'); echo ('<option value="active"');
	if ($person->get_status() == 'active')
	    echo (' SELECTED'); echo('>active</option>');
	echo ('<option value="LOA"');
	if ($person->get_status() == 'LOA')
	    echo (' SELECTED'); echo('>on leave</option>');
	echo ('<option value="former"');
	if ($person->get_status() == 'former')
	    echo (' SELECTED'); echo('>former</option>');
}
echo('</select>');

// only managers can see the manager position type option
if ($_SESSION['access_level'] == 2) {
    // $st = implode(',', $person->get_type());
    $types = array('volunteer' => 'Volunteer', 'manager' => 'Manager');
    echo('<p><span style="color:FF0000">*</span>Position type:');
    // $ts = $types;

    foreach ($types as $key => $value) {
        echo ('&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="type[]" value=' . $key);
        if (in_array($key,$person->get_type()) !== false)
            echo(' CHECKED');
        echo ('>' . $value );

    }
}
    
// volunteers can only see the volunteer option
if ($_SESSION['access_level'] <= 1) {
        $types = array('volunteer' => 'Volunteer');
        // keeping this here, can be used to add descriptions to the jobs, related lines commented out below
        //$descriptions = array('volunteer' => ' *insert job description here <p>',  
                //'manager' => ' *insert job description here');
        echo('<p><span style="color:FF0000">*</span>Position type:');
        // $ts = $types;

        foreach ($types as $key => $value) {
            // set volunteer position to be checked automatically, will need to be changed if adding new position types
            echo ('&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" checked name="type[]" value=' . $key);
            if (in_array($key,$person->get_type()) !== false)
                echo(' CHECKED');
            echo ('>' . $value );
            //if ($_SESSION['access_level']==0)
               // echo $descriptions[$key].'<p>';
        }
}

?>

    <fieldset class="row mb-3" id='availability'>
        <legend class="col-sm-2 col-form-label col-form-label-lg"><span style="color:FF0000">*</span>Availability:<br><br></legend>
        <span class="bigTable">
                <?PHP
            $shifts = array('9-12' => '9-12', '12-3' => '12-3', '3-6' => '3-6',
                '6-9' => '6-9');
            $days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
                echo "<table class='table'>";
                echo "<tr class='Enlarge2'><td class='Enlarge2'>Monday&nbsp;&nbsp;</td><td class='Enlarge2'>Tuesday&nbsp;&nbsp;</td><td class='Enlarge2'>Wednesday&nbsp;&nbsp;</td>".
                "<td class='Enlarge2'>Thursday&nbsp;&nbsp;</td><td class='Enlarge2'>Friday&nbsp;&nbsp;</td><td class='Enlarge2'>Saturday&nbsp;&nbsp;</td><td class='Enlarge2'>Sunday</td></tr>";
            foreach ($shifts as $shift => $shiftvalue) {
                   echo ('<tr>');
                   foreach ($days as $day) {
                     $shiftdisplay=$shiftvalue;
                    //some stuff here is redundant, left over from old version w/ weekends having different hours
                    if (($shift!="night" || $day=="Fri" || $day=="Sat") && $shiftdisplay!="") {
                       $realkey = $day . ":". $shiftdisplay. ":". $person->get_venue();
                         echo ('<td class="fix"><input class="Enlarge form-check-input" type="checkbox" name="availability[]" value="' . $realkey . '"');
                      if (in_array($realkey, $person->get_availability())) echo(' CHECKED');
                      echo ('>');
                      echo "<p class='Enlarge'> ".$shiftdisplay.'<p/></td>';
                     }
                     else echo "<td></td>";
                   }
                   echo ('</tr>');
            }
                echo "</table><p>";
    			?>
        </span>
    </fieldset>
    <p>
        <?PHP

        //change password - only volunteers here       
        if ($_SESSION['access_level'] == 1) {
            if ($id != 'new' ) { 

                echo "<fieldset>";
                echo "<legend>Change Password: </legend>";
                echo('<p>Click <strong><a href="changePassword.php">here</a></strong> to change your password</p>');
                echo '</fieldset>';
            }

        }

        //if you would like to add the ability for managers to change their own password but not other's on profile page
        /*
        if ($_SESSION['access_level'] == 2 && $_SESSION['_id'] == $person->get_id()) {
            if ($id != 'new' ) { 

                echo "<fieldset>";
                echo "<legend>Change Password: </legend>";
                echo('<p>Click <strong><a href="changePassword.php">here</a></strong> to change your password</p>');
                echo '</fieldset>';
            }

        }//end change password
        */

        echo('<input type="hidden" name="schedule" value="' . implode(',', $person->get_schedule()) . '">');
        echo('<input type="hidden" name="hours" value="' . implode(',', $person->get_hours()) . '">');
        echo('<input type="hidden" name="password" value="' . $person->get_password() . ')">');
        echo('<input type="hidden" name="_submit_check" value="1"><p>');
        if ($_SESSION['access_level'] == 0) {
            echo('<p style="font-size: 13px; color: red;"><br><b>By hitting \'Submit\', I understand the importance of this volunteer 
            		commitment and have answered the application questions honestly and to the best of my knowledge.</b></p><br />');
            echo('<input class="submitButton" type="submit" value="Submit" name="Submit Edits">');
        } else
            echo('Hit <input class="btn btn-success" type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
        if ($id != 'new' && $_SESSION['access_level'] >= 2) {
            echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
            '<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />' .
            '<input type="checkbox" name="reset_pass" value="RESET"> Check this box and then hit ' .
            '<input type="submit" value="Reset Password" name="Reset Password"> to reset this person\'s password.</p>');
        }
        echo('<br><br></div>');
        ?>
</form>