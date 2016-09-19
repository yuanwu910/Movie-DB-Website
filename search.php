<?php
	if (isset($_GET["submit"])) 
  	{

	  	if(!$_GET['keyword'])
	  		$errom = "Please type in your input.";

		else
		{
		    $keys = $_GET['keyword'];
    		$keyword = explode(' ',$keys); 
		    include('mysqlConnect.php');
		    $num = count($keyword);
		    $sqla = "select * from Actor where ";
		    $sqlm = "select * from Movie where ";
		    for ($i = 0; $i <$num; $i++)
			{
				$sqla .= "(upper(first) like upper('$keyword[$i]%') or upper(last) like upper('$keyword[$i]%'))";
				 if($i != $num-1)  $sqla .= " and ";

				$sqlm .= "title like '%$keyword[$i]%'";
				if($i != $num-1)  $sqlm .= " and ";
			}
		    $sqla .= ";";
		    $sqlm .= ";";
		    $actor = $conn->query($sqla);
		    $movie = $conn->query($sqlm);

	    	$conn->close();
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title> search </title>
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
	<body style="font-family: Times;">
		<h2> Results </h2>
		<?php echo $errom; ?>

		<?php if($_GET['keyword']) {?>
		<p>---Actor---</br></p>
		<?php while($arow = $actor->fetch_assoc()){ ?>
			<a href="actorinfo.php?id=<?php echo $arow["id"];?>"> 
			<?php echo $arow["first"]." ".$arow["last"]."(".$arow["dob"].")"."<br>"; ?>
			</a>
		<?php }?>
		<hr>
		<p>---Movie---</br></p>
		<?php while($mrow = $movie->fetch_assoc()){ ?>
			<a href="movieinfo.php?id=<?php echo $mrow["id"];?>"> 
			<?php echo $mrow["title"]."(".$mrow["year"].")"."<br>"; ?>
			</a>
		<?php }?>
		<?php }?>



		</div>

	</body>

</html>















