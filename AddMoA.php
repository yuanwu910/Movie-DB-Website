<?php
//include connect.php page for database connection
include('mysqlConnect.php');
//Query in the Selected Database;
$sql = "SELECT CONCAT(title,'(',year,')') AS MovieName, id FROM Movie;";
$AllMovie = mysqli_query($conn, $sql);

if (!$AllMovie) {
$errmsg = mysqli_error();
echo "Sql Err: $errmsg";
exit(0);
}

$sql = "SELECT id, CONCAT(first, ' ',last) AS ActorName FROM Actor ORDER BY first ASC;";
$AllActor = mysqli_query($conn, $sql);

if (!$AllActor) {
$errmsg = mysqli_error();
echo "Sql Err: $errmsg";
exit(1);
}

mysqli_close($conn);
?>

<?php
//if submit is not blanked i.e. it is clicked.
if (isset($_POST["submit"])) {
	$role = $_POST['role'];
	$actor = $_POST['actor'];
	$movie = $_POST['movie'];
		
		//Check if message has been entered
		if (empty($_POST['role'])) { $errRole = 'Please enter the Role in Movie';}
		//Check if message has been entered
		if (empty($_POST['actor'])) { $errActor = 'Please choose actor';}
		if (empty($_POST['movie'])) { $errMovie = 'Please choose movie';}
	
	$validInput = !$errRole && !$errActor && !$errMovie;
}

?>

<?php
if ($validInput) {
	//include connect.php page for database connection
	include('mysqlConnect.php');
	//Query in the Selected Database;

	$sql = "INSERT INTO MovieActor VALUES ('$movie', '$actor', '$role');";
				
	$rsInsert = mysqli_query($conn, $sql);
    if (!$rsInsert) {
  		$errmsg = mysqli_error();
  		echo "Sql Err: $errmsg";
  		exit(2);
  	}else{
  		$result = "You have successfully added 1 record to Movie/Actor Relation!";
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
  <body >
  	<h2>Add Movie/Actor Relation</h2>   
	<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="movie"><strong>Movie</strong></label>
				<select id="movie" name="movie">
					<option selected value="">Please Select</option>
						<?php
								if ($AllMovie->num_rows > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($AllMovie)) {
							?>
								<option value = <?php echo $row["id"] ?>> <?php echo $row["MovieName"] ?></option>
							<?php	}
								}else{
							?>
								<option>No Movie</option>
						<?php } ?>
				</select><br/><br/>

		<label for="actor" ><strong>Actor</strong></label>
					<select id="actor" name="actor">
 							<option selected value="">Please Select</option>
 							<?php
								if ($AllActor->num_rows > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($AllActor)) {
							?>
								<option value = <?php echo $row["id"] ?>><?php echo $row["ActorName"] ?></option>
							<?php	}
								}else{
							?>
								<option>No Actor</option>
							<?php } ?>
				    </select>

	    <label for="role" >Role</label>
		<input type="text" class="form-control" id="role" name="role" placeholder="Role in the Movie">

 		<input id="submit" name="submit" type="submit" value="Add">
 		<br/><br/>
 		<?php if($result) { ?> 
					<span class="successfully"><strong>SUCCESS: </strong><?php echo $result ?></div></span><br/>
					<?php } ?>
  </body>
</html>
