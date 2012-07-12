<?php
/*
Add customer to database with 0 balance.
Mike Germino
10/18/09
*/
require('header.inc');
?>
<head>
<title>Add Movies</title>
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
<h1>Add Movies</h1>
<?php
if (!isset($_POST['submit']))
{
/*
Form to capture customers first and last name
*/

?>

<form action="addmovie.php" method="post">
   <label>Movie Name: <input type="text" name="movie"/></label>
   <br>
   <label>Director Name: <input type="text" name="director"/></label>
   <br>
      <label> Select Genre:
     <select name="genre" size="6">
	   <option value=action>Action</option>
	   <option value=comedy>Comedy</option>
	   <option value=drama>Drama</option>
           <option value=horror>Horror</option>
           <option value=scifi>Sci-Fi</option>
           <option value=family>Family</option>
	  </select>
	 </label>
   <br>
	 <input type="submit" name="submit" value="Submit Movie">
	 </form>
	 <?php
}
else
{
/* 
process information collected. variable has been set past here.
*/
  #was genre selected?
  if (!isset($_POST['genre']))
  {
    echo "You need to select a genre.";
    exit;
  }
$moviename=$_POST['movie'];
$directorname=$_POST['director'];
$genre = $_POST['genre'];
$rating=$_POST['rating'];
  #clean up data
  if (!get_magic_quotes_gpc())
  {
	$moviename = addslashes($moviename);
	$directorname = addslashes($directorname);
  }
  
  
  #open DB
  $db = open_db();
  # query the data and put it into the database in appropriate columns.


  	# put new directorname in table.
	  	$query = "insert into directors (directname)
			  values ('$directorname')";
    $result = mysqli_query($db, $query);
    $directid = mysqli_insert_id($db);
		echo "<br />Director added successfully";






	$query = "insert into movies (moviename, directid)
			  values ('$moviename', '$directid')";
	$result = mysqli_query($db, $query);
  	if ($result)
	{
	  	$rating = $_POST['rating1'];
	
	#select all customers and get most recent
	$query2 = "select * from movies order by moviename desc limit 1";
	$result2 = mysqli_query($db, $query2);
        $movieid2 = mysqli_insert_id($db);
	
	# put new movieid for ratings table in place along with rating.
	  	$query = "insert into ratings (movieid, rating)
			  values ('$movieid2', '$rating')";
    $result = mysqli_query($db, $query);
		echo "<br />Movie Added Successfully";

	# put new movieid for genre table in place along with genre.
	  	$query = "insert into genres (movieid, genre)
			  values ('$movieid2', '$genre')";
    $result = mysqli_query($db, $query);
		echo "<br />Genre Added Successfully";


	#close DB
	mysqli_close($db);
	}
	else
	{
	  echo "<br />Error updating balance in database.";
	}

  
  # close DB
  mysqli_close($db);
  
}
?>
</div>

</body>
</html>
