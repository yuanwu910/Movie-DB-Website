<!DOCTYPE html>
<html style="background-size: 400px">
	<head>
		<title> Home </title>
		<link href="style.css" type="text/css" rel="stylesheet" >

	</head>
	<body>

	<div id="header">
	<h1>Movie Website</h1>
	</div>

	<div id="nav">
		<br>
		<a href="actorinfo.php" target="iframe_a"><strong>Actorinfo</strong></a><br>
		<a href="movieinfo.php" target="iframe_a"><strong>Movieinfo</strong></a><br>
		<a href="AddActor.php" target="iframe_a"><strong>Add Actor/Director</strong></a><br>
		<a href="AddMovie.php" target="iframe_a"><strong>Add Movie</strong></a><br>
		<a href="AddMoA.php" target="iframe_a"><strong>Add Movie/Actor</strong></a><br>
		<a href="AddMoD.php" target="iframe_a"><strong>Add Movie/Director</strong></a><br>

		<form method="get" action="search.php" target="iframe_a";?>
			<input type="text" name="keyword" value="<?php echo $_POST['keyword'];?>" placeholder="Search">
			<button type="submit" name="submit">Search</button>
		</form>
		
	</div>

	<div id="section">
		<iframe src="home.php" name="iframe_a"></iframe>
	</div>

	<div id="footer">
	Copyright Yuan Wu & Ning Wang
	</div>

	</body>

</html>