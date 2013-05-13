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

 A page that allows insertion of researcher data to OAI-PMH feed
 
 Version 	Date		Developer
 1.0        30-04-2013      Irwan Krisna  (IK) Initial 


*/ 

// PLEASE UPDATE THESE VALUES FOR EVERY PAGE
// -----------------------------------------------------------------------------
$title			= 'Research Profile';
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
	
	$resultfirst = mysql_query("SELECT distinct  id_org,title,first_name,family_name,address,email,www,description,for1,for2,for3 FROM useraccount where staffnumber like '$_POST[pubidnext]' ; ") or die('Cannot view useraccount data: ' . mysql_error());


	// Define a public variable:

	while($row = mysql_fetch_array($resultfirst)){
			$id_org_db = $row['id_org'];
			$person_title = $row['title'];
			
	}


         
	$result = mysql_query("SELECT distinct  id_org,title,first_name,family_name,address,email,www,description,for1,for2,for3 FROM useraccount where id_org like '$id_org_db' ; ") or die('Cannot view useraccount data: ' . mysql_error());
	$result2 = mysql_query("select distinct id_org,b.title persontitle,first_name,family_name,address,subject,description, pubid,a.title pubtitle,yearpublished,source from publication a, useraccount b where a.authorid = b.id_rep and b.id_rep  like '$id_org_db'  ; ") or die('publicationvand useraccount ' . mysql_error());
	$result3 = mysql_query("select ori_id from oai_records where ori_id like '$id_org_db' ; ") or die('Cannot view useraccount data: ' . mysql_error());
	
            
	
        if($result3=== TRUE){
	    echo "<br>",$row3['ori_id'],", ","'s"," profile already exist in the OAI-PMH database", "<br/>";
        }
        else{
				
			
         $person_id = "anu.edu.au/".$id_org_db;
		 
		// edit person's title if equal to nbsp because it may disrupt the XML generation
		if($person_title== "&nbsp"){
			mysql_query("update useraccount set title = null where staffnumber like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
		}
			
			
	    mysql_query("insert into oai_records values (null,'testprovider','$person_id',NOW(),'$person_id','class:party',NOW(),'false','this is a title','creator','CompScience','desc ','contributor','publisher1','2012-12-01','type1','format1','id2 ','source1','English ','relation1','coverage1','rights1','rif','useraccount','$id_org_db','person','',null,'')") or die('Cannot insert data-- already exist:  please see here the OAI-PMH page--' . mysql_error());
	    echo "<br>","Status: ",$_POST[pubidnext],"'s"," profile just been added  in the OAI-PMH database", "<br/>";
	    
	    
        }
	  
	    
}
else{
	echo "Please check the 'Confim' Button";
}
if(($result === FALSE) or ($result2 === FALSE)) {
    die(mysql_error()); // TODO: better error handling
}

echo "<html>";
echo "<body>";
echo "<br>";
echo "<br>", "The Profile has been finalized and updated in the OAI-PMH feed to the NLA", "</br>";
while($row = mysql_fetch_array($result)){
	
	echo "<br>","Deidentified Staff ID:   ",$row['id_org'],"<br/>"; 
	echo "<br>","Title:   ",$row['title'],"<br/>"; 
	echo "<br>","First Name:   ",$row['first_name'],"<br/>";
	echo "<br>","Last Name:   ",$row['family_name'],"<br/>";
	echo "<br>","Address:   ",$row['address'],"<br/>";
	echo "<br>","Email:   ",$row['email'],"<br/>";
	echo "<br>","URL:   ",$row['www'],"<br/>";
	echo "<br>","Fields of Research Code 1:   ",$row['for1'],"<br/>";
	echo "<br>","Fields of Research Code 2:   ",$row['for2'],"<br/>";
	echo "<br>","Fields of Research Code 3:   ",$row['for3'],"<br/>";
	echo "<br>","Description:   ",$row['description'],"<br/>";
	
	// Two different processes for the existing and the  new people record:
	 
	
    
        
          
          
	

	
}
echo "<br>";
echo "<a href='http://dc7-dev2.anu.edu.au/oai/oai2.php?verb=ListRecords&metadataPrefix=rif'> Please click on this link to see the OAI-PMH result</a>";
echo "<br>";
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
