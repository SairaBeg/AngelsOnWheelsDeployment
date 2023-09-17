<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/* 
 * Modified by Xun Wang on Feb 25, 2015
 */

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */



session_cache_expire(30);
session_start();
?>
<html>
    <head>
        <title>Events</title>
        <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="styles.css" type="text/css" />
		<link rel="stylesheet" href="lib/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
    <script type="text/javascript">
	$(document).ready(function($) 
	{ 
		$(document).on('click', '.btn_print2', function(event) 
		{
			event.preventDefault();
			
			var element = document.getElementById('container_content2'); 

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
    </head>
    <body style="background-color: rgb(250, 249, 246);">
        <div class="container-fluid" id="container">
            <?PHP include('header.php');
            include('database/dbEvents.php'); ?>
 <div class="container-fluid" id="content">
             		<!-- Button to Save as PDF-->
                     <div class="toPdfButton" style="position:absolute;right:0px; margin-right:3em; margin-top:0.7em; ">
				<input type="button" id="rep" value="Save to PDF" class="btn btn-warning btn_print2">
				</div>
                <div>
 <div class="container_content2" id="container_content2" >
           
                <?PHP
                // display the search form
                $area = $_GET['area'];
                echo('<form method="post">');
                echo('<p><strong>Search for events:</strong>');
               
                echo '<p>Event name (type a few letters): ';
                echo '<input type="text" name="s_name">';

                echo('<p><input class="btn btn-success" type="submit" name="Search" value="Search">');
                echo('</form></p>');

                // if user hit "Search"  button, query the database and display the results
                if ($_POST['Search']) {
                    $name = trim(str_replace('\'', '&#39;', htmlentities($_POST['s_name'])));
                    // now go after the events that fit the search criteria
                    include_once('database/dbEvents.php');
                    include_once('domain/Event.php');
                    $result = getonlythose_dbEvents($name, $_POST['s_day'], $_SESSION['venue']); 
                    echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result) . ' ';   
                        echo "events";
                    if ($name != "")
                        echo ' with name like "' . $name . '"';
				    if (sizeof($result) > 0) {
				       echo ' (select one for more info).';
                       echo '<div class="overflow-auto" id="target" style="width: variable; ">';
				       echo '<p><table class="table table-info table-responsive table-striped-columns table-hover table-bordered"><thead> <tr><th>Event Name</th><th>Event Date (YY-MM-DD)</th></tr></thead>';
				       foreach ($result as $vol) {
                            //if Volunteer
                            if  ($_SESSION['access_level'] == 1) { 
                                                    echo "<tr><td><a href=eventEdit.php?id=" . 
                                                        str_replace(" ","_",$vol->get_id()) . ">" .
                                                            $vol->get_event_name() . "</td><td>" . $vol->get_event_date();
                                                    echo "</td></a></tr>";
                            }
                            //if Admin
                            else if  ($_SESSION['access_level'] == 2) { 
                                echo "<tr><td><a href=eventEdit.php?id=" . 
                                str_replace(" ","_",$vol->get_id()) . ">" .
                                $vol->get_event_name() . "</td><td>" . $vol->get_event_date();
                            echo "</td></a></tr>";
                            }
				       }
				       echo '</table>';   
				    }		               
                }            
                ?>
 </div>
                </div>
            <br>
 <center><hr style="width:90%"></center>
 <br>

    <!-- Button to Save as PDF-->
                     <div class="toPdfButton" style="position:absolute;right:0px; margin-right:3em; margin-top:0.7em; ">
				<input type="button" id="rep" value="Save to PDF" class="btn btn-warning btn_print">
				</div>
                
 <div class="container_content" id="container_content" >
                <!-- Add table of events after the search function-->
                <p><strong>Event List:</strong> <p>
                <form action="">
					<div class="row">
						<div class="col-md-4">
							<div class="input-group mb-3">
								<select name="sort_event" class="form-control">
									<option value="">Sort by...</option>
									<option value="a-z"<?php if(isset($_GET['sort_event']) && $_GET['sort_event'] == "a-z"){echo "selected";}?>>Name (Alphabetical)</option>
									<option value="z-a"<?php if(isset($_GET['sort_event']) && $_GET['sort_event'] == "z-a"){echo "selected";}?>>Name (Reverse Alphabetical)</option>
									<option value="venueAsc"<?php if(isset($_GET['sort_event']) && $_GET['sort_event'] == "venueAsc"){echo "selected";}?>>Venue (Alphabetical)</option>
									<option value="venueDes"<?php if(isset($_GET['sort_event']) && $_GET['sort_event'] == "venueDes"){echo "selected";}?>>Venue (Reverse Alphabetical)</option>
									<option value="dateAsc"<?php if(isset($_GET['sort_event']) && $_GET['sort_event'] == "dateAsc"){echo "selected";}?>>Date (Oldest to Newest)</option>
									<option value="dateDes"<?php if(isset($_GET['sort_event']) && $_GET['sort_event'] == "dateDes"){echo "selected";}?>>Date (Newest to Oldest)</option>
									
								</select>
								<button type="submit" class="input-group-text" id="basic-addon2">Sort

								</button>
							</div>

						</div>		
					</div>
				</form>
                <div class= "overflow-auto" id="target" >
					<table class="table table-info table-responsive table-striped-columns table-hover table-bordered" id= "eventTable">
						<thead>
							<tr>
								<th> Event Name</th>
								<th> Event Venue</th>
								<th> Event Date</th>
							</tr>
						</thead>	
						<tbody>
                            <?php
      //Initally sorted Alphabetically                      
                            $sort_direction = "ASC";
                            $sort_field = "event_name";

    //setting the sort field and direction
                            if(isset($_GET['sort_event'])){
                                if($_GET['sort_event'] == "a-z"){
                                    $sort_field = "event_name";
                                    $sort_direction = "ASC";
                                }else if ($_GET['sort_event'] == "z-a"){
                                    $sort_direction = "DESC";
                                    $sort_field = "event_name";
                                }else if ($_GET['sort_event'] == "venueAsc"){
                                    $sort_direction = "ASC";
                                    $sort_field = "venue";
                                }else if ($_GET['sort_event'] == "venueDes"){
                                    $sort_direction = "DESC";
                                    $sort_field = "venue";
                                }else if ($_GET['sort_event'] == "dateAsc"){
                                    $sort_direction = "ASC";
                                    $sort_field = "event_date";
                                }else if ($_GET['sort_event'] == "dateDes"){
                                    $sort_direction = "DESC";
                                    $sort_field = "event_date";
                                }
                            }



                            $result = sort_events($sort_field, $sort_direction);
                            if (!$result) {
                                die("error getting events.");
                            } else if (mysqli_num_rows($result) > 0){
                                foreach($result as $row){
                                    $evid = $row['event_id'];
                                ?>
                                <tr>

                                <?php
                                    //Volunteer - clicking on an Event name will take you to the View Event Page
                            if  ($_SESSION['access_level'] == 1) {  echo    "<td><a href=eventEdit.php?id=" . 
                                str_replace(" ","_",$evid) . ">" .
                                $row['event_name'] . "</td>";} 
                                //Admin - selecting an Event name will take you to the Event Edit Page
                            else if  ($_SESSION['access_level'] == 2) { echo    "<td><a href=eventEdit.php?id=" . 
                                str_replace(" ","_",$evid) . ">" .
                                $row['event_name'] . "</td>";} 
                                ?>
                                            <td><?=$row['venue']; ?> </td>
                                            <td> <?=$row['event_date']; ?></td>
                
                                </tr>
                                </form>
                                <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan= "3"> There is currently no events.</td>
                            </tr>
                            <?php
                            }
                        ?>
            
                        </tbody>
            </table>
            </div>
            </div>
        </div>
        <!-- End of 2nd Save to PDF-->
                  <!-- below is the footer that we're using currently-->
                  <br><br><br><br>
                </div>
                        </div>
        </div>
        <?PHP include('footer.php'); ?>
    </body>
</html>

