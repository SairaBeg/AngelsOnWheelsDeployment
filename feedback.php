<!DOCTYPE html>
<html lang="en">
<head>
    <title>Angels On Wheels Feedback Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include jQuery library for sliders -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="styling/feedbackForm.css">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <!-- Add script to initialize sliders -->
    <script>
        $(function() {
            $( "#satisfaction-slider" ).slider({
                range: "min",
                value: 3,
                min: 1,
                max: 5,
                step: 1,
                slide: function( event, ui ) {
                    $( "#satisfaction" ).val( ui.value );
                }
            });
            $( "#satisfaction" ).val( $( "#satisfaction-slider" ).slider( "value" ) );

            $( "#recommend-slider" ).slider({
                range: "min",
                value: 3,
                min: 1,
                max: 5,
                step: 1,
                slide: function( event, ui ) {
                    $( "#recommend" ).val( ui.value );
                }
            });
            $( "#recommend" ).val( $( "#recommend-slider" ).slider( "value" ) );

            $( "#volunteer-slider" ).slider({
                range: "min",
                value: 3,
                min: 1,
                max: 5,
                step: 1,
                slide: function( event, ui ) {
                    $( "#volunteer" ).val( ui.value );
                }
            });
            $( "#volunteer" ).val( $( "#volunteer-slider" ).slider( "value" ) );
        });
    </script>
</head>
<body>
<h1>Angels On Wheels Feedback Form</h1>
<form method="post">
    <p>How satisfied are you with Angels On Wheels?</p>
    <div class="slider-labels" style="padding-top: 15px;">
        <label>1 (Very Unsatisfied)</label>
        <label>2</label>
        <label>3</label>
        <label>4</label>
        <label>5 (Very Satisfied)</label>
    </div>
    <input type="text" id="satisfaction" name="satisfaction" readonly>
    <div id="satisfaction-slider"></div>
    <p style="padding-top: 15px;">How likely are you to recommend others to contribute to Angels On Wheels?</p>
    <div class="slider-labels" style="padding-top: 15px;">
        <label>1 (Not Likely)</label>
        <label>2</label>
        <label>3</label>
        <label>4</label>
        <label>5 (Very Likely)</label>
    </div>
    <input type="text" id="recommend" name="recommend" readonly>
    <div id="recommend-slider"></div>

    <p style="padding-top: 15px;">How likely are you to encourage others to volunteer for Angels On Wheels?</p>
    <div class="slider-labels" style="padding-top: 15px;">
        <label>1 (Not Likely)</label>
        <label>2</label>
        <label>3</label>
        <label>4</label>
        <label>5 (Very Likely)</label>
    </div>
    <input type="text" id="volunteer" name="volunteer" readonly>
    <div id="volunteer-slider"></div>

    <p style="padding-top: 15px;">Any recommendations you have for Angels On Wheels? (Optional)</p>
    <textarea name="recommendations" rows="9" cols="50" style="resize: none;"></textarea><br>

    <p style="padding-top: 15px;">Your name (Optional):</p>
    <input type="text" name="name">
    <div style="padding-top: 40px;">
        <input type="submit" name="submit" value="Submit">
    </div>
</form>

<?php
//include_once('database/dbinfo.php');
include_once('database/dbFeedback.php');

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Store form data in variables
    $id = 5;
    $satisfaction = $_POST['satisfaction'];
    $recommend = $_POST['recommend'];
    $volunteer = $_POST['volunteer'];
    $recommendations = $_POST['recommendations'];
    $name = $_POST['name'];
    $date = date("Y-m-d");

    $con = connect();

    $maxID = get_max_id();
    $id = $maxID + 1;

    insert_feedback($id, $name, $recommendations, $date, $satisfaction, $recommend, $volunteer);
}
?>

</body>
</html>
