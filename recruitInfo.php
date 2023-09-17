<?php
    //echo "hello";
    session_cache_expire(30);
    session_start();
?>
<html lang="">

<?PHP include('header.php'); ?>
<h2>Recruit Information</h2>
<?PHP
if($_SESSION['access_level'] >= 2){
    $con = connect();
    $app_query = "SELECT first_name,last_name,id,start_date FROM dbPersons WHERE status LIKE '%applicant%'  AND venue='" .
        $_SESSION['venue'] . "'order by start_date desc";
    $applicants_tab = mysqli_query($con, $app_query);
    $numLines = 0;
    //   if (mysqli_num_rows($applicants_tab) > 0) {
    echo ('<div class="container-fluid"><p><b>Open Applications / Dates:</b></p><ul class="list-group list-group-flush">');
    while ($thisRow = mysqli_fetch_array($applicants_tab, MYSQLI_ASSOC)) {
        echo ('<li class="list-group-item w-25 p-3 list-custom"><a href="' . $path . 'personEdit.php?id=' . $thisRow['id'] . '" id = "appLink">' .
            $thisRow['last_name'] . ', ' . $thisRow['first_name'] . '</a> / ' .
            $thisRow['start_date'] . '</li>');
    }
    echo ('</ul></div>'); //<br>'
    //    }
    mysqli_close($con);
}
?>
<?PHP
include('footer.php');
?>
</html>