<?php
include('mysqlConnect.php');
//Query in the Selected Database;
$sql = "SELECT id, CONCAT(title,'(',year,')') AS MovieName  FROM Movie;";
$AllMovie = mysqli_query($conn, $sql);
if (!$AllMovie) {
$errmsg = mysqli_error();
echo "Sql Err: $errmsg";
exit(0);
}

$sql = "SELECT id, CONCAT(first, ' ',last)AS DirectorName  FROM Director ORDER BY first ASC;";
$AllDirector = mysqli_query($conn, $sql);
if (!$AllDirector) {
$errmsg = mysqli_error();
echo "Sql Err: $errmsg";
exit(1);
}

mysqli_close($conn);
?>

<?php
//if submit is not blanked i.e. it is clicked.
if (isset($_POST["submit"])) {
	$director = $_POST['director'];
	$movie = $_POST['movie'];
		
		//Check if message has been entered
		if (empty($_POST['director'])) { $errDirector = 'Please choose director'; }
		if (empty($_POST['movie'])) { $errMovie = 'Please choose movie'; }
	
	$validInput = !$errDirector && !$errMovie;
}
?>

<?php
if ($validInput) {
	//include connect.php page for database connection
	include('mysqlConnect.php');
	//Query in the Selected Database;

	$sql = "INSERT INTO MovieDirector VALUES ('$movie', '$director');";
				
	$rsInsert = mysqli_query($conn, $sql);
    if (!$rsInsert) {
  		$errmsg = mysqli_error();
  		echo "Sql Err: $errmsg";
  		exit(2);
  	}else{
  		$result = "New record is added to Movie/Director Relation.";
  	}

mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
	<style>
	.error {color: #EE4000;}
	.successfully{color: #548B54}
	</style>
  </head>
  <body>
  	<h2>Add Movie/Director Relation</h2>  
  	<form  role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label for="movie">Movie</label>
				<select class="form-control" id="movie" name="movie">
					<option selected value="">Please Select</option>
							<?php
								if ($AllMovie->num_rows > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($AllMovie)) {
							?>
								<option value = <?php echo $row["id"] ?>><?php echo $row["MovieName"] ?></option>
							<?php	}
								}else{
							?>
								<option>No Movie</option>
							<?php } ?>
				</select><br/><br/>

	<label for="director">Director</label>
			<select class="form-control" id="director" name="director">
 					<option selected value="">Please Select</option>
 							<?php
								if ($AllDirector->num_rows > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($AllDirector)) {
							?>
								<option value = <?php echo $row["id"] ?>><?php echo $row["DirectorName"] ?></option>
							<?php	}
								}else{
							?>
								<option>No Director</option>
							<?php } ?>
			</select>
	<input id="submit" name="submit" type="submit" value="Add">
	<br/><br/>
	<?php if($result) { ?> 
			<span class="successfully"><strong><?php echo $result ?></strong></div>
					<?php } ?>

</body>
</html>