<?php
error_reporting(E_ERROR | E_PARSE);
include_once('dbinfo.php');
function insert_feedback($id, $name, $recommendations, $date, $satisfaction, $recommend, $volunteer) {
    global $con, $id, $name, $recommendations, $date, $satisfaction, $recommend, $volunteer;

    // Prepare and bind SQL statement
    $stmt = $con->prepare("INSERT INTO dbfeedback (id, name, feedback, date, satisfaction_rank, recommend_rank, volunteer_rank) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $id, $name, $recommendations, $date, $satisfaction, $recommend, $volunteer);

    // Execute statement and check if successful
    if ($stmt->execute()) {
        // Close statement and connection
        $stmt->close();
        $con->close();

        // Create alert box using JavaScript
        echo "<script>alert('Thank you for your feedback! Your response has been recorded.');</script>";

        // Redirect back to home page after a delay
        echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 5);</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

/**
 * deletes a feedback entry
 */
function delete_feedback_entry($id) {
    $con=connect();
    $query = "DELETE FROM dbFeedback WHERE id=\"" . $id . "\"";
    $result = mysqli_query($con,$query);
    if (!$result)
        echo mysqli_error($con);
    mysqli_close($con);
}

/**
 * deletes feedback entries with ids specified in array $ids
 * @param array of feedback ids
 */
function delete_feedback_entries($ids) {
    $con=connect();
    for ($i = 0; $i < count((array)$ids); ++$i) {
        $query = "DELETE FROM dbFeedback WHERE id=\"" . $ids[$i] . "\"";
        $result = mysqli_query($con,$query);
        if (!$result)
            echo mysqli_error($con);
    }
    mysqli_close($con);
}

/**
 * returns all Feedback entries
 * @return array of id, name, feedback, and date
 */
function get_feedback() {
    $con=connect();
    $query = "SELECT * FROM dbFeedback";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    if (!$result) {
        die("error getting log");
    } else {
        for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
       
            $result_row = mysqli_fetch_row($result);
            if ($result_row) {
                $fb[] = array($result_row[0],$result_row[1], $result_row[2], $result_row[3]);
            }
        }
    }
    return $fb;
}

/**
 * returns max id
 */
function get_max_id() {
    $con = connect();
    $query = "SELECT MAX(id) FROM dbFeedback";
    $result = mysqli_query($con, $query);
    mysqli_close($con);
    if (!$result) {
        die("error getting max id");
    } else {
        $row = mysqli_fetch_row($result);
        return (int) $row[0];
    }
}
?>
