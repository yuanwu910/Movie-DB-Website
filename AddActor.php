<?php

if (isset($_POST["submit"])) {
	$role = $_POST['role'];
	$last = $_POST['last'];
	$first= $_POST['first']; 
	$sex = $_POST['sex'];
	$dob = $_POST['dob'];
	$dod = $_POST['dod'];
		
		// Check if role has been entered
		if (empty($_POST['role'])) {
			$errRole = 'Please choose the Role';
		}	
		
		if (empty($_POST['last'])) {
			$errLast = 'Last name is required';
		}
		
		// Check if the name has been entered
		if (empty($_POST['first'])) {
			$errFirst = 'First name is required';
		}
		
		// check the role has a sex
		if (($role == "Actor" || $role == "Actor" ) && empty($_POST['sex'])) {
			$errSex = 'Please enter the sex';
		}
		
		//Check if date of birth has been entered and valid
		if (empty($_POST['dob'])) {
			 $errDob = 'Please enter date of birth';
		}elseif (!validTime($dob)) {
			$errDob = 'Please enter a date as yyyy-mm-dd';
		}

		// check the date of death is valid
		if ($_POST['dod'] && !validTime($_POST['dod'])) {
			$errDod = 'Please enter a date as yyyy-mm-dd';
		}
	$validInput = !$errRole && !$errLast && !$errFirst && !$errSex && !$errDob && !$errDod;
}

//--------------------------functions------------------------------//
function validTime($time){
	$patten = "/\d{4}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])$/";  // valid yyyy-mm-dd pattern
	if (preg_match($patten, $time)) { return true;} 
   	else {  return false; } 
}

?>

<?php
if ($validInput) {
	//include connect.php page for database connection
	include('mysqlConnect.php');
	//Query in the Selected Database;
	$sql = "SELECT * FROM MaxPersonID;";
	$rsSelect = mysqli_query($conn, $sql);
	//Querying Exception Handling;
	if(!$rsSelect) {
		$errmsg = mysqli_error();
		$result = "Sql Err1: $errmsg";
		$flag = false;
	}else{
		$row = mysqli_fetch_assoc($rsSelect);
		$newID = $row["id"];

		$sql = "UPDATE MaxPersonID SET id = id + 1;";
		$rsUpdate = mysqli_query($conn, $sql);
		
		if(!$rsUpdate) {
    		$errmsg = mysqli_error();
			$result = "Sql Err2: $errmsg";
			$flag = false;	
		}else{
			if($role == "Actor"){
				if(!$dod){
					$sql = "INSERT INTO Actor VALUES ('$newID', '$last', '$first', '$sex', '$dob', null);";
				}else{
					$sql = "INSERT INTO Actor VALUES ('$newID', '$last', '$first', '$sex', '$dob', '$dod');";
				}
			}else if($role == "Director"){
				if(!$dod){
					$sql = "INSERT INTO Director VALUES ('$newID', '$last', '$first', '$dob', null);";
				}else{
					$sql = "INSERT INTO Director VALUES ('$newID', '$last', '$first', '$dob', '$dod');";
				}
			}
			$rsInsert = mysqli_query($conn, $sql);
    		if (!$rsInsert) {
  				$errmsg = mysqli_error();
  				$result = "Sql Err3: $errmsg";
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


<!--     html      -->
<!DOCTYPE html>
<html lang="en">
 <head>
 <style>
.error {color: #EE4000;}
.successfully{color: #548B54}
</style>
 </head>
 <body >


 <h2>Add Actor/Director</h2> 
 <p><span class="error">* required field.</span></p>  

 	<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 		
 			<label for="role"><strong>Role </strong></label><span class="error">* <?php echo $errRole;?></span><br/>
 				<label><input type="radio" name="role" value="Actor">Actor</label>
				<label><input type="radio" name="role" value="Director">Director</label>
			<br/><br/>
	
			<label for="first"><strong>FirstName</strong></label>
			<input type="text"  id="first" name="first" placeholder="First Name">
			<span class="error">* <?php echo $errFirst;?></span><br/><br/>
		

			<label for="last" > <strong>LastName</strong></label>
			<input type="text"  id="last" name="last" placeholder="Last Name">
			<span class="error">* <?php echo $errLast;?></span><br/><br/>

			<label for="sex"> <strong>Sex </strong> </label>
					<select id="sex" name="sex">
	 						<option>Female</option>
						 	<option>Male</option>
					</select>
					<span class="error">* <?php echo $errSex;?></span><br/><br/>
		

			<label for="dob"> <strong>DateOfBirth</strong></label>
				
					<input type="text" id="dob" name="dob" placeholder="yyyy-mm-dd">
					<span class="error">* <?php echo $errDob;?></span>
				<br/><br/>

				<label for="dod"><strong>DateOfDeath</strong></label>
				<input type="text" id="dod" name="dod" placeholder="yyyy-mm-dd">
				<span class="error"><?php echo $errDod;?></span><br/><br/>
				

		<input id="submit" name="submit" type="submit" value="Add">
		<br/><br/>

			<?php if($finished && $flag) { ?> 
				<span class="successfully"> <strong><?php echo $result ?></strong></span><br/><br/>
				<?php }elseif ($finished && !$flag) { ?>
				<strong>ADD FAILED: </strong><?php echo $result ?>
			<?php } ?>
		
		
	</form>

 </body>
</html>

