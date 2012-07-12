<?php
/*
upload file with customer names
Mike Germino
11/1/09
*/
require('header.inc');
?>
<html>
<head>
  <title>Uploading...</title>
</head>
<body>
<div id="banner">
	<?php
	  my_header("Homework 8");
	  ?>
</div>

<?php
#includes navi links
require('navigation.inc');
?>
<h1>Uploading file...</h1>
<?php

//Check to see if an error code was generated on the upload attempt
  if ($_FILES['userfile']['error'] > 0)
  {
    echo 'Problem: ';
    switch ($_FILES['userfile']['error'])
    {
      case 1:	echo 'File exceeded upload_max_filesize';
	  			break;
      case 2:	echo 'File exceeded max_file_size';
	  			break;
      case 3:	echo 'File only partially uploaded';
	  			break;
      case 4:	echo 'No file uploaded';
	  			break;
	  case 6:   echo 'Cannot upload file: No temp directory specified.';
	  			break;
	  case 7:   echo 'Upload failed: Cannot write to disk.';
	  			break;
    }
    exit;
  }

  // Does the file have the right MIME type?
  if ($_FILES['userfile']['type'] != 'text/plain')
  {
    echo 'Problem: file is not plain text';
    exit;
  }

  // put the file where we'd like it
  $upfile = './uploads/'.$_FILES['userfile']['name'];

  if (is_uploaded_file($_FILES['userfile']['tmp_name'])) 
  {
     if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile))
     {
        echo 'Problem: Could not move file to destination directory';
        exit;
     }
  } 
  else 
  {
    echo 'Problem: Possible file upload attack. Filename: ';
    echo $_FILES['userfile']['name'];
    exit;
  }


  echo 'File uploaded successfully<br><br>'; 

  
  // reformat the file contents
  $fp = fopen($upfile, 'r');
  $contents = fread ($fp, filesize ($upfile));
  fclose ($fp);
 
  $contents = strip_tags($contents);
  $fp = fopen($upfile, 'w');
  fwrite($fp, $contents);
  fclose($fp);

  // show what was uploaded
  echo 'Preview of uploaded file contents:<br><hr>';
  echo $contents;
  echo '<br><hr>';
  
  
$fp = fopen($upfile, 'r');
while (!feof($fp))
{
  $readline1 = fgets($fp, 60);

  //explodes the lines in the file into an array
  $name = explode(" ", $readline1);
  $db = open_db();
		
  
		# inserts all customers from array pieces into customers table
  
		$query = "insert into customers (first, last)
			  values ('$name[0]', '$name[1]')";
		$result = mysqli_query($db, $query);
		$customerid = mysqli_insert_id($db);
	
		#close DB
		mysqli_close($db);
	
	
	
		#open DB
		$db = open_db();
		# inserts customerid and balance amount into balances table
	  	$query2 = "insert into balances (customerid, amount)
			  values ('$customerid', '$amount')";
		$result = mysqli_query($db, $query2);
		#close DB
		mysqli_close($db);
}
	if ($result)
	{
	  echo "All Customers added with $0.00 balance<br>.";
	}
	else
	{
	  echo "Error adding customers to database.";
	}
	?>
</body>
</html>
