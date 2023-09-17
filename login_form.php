<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHC-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
?><?php
/*
 * Created on Mar 28, 2008
 * @author Oliver Radwan <oradwan@bowdoin.edu>, Sam Roberts, Allen Tucker
 * @version 3/28/2008, revised 7/1/2015
 */
?>
<?php //include('loginHeader.php'); ?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/login.css">
    <title>Angels On Wheels Login</title>
</head>

<body>
<div class="page-container">
    <div class="content-container" style="padding-bottom: 100px;">
<div id="content">
    <?PHP
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    if (($_SERVER['PHP_SELF']) == "/logout.php") {
        //prevents infinite loop of logging in to the page which logs you out...
        echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
    }
    if (!array_key_exists('_submit_check', $_POST)) {
        echo('

        <p><div align="center"><img src="images\icon_and_text.png" style="height:130px;" alt="Angles on Wheels Icon">
        <br/><br/>
        <b>Enter Username and Password</b><br><br>' .
        '<ul>'
        );
        
        echo('<div align="left" style="font-size: 12px; padding-right: 32px;"><li>If you are applying for a volunteer position, select the "Create Account" option. ');
        echo('<li>If you are a volunteer logging in for the first time, both your Username and Password is your first name followed by your ten digit phone number. ');
        echo('<li>After you have logged in, you can change your password. ');
        /*echo('<li>(If you are having difficulty logging in or have forgotten your Password, please contact either the
                <a href="mailto:allen@npfi.org"><i>Portland House Manager</i></a>
                or the <a href="mailto:allen@npfi.org"><i>Bangor House Manager</i></a>.) ');*/
        echo '</ul>';

        echo('<p><table><form method="post"><input type="hidden" name="_submit_check" value="true"><tr><td style="font-size: 14px; padding-top: 15px;"><pre><b>Username     </br></pre></td>
        		<td><input type="text" name="user" tabindex="1" style="border: 1px solid black; margin-top: .2in;"></td></tr>
        		<tr><td style="font-size: 14px; padding-top: 15px;"><pre><b>Password     </b></pre></br></td><td><input type="password" name="pass" tabindex="2" 
                style="border: 1px solid black"></td></tr><tr><td colspan="2" align="center"><input type="submit" 
                name="Login" value="Login" style="margin-top: .3in;"></td></tr></table>');
                
                echo ('
                <input type="submit" name="user" value="Create Account" style="background-color: blue; color: white; 
                border: none; padding: 8px; border-radius: 5px; width: 296px;"</input></form>');

                
    } else {
        //login as a guest
        if ($_POST['user'] == "Create Account" && $_POST['pass'] == "") {
            $_SESSION['logged_in'] = 1;
            $_SESSION['access_level'] = 0;
            $_SESSION['venue'] = "";
            $_SESSION['type'] = "";
            $_SESSION['_id'] = "guest";
            echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
        }
        //otherwise authenticate their password
        else {
            $db_pass = md5($_POST['pass']);
            
            $db_id = $_POST['user'];
            $person = retrieve_person($db_id);
            if ($person) { //avoids null results
                if ($person->get_password() == $db_pass) { //if the passwords match, login
                    $_SESSION['logged_in'] = 1;
                    date_default_timezone_set ("America/New_York");
                    if ($person->get_status() == "applicant")
                        $_SESSION['access_level'] = 0;
                    else if (in_array('manager', $person->get_type()))
                        $_SESSION['access_level'] = 2;
                    else
                        $_SESSION['access_level'] = 1;
                    $_SESSION['f_name'] = $person->get_first_name();
                    $_SESSION['l_name'] = $person->get_last_name();
                    $_SESSION['venue'] = $person->get_venue();
                    $_SESSION['type'] = $person->get_type();
                    $_SESSION['_id'] = $_POST['user'];
                    echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
                }
                else {
                    echo('<div align="left"><p class="error">Error: invalid username/password</p><p>Access to Homebase requires a Username and a Password.');
                    echo('<p>If you are a volunteer, your Username is your first name followed by your phone number with no spaces. ' .
                    'For instance, if your first name were John and your phone number were (207)-123-4567, ' .
                    'then your Username would be <strong>John2071234567</strong>.  ');
                    /*echo('If you do not remember your password, please contact either the
        		<a href="mailto:allen@npfi.org"><i>Portland House Manager</i></a>
        		or the <a href="mailto:allen@npfi.org"><i>Bangor House Manager</i></a>.');*/
                    echo('<p><table><form method="post"><input type="hidden" name="_submit_check" value="true"><tr><td>Username:</td><td><input type="text" name="user" tabindex="1"></td></tr><tr><td>Password:</td><td><input type="password" name="pass" tabindex="2"></td></tr><tr><td colspan="2" align="center"><input type="submit" name="Login" value="Login"></td></tr></table>');
                }
            } else {
                //At this point, they failed to authenticate
                echo('<div align="left"><p class="error">Error: invalid username/password</p><p>Access to Homebase requires a Username and a Password.');
                echo('<p>If you are a volunteer, your Username is your first name followed by your phone number with no spaces. ' .
                'For instance, if your first name were John and your phone number were (207)-123-4567, ' .
                'then your Username would be <strong>John2071234567</strong>.  ');
                /*echo('If you do not remember your password, please contact either the
        		<a href="mailto:allen@npfi.org"><i>Portland House Manager</i></a>
        		or the <a href="mailto:allen@npfi.org"><i>Bangor House Manager</i></a>.');*/
                echo('<p><table><form method="post"><input type="hidden" name="_submit_check" value="true"><tr><td>Username:</td><td><input type="text" name="user" tabindex="1"></td></tr><tr><td>Password:</td><td><input type="password" name="pass" tabindex="2"></td></tr><tr><td colspan="2" align="center"><input type="submit" name="Login" value="Login"></td></tr></table>');
            }
        }
    }?>
                </div>
        </div>
</div>
        <footer class="footer">
            <?php include('footer.php'); ?>
        </footer>
</body>

</html>
