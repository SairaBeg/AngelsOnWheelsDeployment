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
        <title>View Schedule Issues</title>
        <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="styles.css" type="text/css" />
		<link rel="stylesheet" href="lib/jquery-ui.css" />
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
    </head>
     
    <body style="background-color: rgb(250, 249, 246);">
 <?PHP   include('header.php');?>  
        <div class="container-fluid" id="container"style="padding:1.5em;">
            <?PHP 
            include('database/dbIssues.php'); ?>
 
    <!-- Button to Save as PDF-->
                     <div class="toPdfButton" style="position:absolute;right:0px; margin-right:3em; margin-top:0.7em; ">
				<input type="button" id="rep" value="Save to PDF" class="btn btn-warning btn_print">
				</div>
                
 <div class="container_content" id="container_content" >
 
                <h4 style="padding-bottom:.5em;"><strong>Reported Schedule Issues:</strong> <h4>
                
                <form action="">
					<div class="row">
						<div class="col-md-4">
							<div class="input-group mb-3">
								<select name="sort_issues" class="form-control">
									<option value="">Sort by...</option>
									<option value="a-z"<?php if(isset($_GET['sort_issues']) && $_GET['sort_issues'] == "a-z"){echo "selected";}?>>Event Name (Alphabetical)</option>
									<option value="z-a"<?php if(isset($_GET['sort_issues']) && $_GET['sort_issues'] == "z-a"){echo "selected";}?>>Event Name (Reverse Alphabetical)</option>
									<option value="nameAsc"<?php if(isset($_GET['sort_issues']) && $_GET['sort_issues'] == "nameAsc"){echo "selected";}?>>Name (Alphabetical)</option>
									<option value="nameDes"<?php if(isset($_GET['sort_issues']) && $_GET['sort_issues'] == "nameDes"){echo "selected";}?>>Name (Reverse Alphabetical)</option>
									<option value="dateAsc"<?php if(isset($_GET['sort_issues']) && $_GET['sort_issues'] == "dateAsc"){echo "selected";}?>>Date (Oldest to Newest)</option>
									<option value="dateDes"<?php if(isset($_GET['sort_issues']) && $_GET['sort_issues'] == "dateDes"){echo "selected";}?>>Date (Newest to Oldest)</option>
									
								</select>
								<button type="submit" class="input-group-text" id="basic-addon2">Sort

								</button>
							</div>

						</div>		
					</div>
				</form>

                <div class= "overflow-auto" id="target" >
					<table class="table table-info table-responsive table-striped-columns table-hover table-bordered" id= "issueTable">
						<thead>
							<tr>
								
                                <th> Event</th>
                                <th> Name</th>
								<th> Schedule Issue</th>
								<th> Date Reported</th>
							</tr>
						</thead>	
						<tbody>
                            <?php
      //Initally sorted Alphabetically                      
                            $sort_direction = "ASC";
                            $sort_field = "event_name";

    //setting the sort field and direction
                            if(isset($_GET['sort_issues'])){
                                if($_GET['sort_issues'] == "a-z"){
                                    $sort_field = "event_name";
                                    $sort_direction = "ASC";
                                }else if ($_GET['sort_issues'] == "z-a"){
                                    $sort_direction = "DESC";
                                    $sort_field = "event_name";
                                }else if ($_GET['sort_issues'] == "nameAsc"){
                                    $sort_direction = "ASC";
                                    $sort_field = "name";
                                }else if ($_GET['sort_issues'] == "nameDes"){
                                    $sort_direction = "DESC";
                                    $sort_field = "name";
                                }else if ($_GET['sort_issues'] == "dateAsc"){
                                    $sort_direction = "ASC";
                                    $sort_field = "date";
                                }else if ($_GET['sort_issues'] == "dateDes"){
                                    $sort_direction = "DESC";
                                    $sort_field = "date";
                                }
                            }

                            $result = sort_issues($sort_field, $sort_direction);
                            if (!$result) {
                                die("error getting Schedule Issues.");
                            } else if (mysqli_num_rows($result) > 0){
                                foreach($result as $row){
                                    $evid = $row['event_id'];
                                ?>
                                <tr>

                                <?php
                                //Admin - selecting an Event name will take you to the Event Edit Page
                             if  ($_SESSION['access_level'] == 2) { echo    "<td><a href=eventEdit.php?id=" . 
                                str_replace(" ","_",$evid) . ">" .
                                $row['event_name'] . "</td>";} 
                                ?>
                                            <td><?=$row['name']; ?> </td>
                                            <td> <?=$row['issue']; ?></td>
                                            <td> <?=$row['date']; ?></td>
                                </tr>
                                </form>
                                <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan= "4"> There is currently no Reported Issues.</td>
                            </tr>
                            <?php
                            }
                        ?>
            
                        </tbody>
            </table>
           
            </div>
            </div>
        <!-- End of 2nd Save to PDF-->
                  <!-- below is the footer that we're using currently-->
                  <br><br><br><br>
                </div>
                        </div>
        
    </body>
    </div>
    <?PHP include('footer.php'); ?>
</html>

