<?php
	$id = $_GET['id'] ? $_GET['id']:"92";
  include('mysqlConnect.php');

  $query1= "select * from Movie where id = $id;";
  $movieinfo = $conn->query($query1);
  $mrow = $movieinfo->fetch_assoc();
  $query2 = "select avg(rating) as avgrating
          from Review
          where mid = $id";

  $rating = $conn->query($query2);
  $avgrat = $rating->fetch_assoc();

  $query3 = "select comment
          from Review
          where mid = $id;";

  $comment = $conn->query($query3);
  $conn->close();

  if (isset($_GET["submit"])) {

    $name = $_GET['name'];
    $rating = $_GET['rating'];
    $comment = $_GET['comment'];
    $mid = $id;
    
      if (!$_GET['name']) {
        $name = "Anonymous";
      }
      
      if (!$_GET['comment']) {
        $comment = "null";;
      }
      include('mysqlConnect.php');
      
      $query4 = "insert into Review values ('$name', CURRENT_TIMESTAMP(), $mid, $rating, '$comment');";
      $insert = $conn->query($query4);
      $result = "Your comment is added.";

      $conn->close(); 
  }

?>


<!DOCTYPE html>
<html>
<head> 
<style>
.error {color: #EE4000;}
.successfully{color: #548B54}
</style> 
</head>
<body>
  <h2> Add Comment </h2>
  <strong> Movie:</strong> <?php echo $mrow["title"];?> </br></br>
  <strong> Ratting:</strong> <?php echo number_format($avgrat["avgrating"],2);?> </br></br>
  <div>
    <form method = "GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
     
        <label for="Name"> <strong>Name</strong> </label>
            <input type="text" name="name" value="Anonymous">
       
        <label for="Rate"> <strong>Rate</strong> </label>
        <select name="rating">
          <option value='5'>5-Excellent</option>
          <option value='4'>4-Good</option>
          <option value='3'>3-Just soso</option>
          <option value='2'>2-Not Worth</option>
          <option value='1'>1-I hate it</option>
        </select>
      </br></br>
        
        <label for="Comment"> <strong>Comment</strong> </label></br>
        <textarea name="comment" rows="10" cols="50"></textarea>

      <input type="hidden" name="id" value=<?php echo $mrow["id"]?> >
      <input type="submit" name="submit" value="Add Comment"> 
    </form>
  </div>

    <?php if (isset($_GET["submit"])) {?>
     <span class="successfully"> <strong> <?php echo $result ?></strong></span><br/>
     <?php } ?>

</body>
</html>


















