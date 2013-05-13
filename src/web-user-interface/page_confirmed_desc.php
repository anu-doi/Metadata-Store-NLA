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

 A page confirming the updated information 
 
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



mysql_select_db("oaidb", $con);
$aDoor = $_POST['pubidcheck'];


// get the details using the UID:



if($_POST[pubidnext]!= ""){
        if($_POST[DescUpdated]!="Enter your Latest Description" or $_POST[DescUpdated] =""){
          
                    
                    $DescriptionUpdated = addslashes($_POST[DescUpdated]);
                    $resultDesc6 = mysql_query("update useraccount set description = '$DescriptionUpdated' where staffnumber like '$_POST[pubidnext]%'" )  or die('Cannot Update Description: ' .mysql_error());
                  
                    
        }
        $emailUpdated = addslashes($_POST[email]);
        $resultDesc1 = mysql_query("update useraccount set email = '$emailUpdated' where staffnumber like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc2 = mysql_query("update useraccount set www = '$_POST[www]' where staffnumber like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc3 = mysql_query("update useraccount set for1 = '$_POST[for1]' where staffnumber like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc4 = mysql_query("update useraccount set for2 = '$_POST[for2]' where staffnumber like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc5 = mysql_query("update useraccount set for3 = '$_POST[for3]' where staffnumber  like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc7 = mysql_query("update useraccount set tel = '$_POST[tel]' where staffnumber  like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc8 = mysql_query("update useraccount set fax = '$_POST[fax]' where staffnumber like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc9 = mysql_query("update useraccount set job_title = '$_POST[jobtitle]' where staffnumber like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc10 = mysql_query("update oai_records a,useraccount b set a.nla_id  = '$_POST[nlaid]' where a.ori_id = b.id_org and  staffnumber = '$_POST[pubidnext]'; ")  or die('Cannot Update Description: ' .mysql_error());
        $resultDesc11 = mysql_query("update useraccount set title = '$_POST[persontitle]' where staffnumber like '$_POST[pubidnext]%'; ") or die('Cannot Update Description:' .mysql_error());
        


        
	
	$result = mysql_query("SELECT distinct a.staffnumber,a.id_org,a.title,a.first_name,a.family_name,a.address,a.email,a.www,a.description,a.tel,a.fax,a.for1,a.for2,a.for3,a.job_title  FROM useraccount a where  a.staffnumber = '$_POST[pubidnext]' ; ") or die('Test Data: ' . mysql_error());
	//$result2 = mysql_query("select distinct id_org,b.title persontitle,first_name,family_name,address,subject,description, pubid,a.title pubtitle,yearpublished,source from publication a, useraccount b where a.authorid = b.id_rep and a.orig_author_id like '$_POST[pubidnext]%'  order by pubid  ; ") or die('Test Data: ' . mysql_error());
	$result2 = mysql_query("select distinct  a.pubtype,a.title pubtitle,a.yearpublished,a.source from publication a, pub_to_authors c where a.pubid = c.pubid and c.staffnumber = '$_POST[pubidnext]' order by a.yearpublished;") or die('Test Data: ' . mysql_error());
	$result3 = mysql_query("SELECT distinct b.nla_id  FROM useraccount a, oai_records b  where  a.staffnumber =  '$_POST[pubidnext]' and a.id_org = b.ori_id ; ") or die('Test Data: ' . mysql_error());
	$result4 = mysql_query("SELECT distinct b.scopus_auth_id  FROM useraccount a, mapping_scopus_anu_author_id b  where  a.staffnumber= '$_POST[pubidnext]' and a.staffnumber = b.staffnumber ; ") or die('Test Data: ' . mysql_error());
      
}
else{
	echo "Please check the 'Confim' Button";
}



if(($result === FALSE) or ($result2 === FALSE)) {
    die(mysql_error()); // TODO: better error handling
}

echo "<html>";
echo "<body>";

while($row3 = mysql_fetch_array($result3)){
	$nlaid = $row3['nla_id'];
}


echo '<form action="page_confirmed_desc_oai-pmh.php" method="post">';

while($row = mysql_fetch_array($result)){
        echo "<br>","<font size='3'>", "Hi  ",$row['title']," ",$row['family_name']," ", ", you are logged in now.  ","</font>","</br>";
		
		
        echo "</br>";
	echo "<h1>","<cite>",$row['title'],"</cite>"," ","<cite>",$row['first_name'],"</cite>"," ","<cite>",$row['family_name'],"</cite>","</h1>";
	echo "<br>","<img src='./images/no-profile-man.jpg' alt='Jobs' width='150' height='150'>","<br/>";
	echo "<br>";
	echo "<br>","Description:   ","<p align='justify'>",$row['description'],"</p>","<br/>";
	
	echo "<label id='labelx' for='StaffNumber'>","Staff Number:","</label>",
	$row['staffnumber'],"<br>";
	echo "<br>";
	
	echo "<label id='labelx' for='DeidentifiedStaffID'>","Deidentified Staff ID:","</label>",
	$row['id_org'],"<br>";
	echo "<br>";

	echo "<label id='labelx' for='nlaid'>","NLA ID:","</label>",
	"<a ", "href='",$nlaid,"'>",$nlaid,"</a>","<br/>"; 	
	echo "<br>";
	
	echo "<label id='labelx' for='jobtitle'>","Job Title:","</label>",
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
	
	

   while($row4 = mysql_fetch_array($result4)){
	    $scopus_auth_id = $row4['scopus_auth_id'];
   echo "<label id='labelx' for='scopus_auth_id'>","Scopus Author ID:   ","</label>",
     "<a ", "href='http://www.scopus.com/authid/detail.url?authorId=",$scopus_auth_id,"'>",	  $scopus_auth_id,"</a>","<br/>"; 	
	echo "<br>";   
	
   }
	
	
	
	echo "<label id='labelx' for='for1'>","Fields of Research Code 1:   ","</label>",
	$row['for1'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='for2'>","Fields of Research Code 2:   ","</label>",
	$row['for2'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='for3'>","Fields of Research Code 3:   ","</label>",
	$row['for3'],"<br/>";
	echo "<br>";
	
        	
	
	// Two different processes for the existing and the  new people record:
	 
}


echo '<input type="radio" name="pubidnext" value=',$_POST[pubidnext],' checked="checked">',"Please tick to confirm",'<br>';
echo "<br>";
echo '<input type="submit" value="Finalize Profile" name="FinalizeProfile"><br/>';

echo "<br>","List of Publications:","<br>";
echo "<br>";
echo "<html>";
echo "<body>";
echo "<table border='1'>";
echo "<tr>";
//echo "<th>Include ?</th>";
echo "<th>Publication Type</th>";
echo "<th>Publication Title</th>";
echo "<th>Year Published</th>";
echo "<th>Source Title</th>";
echo "</tr>";

while($row2 = mysql_fetch_array($result2))
  {
	$valuetextbox = "V-".$row2["pubid"];
	

	echo "<tr>";    	
	echo "<td>",$row2['pubtype'],"</td>"; 
	echo "<td>",$row2['pubtitle'],"</td>"; 
	echo "<td>",$row2['yearpublished'],"</td>";
	echo "<td>",$row2['source'],"</td>";
	
	echo "</tr/>";	
  }


echo "</table>";
echo "<br>";
echo "</table>";

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
