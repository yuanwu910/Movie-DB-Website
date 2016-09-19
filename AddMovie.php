<?php
//if submit is not blanked i.e. it is clicked.
if (isset($_POST["submit"])) {
	$title = $_POST['title'];
	$year = $_POST['year'];
	$rating = $_POST['rating'];
	$company = $_POST['company'];
	$genre_arr = $_POST['genre'];
		
		// Check if title has been entered
		if (empty($_POST['title'])) { $errTitle = 'Please enter the title of Movie';}
		// Check if year has been entered and is valid
		if (empty($_POST['year'])) { $errYear = 'Please enter a valid production year';}
		//Check if message has been entered
		if (empty($_POST['rating'])) { $errRating = 'Please enter the rating';}
		if (empty($_POST['company'])) { $errCompany = 'Please enter a company';}
		if (empty($_POST['genre'])) { $errGenre = 'Please choose a genre';}
	
	$validInput = !$errTitle && !$errYear && !$errRating && !$errCompany && !$errGenre;
}

?>

<?php
if ($validInput) {
	//include connect.php page for database connection
	include('mysqlConnect.php');

	$sql = "SELECT * FROM MaxMovieID;";
	$rsSelect = mysqli_query($conn, $sql);
	
	//Querying Exception Handling;
	if(!$rsSelect) {
		$errmsg = mysqli_error();
		$result = "false1";
		$flag = false;}
	else{
		$row = mysqli_fetch_assoc($rsSelect);
		$newID = $row["id"];

		$sql = "UPDATE MaxMovieID SET id = id + 1;";
		$rsUpdate = mysqli_query($conn, $sql);
		
		if(!$rsUpdate) {
    		$errmsg = mysqli_error();
			$result = "false2";
			$flag = false;	}
		else{
			$sql = "INSERT INTO Movie VALUES ('$newID', '$title', '$year', '$rating', '$company');";
			foreach ($genre_arr as $k=>$v){ 
				$sql .= "INSERT INTO MovieGenre VALUES ('$newID', '$v');";
			}
			$rsInsert = mysqli_multi_query($conn, $sql);
    		if (!$rsInsert) {
  				$errmsg = mysqli_error();
				$result = "false3";
				$flag = false;	
  			}else{
				$result = "ADD SUCCESS";
				$flag = true;
			}
		}
	}
	$finished = ture;
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


<h2>Add Movie</h2> 
<p><span class="error">* required field.</span></p>  
<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="title"><strong>Title</strong></label>
		<input type="text" id="title" name="title" placeholder="Title (eg. Titanic)">
		<span class="error">* <?php echo $errTitle;?></span><br/><br/>
        
        <label for="year"><strong>Year</strong></label>
		<input type="number"  id="Year" name="year" placeholder="yyyy">
		<span class="error">* <?php echo $errYear;?></span><br/><br/>


		<label for="rating"><strong>Rating</strong></label>
			<select class="form-control" id="rating" name="rating">
					    <option selected value="">Please Select</option>
 						<option>surrendere</option>
					 	<option>R</option>
 						<option>G</option>
 						<option>PG</option>
 						<option>PG-13</option>
						<option>NC-17</option>
					</select>
		<span class="error">* <?php echo $errYear;?></span><br/><br/>
        
        <label for="company"><strong>Company</strong></label>
		<input type="text" id="company" name="company" placeholder="company name">
		<span class="error">* <?php echo $errCompany;?></span><br/><br/>

        <label for="genre" ><strong>Genre</strong></label><span class="error">* <br/>
        <?php echo $errGenre;?></span><br/>
		<input type="checkbox" id="genre[]" name="genre[]" value="Action">Action
        <input type="checkbox" id="genre[]" name="genre[]" value="Adult">Adult
		<input type="checkbox" id="genre[]" name="genre[]" value="Adventure">Adventure
		<input type="checkbox" id="genre[]" name="genre[]" value="Animation">Animation
		<input type="checkbox" id="genre[]" name="genre[]" value="Comedy">Comedy
		<input type="checkbox" id="genre[]" name="genre[]" value="Crime">Crime
		<input type="checkbox" id="genre[]" name="genre[]" value="Documentary">Documentary
		<input type="checkbox" id="genre[]" name="genre[]" value="Drama">Drama
		<input type="checkbox" id="genre[]" name="genre[]" value="Family">Family<br/>
		<input type="checkbox" id="genre[]" name="genre[]" value="Fantasy">Fantasy
		<input type="checkbox" id="genre[]" name="genre[]" value="Horror">Horror
		<input type="checkbox" id="genre[]" name="genre[]" value="Musical">Musical
		<input type="checkbox" id="genre[]" name="genre[]" value="Mystery">Mestery
		<input type="checkbox" id="genre[]" name="genre[]" value="Romance">Romance
		<input type="checkbox" id="genre[]" name="genre[]" value="Sci-Fi">Sci-Fi
		<input type="checkbox" id="genre[]" name="genre[]" value="Short">Short
		<input type="checkbox" id="genre[]" name="genre[]" value="Thriller">Thriller
		<input type="checkbox" id="genre[]" name="genre[]" value="War">War
		<input type="checkbox" id="genre[]" name="genre[]" value="Western">Western
		<br/><br/>

        <input id="submit" name="submit" type="submit" value="Add">
        <br/><br/>

        <?php if($finished && $flag) { ?> 
					<span class="successfully"> <strong><?php echo $result ?> </strong></span><br/><br/>
					<?php }elseif ($finished && !$flag) { ?>
					<strong>FAILURE: </strong><?php echo $result ?>
		<?php } ?>
</form>

</body>
</html>