<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHC-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */

/*
 * 	eventForm.inc
 *  shows a form for an event to be added or edited in the database
 * 	@author Oliver Radwan, Xun Wang and Allen Tucker
 * 	@version 9/1/2008, revised 4/1/2012, revised 3/11/2015
 */

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */

    // Only managers for adding and edit
    if ($_SESSION['access_level'] == 2)
	    if ($id == 'new') {
	        echo('<p><strong>Event Page</strong><br />');
	        echo('Adding a new event to the database. ' .
	        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    } else {
	        echo '<p><strong>Edit Form</strong>'.
	        		'&nbsp;&nbsp;&nbsp;&nbsp;(View <strong><a href="volunteerLog.php?id='.$event->get_id().'">Log Sheet</a></strong>)<br>';
	        echo('Here you can edit and delete an event in the database.' .
	        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    } 
	    //else {
		   // echo("<p id=\"error\">You do not have sufficient permissions to add a new event to the database.</p>");
		    //echo('</div></div></body></html>');
		   // die();
	   // }
    if ($_SESSION['access_level']==2) {
    echo '<br> (<span style="font-size:x-small;color:FF0000">*</span> denotes required information).';
    }
?>
<form method="POST">
    <input type="hidden" name="old_id" value=<?PHP echo("\"" . $id . "\""); ?>>
    
    <input type="hidden" name="_form_submit" value="1">
    <script>
			$(function(){
				$( "#event_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
			})
	</script>
    <?PHP 
    	$venues = array('portland'=>"Portland House");
        if ($_SESSION['access_level']==2) {
        echo '<table><tr><td>Event Date <span style="font-size:x-small;color:FF0000">*</span>: '. 
	             '</td><td colspan=2><input name="event_date" type="text" id="event_date" value="'.$event->get_event_date().'">';
        }
	   	foreach ($venues as $venue=>$venuename) {
	   		echo ('<td><input type="hidden" name="location" value="' .$venue.'"'. ($event->get_venue()==$venue?' checked':'').'>');
	   	}
	   	echo "</tr></table><br>"; 
    ?>
    <?php
    echo '<fieldset>';
        '<legend>Event information:</legend>';
        ?> 
    <?php

    ?>  
        
        <?php
        if ($_SESSION['access_level']==2) {
            echo('<p>&nbsp;&nbsp;&nbsp;&nbspStart Time <select name="start_time" tabindex="2" id="start_time"> <span style="font-size:x-small;color:FF0000">*</span>:');
            echo('<option value="9:00">9:00</option>');
            echo('<option value="9:30">9:30</option>');
            echo('<option value="10:00">10:00</option>');
            echo('<option value="10:30">10:30</option>');
            echo('<option value="11:00">11:00</option>');
            echo('<option value="11:30">11:30</option>');
            echo('<option value="12:00">12:00</option>');
            echo('<option value="12:30">12:30</option>');
            echo('<option value="1:00">1:00</option>');
            echo('<option value="1:30">1:30</option>');
            echo('<option value="2:00">2:00</option>');
            echo('<option value="2:30">2:30</option>');
            echo('<option value="3:00">3:00</option>');
            echo('<option value="3:30">3:30</option>');
            echo('<option value="4:00">4:00</option>');
            echo('<option value="4:30">4:30</option>');
            echo('<option value="5:00">5:00</option>');
            echo('<option value="5:30">5:30</option>');
            echo('<option value="6:00">6:00</option></select>');
            echo('&nbsp;&nbsp;&nbsp;&nbspEnd Time <select name="end_time" tabindex="2" id="end_time"> <span style="font-size:x-small;color:FF0000">*</span>:');
            echo('<option value="9:00">9:00</option>');
            echo('<option value="9:30">9:30</option>');
            echo('<option value="10:00">10:00</option>');
            echo('<option value="10:30">10:30</option>');
            echo('<option value="11:00">11:00</option>');
            echo('<option value="11:30">11:30</option>');
            echo('<option value="12:00">12:00</option>');
            echo('<option value="12:30">12:30</option>');
            echo('<option value="1:00">1:00</option>');
            echo('<option value="1:30">1:30</option>');
            echo('<option value="2:00">2:00</option>');
            echo('<option value="2:30">2:30</option>');
            echo('<option value="3:00">3:00</option>');
            echo('<option value="3:30">3:30</option>');
            echo('<option value="4:00">4:00</option>');
            echo('<option value="4:30">4:30</option>');
            echo('<option value="5:00">5:00</option>');
            echo('<option value="5:30">5:30</option>');
            echo('<option value="6:00">6:00</option></select>');
            echo('&nbsp;&nbsp;&nbsp;&nbspEvent Name <span style="font-size:x-small;color:FF0000">*</span>:<input type="text" name="event_name" tabindex="2" value="'. $event->get_event_name() . '"</p>');
        }
        if ($_SESSION['access_level']==1) {
            echo ('<h3 style="text-align:center" Event:>'  . $event->get_event_name() . '</h3>');
            
        }
    ?>

</select>
<?php     
        
       
        
?>
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
</fieldset>

<?php 	
// managers can add an event description	  
if ($_SESSION['access_level']==2) {
    echo('<br>');
	echo('<p>Event Description:<br />');
	echo('<textarea name="description" rows="2" cols="75">');
	echo($event->get_description().'</textarea>');
    
}

// volunteers can view the event description
if ($_SESSION['access_level']==1) {
    echo('<br>');
	echo('<p>Event Description: Please read before signing up<br />');
    echo ('<p style="border-width:3px; border-style:solid; border-color:#0000FF.; padding: 1em;">' . $event->get_description() . '</p>');
	

}

/*
echo('<h4>need to add:</h4>');
echo('<h4>event hours/shift hours</h4>');
echo('<h4>ability to upload pdf?</h4>');
echo('<h4>ability to add video (just a url?)?</h4>');
echo('<h4>max number of volunteers</h4>');
echo('<h4>ability to sign up</h4>');
echo('<h4>ability remove remove yourself after signing up</h4>');
*/

echo '</fieldset>';
echo '</fieldset>';


?>

    <p>
        <?PHP
        


        
        echo('<input type="hidden" name="_submit_check" value="1"><p>');


        // only managers can submit edits
        if ($_SESSION['access_level'] == 2)
            //echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
            echo('Hit <input class="btn btn-success" type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
        
        if ($id != 'new' && $_SESSION['access_level'] >= 2) {
            echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
            '<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />');
            
            
            
        }
        ?>
</form>