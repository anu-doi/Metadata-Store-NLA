<?php session_start(); ?>
<?php // Page Template version 3.3
/*******************************************************************************
 * Australian National University Metadata Store
 * Copyright (C) 2013  The Australian National University
 * 
 * This file is part of Australian National University Metadata Store.
 * 
 * Australian National University Metadatastore is free software: you
 * can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later
 * version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 ******************************************************************************/

/*
 Australian National University Metadata Store

 A page that provides a text field  to insert bibtex data 
 
 Version 	Date		Developer
 1.0        30-04-2013      Irwan Krisna  (IK) Initial 


*/ 

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
include $Menu5;


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
function confirmproceed()
{
  var answer = confirm("Are you sure?");
  if(answer == true){
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

if(($result === FALSE)) {
    die(mysql_error()); // TODO: better error handling
}




//echo "<br/>";
//echo "<br/>";
echo "<html>";
echo "<body>";
echo '<form action="page_confirmed_bibtex.php" method="post" onsubmit="return confirm("Are you sure you want to submit?")">';
while($row = mysql_fetch_array($result)){
	echo "<br>";
	echo "<h1>","<cite>",$row['title'],"</cite>"," ","<cite>",$row['first_name'],"</cite>"," ","<cite>",$row['family_name'],"</cite>","</h1>";
        echo "Status: ";		
		echo "<br>";
        echo "Please insert the Reference List in the BibTex format. ";
        echo "<br>";
	
	//echo "<img src='Steve_Jobs.jpg' alt='some_text'>","<br/>","<br/>";
	echo "<br>","<form>";
	echo "<div id='wrapper'>";
	echo "<div id='left'>";
	
	
	echo "<br>","BibTex import :","</br>","</br>"; 
echo "<textarea rows='25' cols='100' name='DescUpdated' wrap='hard'>Enter your BibTex data</textarea>","<br>";
	
	
	echo "</form>";
	
    
      
	
}



$uid_post = $_SESSION['username'];

echo '<input type="radio" name="pubidnext" value=',$uid_post,' checked="checked", style="visibility:hidden">','<br>';
echo "<br/>";
echo '<input id="MyConfirm" onclick="return confirmproceed();" type="Submit" value="Confirm" name="IncludePubs"><br/>';


	echo "<br/>";

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
