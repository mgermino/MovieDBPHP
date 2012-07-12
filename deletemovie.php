<?php
/*
Select customer and delete them along with their balance
Mike Germino
*/
require('header.inc');
?>
<head>
<title>Remove Movie</title>
</head>
<body>
<div id="banner">
	<?php
	  my_header("Homework 7");
	  ?>
</div>

<?php
#includes navi links
require('navigation.inc');
?>

<div id="main">
<h1>Delete Movie</h1>
<?php
if (!isset($_POST['submit']))
{
/*
First time through variable not set
*/

?>

<form action="deletemovie.php" method="post">
<label>Select Movie:
  <select name="movieid" size="3">
    <?php
	#open DB
	$db = open_db();
	
	#select all movies
	$query = "select * from movies order by moviename";
	$result = mysqli_query($db, $query);
	
	# retrieve query results and display in a select
	# $row[0] = movieid
	# $row[1] = moviename
        # $row[2] = directid
	
	$num_results = mysqli_num_rows($result);
	for ($i=0; $i <$num_results; $i++)
	{
	  $row = mysqli_fetch_row($result);
	  echo "<option value=".$row[0].">".$row[1]."</option>";
	}
	
	#close DB
	mysqli_close($db);
	?>
	</select>
   </label>
   <br>
	 <input type="submit" name="submit" value="Do it">
	 </form>
	 <?php
}
else
{
/* 
process information collected. variable has been set past here.
*/

  #was customer selected?
  if (!isset($_POST['movieid']))
  {
    echo "You need to select a movie.";
    exit;
  }
  $movieid = $_POST['movieid'];
  $directid = $_POST['movieid'];




  #open DB
  $db = open_db();

      # Query removes director of movie genre from director table

  $query = "delete from directors where directid = $directid";
  $result = mysqli_query($db, $query);
  	if ($result)
	{
	  echo "<br />Director has been removed.";
	}
	else
	{
	  echo "<br /> Error removing Director from database.";
	}





  # Query removes movie rating from ratings table
    
  $query = "delete from ratings where movieid = $movieid";
  $result = mysqli_query($db, $query);
  $num_results = mysqli_num_rows($result);
  
  

  
  # Query removes movie from movies table
  
  $query = "delete from movies where movieid = $movieid";
  $result = mysqli_query($db, $query);
  	if ($result)
	{
	  echo "<br />Movie has been removed.";
	}
	else
	{
	  echo "<br />Error removing Movie from database.";
	}
  


  # Query removes movie genre from genres table

  $query = "delete from genres where movieid = $movieid";
  $result = mysqli_query($db, $query);
  	if ($result)
	{
	  echo "<br />Genre has been removed.";
	}
	else
	{
	  echo "<br />Error removing Genre from database.";
	}



  # close DB
  mysqli_close($db);


  
}
?>
</div>
</body>
</html>