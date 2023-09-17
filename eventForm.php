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
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    session_cache_expire(30);
    session_start();
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
    <link rel="stylesheet" href="styling\eventForm.css" type="text/css" />
<form method="POST">
    <input type="hidden" name="old_id" value=<?PHP echo("\"" . $id . "\""); ?>>
    <link rel="stylesheet" href="styling\eventForm.css" type="text/css" />
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--START Script for saving the page as a PDF image -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" ></script>

	<script type="text/javascript">
	$(document).ready(function($) 
	{ 
		$(document).on('click', '.btn_print', function(event) 
		{
			event.preventDefault();
			
			var element = document.getElementById('container_content'); 

			html2pdf().from(element).save();

			var opt = 
			{
			  margin:       1,
			  filename:     'pageContent_'+js.AutoCode()+'.pdf',
			  image:        { type: 'jpeg', quality: 0.98 },
			  html2canvas:  { scale: 2 },
			  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
			};
			html2pdf().set(opt).from(element).save();
		});

	});
	</script>
<!--END Script for saving the page as a PDF image -->

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
             
    ?>
              		<!-- Button to Save as PDF-->
	<div class="toPdfButton" style="position:absolute;right:0px; margin-right:3em; margin-top:0.7em; ">
				<input type="button" id="rep" value="Save to PDF" class="btn btn-warning btn_print">
				</div>      
                <div class="container_content" id="container_content" >              
<div class="container">

    <h2> <?PHP echo($event->get_event_name()); ?> </h2>
    <div class= "content">
        
        <p><strong>Date: </strong><?PHP echo($event->get_event_date()); ?> </p>
        <p><strong>Venue: </strong> <?PHP echo($event->get_venue()); ?> </p>
        <p><strong>Description: </strong><?PHP echo($event->get_description()); ?> </p>
    
        </div>
</select>
<?php     
        }
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
/*
// volunteers can view the event description
if ($_SESSION['access_level']==1) {
    echo('<br>');
	echo('<p>Event Description: Please read before signing up<br />');
    echo ('<p style="border-width:3px; border-style:solid; border-color:#0000FF.; padding: 1em;">' . $event->get_description() . '</p>');
	

}


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
      //  if ($_SESSION['access_level'] == 1){
        //Start Report button
     /*   
        echo '<form action="scheduleIssue.php?id=' . str_replace(" ", "_", $event->get_id()) . '"><input type="submit" value="Report Schedule Issue">
        </form>'; 
   */


 //   
    }
?>

    <p>
    <input type="hidden" name="event_id" value=<?PHP echo("\"" . $event->get_event_id() . "\""); ?>>
        <?PHP
        
        echo('<input type="hidden" name="_submit_check" value="1"><p>');

        // only managers can submit edits
        if ($_SESSION['access_level'] == 2){
            //echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
            echo('Hit <input class="btn btn-success" type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
        }
        if ($id != 'new' && $_SESSION['access_level'] >= 2) {
            echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
            '<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />');

        }
        ?>
       
        </form>
        <?PHP

        if ($_SESSION['access_level'] == 1){
            $evid = $event->get_event_id();

            ?><form style="float: left; margin-bottom:4em; margin-top:0; padding-top:-3em;" class="reportButton" method="post" action="scheduleIssue.php?id=<?php echo str_replace(" ", "_", $evid); ?>"><input class="btn btn-success"type="submit" value="Report Schedule Issue">
            </form>
    <?php
        }
        ?>
         </div>
    </div>
    </body>    

