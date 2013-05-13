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

 A page that provides the functionality to insert the BiBtex data into the database
 
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
					$myFile = "test_file.txt";
					$fh = fopen($myFile, 'w') or die("can't open file");
					$stringData = $DescriptionUpdated;
					fwrite($fh, $stringData);
					fclose($fh);
					

        }
        $emailUpdated = addslashes($_POST[email]);

	$result = mysql_query("SELECT distinct a.staffnumber,a.id_org,a.title,a.first_name,a.family_name,a.address,a.email,a.www,a.description,a.tel,a.fax,a.for1,a.for2,a.for3,a.job_title  FROM useraccount a where  a.staffnumber like '$_POST[pubidnext]%' ; ") or die('Test Data: ' . mysql_error());
	$result2 = mysql_query("select distinct id_org,b.title persontitle,first_name,family_name,address,subject,description, pubid,a.title pubtitle,yearpublished,source from publication a, useraccount b where a.authorid = b.id_rep and a.orig_author_id like '$_POST[pubidnext]%'  order by pubid  ; ") or die('Test Data: ' . mysql_error());
	$result3 = mysql_query("SELECT distinct b.nla_id  FROM useraccount a, oai_records b  where  a.staffnumber like '$_POST[pubidnext]%' and a.id_org = b.ori_id ; ") or die('Test Data: ' . mysql_error());
	$result4 = mysql_query("SELECT distinct b.scopus_auth_id  FROM useraccount a, mapping_scopus_anu_author_id b  where  a.staffnumber like '$_POST[pubidnext]%' and a.staffnumber = b.staffnumber ; ") or die('Test Data: ' . mysql_error());
      
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

	echo "<br>";

	echo "<br>", "List of Publications: ", "</br>";
	echo "<br>";
	
	$_GET['bib']='test_file.txt';

	$_GET['all']=1;
	include( 'bibtexbrowser.php' );
	$bibentry->getField("journal");
	echo $bibentry->getField("journal");
	echo "test";
	
        	
	
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

echo "<th>Publication ID</th>";
echo "<th>Publication Title</th>";
echo "<th>Year Published</th>";
echo "<th>Source Title</th>";
echo "</tr>";

while($row2 = mysql_fetch_array($result2))
  {
	$valuetextbox = "V-".$row2["pubid"];
	echo "<tr>";
	    	
	echo "<td>",$row2['pubid'],"</td>"; 
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
