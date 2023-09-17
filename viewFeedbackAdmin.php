<?php
include_once('database/dbinfo.php');
session_cache_expire(30);
session_start();
?>

<html>
	<head>
		<title>
			View Feedback
		</title>
		

<link type="text/css" rel="stylesheet" href="styling/viewFeedback.css" />

	</head>

	<body style="background-color: rgb(250, 249, 246);">
	<?php
				include('database/dbFeedback.php');

				$feedback=get_feedback();

				   ?>
		<div id="container">
			<?php include('header.php');
			echo ('<h3>Feedback from Volunteers</h3>');?>
			<div id="content" class="feedback">


				<form action="">
					<div class="row">
						<div class="col-md-4">
							<div class="input-group mb-3">
								<select name="sort_feedback" class="form-control">
									<option value="">Sort by...</option>
									<option value="a-z"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "a-z"){echo "selected";}?>>Name (Alphabetical)</option>
									<option value="z-a"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "z-a"){echo "selected";}?>>Name (Reverse Alphabetical)</option>
									<option value="satisfactionAsc"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "satisfactionAsc"){echo "selected";}?>>Satisfaction (Ascending)</option>
									<option value="satisfactionDes"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "satisfactionDes"){echo "selected";}?>>Satisfaction (Descending)</option>
									<option value="recommendAsc"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "recommendAsc"){echo "selected";}?>>Likely to Reccomend (Ascending)</option>
									<option value="recommendDes"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "recommendDes"){echo "selected";}?>>Likely to Reccomend (Descending)</option>
									<option value="encourageAsc"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "encourageAsc"){echo "selected";}?>>Likely to Encourage  (Ascending)</option>
									<option value="encourageDes"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "encourageDes"){echo "selected";}?>>Likely to Encourage (Descending)</option>
									<option value="dateAsc"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "dateAsc"){echo "selected";}?>>Date (Oldest to Newest)</option>
									<option value="dateDes"<?php if(isset($_GET['sort_feedback']) && $_GET['sort_feedback'] == "dateDes"){echo "selected";}?>>Date (Newest to Oldest)</option>
									
								</select>
								<button type="submit" class="input-group-text" id="basic-addon2">Sort

								</button>
							</div>

						</div>		
					</div>
				</form>	

				<div class= "table-responsive">
					<form method="POST">
					<table class="table feedback-table">
						<thead>
							<tr>
								<th> Name</th>
								<th> Feedback</th>
								<th> Satisfaction (1-5)</th>
								<th> Likely to Recommend for Others to Contribute (1-5)</th>
								<th>Likely to Encourage Others to Volunteer (1-5)</th>
								<th>Date </th>
								<th><input type="submit" value="Delete Selected Feedback" name="delete"></th>
							</tr>
						</thead>	
						<tbody>
							<?php
						
				$con=connect();
    $sort_direction = "ASC";
	$sort_field = "id";
    if(isset($_GET['sort_feedback'])){
        if($_GET['sort_feedback'] == "a-z"){
			$sort_field = "name";
            $sort_direction = "ASC";
        }else if ($_GET['sort_feedback'] == "z-a"){
            $sort_direction = "DESC";
			$sort_field = "name";
        }else if ($_GET['sort_feedback'] == "satisfactionAsc"){
            $sort_direction = "ASC";
			$sort_field = "satisfaction_rank";
        }else if ($_GET['sort_feedback'] == "satisfactionDes"){
            $sort_direction = "DESC";
			$sort_field = "satisfaction_rank";
        }else if ($_GET['sort_feedback'] == "recommendAsc"){
            $sort_direction = "ASC";
			$sort_field = "recommend_rank";
        }else if ($_GET['sort_feedback'] == "recommendDes"){
            $sort_direction = "DESC";
			$sort_field = "recommend_rank";
        }else if ($_GET['sort_feedback'] == "encourageAsc"){
            $sort_direction = "ASC";
			$sort_field = "volunteer_rank";
        }else if ($_GET['sort_feedback'] == "encourageDes"){
            $sort_direction = "DESC";
			$sort_field = "volunteer_rank";
        }else if ($_GET['sort_feedback'] == "dateAsc"){
            $sort_direction = "ASC";
			$sort_field = "date";
        }else if ($_GET['sort_feedback'] == "dateDes"){
            $sort_direction = "DESC";
			$sort_field = "date";
        }
      
    }
    $query = "SELECT * FROM dbFeedback ORDER BY $sort_field $sort_direction";
    $result = mysqli_query($con,$query);
    
    if (!$result) {
        die("error getting feedback");
    } 
	if (mysqli_num_rows($result) > 0){
		foreach($result as $row){
			?>
			<tr>
				<td> <?=$row['name']; ?></td>
					<td><?=$row['feedback']; ?> </td>
					<td> <?=$row['satisfaction_rank']; ?></td>
					<td><?=$row['recommend_rank'];?></td>
					<td><?=$row['volunteer_rank'];?></td>
					<td><?=$row['date'];?></td>
					<td style="text-align:center; vertical-align:middle;"><input style="text-align:center; vertical-align:middle" type="checkbox" name="checkbox[]" value="<?=$row['id'];?>">
					
					</td>
					
		</tr>
		</form>
		<?php
		}
	}else{
		?>
		<tr>
			<td colspan= "7"> There is currently no feedback from volunteers</td>
	</tr>

	<?php
	}

?>
<?php
				//if "deleted selected feedback" AND checkboxes are selected		
					if(isset($_POST['delete']) && isset($_POST['checkbox'])){
							$del= count((array)$_POST['checkbox']);
							
							$i = 0;

							while ($i<$del){
								echo($_POST['checkbox'][$i]);
								$keyToDelete = $_POST['checkbox'][$i];
								echo($keyToDelete);

								mysqli_query($con, "DELETE from dbFeedback WHERE id = '$keyToDelete'");
								$i++;
							}
							echo "<meta http-equiv='refresh' content='0'>";
							
						}
						?>
						</tbody>
				</div>		
</table>
			
				<br><br><br><br>
		</div>
</div>
	</body>
<footer>
	<?php mysqli_close($con); include('footer.php');?>
</footer>

</html>
