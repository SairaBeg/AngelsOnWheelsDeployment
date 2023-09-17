<?php
session_cache_expire(30);
session_start();
include_once('database/dbCampaigns.php');
include_once('domain/Campaign.php');
$id = str_replace("_"," ",$_GET["id"]);
?>
<html>
    <head>
        <title>
            Create Campaign
        </title>
        <link rel="stylesheet" href="lib/jquery-ui.css" />
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <?PHP include('header.php');?>
        <script src="lib/jquery-1.9.1.js"></script>
		<script src="lib/jquery-ui.js"></script>
		<script>
			$(function(){
				$( "#start" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "2023:2040"});
				$( "#end" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "2023:2040"});
			})
		</script>
    </head>

</div> 
</html>

<?php 
    //If form hasn't been submitted show the form
    if ($_POST['_form_submit'] != 1) {include('campaignForm.inc');}
    else {
        $new_campaign = New Campaign($_POST["name"],$_POST["description"],100, $_POST["start"],$_POST["end"]);
        //If user didn't provide a name
        if ($new_campaign->get_campaign_name() == NULL or $new_campaign->get_description() == NULL
        or $new_campaign->get_campaign_start() == NULL or $new_campaign->get_campaign_end() == NULL ){
            
            echo("<ul><li><strong><font color=\"red\"> Please fill out all fields. </font></strong></li></ul>\n");
            include('campaignForm.inc');
           
        } else {
            add_campaign($new_campaign);
            echo("<ul><li><strong><font color=\"green\">Your new Campaign has been added succeesfully!</font></strong></li></ul>\n");
            include('campaignForm.inc');
        }
        
        echo($test_campaign->get_campaign_name());
        echo("<br>");
        echo($test_campaign->get_description());
        ;
    }


?>