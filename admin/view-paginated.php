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
        <div class="col-lg-12">

<?php

/*

VIEW-PAGINATED.PHP

Displays all data from 'players' table

This is a modified version of view.php that includes pagination

*/



// connect to the database

include('connect-db.php');



// number of results to show per page

$per_page = 3;



// figure out the total pages in the database

$result = mysql_query("SELECT * FROM members");

$total_results = mysql_num_rows($result);

$total_pages = ceil($total_results / $per_page);



// check if the 'page' variable is set in the URL (ex: view-paginated.php?page=1)

if (isset($_GET['page']) && is_numeric($_GET['page']))

{

$show_page = $_GET['page'];



// make sure the $show_page value is valid

if ($show_page > 0 && $show_page <= $total_pages)

{

$start = ($show_page -1) * $per_page;

$end = $start + $per_page;

}

else

{

// error - show first set of results

$start = 0;

$end = $per_page;

}

}

else

{

// if page isn't set, show first set of results

$start = 0;

$end = $per_page;

}



// display pagination



echo "<p><a href='home.php'>View All</a> | <b>View Page:</b> ";

for ($i = 1; $i <= $total_pages; $i++)

{

echo "<a href='view-paginated.php?page=$i'>$i</a> ";

}

echo "</p>";



// display data in table

echo "<table class='table table-hover table-bordered'>";

echo "<tr> <th>ID</th> <th>First Name</th> <th>Last Name</th> <th>Date of Birth</th> <th>Gender</th> <th>Residential_Address</th> <th>Postal Address Address</th>

<th>constituency</th> <th>income_source</th> <th>registered_by</th> <th>occupation</th> <th>Age</th> <th></th> <th></th></tr>";


// loop through results of database query, displaying them in the table

for ($i = $start; $i < $end; $i++)

{

// make sure that PHP doesn't try to show results that don't exist

if ($i == $total_results) { break; }



// echo out the contents of each row into a table id
        "<tr>";

echo '<td>' . mysql_result($result, $i, 'id') . '</td>';

echo '<td>' . mysql_result($result, $i, 'firstname') . '</td>';

echo '<td>' . mysql_result($result, $i, 'lastname') . '</td>';

echo '<td>' . mysql_result($result, $i, 'dateOfBirth') . '</td>';

echo '<td>' . mysql_result($result, $i, 'gender') . '</td>';

echo '<td>' . mysql_result($result, $i, 'residential_address') . '</td>';

echo '<td>' . mysql_result($result, $i, 'postal_address') . '</td>';

echo '<td>' . mysql_result($result, $i, 'constituency') . '</td>';

echo '<td>' . mysql_result($result, $i, 'income_source') . '</td>';

echo '<td>' . mysql_result($result, $i, 'registered_by') . '</td>';

echo '<td>' . mysql_result($result, $i, 'occupation') . '</td>';

echo '<td>' . mysql_result($result, $i, 'age') . '</td>';

echo '<td><a href="edit.php?id=' . mysql_result($result, $i, 'id') . '">Edit</a></td>';

echo '<td><a href="delete.php?id=' . mysql_result($result, $i, 'id') . '">Delete</a></td>';

echo "</tr>";

}

// close table>

echo "</table>";



// pagination



?>

<p><a href="new.php">Add a new record</a></p>



</body>

</html>



</div>
        </div>
    
    </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>
