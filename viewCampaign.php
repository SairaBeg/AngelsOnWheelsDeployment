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
include_once('database/dbCampaigns.php');
include_once('domain/Campaign.php');
?>
<html>
    <head>
        <title>
            View Campaigns
        </title>
        <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="styles.css" type="text/css" />
		<link rel="stylesheet" href="lib/jquery-ui.css" />
		
    </head>
    <body style="background-color: rgb(250, 249, 246);">
        <div class="container-fluid" id="container">
            <?PHP include('header.php'); 
            ?>
            <br>
            <h4>List of current and Future Campaigns</h4> 
            <br> 
            <h4>Search Campaign by name</h4> 
            <form method="GET"> 
            <strong>Campaign Name:</strong> <input type="text" name="campaignName"></input>
            <input class="btn btn-success" type="submit" name="Search"></input>           
            </form>

            <center><hr style="width:90%"></center>
            <strong> <h4>Sort Campaigns</h4> </strong>
            <form method="GET">
					<div class="row">
						<div class="col-md-4">
							<div class="input-group mb-3">                               
								<select name="sort_campaign" class="form-control">
									<option value="">Sort by...</option>
									<option value="ASC">Name (Alphabetical)</option>
									<option value="DESC">Name (Reverse Alphabetical)</option>
									<option value="start_asc">Start Date (Ascending)</option>
									<option value="start_desc">Start Date (Descending)</option>	
                                    <option value="end_asc">End Date (Ascending)</option>
									<option value="end_desc">End Date (Descending)</option>									
								</select>
								<input type="submit" class="input-group-text" name="sort" id="basic-addon2"></input>
							</div>
						</div>		
					</div>
				</form>
            
            
            
            
            <?PHP
            echo("<br>");

            $result = get_all_campaigns();
            //Searching by name
            if (isset($_GET['Search'])){
                $name = $_GET['campaignName'];
                $result = get_campaign_by_name($name); 
                if($result== Null){
                    echo("<p style='color:red'><strong> No campaigns with that name<strong></p>");
                    echo("<br>");
                }             
            } 


            if (isset($_GET['sort'])){      
                $sort_by = strval($_GET['sort_campaign']);
                #CONVERT TO STRING USING strval($string)
                
                if ( $sort_by == "DESC" || $sort_by == "ASC"){
                    $result = get_campaign_by_name_sort($sort_by);
                } 
                
                if ( $sort_by == "start_asc" || $sort_by == "start_desc"){
                    $result = sort_start_dates_by($sort_by);
                }

                if ( $sort_by == "end_asc" || $sort_by == "end_desc"){                  
                    $result = sort_start_dates_by($sort_by);
                }

            } 
            
            echo '<div class="overflow-auto" id="target" style="width: variable; height: 400px;">';
            echo '<p><table class="table table-info table-responsive table-striped-columns table-hover 
            table-bordered"> <tr><td><strong> Campaign Name </strong></td> <td> <strong>Description</strong> </td> <td>
            <strong>Start Date (YY-MM-DD)</strong></td>
            <td><strong>End Date </strong></td> 
            </tr>';
            
            
            foreach ($result as $vol) {
            
            $td = "</td><td>";
                echo("<tr>");

                $id = $vol->get_campaign_id();

			    echo("<td> <a href='campaignEdit.php?id=".$id."'>". $vol->get_campaign_name() ."</a>". $td
            .    $vol->get_description()  . $td . $vol->get_campaign_start()) . $td . $vol->get_campaign_end();
                echo("</tr>");    
                    }
                    echo '</table>';  
                     ?>


</div>
            <!-- below is the footer that we're using currently-->
                </div>
        </div>
        <?PHP include('footer.php'); ?>
    </body>
</html>

