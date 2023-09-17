<?php
    //echo "hello";
    session_cache_expire(30);
    session_start();
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    include_once('database/dbShifts.php');
    include_once('domain/Shift.php');
    $id = str_replace("_"," ",$_GET["id"]);
    $person = retrieve_person($id);
    if (!$person) { // try again by changing blanks to _ in id
        $id = str_replace(" ","_",$_GET["id"]);
        $person = retrieve_person($id);
        if (!$person) {
            echo('<p id="error">Error: there\'s no person with this id in the database</p>' . $id);
            die();
        }
    }
?>
<html lang="">
<head>
    <title>
        Profile
    </title>
    <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="lib/jquery-ui.css" />
    <script type="text/javascript" src="lib/jquery-1.9.1.js"></script>
    <script src="lib/jquery-ui.js"></script>
    <script>
    $(function() {
        $( "#from" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
        $( "#to" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});

        $(document).on("keyup", ".volunteer-name", function() {
            var str = $(this).val();
            var target = $(this);
            $.ajax({
                type: 'get',
                url: 'reportsCompute.php?q='+str,
                success: function (response) {
                    var suggestions = $.parseJSON(response);
                    console.log(target);
                    target.autocomplete({
                        source: suggestions
                    });
                }
            });
        });

        $("input[name='date']").change(function() {
            if ($("input[name='date']:checked").val() == 'date-range') {
                $("#fromto").show();
            } else {
                $("#fromto").hide();
            }
        });

        $("#report-submit").on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: 'reportsCompute.php',
                data: $('#search-fields').serialize(),
                success: function (response) {
                    $("#outputs").html(response);
                }
            });
        } );
        
    });
    </script>
    <style>
        #appLink:visited {
            color: gray;
        }

        li.list-custom {
            background-color: rgb(250, 249, 246);
        }
    </style>
</head>
<div class="container-fluid">
        <?PHP include('header.php'); ?>
        <div style="padding-top: 20px"></div>
        <div class="square rounded p-1" id="content">
            <p id="search-fields-container">
	        <form id = "search-fields" method="post">
            <p class = "search-description" id="today">
            <input type="hidden" name="report-types[]" id = "report-type" value="individual-hours">
	        </p>
            <?PHP
                $venue = 'portland';
                echo '<input type="hidden" name="_form_submit" value="report'.$venue.'" />';
                echo '<input type="hidden" name="name_from" value="'.$person->get_id().'" />';
                if ($person->get_first_name()=="new")
        	        echo '<p>First Name<span style="font-size:x-small;color:FF0000">*</span>: <input class="form-control-sm" type="text" name="first_name" tabindex="1" value="'.$person->get_first_name().'">';
                else 
                    echo '<h3 style="margin-left:40px;">Personal Information</h3>';
                    echo '<div class="rounded-circle text-center" style="float:right; margin-right:100px; width: 150px; height: 150px; background-color: white; color:#870287"><p style="padding-top:8px;font-size:11;">T-Shirt Size</p>';
                    echo '<p style="font-size:40px; padding-top:0px;">' .$person->get_shirt_size() . '</p></div>';
                    echo '<div class="rounded-circle text-center" style="clear: both; float:right; margin-right:200px; width: 150px; height: 150px; background-color: white; color:#870287"><p style="padding-top:12px;font-size:11;">Computer Owner</p>';
                    echo '<p style="font-size:40px;">' .$person->get_computer() . '</p></div>';
                    echo '<div class="rounded-circle text-center" style="clear: both; float:right; margin-right:100px;width: 150px; height: 150px; background-color: white; color:#870287"><p style="padding-top:12px;font-size:11;">Camera Owner</p>';
                    echo '<p style="font-size:40px;">' .$person->get_camera() . '</p></div>';
                    echo '<div class="rounded-circle text-center" style="clear: both; float:right; margin-right:200px;width: 150px; height: 150px; background-color: white; color:#870287"><p style="padding-top:22px;font-size:11;">Reliable Transportation</p>';
                    echo '<p style="font-size:40px;">' .$person->get_transportation() . '</p></div>';
        	        echo '<table style="margin-left:40px;"><tr valign=top><td style="color:white">Name:</td></tr>';
                    echo '<tr valign=top><td style="color:white; height:50px">' . $person->get_first_name() . ' ' . $person->get_last_name() . '</td></tr>';
                    echo '<tr valign=top style="color:white"><td>Address: </td></tr>';
                    echo '<tr valign=top style="color:white"><td>' . $person->get_address() . '</td></tr>';
                    echo '<tr valign=top style="color:white; height:50px"><td>' . $person->get_city() .', ' . $person->get_state() .' '. $person->get_zip() . '</td></tr>';
                    echo '<tr valign=top style="color:white"><td>Primary phone: </td></tr>';
                    echo '<tr valign=top style="color:white; height:50px"><td>' . phone_edit($person->get_phone1()) . '</td></tr>';
                    echo '<tr valign=top style="color:white"><td>Birthday: </td></tr>';
                    echo '<tr valign=top style="color:white; height:50px"><td>' . $person->get_birthday() . '</td></tr>';
                    echo '<tr valign=top style="color:white"><td>Email address: </td></tr>';
                    echo '<tr valign=top style="color:white; height:50px"><td>' . $person->get_email() . '</td></tr>';
                    echo '<tr valign=top style="color:white"><td>Contact time: </td></tr>';
                    echo '<tr valign=top style="color:white; height:50px"><td>' . $person->get_contact_time() . '</td></tr>';
                    echo '<tr valign=top style="color:white"><td>Preferred Method of Contact: </td></tr>';
                    echo '<tr valign=top style="color:white; height:50px"><td>' . $person->get_cMethod() . '</td></tr></table>';
                    echo '<h3 style="margin-left:40px;">Emergency Contact Information</h3>';
                    echo '<div style="margin-left:80px"></div>';
                    echo '<table style="margin-left:40px;"><tr valign=top><td style="color:white">Name:</td></tr>';
                    echo '<tr valign=top><td style="color:white; height:50px">' . $person->get_contact_name() . '</td></tr>';
                    echo '<tr valign=top style="color:white"><td>Telephone Number: </td></tr>';
                    echo '<tr valign=top style="color:white; height:50px;"><td>' . $person->get_contact_num() . '</td></tr>';
                    echo '<tr valign=top style="color:white"><td>Relationship: </td></tr>';
                    echo '<tr valign=top style="color:white; height:50px;"><td>' . $person->get_relation() . '</td></tr></table>';
                    //Availability
                    echo '<h3 style="margin-left:40px;">Availability</h3>';
                    echo '<div style="margin-left:80px"></div>';
                    $shifts = array('9-12' => '9-12', '12-3' => '12-3', '3-6' => '3-6',
                    '6-9' => '6-9');
                    $days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
                    echo '<table style="margin-left:40px;"><tr><td style="color:white">Monday&nbsp;&nbsp;</td><td style="color:white">Tuesday&nbsp;&nbsp;</td><td style="color:white">Wednesday&nbsp;&nbsp;</td>
                    <td style="color:white">Thursday&nbsp;&nbsp;</td><td style="color:white">Friday&nbsp;&nbsp;</td><td style="color:white">Saturday&nbsp;&nbsp;</td><td style="color:white">Sunday</td></tr>';
                    foreach ($shifts as $shift => $shiftvalue) {
                        echo ('<tr>');
                        foreach ($days as $day) {
                          $shiftdisplay=$shiftvalue;
                         //some stuff here is redundant, left over from old version w/ weekends having different hours
                         if (($shift!="night" || $day=="Fri" || $day=="Sat") && $shiftdisplay!="") {
                            $realkey = $day . ":". $shiftdisplay. ":". $person->get_venue();
                              echo ('<td class="fix" style="color:white"><input class="Enlarge form-check-input" type="checkbox" name="availability[]" value="' . $realkey . '"');
                           if (in_array($realkey, $person->get_availability())) echo(' CHECKED');
                           echo (' disabled>');
                           echo "<p class='Enlarge'> ".$shiftdisplay.'<p/></td>';
                          }
                          else echo "<td></td>";
                        }
                        echo ('</tr>');
                    }

                    echo '</table>';

                    // link to personal profile for editing
                    echo('<br><div class="container-fluid" id="scheduleBox" style="text-align:center"><p><strong>Edit Profile:</strong><br /></p><ul>');
                    echo('</ul><p>Click <strong><a href="personEdit.php?id='.$person->get_id().'">here</a></strong> to edit your account.</p></div>');
                    // view log of hours
                    echo('<br><div class="container-fluid" id="scheduleBox" style="text-align:center"><p><strong>View Log Of Hours:</strong><br /></p><ul>');
                    echo('<p class = "search-description">Date Range: ');
                    echo('<p id="fromto"> from : <input name = "from" type="text" size="10" id="from">');
                    echo('&nbsp;&nbsp;&nbsp;&nbsp;to : <input name = "to" type="text" size="10" id="to"></p>');

                    echo('To view report, click <input class="btn btn-success btn-sm" type="submit" value="Submit" id ="report-submit" class ="btn">');

                    echo('<p id="outputs">

                    </p>');

                    echo '</div>';
            ?>
            </form>
            <style>
                .square {
                height: 1500px;
                width: 930px;
                color: white;
                background-color: #870287;
                margin-left: 150px;
                padding-bottom: 200px;
                }
            </style>
        </div>
        <div style="padding-bottom: 150px"></div>
    </div>
    <?PHP
    include('footer.php');
    ?>
</body>
</html>