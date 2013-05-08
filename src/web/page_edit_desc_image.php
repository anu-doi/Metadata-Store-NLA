<?php session_start(); ?>
<?php // Page Template version 3.3

// PLEASE UPDATE THESE VALUES FOR EVERY PAGE
// -----------------------------------------------------------------------------
$title			= 'Researcher Profile';
$description	= 'Research Activities';
$subject		= 'Research, Website';

// Include configuration file & begin the XHTML response
// -----------------------------------------------------------------------------
include ($_SERVER['DOCUMENT_ROOT'] .'/anu_template/config.php');

echo $DocType; 
echo $Head; 
// insert additional header statements here //
echo $Body;
echo $Banner; 
include $Menu2;


// BEGIN: Page Content
// =============================================================================
?>




	<div class=narrow">
		<h1><?php echo $title; ?></h1>
	
	</div>	
<html>    
<head>
	<meta name="author" content="Vladimir Carrer">
	<link rel="stylesheet" href="form.css" type="text/css">
	<!--[if gt IE 5]>
	<!--link rel="stylesheet" href="ie.css" type="text/css">
	<!--[endif]-->
</head>
	
<script>    
function sayHello()
{
  if(confirm("Are you sure?")){
	document.getElementById("MyConfirm").submit();
  }else {
  	alert('A wise decision!');
    return false;
  }
	
}
</script>
<body>

    

<fieldset>

<style>
#labelx	 
	{ float:left; width:20em; display:block; clear:left; margin-right:1em; text-align:left;  cursor:hand; }
</style>    
        
    
<?php
//set_error_handler('myHandlerForMinorErrors', E_NOTICE | E_STRICT);
// Make a MySQL Connection
//var_dump(isset($Fname));
//var_dump(isset($Lname));
//session_start();

//require_once('index_login_nla.php');
//session_start();

$con = mysql_connect("localhost","irwan","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }



//pop -up box



mysql_select_db("oaidb", $con);

//if($_POST[UID]!= ""){
//echo $_SESSION['logged_in'];
//echo $_SESSION['universityid'];


echo $_POST[username],"</br>";
$uniid= $_SESSION['universityid'];
//echo $uniid;
if ($_SESSION['logged_in']){
	$result = mysql_query("SELECT distinct staffnumber,id_org,title,first_name,family_name,address,email,www,description,tel,fax,for1,for2,for3,job_title FROM useraccount where  staffnumber like '$uniid' ; ") or die('Test Data: ' . mysql_error());
	
	
}
else{
	echo "Please go back to previous page";
}

if(($result === FALSE) or ($result2 === FALSE)) {
    die(mysql_error()); // TODO: better error handling
}

while($row3 = mysql_fetch_array($result3)){
	$nlaid = $row3['nla_id'];
}


//echo "<br/>";
//echo "<br/>";
echo "<html>";
echo "<body>";
//echo '<form action="page_confirmed_desc.php" method="post" onsubmit="return confirm("Are you sure you want to submit?")">';
while($row = mysql_fetch_array($result)){
	echo "<br>";
	echo "<h1>","<cite>",$row['title'],"</cite>"," ","<cite>",$row['first_name'],"</cite>"," ","<cite>",$row['family_name'],"</cite>","</h1>";
        echo "Status: ";		
		echo "<br>";
        echo "Please insert profile picture ";
        echo "<br>";
	
	//echo "<img src='Steve_Jobs.jpg' alt='some_text'>","<br/>","<br/>";
	echo "<br>","<form>";
	echo "<div id='wrapper'>";
	echo "<div id='left'>";
	include "imageuploadfunctions.php";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	
	
	echo "<label id='labelx' for='StaffNumber'>","Staff Number:","</label>",
	$row['staffnumber'],"<br>";
	echo "<br>";
	
	echo "<label id='labelx' for='DeidentifiedStaffID'>","Deidentified Staff ID:","</label>",
	$row['id_org'],"<br>";
	echo "<br>";

	echo "<label id='labelx' for='nlaid'>","NLA ID:","</label>",
	"<a ", "href='",$nlaid,"'>",$nlaid,"</a>","<br/>"; 	
	echo "<br>";
	
	echo "<label id='labelx' for='nlaid'>","Job Title:","</label>",
	$row['job_title'],"<br/>"; 	
	echo "<br>";
	
	echo "<label id='labelx' for='title'>","Title:   ","</label>",
	$row['title'],"<br/>"; 
	echo "<br>";
	
	echo "<label id='labelx' for='firstname'>","First name:   ","</label>",
	$row['first_name'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='lastname'>","Last name:   ","</label>",
	$row['family_name'],"<br/>";
	echo "<br>";

	echo "<label id='labelx' for='address'>","Address:   ","</label>",
	$row['address'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='email'>","Email:   ","</label>",
	$row['email'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='email'>","URL:   ","</label>",
	"<a ", "href='",$row['www'],"'>",$row['www'],"</a>","<br/>"; 	
	echo "<br>";
	
	echo "<label id='labelx' for='telephone'>","Telephone:   ","</label>",
	$row['tel'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='fax'>","Fax:   ","</label>",
	$row['fax'],"<br/>";
	echo "<br>";
	
	
	echo "</form>";
	
    
      
	
}



$uid_post = $_SESSION['username'];


echo "</body>";
echo "</html>"; 


?>

<!-- END MAIN PAGE CONTENT -->
<?php 
// =============================================================================
// END: Page Content


// Complete the XHTML response
// -----------------------------------------------------------------------------
echo $Update; 
echo $Analytics;
echo $Footer; 

?>
