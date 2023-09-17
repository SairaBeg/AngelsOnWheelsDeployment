<?php
/*
 * Copyright 2015 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
session_cache_expire(30);
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About</title>
    <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="styling/about.css" type="text/css" />
</head>
<?php include('header.php'); ?>
<body>
<div class="container" style="padding-bottom: 20px;">
    <img class='mx-auto d-block'src="images\angelsIcon.png" alt="Angles on Wheels Icon" style='max-width: 20%'>
          </a>
    <div id="content" class="mt-4">
        <h2 class="text-center"><strong>About Angels on Wheels</strong></h2>
        <p class="text-center">The Angels are on a mission to “Love Thy Neighbors” by changing the lives of our neighbors who are at risk of becoming homeless and hungry. 
            Providing resources and support such as food, shelter,  and necessities to improve the lives of our neighbors while bridging the gap between community 
            agencies and their clients by providing volunteer services.</p>

        <p class="text-center">Angels On Wheels Charity Organization (AOWCO) is a 501(c)(3) Nonprofit Organization. 
            We were created to help those in need within the communities while working towards ending homelessness and hunger.</p>

        <p class="text-center">The AOWCO helps people in need by addressing economic challenges such as issues that stem from low wages, unaffordable housing, and food insecurity. 
            We provide a range of support and services to empower communities by addressing the root causes and social issues. 
        We spend as much time and resources on homelessness and hunger prevention strategies and research as we provide services to those currently at risk of 
        becoming homeless community, those suffering from food insecurities and those in need of resources.</p>

        <div>
            <h3 class="section-title text-center "><strong>Our Vision</strong></h3>
            <p class="text-center">Our vision is a nation where every individual has access to the basic necessities of life and the opportunity to live with dignity and self-sufficient.
A world without people in need,
A community that collaborates so neighbors are helping other neighbors,
A community where hope lives and hunger no longer forces acts of desperation,
A thriving community where even the vulnerable neighbors are given the tools to flourish.</p>
        </div>

        
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
