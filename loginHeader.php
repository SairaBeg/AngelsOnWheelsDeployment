<?php
error_reporting(E_ERROR | E_PARSE);
/*
 * Copyright 2013 by Allen Tucker.
 * This program is part of RMHP-Homebase, which is free software.  It comes with
 * absolutely no warranty. You can redistribute and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 *
 */
?>

<link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="styling/header.css">
<script src="lib\bootstrap\js\bootstrap.js"></script>

<div class="d-flex justify-content-center" id="navigationLinks">
    <?PHP
        echo('<nav class="navbar navbar-custom navbar-expand-lg bg-light">');
        echo('<div class="container-fluid">');
        echo('<a class="navbar-brand" href="' . $path . 'index.php">
        <img src="images\angelsIcon.png" alt="Angles on Wheels Icon" width="203" height="63"></a>');
        echo('<a class="navbar-brand"><i>Homebase</i></a>');
        echo('<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>');
        echo('<div class="collapse navbar-collapse" id="navbarSupportedContent">');
        echo('<ul class="navbar-nav me-auto mb-2 mb-lg-0">');

        echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'about.php">About</a></li>');
        echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">Help</a></li>');
    ?>
</div>
