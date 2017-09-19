<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          <li class="active"><a href="home.php">Home</a></li>
          <li class="active"><a href="home.php">Display Records</a></li>
          <li class="active"><a href="new.php">Add Record</a></li>
          <li class="active"><a href="view-paginated.php">Pagination</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userEmail']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav> 

	<div id="wrapper">

	<div class="container">
    
    	<div class="page-header">
    	<h3>List of all the user registered</h3>
    	</div>
        
        <div class="row">
        <div class="col-12">

        <?php

/*

VIEW.PHP

Displays all data from 'players' table

*/

// connect to the database

include('connect-db.php');



// get results from database

$result = mysql_query("SELECT * FROM members")

or die(mysql_error());

// display data in table



echo "<p><b>View All</b> | <a href='view-paginated.php?page=1'>View Paginated</a></p>";

echo "<table width='100%' height='100%' class='table table-hover table-bordered' color='blue'>";

echo "<tr> <th height='100%'>ID</th> <th>First Name</th> <th>Last Name</th> <th>Date of Birth</th> <th>Gender</th> <th>Residential_Address</th> <th width='100%'>Postal Address</th>

<th>constituency</th> <th>income_source</th> <th>registered_by</th> <th>occupation</th> <th>Age</th> <th></th> <th></th></tr>";

// loop through results of database query, displaying them in the table

while($row = mysql_fetch_array( $result )) {
   
// echo out the contents of each row into a table

echo "<tr height='100%'>";

echo '<td>' . $row['id'] . '</td>';

echo '<td width=100%;>' . $row['firstname'] . '</td>';

echo '<td width=100%;>' . $row['lastname'] . '</td>';

echo '<td width=100%;>' . $row['dateOfBirth'] . '</td>';

echo '<td width=100%;>' . $row['gender'] . '</td>';

echo '<td width=100%;>' . $row['residential_address'] . '</td>';
echo '<td width=100%;>' . $row['postal_address'] . '</td>';

echo '<td width=100%;>' . $row['constituency'] . '</td>';
echo '<td width=100%;>' . $row['income_source'] . '</td>';

echo '<td width=100%;>' . $row['registered_by'] . '</td>';
echo '<td width=100%;>' . $row['occupation'] . '</td>';

echo '<td>' . $row['age'] . '</td>';

echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>';

echo '<td><a href="delete.php?id=' . $row['id'] . '">Delete</a></td>';

echo "</tr>";

}

// close table>

echo "</table>";

?>
<p><a href="new.php">Add a new record</a></p>

        </div>
        </div>
    
    </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>