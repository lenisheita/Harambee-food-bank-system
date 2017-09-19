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

EDIT.PHP

Allows user to edit specific entry in database

*/

// creates the edit record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm( $id,$firstname,$lastname,$dateOfBirth,$gender,$residential_address, $postal_address,$constituency,	$income_source,	$registered_by,	$occupation,$age

, $error)


{

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>Edit Record</title>

</head>

<body>

<?php

// if there are any errors, display them

if ($error != '')

{

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>

<form action="" method="post">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div>
<div class="row">
<div class="col-lg-6">
<strong>ID:</strong> <?php echo $id; ?>
</div>
<div class="col-lg-6">
<input type="text" name="firstname" placeholder="First Name" class="form-control" value="<?php echo $firstname; ?>"/><br/>
</div>
</div>

<div class="row">
<div class="col-lg-6">
<input type="text" name="lastname" placeholder="Last Name" class="form-control" value="<?php echo $lastname; ?>"/><br/>
</div>
<div class="col-lg-6">
<input type="text" name="dateOfBirth" placeholder="Date of birth" class="form-control" value="<?php echo $dateOfBirth; ?>"/><br/>
</div>
</div>

<div class="row">
<div class="col-lg-6">
<input type="text" name="gender" class="form-control" placeholder="Gender" value="<?php echo $gender; ?>"/><br/>
</div>
<div class="col-lg-6">
<input type="text" class="form-control" placeholder="residential_address" name="residential_address" value="<?php echo $residential_address; ?>"/><br/>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<input type="text" class="form-control" placeholder="Postall Address" name="postal_address" value="<?php echo $postal_address; ?>"/><br/>
</div>
<div class="col-lg-6">
<input type="text" class="form-control" placeholder="constituency" name="constituency" value="<?php echo $constituency; ?>"/><br/>
</div>
</div>

<div class="row">
<div class="col-lg-6">
<input type="text" class="form-control" placeholder="Income_source" name="income_source" value="<?php echo $income_source; ?>"/><br/>
</div>

<div class="col-lg-6">
<input type="text" class="form-control" placeholder="Registered By" name="registered_by" value="<?php echo $registered_by; ?>"/><br/>
</div>
</div>

<div class="row">
<div class="col-lg-6">
<input type="text" class="form-control" placeholder="Occupation" name="occupation" value="<?php echo $occupation; ?>"/><br/>
</div>
<div class="col-lg-6">
<input type="text" class="form-control" placeholder="Age" name="age" value="<?php echo $age; ?>"/><br/>
</div>
</div>
<input type="submit" class="btn btn-block btn-primary" name="submit" value="Submit">

</div>

</form>

<?php

}

// connect to the database

include('connect-db.php');



// check if the form has been submitted. If it has, process the form and save it to the database

if (isset($_POST['submit']))

{

// confirm that the 'id' value is a valid integer before getting the form data

if (is_numeric($_POST['id']))

{

// get form data, making sure it is 


$id = $_POST['id'];

$firstname = mysql_real_escape_string(htmlspecialchars($_POST['firstname']));

$lastname = mysql_real_escape_string(htmlspecialchars($_POST['lastname']));

$dateOfBirth = mysql_real_escape_string(htmlspecialchars($_POST['dateOfBirth']));

$gender = mysql_real_escape_string(htmlspecialchars($_POST['gender']));

$residential_address = mysql_real_escape_string(htmlspecialchars($_POST['residential_address']));

$postal_address = mysql_real_escape_string(htmlspecialchars($_POST['postal_address']));

$constituency = mysql_real_escape_string(htmlspecialchars($_POST['constituency']));

$income_source = mysql_real_escape_string(htmlspecialchars($_POST['income_source']));

$registered_by = mysql_real_escape_string(htmlspecialchars($_POST['registered_by']));

$occupation = mysql_real_escape_string(htmlspecialchars($_POST['occupation']));

$age = mysql_real_escape_string(htmlspecialchars($_POST['age']));

// check that firstname/lastname fields are both filled in

if ($firstname == '' || $lastname == '' | $dateOfBirth == ''| $gender == ''| $residential_address == ''| $postal_address == ''| $constituency == ''| $income_source == ''| $registered_by == '' | $occupation == '' | $age == '')

{
// generate error message

$error = 'ERROR: Please fill in all required fields!';
//error, display form
renderForm( $id,$firstname,$lastname,$dateOfBirth,$gender,$residential_address, $postal_address,$constituency,	$income_source,	$registered_by,	$occupation,$age

, $error);

}

else

{

// save the data to the database

mysql_query("UPDATE members SET firstname='$firstname', lastname='$lastname', dateOfBirth='$dateOfBirth', gender='$gender', residential_address='$residential_address', postal_address='$postal_address', constituency='$constituency', income_source='$income_source', registered_by='$registered_by', occupation='$occupation', age='$age' WHERE id='$id'")

or die(mysql_error());

// once saved, redirect back to the view page

header("Location: home.php");

}

}

else

{

// if the 'id' isn't valid, display an error

echo 'Error!';

}

}

else

// if the form hasn't been submitted, get the data from the db and display the form

{


// get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)

{

// query db

$id = $_GET['id'];

$result = mysql_query("SELECT * FROM members WHERE id=$id")

or die(mysql_error());

$row = mysql_fetch_array($result);

// check that the 'id' matches up with a row in the databse

if($row)

{


// get data from db


$firstname = $row['firstname'];

$lastname = $row['lastname'];

$dateOfBirth = $row['dateOfBirth'];

$gender = $row['gender'];

$residential_address = $row['residential_address'];

$postal_address = $row['postal_address'];

$constituency = $row['constituency'];

$income_source = $row['income_source'];

$registered_by = $row['registered_by'];

$occupation = $row['occupation'];

$occupation = $row['occupation'];

$age = $row['age'];

// show form

renderForm($id,$firstname,$lastname,$dateOfBirth,$gender,$residential_address, $postal_address,$constituency,	$income_source,	$registered_by,	$occupation,$age

,  '');

}

else

// if no match, display result

{

echo "No results!";

}

}

else

// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error

{

echo 'Error!';

}

}

?>



</div>
        </div>
    
    </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>