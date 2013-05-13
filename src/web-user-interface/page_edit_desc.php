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

 A  page to edit  general information of  a person
 
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
function sayProceed()
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




$con = mysql_connect("localhost","irwan","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }                             



//pop -up box



mysql_select_db("oaidb", $con);



echo $_POST[username],"</br>";
$uniid= $_SESSION['universityid'];
if ($_SESSION['logged_in']){
	$result = mysql_query("SELECT distinct a.staffnumber,a.id_org,title,a.first_name,a.family_name,a.address,a.email,a.www,a.description,a.tel,a.fax,a.for1,a.for2,a.for3,a.job_title,b.nla_id FROM useraccount a LEFT JOIN oai_records b ON (a.id_org = b.ori_id)  where  staffnumber = '$uniid' ; ") or die('Test Data: ' . mysql_error());
        $result2 = mysql_query("select distinct  a.pubtype,a.title pubtitle,a.yearpublished,a.source from publication a, pub_to_authors c where a.pubid = c.pubid and c.staffnumber = '$uniid' order by a.yearpublished desc;") or die('Test Data: ' . mysql_error());
	$result3 = mysql_query("SELECT distinct b.nla_id  FROM useraccount a, oai_records b  where  a.staffnumber = '$uniid' and a.id_org = b.ori_id ; ") or die('Test Data: ' . mysql_error());
	$result4 = mysql_query("SELECT distinct b.scopus_auth_id  FROM useraccount a, mapping_scopus_anu_author_id b  where  a.staffnumber = '$uniid' and a.staffnumber = b.staffnumber ; ") or die('Test Data: ' . mysql_error());
	
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

echo "<html>";
echo "<body>";
echo '<form action="page_confirmed_desc.php" method="post" onsubmit="return confirm("Are you sure you want to submit?")">';
while($row = mysql_fetch_array($result)){
	echo "<br>";
	echo "<h1>","<cite>",$row['title'],"</cite>"," ","<cite>",$row['first_name'],"</cite>"," ","<cite>",$row['family_name'],"</cite>","</h1>";
        echo "Status: ";		
		echo "<br>";
        echo "The general information of ", $row['title']," ",$row['first_name']," ",$row['family_name'], ". Please update the information accordingly. ";
        echo "<br>";
	
	
	echo "<br>","<form>";
	echo "<div id='wrapper'>";
	echo "<div id='left'>";
	
	
	echo "<br>","Biography:   ","<p align='justify'>",$row['description'],"</p>","<br/>";
	
	
	
	echo "<br>","Biography Updated:","</br>","</br>"; 
echo "<textarea rows='10' cols='100' name='DescUpdated' wrap='physical'>Enter your Latest Description</textarea>","<br>";
	
	echo "<label id='labelx' for='StaffNumber'>","Staff Number:","</label>",
	$row['staffnumber'],"<br>";
	echo "<br>";
	
	echo "<label id='labelx' for='DeidentifiedStaffID'>","Deidentified Staff ID:","</label>",
	$row['id_org'],"<br>";
	echo "<br>";

	echo "<label id='labelx' for='nlaid'>","NLA ID:","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['nla_id'],"' NAME ='nlaid' id = 'nlaid' size='50'>","<br/>"; 	
	echo "<br>";
	
	echo "<label id='labelx' for='jobtitle'>","Job Title:","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['job_title'],"' NAME ='jobtitle' id = 'jobtitle' size='50'>","<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='title'>","Title:   ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['title'],"' NAME ='persontitle' id = 'persontitle' size='50'>","<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='firstname'>","First name:   ","</label>",
	$row['first_name'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='lastname'>","Last name:   ","</label>",
	$row['family_name'],"<br/>";
	echo "<br>";

	echo "<label id='labelx' for='address'>","Address:   ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['address'],"' NAME ='address' id = 'address' size='50'>","<br/>";
	echo "<br>";
	
	
	echo "<label id='labelx' for='email'>","Email:   ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['email'],"' NAME ='email' id = 'email' size='50'>","<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='url'>","URL:   ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['www'],"' NAME ='www' id = 'www' size='50'>","<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='telephone'>","Telephone:   ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['tel'],"' NAME ='tel' id = 'tel' size='50'>","<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='fax'>","Fax:   ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['fax'],"' NAME ='fax' id = 'fax' size='50'>","<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='for1'>","Fields of Research Code 1: ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['for1'],"' NAME ='for1' id = 'for1' size='10'>","<br/>";
	echo "<br>";
	
	
	
	echo "<label id='labelx' for='for2'>","Fields of Research Code 2:   ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['for2'],"' NAME ='for2' id = 'for2' size='10'>","<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='for3'>","Fields of Research Code 3:   ","</label>",
	"<INPUT TYPE = 'Text' VALUE ='",$row['for3'],"' NAME ='for3' id = 'for3' size='10'>","<br/>";
	echo "<br>";
	
	
	
	echo "</form>";
	
    
      
	
}



$uid_post = $_SESSION['username'];

echo '<input type="radio" name="pubidnext" value=',$uid_post,' checked="checked">',"Please tick to confirm",'<br>';
echo "<br/>";
echo '<input id="MyConfirm" onclick="return sayProceed();" type="Submit" value="Confirm" name="IncludePubs"><br/>';


		
echo "<br>","List of Publications:","<br>";
echo "<br>";
echo "<html>";
echo "<body>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>ARIES ID</th>";
echo "<th>Publication Title</th>";
echo "<th>Publication Year</th>";
echo "<th>Source Title</th>";
echo "</tr>";



while($row2 = mysql_fetch_array($result2))
  {
	
	echo "<tr>";   	
	echo "<td>",$row2['pubtype'],"</td>"; 
	echo "<td>",$row2['pubtitle'],"</td>"; 
	echo "<td>",$row2['yearpublished'],"</td>";
	echo "<td>",$row2['source'],"</td>";
	
	echo "</tr/>";	
  }


echo "</table>";
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
