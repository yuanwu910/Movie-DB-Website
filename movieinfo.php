<?php
	include('mysqlConnect.php');

	$id = $_GET['id'] ? $_GET['id'] : "4";
	$query1= "select * from Movie where id = $id;";
	$movieinfo = $conn->query($query1);

  	$mrow = $movieinfo->fetch_assoc();

  	$query2 = "select Actor.first as first, Actor.last as last, Actor.id as aid
  			   from Actor, MovieActor 
  			   where MovieActor.mid = $id and MovieActor.aid = Actor.id;";
  	$actor = $conn->query($query2);

  	$query3 = "select avg(rating) as avgrating
  			   from Review
  			   where mid = $id;";

  	$rating = $conn->query($query3);
  	$avgrat = $rating->fetch_assoc();

  	$query4 = "select comment
  			   from Review
  			   where mid = $id;";

  	$comment = $conn->query($query4);

  	$query5 = "select Director.last, Director.first from MovieDirector, Director where Director.id = MovieDirector.did and MovieDirector.mid = $id";
  	$director = $conn->query($query5);
  	$drow = $director->fetch_assoc();

  	$query6 = "select genre from MovieGenre where mid = $id;";
  	$genre = $conn->query($query6);
  	$grow = $genre->fetch_assoc();
  	mysql_close($conn);

?>

<!DOCTYPE html>
<html>
<head>
	<title> Movie Information </title>
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
	.add :{
		height:50px;
	    width:120px;
	    border-color:#6495ED;
	    background-color:#BCD2EE;
	    border-radius: 5px;
	    margin:auto;
	    text-align:center;
	}
	</style>
</head>

<body style="font-family: Times; font-size: 20px；">
	<!-- show movie info -->
	<h2> Movie Information </h2>
	<h3> <?php echo $mrow["title"]." (".number_format($avgrat["avgrating"],1).")";?> </h3>
	<table>
            <tbody>
                <tr>
                    <td>Title </td>
                    <td><?php echo $mrow["title"];?></td>     
                </tr>
                <tr>
                	<td>Year</td>
                	<td><?php echo $mrow["year"];?></td>
                </tr>
                <tr>
                	<td>Director </td>
                    <td><?php echo $drow["first"]? $drow["first"]:"N/A"; echo " ".$drow["last"];?> </td>   
                </tr>
                <tr>
                	<td>Genre</td>
                    <td><?php echo $grow["genre"]? $grow["genre"]:"N/A";?></td>   
                </tr>
                <tr>
                	<td>Rating </td>
                    <td><?php echo $mrow["rating"];?></td>   
                </tr>
                <tr>
                	<td>Company &nbsp</td>
                    <td><?php echo $mrow["company"];?></td>   
                </tr>

            </tbody>
	</table>
	<hr>
	<!-- show actors in this movie -->
	<div style="margin-top: 10px;margin-bottom:6px;"> Actors in movie</div>
		<?php while($arow = $actor->fetch_assoc()){ ?>
				<a href="actorinfo.php?id=<?php echo $arow["aid"];?>"> 
				<?php echo $arow["first"]." ".$arow["last"]."<br>"; ?>
				</a>
		<?php }?>
	<hr>
	<!-- comments -->
	<div style="margin-top: 10px;margin-bottom:6px;"> Comments 
		<a href="addcomment.php?id=<?php echo $id;?>"> Add Comment </a>
	</div>
	<div> 
		<?php 
			while($crow = $comment->fetch_assoc())
				echo $crow["comment"]."<br>";
		?>
	</div>
		
</body>
</html>


















