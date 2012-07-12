<!-- header -->
<html>
<head>
<style type="text/css">
<!--
/* styles for main page */



#banner {
  background:#FF9900;
  padding-top: 10px;
  padding-bottom: 10px;
  border-bottom: 2px solid;
  font: small-caps 24px/24px "Times New Roman", serif;
  color: black;
  text-align: center;
}
#header {
  background:#fff;
  padding-top: 5px;
  padding-bottom: 5px;
  border-bottom: 2px solid;
  font: small-caps 16px/16px "Times New Roman", serif;
  color: #282;
}

#columns {
  background: #141;
}

#main {
  margin-left: 15em;
  padding-top: 4ex;
  padding-left: 2em;
  background: white;
}

#side {
  float: left;
  padding-top: 1em;
  padding-left: 1em;
  padding-bottom: 1em;
  width: 14em;
  background: #FF9900;
  color : #444444;

}

#side a {
  color: black;
  font-size: small;
}

h1 {
  font: 150% sans-serif;
  color: black;
  border-bottom: 3px dotted black;
}
-->
</style>

<?php
function my_header($assignment)
{
	echo "Mike Germino<br>";
	echo $assignment."<br>";
	echo date('M j, Y');
}

function open_db()
{
	@ $db = mysqli_connect('cs.sierracollege.edu','php121','germ5234',php121_dev);
	if (mysqli_connect_error())
	{
		echo '<br>Error: Could not connect to database.<br>';
		exit;
	}
	else
	{
		return $db;
	}
}


  
?>
</head>
<body>