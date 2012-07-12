<?php
/*
Rate and edit movies
Mike Germino
*/
require('header.inc');
?>
<head>
<title>Rate and Edit Movies</title>
</head>
<body>
<div id="banner">
	<?php
	  my_header("Movies");
	  ?>
</div>

<?php
#includes navi links
require('navigation.inc');
?>

<div id="main">
<h1>Rate and Edit Movies</h1>
<?php
if (!isset($_POST['submit']))
{
/*
First time through variable not set
*/

?>

<form action="ratemovie.php" method="post">
<label>Select Movie:
  <select name="movieid" size="6">
    <?php
	#open DB
	$db = open_db();
	
	#select all movies
	$query = "select * from movies order by moviename";
	$result = mysqli_query($db, $query);
	
	# retrieve query results and display in a select
	# $row[0] = customerid
	# $row[1] = first
	# $row[2] = last
	
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
   <labeel>Rating(1-5): <input type="text" name="rating"/></label>
   <br>
   <label> Select Action:
     <select name="action" size="2">
	   <option value=set>Set Rating to</option>
	  </select>
	 </label>
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
    echo "You need to select a Movie.";
    exit;
  }
  $movieid = $_POST['movieid'];
  
  #check that we have a number amount.
  if (!isset($_POST['rating']))
  {
    echo "You need to enter a rating.";
	exit;
  }
  $rating = $_POST['rating'];
  if (!is_numeric($rating))
  {
    echo "You need to enter a numeric amount.";
	exit;
  }
  $rating = $_POST['rating'];
  if ($rating > 5)
  {
    echo "You need to enter a rating of 1-5.";
	exit;
  }
  $rating = $_POST['rating'];
  if ($rating < 1)
  {
    echo "You need to enter a rating of 1-5.";
	exit;
  }
  #clean up data
  if (!get_magic_quotes_gpc())
  {
    $rating = addslashes($rating);
  }
  
  #was an action selected?
  if (!isset($_POST['action']))
  {
    echo "You need to select an action.";
	exit;
  }
  $action = $_POST['action'];
  
  #open DB
  $db = open_db();
  
  # Get entry for the customer selected. customerid is returned
  # by the slected statement.
  
  $query = "select rating from ratings where movieid = $movieid";
  $result = mysqli_query($db, $query);
  $num_results = mysqli_num_rows($result);
  if ($num_results == 1) # we expect only 1 entry in the db.
  {
   # we have the balances record for the customer. update it and save back to db.
   $row = mysqli_fetch_row($result);
   $balance = $row[0];
   switch($action)
   {
	 case 'set' :
	   $finalrate = $rating;
	   break;
	}
	$query = "update ratings set rating = $finalrate where movieid = $movieid";
	$result = mysqli_query($db, $query);
	if ($result)
	{
	  echo "Rating updated to $finalrate.";
	}
	else
	{
	  echo "Error updating rating in database.";
	}
  }
  else
  {
    echo "Error in database. Either we found no entry or more than 1 entry";
  }
  
  # close DB
  mysqli_close($db);
  
}
?>
</div>
</body>
</html>