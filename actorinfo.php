<?php
	include('mysqlConnect.php');

	$id = $_GET['id'] ? $_GET['id'] : "25722";
	$query1= "select * from Actor where id = $id;";
	$actorinfo = $conn->query($query1);

	if (!$actorinfo)
	{
  		die('Could not find actor');
  	}
  	$arow = $actorinfo->fetch_assoc();

  	$query2 = "select * 
  			   from Movie, MovieActor 
  			   where MovieActor.aid = $id and MovieActor.mid = Movie.id ;";
  	$movie = $conn->query($query2);

  	mysql_close($conn);

?>

<!DOCTYPE html>
<html>
<head>
	<title> Actor Information </title>
	<style>
	a:link{
		text-decoration: none;
		color:purple;
	}
	a:hover{
		text-decoration: underline;
	}
	a:visited{
		text-decoration: none;
		color:purple;
	}
	</style>
</head>

<body style="font-family: Times; font-size: 20px；text-align:center">
	<!-- show actor info -->
	<h2> Actor Information </h2>
	<h3> <?php echo $arow["first"]." ".$arow["last"];?> </h3>
	<!-- <hr> -->
	<table>
            <tbody>
                <tr>
                    <td>First Name</td>
                    <td><?php echo $arow["first"];?></td>     
                </tr>
                <tr>
                	<td>Last Name</td>
                	<td><?php echo $arow["last"];?></td>
                </tr>
                <tr>
                	<td>Sex</td>
                    <td><?php echo $arow["sex"];?></td>   
                </tr>
                <tr>
                	<td>Date of Birth</td>
                    <td><?php echo $arow["dob"];?></td>   
                </tr>
                <tr>
                	<td>Date of Death&nbsp &nbsp</td>
                    <td><?php echo $arow["dod"]? $arow["dod"]: "N/A";?></td>   
                </tr>

            </tbody>
	</table>

	<hr>
	<!-- show actor's movies -->
	<div style="margin-top: 10px;margin-bottom:6px;"> Acting in </div>
	<div>
		<?php while($mrow = $movie->fetch_assoc()){ ?>
				<a href="movieinfo.php?id=<?php echo $mrow["mid"];?>"> 
				<?php echo $mrow["title"]."(".$mrow["year"].")"."<br>"; ?>
				</a>
		<?php }?>
	</div>

</body>
</html>














