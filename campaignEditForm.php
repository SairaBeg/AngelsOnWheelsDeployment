<?PHP  
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    // Only managers for adding and edit
    if ($_SESSION['access_level'] == 2)
        //When an Admin clicks a Campaign this displays
	    echo '<p><strong>Edit Form </strong>';
	    echo('Here you can edit and delete an event in the database.' .
        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    
        if ($_SESSION['access_level']==2) {
            echo '<br> (<span style="font-size:x-small;color:FF0000">*</span> denotes required information).';
            }
    ?>
    <form method="POST">
     <script>
			$(function(){
				$( "#start" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
			})
	</script>
    <script>
			$(function(){
				$( "#end" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
			})
	</script>
    
    <input type="hidden" name="old_id" value=<?PHP echo("\"" . $id . "\""); ?>>
    <input type="hidden" name="_form_submit" value="1">
    
    <h3>Campaign: <strong>
             <?PHP echo($event->get_campaign_name());?>
    </strong></h3>
        

 <?PHP  
// managers can add an event description	  
if ($_SESSION['access_level']==2) {
    echo('<br>');
	echo('<p><strong>Campaign Description:</strong><br />');
	echo('<textarea name="description" rows="2" cols="75">');
	echo($event->get_description().'</textarea>');
   
    
}

// volunteers can view the event description
if ($_SESSION['access_level']==1) {
    echo('<br>');
	echo('<p><strong>Campaign Description:</strong> Please read before signing up<br />');
    echo ('<p style="border-width:3px; border-style:solid; border-color:#0000FF.; padding: 1em;">' . $event->get_description() . '</p>');
	}

?>
    <table>
        <?PHP 
        //    GuestApplying4564563232
        //  Micah1234567890

        if ($_SESSION['access_level']==2) {
        echo('<tr><td>Start Date <span style="font-size:x-small;color:FF0000">*</span>: '. 
	             '</td><td colspan=2><input name="start" id="start" type="text" value='.$event->get_campaign_start().'></tr>');
        echo('<tr><td>End Date <span style="font-size:x-small;color:FF0000">*</span>: '. 
	             '</td><td colspan=2><input name="end" id="end" type="text" value='.$event->get_campaign_end().'></tr>');
        }
        ?>
    </tr></table>


    <input type="hidden" name="camp_id" value=<?PHP echo("\"" . $event->get_campaign_id() . "\""); ?>>

    <?PHP
    if ($_SESSION['access_level'] >= 1){
        $con = connect();
        echo('<p><strong>People Working:</strong> <ul>');
        $thisperson = retrieve_person($_SESSION['_id']);
        $thisname = $thisperson->get_first_name();
        $this_person_id = $thisperson->get_id();
        #echo($this_person_id);
        $eventId = $event->get_campaign_id();
        $query = 'SELECT * FROM dbcampaigns WHERE campaign_id='.$eventId.' LIMIT 1';
        $result = mysqli_query($con, $query);
        $set = 0;
        while($row = $result->fetch_assoc()){
            $working = explode("#", $row['campaign_working']);
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
    }
    ?>

    <?PHP
    if ($_SESSION['access_level'] == 2){
            echo('<br>');
            echo('&nbsp;&nbsp;&nbsp;<input class="btn btn-success" type="submit" value="Submit" name="Submit"><br /><br />');
            
            echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
            '<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />');

    }
    include('footer.php')
        ?>


</form>
