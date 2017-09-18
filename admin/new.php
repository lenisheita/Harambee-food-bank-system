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
          <li class="active"><h1><a href="">HARAMBEE ADMIN</a> </h1></li>
         
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

NEW.PHP

Allows user to create a new entry in the database

*/



// creates the new record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($firstname, $lastname,$email_address,$occupation,$age,$error)

{

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>New Record</title>

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

<div>

<input type="text" class="form-control" placeholder="User Id" name="id"/><br/>

<input type="text" class="form-control" placeholder="First Name" name="firstname"/><br/>

<input type="text" class="form-control" placeholder="Last Name" name="lastname" /><br/>

<input type="text" placeholder="Date of birth" class="form-control" name="dateOfBirth" /><br/>

<input type="text" class="form-control" placeholder="Gender" name="gender" /><br/>

 <input type="text" class="form-control" placeholder="Residential Address" name="residential_address" /><br/>


 <input type="text" class="form-control" placeholder="Postall Address" name="postal_address" /><br/>

 <input type="text" class="form-control" placeholder="Consitituency" name="constituency" /><br/>
 <input type="text" class="form-control" placeholder="Income source" name="income_source" /><br/>

 <input type="text" class="form-control" placeholder="Registered by" name="registered_by" /><br/>

 <input type="text" class="form-control" placeholder="Occupation" name="occupation" /><br/>

 <input type="text" class="form-control" placeholder="Age" name="age"/><br/>

<p>* Required</p>

<input type="submit" name="submit" class="btn btn-block btn-primary" value="Submit">

</div>

</form>

</body>

</html>

<?php

}









// connect to the database

include('connect-db.php');



// check if the form has been submitted. If it has, start to process the form and save it to the database

if (isset($_POST['submit']))

{

// get form data, making sure it is valid


$id = mysql_real_escape_string(htmlspecialchars($_POST['id']));

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



// check to make sure both fields are entered

if ($id == '' || $firstname == '' | $lastname == '' | $dateOfBirth == ''| $gender == ''| $residential_address == ''| $postal_address == ''| $constituency == ''| $income_source == ''| $registered_by == '' | $occupation == '' | $age == '')

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again

renderForm( $id,$firstname,$lastname,$dateOfBirth,$gender,$residential_address, $postal_address,$constituency,	$income_source,	$registered_by,	$occupation,$age, $error);

}

else

{

// save the data to the database

mysql_query("INSERT members SET id='$id', firstname='$firstname', lastname='$lastname', dateOfBirth='$dateOfBirth', gender='$gender', residential_address='$residential_address', postal_address='$postal_address', constituency='$constituency', income_source='$income_source', registered_by='$registered_by', occupation='$occupation', age='$age'")


or die(mysql_error());



// once saved, redirect back to the view page

header("Location: home.php");

}

}

else

// if the form hasn't been submitted, display the form

{

renderForm('','','','','','');

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