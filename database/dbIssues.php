<?php

function report_issue($id,$name, $issues, $date, $evName, $evId) {
    $con=connect();
    $query = "INSERT INTO dbissues(`id`, `name`, `issue`, `date`, `event_name`, `event_id`) VALUES ('$id','$name','$issues','$date','$evName', '$evId')";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    if (!$result) {
        die("Error reporting Issue");
    } else{
        echo("Successfully reported Issue!");
    }
}

/**
 * returns Schedule Issues sorted by different metrics 
 * @return mysqli_result 
 */
function sort_issues($sort_field, $sort_direction) {
    $con=connect();
    $query = "SELECT * FROM dbissues ORDER BY $sort_field $sort_direction";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    if (!$result) {
        die("error getting log");
    } 
  /*  else {
        for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
       
            $result_row = mysqli_fetch_row($result);
            if ($result_row) {
                $ev[] = array($result_row[0],$result_row[1], $result_row[2], $result_row[3], $result_row[4], $result_row[5]);
            }
        }
    } */
    return $result;
}

?>