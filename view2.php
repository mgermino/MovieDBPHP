<?php
/*
Mike Germino
Displays Movies, ratings, director, and genre
*/
require('header.inc');
?>
<head>
<title>View Movies</title>
</head>
<body>
<div id="banner">
  <?php
  my_header("Movies");
  ?>
 </div>
 <?php
 #the following include contains navi links.
 require('navigation.inc');
 ?>
 <div id="main">
 <div id="header">
   <p>Genre: <a href="view2.php?rt">Action</a> <a href="#">Comedy</a> <a href="#">Drama</a> <a href="#">Horror</a> <a href="#">Sci-Fi</a></p>

   <p>Directors Last name: <a href="#">A</a><a href="#">B</a><a href="#">C</a><a href="#">D</a><a href="#">E</a><a href="#">F</a><a href="#">G</a><a href="#">H</a><a href="#">I</a><a href="#">J</a><a href="#">K</a><a href="#">L</a><a href="#">M</a><a href="#">N</a><a href="#">O</a><a href="#">P</a><a href="#">Q</a><a href="#">R</a><a href="#">S</a><a href="#">T</a><a href="#">U</a><a href="#">V</a><a href="#">W</a><a href="#">X</a><a href="#">Y</a><a href="#">Z</a></p>

   <p >Rating: <a href="#">One</a> <a href="#">Two</a> <a href="#">Three</a> <a href="#">Four</a> <a href="#">Five</a></p>
 </div>
 <h1>View Movies</h1>
 <?php
 #open Database
 $db = open_db();

 #select all movies
 $query = "select movies.moviename, ratings.rating, genres.genre, directors.directname from movies,
 ratings, genres, directors where movies.movieid = ratings.ratingid and movies.movieid = genres.genreid
and directors.directid = movies.directid order by movies.moviename";
 $result = mysqli_query($db, $query);

 $query2 = "select directors.directname from directors, movies where directors.directid = movies.directid order by movies.moviename";
 $result2 = mysqli_query($db, $query2);
 ?>

 <!-- Set up the header for the table -->
 <table border="0">
 <tr bgcolor="#cccccc">
	<td width="300">Movie Name</td>
	<td width="100">Director Name</td>
	<td width="100" align=right>Rating</td>
        <td width="100">Genre</td>
 </tr>

 <?php
 #retrieve results and dislay in table
 $num_results = mysqli_num_rows($result);
 for ($i=0; $i < $num_results; $i++)
 {
	$row = mysqli_fetch_row($result);
	echo "<tr>";
	echo "<td>".stripslashes($row[0])."</td>";
	echo "<td>".stripslashes($row[3])."</td>";
	echo "<td align=right>".stripslashes($row[1])."</td>";
        echo "<td>".stripslashes($row[2])."</td>";
	echo "<tr>";
}


 #retrieve results and dislay in table
 $num_results2 = mysqli_num_rows($result2);
 for ($i=0; $i < $num_results2; $i++)
 {
	$row2 = mysqli_fetch_row($result2);
	echo "<tr>";
	echo "<td>".stripslashes($row2[3])."</td>";
	echo "<tr>";
}


$mode="select * from genres where genre='action'";
$rt=mysqli_query($query);
?>

<!-- close the table -->
</table>
<?php
#close DB
mysqli_close($db);
?>

</div>
</body>
</html>